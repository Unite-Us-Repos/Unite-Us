<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
  return sprintf('...');
}, 99);
// then in Blade: {!! get_the_excerpt() !!}


/* ACF Icon Picker */
function wp_admin_post_type()
{
    global $post, $parent_file, $typenow, $current_screen, $pagenow;

    $post_type = null;

    if ($post && (property_exists($post, 'post_type') || method_exists($post, 'post_type'))) {
        $post_type = $post->post_type;
    }

    if (empty($post_type) && !empty($current_screen) && (property_exists($current_screen, 'post_type') || method_exists($current_screen, 'post_type')) && !empty($current_screen->post_type)) {
        $post_type = $current_screen->post_type;
    }

    if (empty($post_type) && !empty($typenow)) {
        $post_type = $typenow;
    }

    if (empty($post_type) && function_exists('get_current_screen')) {
        $post_type = get_current_screen();
    }

    if (empty($post_type) && isset($_REQUEST['post']) && !empty($_REQUEST['post']) && function_exists('get_post_type') && $get_post_type = get_post_type((int)$_REQUEST['post'])) {
        $post_type = $get_post_type;
    }

    if (empty($post_type) && isset($_REQUEST['post_type']) && !empty($_REQUEST['post_type'])) {
        $post_type = sanitize_key($_REQUEST['post_type']);
    }

    if (empty($post_type) && 'edit.php' == $pagenow) {
        $post_type = 'post';
    }

    return $post_type;
}

// modify the path to the icons directory
add_filter(
    'acf_icon_path_suffix',
    function ( $path_suffix ) {
        $dir = 'acf';
        return '/icons/' . $dir . '/'; // After assets folder you can define folder structure
    }
);

// modify the path to the above prefix
add_filter(
    'acf_icon_path',
    function ($path_suffix) {
        return $_SERVER["DOCUMENT_ROOT"] . '/wp-content/themes/uniteus-sage/resources';
    }
);

// modify the URL to the icons directory to display on the page
add_filter(
    'acf_icon_url',
    function ($path_suffix) {
        return get_stylesheet_directory_uri() . '/resources';
    }
);

// remove scripts from 5xx page
add_action(
    'wp_enqueue_scripts',
    function () {
        if (is_page_template('5xx.blade.php')) {
            wp_deregister_script('lazysizes');
        }
    }, 100
);

// Disable Gutenberg on the back end.
add_filter(
    'use_block_editor_for_post',
    function () {
        return false;
    },
);

// Disable Gutenberg for widgets.
add_filter(
    'use_widgets_blog_editor',
    function () {
        return false;
    }
);

add_action(
    'wp_enqueue_scripts',
    function () {
        // Remove CSS on the front end.
        wp_dequeue_style('wp-block-library');

        // Remove Gutenberg theme.
        wp_dequeue_style('wp-block-library-theme');

        // Remove inline global CSS on the front end.
        wp_dequeue_style('global-styles');

        // remove some jquery scripts
        wp_dequeue_script('jquery-ui-datepicker');

        wp_deregister_script('hoverintent-js');

        wp_deregister_script('search-filter-plugin-chosen');
    }, 20
);

// Add class to nav menu links
add_filter(
    'nav_menu_link_attributes',
    function ($classes, $item, $args) {

        if (isset($args->link_class)) {
            $classes['class'] = $args->link_class;
        }

        if (!$item->has_children && $item->menu_item_parent > 0) {
            $classes['class'] = $args->sub_link_class;
        }
        return $classes;
    }, 1, 3
);

// Remove archive title prefix
add_filter(
    'get_the_archive_title',
    function ($title) {
        if ( is_category() ) {
            $title = single_cat_title( '', false );
        } elseif ( is_tag() ) {
            $title = single_tag_title( '', false );
        } elseif ( is_author() ) {
            $title = '<span class="vcard">' . get_the_author() . '</span>';
        } elseif ( is_post_type_archive() ) {
            $title = post_type_archive_title( '', false );
        } elseif ( is_tax() ) {
            $title = single_term_title( '', false );
        }

        return $title;
    }
);



// ACF Custom WYSYWYG style select
// Callback function to insert 'styleselect' into the $buttons array
add_filter(
    'mce_buttons_2',
    function ($buttons) {
        array_unshift($buttons, 'styleselect');
        return $buttons;
    }
);

