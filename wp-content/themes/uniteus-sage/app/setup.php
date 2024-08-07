<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\bundle;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    bundle('app')->enqueue();

    $template_slug = get_page_template_slug();
    if ('template-event-landing-page.blade.php' == $template_slug
        OR (get_post_type() == '1c')
        OR (is_page('one-continuum'))
        ) {
        bundle('time')->enqueue();
    }
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    bundle('editor')->enqueue();
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from the Soil plugin if activated.
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
        'clean-up',
        'nav-walker',
        'nice-search',
        'relative-urls'
    ]);

    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'footer_navigation' => __('Footer Navigation', 'sage'),
        'footer_solutions' => __('Footer Solutions', 'sage'),
        'footer_support' => __('Footer Support', 'sage'),
        'footer_company' => __('Footer Company', 'sage'),
        'footer_legal' => __('Footer Legal', 'sage'),
        'footer_products' => __('Footer Products', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style'
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary'
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer'
    ] + $config);
});

/* Admin CSS */

add_action(
    'admin_head',
    function () {
        echo '<style>
            .acf-svg-icon-picker__popup-holder {
                z-index: 999999999;
            }   
            ul#icons-list {
                margin-top: 1rem;
            }

            ul#icons-list li {
                text-align: center;
            }

            .acf-svg-icon-picker__svg,
            .acf-svg-icon-picker__popup-svg {
                background: #ebebeb;
                border-radius: 50%;
                padding: 2rem;
            }

            .acf-svg-icon-picker__svg {
                padding: 0;
                width: 60px;
                height: 60px;
            }
            .acf-svg-icon-picker__svg--span {
                background-color: #f4f4f4;
                top: 5px;
                left: 5px;
                position: relative;
            }
            /* Image Selector */
            .acfe-image-selector .image {
                background-color: #ebebeb;
            }

        </style>';
    }
);

/**
 * AJAX posts load more data
 */
add_action('wp_head', function () {
    global $wp_query;
    $vars = array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
        'posts' => json_encode($wp_query->query_vars), // blog posts
        'current_page' => get_query_var('paged') ? get_query_var('paged') : 1,
        'max_page' => $wp_query->max_num_pages
    );
    ?>
    <script>
    /* <![CDATA[ */
    var loadmore_posts_params = <?php echo json_encode($vars); ?>
    /* ]]> */
    </script>
    <?php
});

add_editor_style('resources/styles/editor.css');

/**
 * Custom Noindex Override for Yoast SEO
 */
function custom_noindex_override() {
    error_log('custom_noindex_override function loaded'); // Log to confirm function is loaded
    if (is_page()) {
        $noindex = get_field('set_as_noindex');
        if ($noindex) {
            error_log('Noindex is active'); // Log to confirm condition is met
            // Overriding the Yoast SEO robots meta tag
            add_filter('wpseo_robots', function() {
                return 'noindex, nofollow';
            });
         }
    }
}
add_action('wp', 'App\\custom_noindex_override');



