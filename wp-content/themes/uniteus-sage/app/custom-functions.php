<?php
/*
 * Custom functions
 *
 * @package Uniteus
 */

 /**
 * Convert an array of attributes into a string.
 *
 * @param array $attrs
 * @return string
 */

 if (!function_exists('html_attributes')) {
    function html_attributes(array $attrs): string {
        return collect($attrs)->map(function($value, $key) {
            if (is_bool($value)) {
                return $value ? $key : '';
            }
            return $key . '="' . e($value) . '"';
        })->filter()->implode(' ');
    }
 }

/**
 * Document Manager role limited to WP Document Revisions (no mu-plugin).
 * Paste at the end of app/custom-functions.php in your uniteus-sage theme.
 */

if (!defined('ABSPATH')) exit;

/**
 * Create/update the "Document Manager" role and grant caps for the "document" CPT.
 * Runs after CPTs/taxonomies are registered so WPDR's post type exists.
 */
add_action('init', function () {
    // Only proceed if WP Document Revisions is active and the CPT is registered.
    if (!post_type_exists('document')) {
        return;
    }

    $role_key = 'document_manager';

    // Create the role if missing.
    if (!get_role($role_key)) {
        add_role($role_key, 'Document Manager', ['read' => true]);
    }
    $role = get_role($role_key);
    if (!$role) return;

    // Grant all caps that the "document" post type declares (future-proof).
    $doc_pto = get_post_type_object('document');
    if ($doc_pto && !empty($doc_pto->cap)) {
        foreach ($doc_pto->cap as $cap_name) {
            if (is_string($cap_name) && $cap_name !== '') {
                $role->add_cap($cap_name);
            }
        }
    }

    // Allow uploads for adding/updating document files.
    $role->add_cap('upload_files');

    // Let Document Managers manage (create/edit/delete) categories, so the submenu shows.
    // NOTE: This also grants management of *post* categories, but your menu trim + redirect
    // keep them inside Documents-only screens.
    $role->add_cap('manage_categories');

    // Marker cap to identify this role when trimming the admin UI.
    $role->add_cap('document_manager_only_guard');

    // (Optional) Grant taxonomy caps for WPDR workflow states if present.
    $tax = get_taxonomy('workflow_state');
    if ($tax && !empty($tax->cap) && is_array($tax->cap)) {
        foreach ($tax->cap as $tax_cap) {
            if (is_string($tax_cap) && $tax_cap !== '') {
                $role->add_cap($tax_cap);
            }
        }
    }
}, 20);

/**
 * Trim admin menus for the Document Manager role.
 * Keep only Dashboard, Documents, and Profile (adjust the $keep list if desired).
 */
add_action('admin_menu', function () {
    if (!current_user_can('document_manager_only_guard')) return;

    $keep = [
        'index.php',                   // Dashboard
        'edit.php?post_type=document', // WP Document Revisions (Documents)
        'profile.php',                 // Profile
    ];

    global $menu;
    foreach ($menu as $i => $item) {
        $slug = $item[2] ?? '';
        if (!in_array($slug, $keep, true)) {
            remove_menu_page($slug);
        }
    }

    // Hide Media Library menu even though uploads are allowed (keeps UX focused).
    remove_menu_page('upload.php');
}, 999);

/**
 * Soft-redirect this role back to Documents if they hit a disallowed admin screen.
 * Allow the Document Categories terms screen explicitly.
 */
add_action('admin_init', function () {
    if (!current_user_can('document_manager_only_guard')) return;

    // Don’t interfere with AJAX, cron, REST, or CLI.
    if ((defined('DOING_AJAX') && DOING_AJAX) || wp_doing_cron() || (defined('REST_REQUEST') && REST_REQUEST)) {
        return;
    }
    if (function_exists('wp_is_json_request') && wp_is_json_request()) {
        return;
    }
    if (defined('WP_CLI') && WP_CLI) return;

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen) return;

    $is_doc_screen     = ($screen->post_type === 'document');
    $is_profile        = in_array($screen->base, ['profile', 'user-edit'], true);
    $is_dashboard      = ($screen->base === 'dashboard');
    $is_doc_cat_screen = ($screen->base === 'edit-tags' && !empty($screen->taxonomy) && $screen->taxonomy === 'document_category');

    if ($is_doc_screen || $is_profile || $is_dashboard || $is_doc_cat_screen) {
        return;
    }

    wp_safe_redirect(admin_url('edit.php?post_type=document'));
    exit;
}, 20);