/*
* Callback function to filter the MCE settings
*/
add_filter(
    'tiny_mce_before_init',
    function ($init_array) {
        // Define the style_formats array

        $style_formats = array(
        /*
        * Each array child is a format with it's own settings
        * Title is the label which will be visible in Formats menu
        * Block defines whether it is a span, div, selector, or inline style
        * Classes allows you to define CSS classes
        * Wrapper whether or not to add a new block-level element around any selected elements
        */
            array(
                'title' => 'Headline',
                'selector' => 'span',
                'classes' => 'headline',
                'wrapper' => false,
            ),
            array(
                'title' => 'Button Solid',
                'selector' => 'a',
                'classes' => 'button button-solid',
                'wrapper' => false,
            ),
            array(
                'title' => 'Button Hollow',
                'selector' => 'a',
                'classes' => 'button button-hollow',
                'wrapper' => false,
            ),
            array(
                'title' => 'Button (Docs)',
                'selector' => 'a',
                'classes' => 'doc-button',
                'wrapper' => false,
            ),
            array(
                'title' => 'Download Button',
                'selector' => 'a',
                'classes' => 'doc-button download',
                'wrapper' => false,
            ),
            array(
                'title' => 'List Blue Box',
                'selector' => 'ul',
                'classes' => 'list-box',
                'wrapper' => false,
            ),
            array(
                'title' => 'List Checkmarks',
                'selector' => 'ul',
                'classes' => 'list-checkmarks',
                'wrapper' => false,
            ),
            array(
                'title' => 'List Circle Checkmarks',
                'selector' => 'ul',
                'classes' => 'list-circle-checkmark',
                'wrapper' => false,
            ),
            array(
                'title' => 'List Video Play',
                'selector' => 'ul',
                'classes' => 'list-video-play',
                'wrapper' => false,
            ),
            array(
                'title' => 'Numbered List Circles (Large)',
                'selector' => 'ol',
                'classes' => 'ol-circles',
                'wrapper' => false,
            ),
            array(
                'title' => 'Numbered List Circles (small)',
                'selector' => 'ol',
                'classes' => 'ol-circles-sm',
                'wrapper' => false,
            ),
            array(
                'title' => 'Background Gradient (Service)',
                'block' => 'span',
                'classes' => 'bg-gradient-service',
                'wrapper' => false,

            ),
            array(
                'title' => 'Background Gradient (Clips)',
                'block' => 'span',
                'classes' => 'bg-gradient-clips',
                'wrapper' => true,
            ),
            array(
                'title' => 'Background Gradient (Clips V2)',
                'block' => 'span',
                'classes' => 'bg-gradient-clip-v2',
                'wrapper' => true,
            ),
            array(
                'title' => 'Blockquote (Testimonial)',
                'block' => 'blockquote',
                'classes' => 'custom-blockquote testimonial-quote',
                'wrapper' => true,
            ),
        );

        // Insert the array, JSON ENCODED, into 'style_formats'
        $init_array['style_formats'] = json_encode( $style_formats );

        return $init_array;
    }
);

// Keep Knowledge Hub at 20 results per page. No campaign logic. No offset tweaks.
add_action('pre_get_posts', function ($q) {
  if (is_admin()) return;

  // Only when rendering the Knowledge Hub page
  $pagename = get_query_var('pagename') ?: '';
  if ($pagename !== 'knowledge-hub') return;

  // Enforce 20 per page; let S&F handle paged/offets
  $q->set('posts_per_page', 20);
}, 9999);


// add_action(
//     'pre_get_posts',
//     function ($query) {
//         $pagename = (get_query_var('pagename')) ? get_query_var('pagename') : 0;
//         if (!is_admin() && 'knowledge-hub' == $pagename) {
//             // keep going with filters
//         } else {
//             return;
//         }
//         $current_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
//         $current_page = max(1, $current_page);

//         $campaignAd = get_field('campaign_ad', 'options');
//         if (!$campaignAd) {
//             return;
//         }

//         $offset_start = -2;
//         //Apply adjust page offset
//         if ($current_page === 1) {
//             if ($campaignAd) {
//                 $per_page = 18;
//             } else {
//                 $per_page = 20;
//             }
//             $offset = 0;
//         } else {
//             $per_page = 20;
//             $offset = ( $current_page - 1 ) * $per_page + $offset_start;

