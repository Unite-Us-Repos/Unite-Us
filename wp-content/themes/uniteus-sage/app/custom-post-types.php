<?php
/**
 * Post Types
 */


// register OC
add_action('init', 'register_cpt_1c');

function register_cpt_1c()
{
    register_post_type(
        '1c',
        array(
            'labels' => array(
                'name'               => 'One Continuum',
                'singular_name'      => 'One Continuum',
                'menu_name'          => 'One Continuum',
                'name_admin_bar'     => 'One Continuum',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New',
                'edit_item'          => 'Edit',
                'new_item'           => 'New',
                'view_item'          => 'View',
                'search_items'       => 'Search One Continuum',
                'not_found'          => 'No events found',
                'not_found_in_trash' => 'No events found in trash',
                'all_items'          => 'One Continuum',
            ),

            'public'        => true,
            'menu_position' => 15,
            'supports'      => array('title', 'page-attributes', 'thumbnail'),
            'show_in_rest'  => true,
            'taxonomies'    => array(''),
            'rewrite'       => array('slug' => 'one-continuum'),
            'menu_icon'     => 'dashicons-media-document',
            'has_archive'   => false
        )
        );

        // Post custom taxonomy
        $labels = array(
            'name' => _x('Type', 'taxonomy general name'),
            'singular_name' => _x('Type', 'taxonomy singular name'),
            'search_items' =>  __('Search Type'),
            'all_items' => __('All Typs'),
            'parent_item' => __('Parent Type'),
            'parent_item_colon' => __('Parent Type:'),
            'edit_item' => __('Edit Type'),
            'update_item' => __('Update Type'),
            'add_new_item' => __('Add New Type'),
            'new_item_name' => __('New Type'),
            'menu_name' => __('Type'),
        );
        // Now register the taxonomy
        register_taxonomy(
            'event_type', array('1c'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'type' ),
            )
        );
}

// register team
add_action('init', 'register_cpt_team');

function register_cpt_team()
{
    register_post_type(
        'team',
        array(
            'labels' => array(
                'name'               => 'Team',
                'singular_name'      => 'Team',
                'menu_name'          => 'Team',
                'name_admin_bar'     => 'Team',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Member',
                'edit_item'          => 'Edit Member',
                'new_item'           => 'New Member',
                'view_item'          => 'View Member',
                'search_items'       => 'Search Team',
                'not_found'          => 'No Team found',
                'not_found_in_trash' => 'No Team found in trash',
                'all_items'          => 'Team',
            ),

            'public'        => true,
            'menu_position' => 14,
            'supports'      => array('title', 'editor', 'thumbnail'),
            'show_in_rest'  => false,
            'taxonomies'    => array(''),
            'menu_icon'     => 'dashicons-groups',
            'has_archive'   => false
        )
    );

    $labels = array(
        'name' => _x('Team Category', 'taxonomy general name'),
        'singular_name' => _x('Team Category', 'taxonomy singular name'),
        'search_items' =>  __('Search Team Categories'),
        'all_items' => __('All Team Categories'),
        'parent_item' => __('Parent Team Category'),
        'parent_item_colon' => __('Parent Team Category:'),
        'edit_item' => __('Edit Team Category'),
        'update_item' => __('Update Team Category'),
        'add_new_item' => __('Add New Team Category'),
        'new_item_name' => __('New Team Category'),
        'menu_name' => __('Categories'),
      );

    // Now register team category taxonomy
    register_taxonomy(
        'team_category', array('team'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'team-category' ),
        )
    );


    $labels = array(
        'name' => _x('Team Groups', 'taxonomy general name'),
        'singular_name' => _x('Group', 'taxonomy singular name'),
        'search_items' =>  __('Search Groups'),
        'all_items' => __('All Groups'),
        'parent_item' => __('Parent Group'),
        'parent_item_colon' => __('Parent Group:'),
        'edit_item' => __('Edit Group'),
        'update_item' => __('Update Group'),
        'add_new_item' => __('Add New Group'),
        'new_item_name' => __('New Group'),
        'menu_name' => __('Groups'),
      );

    // Now register team groups taxonomy
    register_taxonomy(
        'team_groups', array('team'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'group' ),
        )
    );
}

// register Network 
add_action('init', 'register_cpt_network');

function register_cpt_network()
{
    register_post_type(
        'network',
        array(
            'labels' => array(
                'name'               => 'Network',
                'singular_name'      => 'Network',
                'menu_name'          => 'Network',
                'name_admin_bar'     => 'Network',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New',
                'edit_item'          => 'Edit',
                'new_item'           => 'New',
                'view_item'          => 'View',
                'search_items'       => 'Search Network',
                'not_found'          => 'No Network found',
                'not_found_in_trash' => 'No Network found in trash',
                'all_items'          => 'Network',
            ),

            'public'        => true,
            'menu_position' => 15,
            'supports'      => array('title', 'editor', 'thumbnail'),
            'show_in_rest'  => false,
            'taxonomies'    => array(''),
            'rewrite'       => array( 'slug' => 'networks' ),
            'menu_icon'     => 'dashicons-media-document',
            'has_archive'   => false
        )
    );
}