/**
 * Document Categories taxonomy for WP Document Revisions (CPT: document)
 * No custom caps — uses WordPress' defaults so Admins/Editors (and DMs with manage_categories) can manage.
 */
add_action('init', function () {
    if (!post_type_exists('document')) {
        return; // Ensure WP Document Revisions is active
    }

    $taxonomy = 'document_category';

    $labels = [
        'name'                       => 'Categories',
        'singular_name'              => 'Category',
        'menu_name'                  => 'Categories',
        'all_items'                  => 'All Categories',
        'edit_item'                  => 'Edit Category',
        'view_item'                  => 'View Category',
        'update_item'                => 'Update Category',
        'add_new_item'               => 'Add New Category',
        'new_item_name'              => 'New Category Name',
        'search_items'               => 'Search Categories',
        'parent_item'                => 'Parent Category',
        'parent_item_colon'          => 'Parent Category:',
        'not_found'                  => 'No categories found',
    ];

    register_taxonomy($taxonomy, ['document'], [
        'public'            => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,     // Block editor & REST API
        'hierarchical'      => true,     // acts like normal WP categories
        'labels'            => $labels,
        'rewrite'           => false,    // no public rewrite since 'public' is false

        // Built-in caps:
        // - Users with manage_categories can create/edit/delete.
        // - Anyone who can edit Documents can assign categories to them.
        'capabilities' => [
            'manage_terms' => 'manage_categories',
            'edit_terms'   => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'edit_documents',
        ],
    ]);
}, 12);


/**
 * Admin list filter: Document Categories dropdown on the Documents screen.
 * Shows a hierarchical dropdown and filters the list when selected.
 */

// 1) Render the dropdown on the Documents list screen.
add_action('restrict_manage_posts', function ($post_type) {
    if ($post_type !== 'document') return;

    $tax = 'document_category';
    if (!taxonomy_exists($tax)) return; // Our custom taxonomy must be registered first

    // Current selection (slug)
    $selected = isset($_GET[$tax]) ? sanitize_text_field(wp_unslash($_GET[$tax])) : '';

    wp_dropdown_categories([
        'show_option_all' => __('All Categories', 'uniteus-sage'),
        'taxonomy'        => $tax,
        'name'            => $tax,          // important: name must match the taxonomy query var
        'orderby'         => 'name',
        'selected'        => $selected,
        'hierarchical'    => true,
        'hide_empty'      => false,         // show even empty categories
        'value_field'     => 'slug',        // pass slug in the GET var (works nicely with WP_Query)
    ]);
}, 20);

// 2) Make the selection actually filter the query (robust even if query_var were off).
add_action('pre_get_posts', function ($query) {
    // Only affect the admin main list query for Documents
    if (!is_admin() || !$query->is_main_query()) return;

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || $screen->id !== 'edit-document') return;

    $tax = 'document_category';
    if (!taxonomy_exists($tax)) return;

    if (!empty($_GET[$tax])) {
        $slug = sanitize_title(wp_unslash($_GET[$tax]));
        $query->set('tax_query', [
            [
                'taxonomy' => $tax,
                'field'    => 'slug',
                'terms'    => $slug,
            ],
        ]);
    }
});

// Extra spacing so the filter row doesn't crash into pagination on Documents list.
add_action('admin_head', function () {
    if (!function_exists('get_current_screen')) return;
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'edit-document') return; // only on Documents list

    ?>
    <style>
      /* Add vertical breathing room under the filter dropdowns */
      body.post-type-document .tablenav .actions { margin-bottom: 10px; }
      /* Optional: add a touch more horizontal spacing between controls */
      body.post-type-document .tablenav .actions select,
      body.post-type-document .tablenav .actions .button { margin-right: 6px; }
      /* When pagination wraps below on narrower screens, give it a little top gap */
      @media (max-width: 1280px) {
        body.post-type-document .tablenav .tablenav-pages { margin-top: 6px; }
      }
    </style>
    <?php
});