//         }
//         $query->set('posts_per_page', $per_page);
//         $query->set('offset', $offset);
//     }, 1
// );

/* Remove password form message */
add_filter(
    'the_password_form',
    function ($output) {
        return str_replace(
            'This content is password protected. To view it please enter your password below:',
            '',
            $output
        );
    return $output;
});

/**
* Removes or edits the 'Protected:' part from posts titles
*/
add_filter(
    'protected_title_format',
    function () {
        return __('%s');
    }
);

// Redirect press permalinks with external links
add_action(
    'template_redirect',
    function () {
        if (is_singular( 'press') ) {
            $external_link = get_field('external_link');
            if ($external_link) {
                wp_redirect($external_link, 302);
                exit;
            }
        }
    }
);

add_action(
    'init',
    function () {
        add_rewrite_endpoint('get-help', EP_PERMALINK);
    }
);



add_action(
    'loop_start',
    function () {
        // main query only
        if (!is_main_query()) {
            return;
        }
        $debug = get_query_var('get-help');
        // look for a debug query variable that has a value
        if (!empty($debug) ) {
            // show post information if on a permalink
            if ($debug == 'post') {
                $post = get_post();
                d($post);
            }
            // show wp_query info if debug has value of "query"
            if ($debug == 'query') {
                global $wp_query;
                d($wp_query);
            }
        }
    }
);

add_action(
    'init',
    function () {
        add_rewrite_rule(
            '^(thank-you)/([^/]*)/?',
            'index.php?pagename=thank-you&page_slug=$matches[2]',
            'top'
        );
    }
);

add_filter(
    'query_vars',
    function( $vars ) {
        $vars[] = 'page_slug';
        $vars[] = 'doc';

        return $vars;
    }
);

add_filter(
    'acf/load_field/name=network_form_id',
    function ($field ) {

        // reset choices
        $field['choices'] = array();

        global $post;
        $network_forms = get_field('network_forms', $post->ID);

        foreach ($network_forms as $index => $form) :
            $field['choices'][ $index ] = $form['title'];
        endforeach;

        return $field;
    }
);

// get head code from options
// get head code from options (defer non-critical marketing scripts)
add_action(
    'wp_head',
    function () {
        $html = '';
        $header_code = get_field('header_code_repeater', 'option');
        if ($header_code) {
            foreach ($header_code as $code) {
                $html .= $code['header_code'];
            }
        }

        // Add 'defer' to external <script src="..."> from marketing.uniteus.com / pi.pardot.com
        // Leaves inline scripts and other domains untouched.
        $html = preg_replace(
            '#<script\s+([^>]*?)src=("|\')(https://(?:marketing\.uniteus\.com|pi\.pardot\.com)[^"\']+)("|\')([^>]*)>\s*</script>#i',
            '<script $1 src="$3" defer $5></script>',
            $html
        );

        echo $html;
    },
    20 // run after default head output
);

// Defer the raw CookieYes script that prints in <head>.
add_action('template_redirect', function () {
  if (is_admin() || is_feed() || is_customize_preview()) return;

  ob_start(function ($html) {
    // Add defer to CookieYes (cdn-cookieyes.com) tag in <head>
    $html = preg_replace(
      '#<script\s+([^>]*?)src=(["\'])(https://cdn-cookieyes\.com[^"\']+)\2([^>]*)>\s*</script>#i',
      '<script $1 src=$2$3$2 defer$4></script>',
      $html
    );
    return $html;
  });
}, 0);

add_action('shutdown', function () {
  while (ob_get_level() > 0) { @ob_end_flush(); }
}, 0);

// get footer code from options
add_action(
    'wp_footer',
    function () {
        $html = '';
        $footer_code = get_field('footer_code_repeater', 'option');
        if ($footer_code) {
            foreach ($footer_code as $code) {
                $html .= $code['footer_code'];
            }
        }
        echo $html;
    }
);