// register Network Form
add_action('init', 'register_cpt_network_form');

function register_cpt_network_form()
{
    register_post_type(
        'network_form',
        array(
            'labels' => array(
                'name'               => 'Network Forms',
                'singular_name'      => 'Network Form',
                'menu_name'          => 'Network Form',
                'name_admin_bar'     => 'Network Form',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Network Form',
                'edit_item'          => 'Edit Network Form',
                'new_item'           => 'New Network Form',
                'view_item'          => 'View Network Form',
                'search_items'       => 'Search Network Forms',
                'not_found'          => 'No Network Forms found',
                'not_found_in_trash' => 'No Network Forms found in trash',
                'all_items'          => 'Network Forms',
            ),

            'public'        => true,
            'menu_position' => 15,
            'supports'      => array('title', 'editor', 'thumbnail'),
            'show_in_rest'  => false,
            'show_in_menu'         => 'edit.php?post_type=network',
            'taxonomies'    => array(''),
            'menu_icon'     => 'dashicons-editor-table',
            'has_archive'   => false
        )
    );
}

// register Press
add_action('init', 'register_cpt_press');

function register_cpt_press()
{
    register_post_type(
        'press',
        array(
            'labels' => array(
                'name'               => 'Press',
                'singular_name'      => 'Press',
                'menu_name'          => 'Press',
                'name_admin_bar'     => 'Press',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New',
                'edit_item'          => 'Edit',
                'new_item'           => 'New',
                'view_item'          => 'View',
                'search_items'       => 'Search Press',
                'not_found'          => 'No Press found',
                'not_found_in_trash' => 'No Press found in trash',
                'all_items'          => 'Press',
            ),

            'public'        => true,
            'menu_position' => 15,
            'supports'      => array('title', 'editor', 'thumbnail'),
            'show_in_rest'  => true,
            'taxonomies'    => array(''),
            'menu_icon'     => 'dashicons-media-document',
            'has_archive'   => false
        )
    );

    // now register category taxonomy
    register_taxonomy(
        'press_cat',
        array('press'), 
        array('hierarchical' => true,     
            'labels' => array(
                'name' => __('Categories', 'sage'), 
                'singular_name' => __('Category', 'sage'), 
                'search_items' =>  __('Search Categories', 'sage'), 
                'all_items' => __('All Categories', 'sage'), 
                'parent_item' => __('Parent Category', 'sage'), 
                'parent_item_colon' => __('Parent Category:', 'sage'), 
                'edit_item' => __('Edit Category', 'sage'), 
                'update_item' => __('Update Category', 'sage'), 
                'add_new_item' => __('Add New Category', 'sage'), 
                'new_item_name' => __('New Category Name', 'sage') 
            ),
            'show_admin_column' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'press_cat' ),
        )
    );
    

    $labels = array(
        'name' => _x('States', 'taxonomy general name'),
        'singular_name' => _x('State', 'taxonomy singular name'),
        'search_items' =>  __('Search States'),
        'all_items' => __('All States'),
        'parent_item' => __('Parent State'),
        'parent_item_colon' => __('Parent State:'),
        'edit_item' => __('Edit State'),
        'update_item' => __('Update State'),
        'add_new_item' => __('Add New State'),
        'new_item_name' => __('New State Name'),
        'menu_name' => __('States'),
      );

    // Now register state taxonomy
    register_taxonomy(
        'states', array('network_form', 'network_team', 'post', 'press'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'state' ),
        )
    );


    $labels = array(
        'name' => _x('Topic', 'taxonomy general name'),
        'singular_name' => _x('Topic', 'taxonomy singular name'),
        'search_items' =>  __('Search Topic'),
        'all_items' => __('All Topics'),
        'parent_item' => __('Parent Topic'),
        'parent_item_colon' => __('Parent Topic:'),
        'edit_item' => __('Edit Topic'),
        'update_item' => __('Update Topic'),
        'add_new_item' => __('Add New Topic'),
        'new_item_name' => __('New Topic'),
        'menu_name' => __('Topics'),
      );
    // Now register topic taxonomy 
    register_taxonomy(
        'topic', array('post', 'press'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'topic' ),
        )
    );


    $labels = array(
        'name' => _x('Industry', 'taxonomy general name'),
        'singular_name' => _x('Industry', 'taxonomy singular name'),
        'search_items' =>  __('Search Industry'),
        'all_items' => __('All Industries'),
        'parent_item' => __('Parent Industry'),
        'parent_item_colon' => __('Parent Industry:'),
        'edit_item' => __('Edit Industry'),
        'update_item' => __('Update Industry'),
        'add_new_item' => __('Add New Industry'),
        'new_item_name' => __('New Industry'),
        'menu_name' => __('Industries'),
      );
    // Now register industry taxonomy
    register_taxonomy(
        'industry', array('post'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'industry' ),
        )
    );

}