// force 404 network has no form; redirects to network landing
add_action(
    'wp',
    function () {
        global $post, $wp_query;
        if (is_singular('network')) {
            $isGetHelp = View\Composers\Post::isGetHelp();
            $networkFormId = View\Composers\Post::getNetworkFormId();
            $network_forms_repeater = get_field('network_forms', $networkFormId);

            $repeater = get_field('network_forms', $networkFormId);
            $slug = $isGetHelp;
            $network_forms = [];
            if (is_array($network_forms_repeater)) {
                foreach ($network_forms_repeater as $index => $form) {
                    if ($form['network_form_slug']) {
                        $index = $form['network_form_slug'];
                    }
                    $network_forms[$index] = $form;
                }
            }
            $form_page_id  = View\Composers\Post::getHelpPage();

            if (is_numeric($form_page_id)) {
                $form_index = $form_page_id-1;
            } else {
                $form_index = $form_page_id;
            }

            $has_form = true;

            if (!$network_forms) {
                $network_forms = [];
            }
            if ($isGetHelp && (count($network_forms) > 0)) {
                if ($form_page_id) {
                    if (!isset($network_forms[$form_index])) {
                       $has_form = false;
                    }
                }

                if (isset($wp_query->query_vars['get-help']) && ($form_page_id == '0')) {
                    $has_form = false;
                }
            } else {
                $has_form = false;
            }

            if ((!$has_form && $isGetHelp)) {
                $wp_query->set_404();
                status_header(404);
            }
        }
    }
);

// fix taxonomy bug on filters
add_filter(
    'wp_pagenavi',
    function ($html) {
            $out = '';
            if (is_archive()) {
                    $obj = get_queried_object();
                    if (isset($obj->taxonomy)) {
                        $out = str_replace(home_url(), home_url(). '/' . $obj->taxonomy, $html);
                    } else {
                        return $html;
                    }
            } else {
                    return $html;
            }
            return $out;
    }
);

// Delete post via API
add_action(
    'wp_trash_post',
    function ($post_id) {
        if ($post_id) {
            $mirror_post = get_field('mirror_post', $post_id);
            if (!$mirror_post) {
              return false;
            }

            $post_type = get_post_type($post_id);
            if ($post_type == 'post') {
                $endpoint = 'posts';
            } elseif ($post_type == 'page') {
                $endpoint = 'pages';
            } else  {
                $endpoint = $post_type;
            }

            // login is created in remote site; part of wp core
            $login = get_field('rest_user', 'mirror_options');
            $password = get_field('rest_password', 'mirror_options');

            $fields = get_fields($post_id, false); // get acf fields



            $remote['url'] = get_field('rest_url', 'mirror_options');

            $remote_post_id = get_post_meta($post_id, 'remote_post_id', true);


            if (!$remote_post_id) {
                return; // abort
            }

            $wp_request_headers = array(
                'Authorization' => 'Basic ' . base64_encode( "$login:$password" ),
            );

            $wp_request_url = $remote['url'] . '/wp-json/wp/v2/' . $endpoint . '/' . $remote_post_id;


            $wp_delete_post_response = wp_remote_request(
            $wp_request_url,
            array(
                'method'    => 'DELETE',
                'headers'   => $wp_request_headers
            )
            );
            //  echo wp_remote_retrieve_response_code( $wp_delete_post_response ) . ' ' . wp_remote_retrieve_response_message( $wp_delete_post_response );
        }

     }, 10, 1
);

add_filter(
    'register_post_type_args',
    function ($args, $post_type) {
        $args['show_in_rest'] = true;

        return $args;
    }, 10, 2
);

// Remove from trash via API
add_action(
    'untrash_post',
    function ($post_id, $post) {
        if ($post_id) {
            $mirror_post = get_field('mirror_post', $post_id);
            if (!$mirror_post) {
                return false;
            }

            $post_type = get_post_type($post_id);
            if ($post_type == 'post') {
                $endpoint = 'posts';
            } elseif ($post_type == 'page') {
                $endpoint = 'pages';
            } else  {
                $endpoint = $post_type;
            }

            // login is created in remote site; part of wp core
            $login = get_field('rest_user', 'mirror_options');
            $password = get_field('rest_password', 'mirror_options');

            $fields = get_fields($post_id, false); // get acf fields; no formatting logic

            $remote['url'] = get_field('rest_url', 'mirror_options');

            $remote_post_id = get_post_meta($post_id, 'remote_post_id', true);


            if (!$remote_post_id) {
                return; // abort
            }

            $wp_request_headers = array(
                'Authorization' => 'Basic ' . base64_encode( "$login:$password" ),
            );

            $wp_request_url = $remote['url'] . '/wp-json/wp/v2/' . $endpoint . '/' . $remote_post_id;

            $wp_delete_post_response = wp_remote_request(
            $wp_request_url,
            array(
                'method'    => 'DELETE',
                'headers'   => $wp_request_headers
            )
            );
            //  echo wp_remote_retrieve_response_code( $wp_delete_post_response ) . ' ' . wp_remote_retrieve_response_message( $wp_delete_post_response );
        }

     }, 10, 3
);

// Add post via API
add_action(
    'acf/save_post',
    function ($post_id) {
        // Listen for publishing of a new post
        if ($post_id) {

            // checkmark check for mirror
            $mirror_post = get_field('mirror_post', $post_id);
            if (!$mirror_post) {
                return false;
            }
            // login is created in remote site; part of wp core
            $login = get_field('rest_user', 'mirror_options');
            $password = get_field('rest_password', 'mirror_options');

            $fields = get_fields($post_id, false); // get acf fields



            $remote['url'] = get_field('rest_url', 'mirror_options');

            $post_status = get_post_status($post_id); // default
            $post_meta = get_post_meta($post_id);

            // Get the post as an array
            $duplicate = get_post($post_id, 'ARRAY_A');


            $post_slug = $duplicate['post_name'];
            $post_password = $duplicate['post_password'];

            $terms = [];
            $yoast_meta = [];

            // Remove some of the keys
                unset( $duplicate['ID'] );
                unset( $duplicate['guid'] );
                unset( $duplicate['comment_count'] );


$custom_fields_sanitized = [];
            // Retrieves post meta fields, based on post ID.
        $custom_fields = get_post_custom($post_id);


        if (is_array($custom_fields)) {
            foreach ($custom_fields as $key => $field) {
                if (is_array($field)) {
                    $field = $field[0];
                }
                if (is_bool($field)) {
                    $field = rest_sanitize_boolean($field);
                }
                $custom_fields_sanitized[$key] = $field;
            }
        }

        if ($duplicate['post_type'] == 'post') {
            $endpoint = 'posts';
        } elseif ($duplicate['post_type'] == 'page') {
            $endpoint = 'pages';
        } else  {
            $endpoint = $duplicate['post_type'];
        }



    $remote_post_exists = false;
    $api_response = wp_remote_get(
        $remote['url'] . '/wp-json/wp/v2/' . $endpoint .'/' . $post_id,
        array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode("$login:$password"),
                'Content-Type: application/json',
                'sslverify' => false,
            ),
        )
    );




    $remote_post_response = wp_remote_retrieve_response_message($api_response);

if ('Not Found' == $remote_post_response) {
        if (isset($custom_fields['remote_post_id'][0])) {
            $remote_post_id = $custom_fields['remote_post_id'][0];
        } else {
            $remote_post_id = '';
        }
    } else {
        $remote_post_id = $post_id;
        $remote_post_exists = true;
    }



        // Duplicate all the taxonomies/terms
	$taxonomies = get_object_taxonomies( $duplicate['post_type'] );
	foreach( $taxonomies as $taxonomy ) {
        $term = wp_get_post_terms( $post_id, $taxonomy, array('fields' => 'slugs') );
        if (!empty($term) && is_array($term)) {
		    $terms[$taxonomy] = implode(',', $term); // for json needs to be a string
        }

	}


    // upload featured image via api
    $featured_image_url = get_the_post_thumbnail_url($post_id);
    $featured_image_id = 0;
    $remote_image_exists = false;

    // check if remote image exists
    // https://kellenmace.com/check-if-a-remote-image-file-exists-in-wordpress/

   ////// function km_remote_image_file_exists( $url ) {
    $home_url = get_home_url();
    $remote_featured_image_url = str_replace($home_url, $remote['url'], $featured_image_url);
	$featured_image_response = wp_remote_head($remote_featured_image_url);

	if (200 === wp_remote_retrieve_response_code($featured_image_response)) {
        $remote_image_exists = true;
    }
//}


if ($featured_image_url && !$remote_image_exists) {
$headers = array(
    'headers' => array(
        'Authorization' => 'Basic ' . base64_encode( "$login:$password" ),
        'Content-Disposition' => 'attachment; filename="' . basename( $featured_image_url ) . '"',
        'Content-Type: ' . wp_get_image_mime( $featured_image_url ),
        'sslverify' => false,
    ),
    'body' => file_get_contents( $featured_image_url )
);

$request = wp_remote_post(
	$remote['url'] . '/wp-json/wp/v2/media', $headers

);

if( 'Created' === wp_remote_retrieve_response_message( $request ) ) {
	$body = json_decode( wp_remote_retrieve_body( $request ) );
	$featured_image_id = $body->id;
}

}

    $post_type = get_post_type($post_id);
    if ($post_type == 'post') {
        $endpoint = 'posts';
    } elseif ($post_type == 'page') {
        $endpoint = 'pages';
    } else  {

    $endpoint = $duplicate['post_type'];
    }

$yoast_is_active = is_plugin_active('wordpress-seo/wp-seo.php');

if ($yoast_is_active) {
    $yoast = YoastSEO()->meta->for_post($post_id);

    $yoast_meta = [
         [
            'key' => '_yoast_wpseo_metadesc',
            'value' => $yoast->description,
        ],
        [
            'key' => 'yoast_wpseo_metadesc',
            'value' => $yoast->description,
         ],
    ];

}

    // if remote_post_id do an update
    $post_date = get_post_timestamp($post_id);
    $datetime = date('Y-m-d h:i:s', $post_date);

    $body = array(
        'title'   => get_the_title($post_id),
        'post_date' => $datetime,
        'post_name' => $post_slug,
        'status'  => $post_status,
        'content' => $duplicate['post_content'],
        'excerpt' => $duplicate['post_excerpt'],
        'meta' => $custom_fields_sanitized,
        //'categories' => '118',
        'acf' => (array)$fields,
        'taxonomy_slugs' => $terms,
        'featured_media' => $featured_image_id,
        'yoast_meta' => $yoast_meta,
    );



            $api_response = wp_remote_post(
                $remote['url'] . '/wp-json/wp/v2/' . $endpoint .'/' . $remote_post_id,
                array(
                    'headers' => array(
                        'Authorization' => 'Basic ' . base64_encode("$login:$password"),
                        'Content-Type: application/json',
                        'sslverify' => false,
                    ),
                    'body' => $body
                )
            );


//print_r($api_response);die();
            $remote_data = json_decode($api_response['body']);

            $response_message = wp_remote_retrieve_response_message($api_response);


            // If the post was published successfully we can display a little message
            if ($response_message === 'Created') {
                // get remote post id and store in current post custom meta
                echo 'The post ' . $remote_data->title->rendered . ' has been created successfully';
                if (!wp_is_post_revision($post_id)) {
                    add_post_meta($post_id, 'remote_post_id', $remote_data->id, true);
                }
            } else {
                ob_start();
             echo $remote['url'] . '/wp-json/wp/v2/' . $endpoint .'/' . $remote_post_id;
                echo ' ' . $response_message;
            echo wp_remote_retrieve_response_code($api_response);
            $data = ob_get_contents();
    ob_end_clean();
    wp_mail('josejtamayo@gmail.com', 'error api response', $data);
        }

        }

    }, 20
);