// register add category to press cpt
add_action('init', 'add_category_to_press_cpt');

function add_category_to_press_cpt() {
    register_taxonomy_for_object_type('category', 'press');
}

// register rename category to type for press cpt
add_action('init', 'rename_category_to_type_for_press');

function rename_category_to_type_for_press() {
    global $wp_taxonomies;

    if (isset($wp_taxonomies['category'])) {
        // Only update labels for the 'press' post type
        $labels = &$wp_taxonomies['category']->labels;

        $labels->name = 'Types';
        $labels->singular_name = 'Type';
        $labels->search_items = 'Search Types';
        $labels->all_items = 'All Types';
        $labels->parent_item = 'Parent Type';
        $labels->parent_item_colon = 'Parent Type:';
        $labels->edit_item = 'Edit Type';
        $labels->update_item = 'Update Type';
        $labels->add_new_item = 'Add New Type';
        $labels->new_item_name = 'New Type';
        $labels->menu_name = 'Types';
    }
}

// register Presenters
add_action('init', 'register_cpt_presenter');

function register_cpt_presenter()
{
    register_post_type(
        'presenter',
        array(
            'labels' => array(
                'name'               => 'Presenters',
                'singular_name'      => 'Presenters',
                'menu_name'          => 'Presenters',
                'name_admin_bar'     => 'Presenters',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Member',
                'edit_item'          => 'Edit Member',
                'new_item'           => 'New Member',
                'view_item'          => 'View Member',
                'search_items'       => 'Search Presenters',
                'not_found'          => 'No Presenters found',
                'not_found_in_trash' => 'No Presenters found in trash',
                'all_items'          => 'Presenters',
            ),

            'public'        => true,
            'menu_position' => 14,
            'supports'      => array('title', 'editor', 'thumbnail'),
            'show_in_rest'  => false,
            'taxonomies'    => array(''),
            'menu_icon'     => 'dashicons-groups',
            'has_archive'   => false,
            'exclude_from_search'   => true
        )
    );

    $labels = array(
        'name' => _x('Presenters Category', 'taxonomy general name'),
        'singular_name' => _x('Presenters Category', 'taxonomy singular name'),
        'search_items' =>  __('Search Presenters Categories'),
        'all_items' => __('All Presenters Categories'),
        'parent_item' => __('Parent Presenters Category'),
        'parent_item_colon' => __('Parent Presenters Category:'),
        'edit_item' => __('Edit Presenters Category'),
        'update_item' => __('Update Presenters Category'),
        'add_new_item' => __('Add New Presenters Category'),
        'new_item_name' => __('New Presenters Category'),
        'menu_name' => __('Categories'),
      );

    // Now register presenter category taxonomy
    register_taxonomy(
        'presenter_category', array('presenter'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'presenter-category' ),
        )
    );

    $labels = array(
        'name' => _x('Presenters Groups', 'taxonomy general name'),
        'singular_name' => _x('Group', 'taxonomy singular name'),
        'search_items' =>  __('Search Groups'),
        'all_items' => __('All Groups'),
        'parent_item' => __('Parent Group'),
        'parent_item_colon' => __('Parent Group:'),
        'edit_item' => __('Edit Group'),
        'update_item' => __('Update Group'),
        'add_new_item' => __('Add New Group'),
        'new_item_name' => __('New Group'),
        'menu_name' => __('Groups'),
      );

    // Now register presenter group taxonomy
    register_taxonomy(
        'presenter_groups', array('presenter'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'group' ),
        )
    );
}


// register Authors
add_action('init', 'register_cpt_author');

function register_cpt_author()
{
    register_post_type(
        'author',
        array(
            'labels' => array(
                'name'               => 'Authors',
                'singular_name'      => 'Authors',
                'menu_name'          => 'Authors',
                'name_admin_bar'     => 'Authors',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Author',
                'edit_item'          => 'Edit Author',
                'new_item'           => 'New Author',
                'view_item'          => 'View Author',
                'search_items'       => 'Search Authors',
                'not_found'          => 'No Authors found',
                'not_found_in_trash' => 'No Authors found in trash',
                'all_items'          => 'Authors',
            ),

            'public'        => true,
            'menu_position' => 14,
            'supports'      => array('title', 'editor', 'thumbnail'),
            'show_in_rest'  => false,
            'taxonomies'    => array(''),
            'menu_icon'     => 'dashicons-edit-large',
            'has_archive'   => false,
            'exclude_from_search'   => true
        )
    );
}