// DEV SITE
add_action(
    'rest_insert_post',
    function($post, $request, $creating) {
        ob_start();
        $params = $request->get_body_params();
       print_r($params);
        $data = ob_get_contents();
        ob_end_clean();
        wp_mail('josejtamayo@gmail.com', 'POST data via api', $data);

        // new post
        if ($creating) {
        }
            // loop through taxonomy slugs
            if ($params['taxonomy_slugs'] && is_array($params['taxonomy_slugs'])) {
                ob_start();

               print_r($params['taxonomy_slugs']);
                $data = ob_get_contents();
                ob_end_clean();
                wp_mail('josejtamayo@gmail.com', 'POST taxonomy slugs via api', $data);
                foreach ($params['taxonomy_slugs'] as $taxonomy => $terms) {

                        $terms_array = explode(',', $terms);
                            // Assign a term to our post
                            wp_set_object_terms( $post->ID, $terms_array, $taxonomy);


                }
            }
            // if term does not exist, create it

            // assign proper term ids


            // meta
            if ($params['yoast_meta'] && is_array($params['yoast_meta'])) {
                foreach ($params['yoast_meta'] as $index => $seo) {
                        update_post_meta($post->ID, $seo['key'], $seo['value']);
                }
            }


            $time = $params['post_date'];

            // update slug
            $new_slug = $params['post_name'];
            wp_update_post( array(
                'ID' => $post->ID,
                'post_name' => $new_slug,
                'post_date' => $time,
                'post_date_gmt' => get_gmt_from_date($time),
            ));

    }, 10, 3
);