add_action( 'init', 'unregister_tags' );

/**
 * Removes tags from blog posts
 */
function unregister_tags() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

function revcon_change_cat_label() {
    global $submenu;
    $submenu['edit.php'][15][0] = 'Types'; // Rename categories to Authors
}
add_action( 'admin_menu', 'revcon_change_cat_label' );

/**
 * Get excerpt from string
 *
 * @param String $str String to get an excerpt from
 * @param Integer $startPos Position int string to start excerpt from
 * @param Integer $maxLength Maximum length the excerpt may be
 * @return String excerpt
 */
function getGhExcerpt($str, $title="", $startPos=0, $maxLength=150) {
    $str = html_entity_decode($str);


    $str = preg_replace('/Job Title:[\s\S]+?<\/p>/', '', $str);
    $str = preg_replace('/Department:[\s\S]+?<\/p>/', '', $str);
    $str = preg_replace('/Departments:[\s\S]+?<\/p>/', '', $str);
    $str = preg_replace('/Departments:[\s\S]+?<\/p>/', '', $str);
    $str = str_replace('<strong>Associate Director of Government Marketing</strong>', '', $str);
    $str = str_replace("Marketing Department", "", $str);
    $str = str_replace("<strong>{$title}</strong>", "", $str);
    $str = str_ireplace('About the Role:', '', $str);
    $str = str_ireplace('About the Role', '', $str);
    $str = str_ireplace('About the Internship:', '', $str);
    $str = strip_tags($str);
    $str = str_replace('&nbsp;', '', $str);
    $str = str_replace(':', '', $str);
      if(strlen($str) > $maxLength) {
          $excerpt   = substr($str, $startPos, $maxLength-3);
          $lastSpace = strrpos($excerpt, ' ');
          $excerpt   = substr($excerpt, 0, $lastSpace);
          $excerpt  .= '...';
      } else {
          $excerpt = $str;
      }

      return $excerpt;
  }

  function add_category_taxonomy_to_pages() {
    register_taxonomy_for_object_type('category', 'page');
}
add_action('init', 'add_category_taxonomy_to_pages');

function add_category_metabox_to_pages() {
    add_meta_box('categorydiv', __('Categories'), 'post_categories_meta_box', 'page', 'side', 'default', array('taxonomy' => 'category'));
}
add_action('add_meta_boxes', 'add_category_metabox_to_pages');

if (has_term('', 'category')) {
    echo '<div class="page-categories">';
    echo '<h2>Categories:</h2>';
    echo get_the_term_list(get_the_ID(), 'category', '<ul><li>', '</li><li>', '</li></ul>');
    echo '</div>';
}

// Render taxonomy dropdowns on list tables
add_action('restrict_manage_posts', function () {
    global $typenow;

    // Order = left → right in the UI
    $tax_map = [
        // Press: State, Press Categories, Topics (NO core Category/“Types”)
        'press' => ['states', 'press_cat', 'topic'],

        // Posts: core Categories/“Types” shows automatically; add the rest here
        'post'  => ['topic', 'states', 'industry'],
    ];

    if (empty($tax_map[$typenow])) return;

    foreach ($tax_map[$typenow] as $taxonomy) {
        $tax_obj = get_taxonomy($taxonomy);
        if (!$tax_obj) continue;

        wp_dropdown_categories([
            'taxonomy'        => $taxonomy,
            'name'            => $taxonomy,
            'orderby'         => 'name',
            'hierarchical'    => true,
            'hide_empty'      => false,
            'value_field'     => 'slug',
            'selected'        => isset($_GET[$taxonomy]) ? sanitize_text_field($_GET[$taxonomy]) : '',
            'show_option_all' => $tax_obj->labels->all_items ?: sprintf(__('All %s'), $tax_obj->label),
        ]);
    }
}, 10);

// Make those dropdowns filter the query
add_filter('parse_query', function ($query) {
    global $pagenow;

    if ($pagenow !== 'edit.php' || !is_admin() || empty($query->query['post_type'])) return $query;

    $post_type = $query->query['post_type'];

    $tax_map = [
        'press' => ['states', 'press_cat', 'topic'],
        'post'  => ['topic', 'states', 'industry'],
    ];

    if (empty($tax_map[$post_type])) return $query;

    foreach ($tax_map[$post_type] as $taxonomy) {
        if (!empty($_GET[$taxonomy])) {
            $query->query_vars[$taxonomy] = sanitize_text_field($_GET[$taxonomy]);
        }
    }

    return $query;
}, 10);