/*
add_filter(
    'rest_prepare_post',
    function ($response, $post, $request ) {
        $reponse['title'] = 'my new title';
        $response['meta']['gated_page_featured_image'] = [3552];


        return $response;
    }, 10, 3
);
*/

// add position to team
add_filter(
    'acf/fields/relationship/result',
    function ($text, $post, $field, $post_id) {
        $position = get_field('position', $post->ID);
        $first_name = get_field('first_name', $post->ID);
        $last_name = get_field('last_name', $post->ID);
        if ($first_name) {
            $text = str_replace(get_the_title($post->ID), $first_name . ' ' . $last_name, $text);
        }
        if ($position) {
            $text .= ' ' . sprintf('(%s)', $position);
        }
        return $text;
    }, 10, 4
);

// alphabetize network team by last name
add_filter(
    'acf/fields/relationship/query',
    function ($args, $field, $post_id) {
        // TO DO: add condition to only apply to team posts with last_name
        // modify the order
        //$args['meta_key'] = 'last_name';
        //$args['orderby'] = 'meta_value';
        //$args['order'] = 'ASC';

        return $args;
    }, 10, 3
);

// uncheck mirror checkbox on post load
add_filter(
    'acf/load_field/name=mirror_post',
    function ($field) {

        $field['value'] = false;
        return $field;
    }
);

/**
 * Returns menu items in a array based on the navigation menu id passed
 *
 * @param object The actual request where parameters can be accessed.
 * @return array The menu items contained in that specific menu
 */
function expose_navigation($request) {
    $id = $request['id'];
    return wp_get_nav_menu_items($id);
  }

  /**
   * Exposes under /navigation/{id} the menu items in the wp-json api
   *
   * @return void
   */
  add_action('rest_api_init',
    function($request) {
        register_rest_route( 'wp/v2', '/navigation/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => function($request) {
                $id = $request['id'];
                return wp_get_nav_menu_items($id);
            },
            'permission_callback' => '__return_true',
          ]
        );
    }
);

add_filter(
    'bladesvg',
    function () {
        return [
            'svg_path' => 'resources/icons/',
            'spritesheet_path' => '',
            'spritesheet_url' => '',
            'sprite_prefix' => '',
            'inline' => true,
            'class' => ''
        ];
    }
);

add_action(
    'addtoany_script_disabled',
    function ($script_disabled) {
        // Allow only on single posts (of any post type)
        if (is_singular('post')) {
            return $script_disabled;
        }
        return true;
    }, 10
);

/*
add_action(
    'wp_enqueue_scripts',
    function () {
        if (is_front_page()) {
            wp_deregister_script('jquery');
        }
    }
);
*/

add_action(
    'wp_enqueue_scripts',
    function () {
        wp_deregister_style('search-filter-plugin-styles');
    }
);

//Disable emojis in WordPress
add_action(
    'init',
    function () {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }
);

add_action(
    'acf/init',
    function () {

        // Check function exists, then include and register the custom location type class.
        if( function_exists('acf_register_location_type') ) {
            acf_register_location_type( 'My_ACF_Location_Post_Layout' );
        }
    }
);

add_action(
    'acf/save_post',
    function ($post_id) {
        $selector   = 'alerts_unique_id';
        $value      = wp_generate_uuid4();
        if (get_field($selector, $post_id)) {
            update_field($selector, $value, $post_id);
        }
    }, 10, 1
);

/* OLD defer parsing js */
// add_filter('script_loader_tag',
//     function ($url) {
//         if (is_user_logged_in()) return $url; //don't break WP Admin
//         if (FALSE === strpos( $url, '.js')) return $url;
//         if (strpos($url, 'jquery.js')) return $url;
//         if (strpos($url, 'jquery.min.js')) return $url;
//         if (strpos($url, 'iframeResizer')) return $url;
//         return str_replace(' src', ' defer src', $url);
//     }, 10
// );

// add_filter(
//     'oembed_fetch_url',
//     function ($provider, $url, $args) {
//         if (!strstr($url, 'vimeo.com')) {
//             return $html;
//         }

//         if (strpos($url, 'background')) {
//             $provider = add_query_arg('background', 1, $provider);
//         }
//         /*
//         $provider = add_query_arg('title', 0, $provider);
//         $provider = add_query_arg('byline', 0, $provider);
//         $provider = add_query_arg('badge', 0, $provider);
//         $provider = add_query_arg('controls', 1, $provider);
//         */

//         return $provider;
//     }, 10, 3
// );
add_filter(
    'oembed_fetch_url',
    function ($provider, $url, $args) {
        if (!strstr($url, 'vimeo.com')) {
            return $provider;
        }

        if (strpos($url, 'background')) {
            $provider = add_query_arg('background', 1, $provider);
        }
        /*
        $provider = add_query_arg('title', 0, $provider);
        $provider = add_query_arg('byline', 0, $provider);
        $provider = add_query_arg('badge', 0, $provider);
        $provider = add_query_arg('controls', 1, $provider);
        */

        return $provider;
    }, 10, 3
);

// remove body class names for top level main nav
// fixes warped menu
add_filter(
    'body_class',
    function ($wp_classes, $extra_classes) {
        // List body classes to delete
        $class_delete = array('company', 'resources', 'solutions');

        // Verify if exist the class of WP in $class_delete
        foreach ($wp_classes as $class_css_key => $class_css) {
            if (in_array($class_css, $class_delete)) {
                unset($wp_classes[$class_css_key]);
            }
        }

        // Add the extra classes back untouched
        return array_merge( $wp_classes, (array) $extra_classes );
    }, 20, 2
);

// 1) Move core jQuery + migrate to FOOTER (safe for dependencies)
add_action('wp_default_scripts', function ($scripts) {
  if (is_admin()) return;
  foreach (['jquery','jquery-core','jquery-migrate'] as $h) {
    if (isset($scripts->registered[$h])) {
      $scripts->registered[$h]->extra['group'] = 1; // footer
    }
  }
}, 1);

// In case any plugin re-registers them in <head>, force them to footer last:
add_action('wp_enqueue_scripts', function () {
  if (is_admin()) return;
  $ws = wp_scripts();
  foreach (['jquery','jquery-core','jquery-migrate'] as $h) {
    if (isset($ws->registered[$h])) {
      $r = $ws->registered[$h];
      wp_deregister_script($h);
      wp_register_script($h, $r->src, $r->deps, $r->ver, true); // true => footer
      wp_enqueue_script($h);
    }
  }
}, 9999);

// 2) Defer the exact offenders Lighthouse lists (NOT jQuery)
add_filter('script_loader_tag', function ($tag, $handle, $src) {
  if (is_admin()) return $tag;

  // leave JSON-LD / modules alone
  if (strpos($tag, 'type="application/ld+json"') !== false) return $tag;
  if (strpos($tag, ' type="module"') !== false) return $tag;

  // never defer jQuery core/migrate
  if (in_array($handle, ['jquery','jquery-core','jquery-migrate'], true)) return $tag;

  $is_search_filter = strpos($src, 'search-filter-build.min.js') !== false;
  $is_cookieyes     = strpos($src, 'cdn-cookieyes.com') !== false;
  $is_iframe_resizer= strpos($src, 'iframeResizer') !== false;
  $is_theme_bundle  = (strpos($src, '/wp-content/themes/') !== false && strpos($src, '/public/') !== false && substr($src, -3) === '.js');

  if ($is_search_filter || $is_cookieyes || $is_iframe_resizer || $is_theme_bundle) {
    if (strpos($tag, ' defer') === false) $tag = str_replace('<script ', '<script defer ', $tag);
  }
  return $tag;
}, 999, 3);

// If some plugin still forces jQuery in <head>, make it non-blocking on the homepage.
add_filter('script_loader_tag', function ($tag, $handle, $src) {
  if (is_admin() || !is_front_page()) return $tag;

  if (in_array($handle, ['jquery','jquery-core','jquery-migrate'], true)) {
    if (strpos($tag, ' defer') === false) {
      $tag = str_replace('<script ', '<script defer ', $tag);
    }
  }
  return $tag;
}, 1000, 3);

