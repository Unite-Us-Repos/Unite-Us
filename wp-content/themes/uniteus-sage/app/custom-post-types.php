<?php
/**
 * Post Types
 */

 // register team
add_action('init', 'register_cpt_team');

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

add_action('init', 'register_cpt_1c');

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

    // Now register the taxonomy
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
}

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

// register Network Team
add_action('init', 'register_cpt_network_team');

function register_cpt_network_team()
{
    register_post_type(
        'network_team',
        array(
            'labels' => array(
                'name'               => 'Network Team',
                'singular_name'      => 'Network Team',
                'menu_name'          => 'Network Team',
                'name_admin_bar'     => 'Network Team',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Member',
                'edit_item'          => 'Edit Member',
                'new_item'           => 'New Member',
                'view_item'          => 'View Member',
                'search_items'       => 'Search Network Team',
                'not_found'          => 'No Network Team found',
                'not_found_in_trash' => 'No Network Team found in trash',
                'all_items'          => 'Network Team',
            ),

            'public'        => true,
            'menu_position' => 14,
            'supports'      => array('title', 'editor', 'thumbnail'),
            'show_in_rest'  => false,
            'show_in_menu'         => 'edit.php?post_type=network',
            'taxonomies'    => array(''),
            'menu_icon'     => 'dashicons-groups',
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

    // now let's add categories (these act like categories)
    register_taxonomy(
        'press_cat',
        array('press'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
        array('hierarchical' => true,     /* if this is true, it acts like categories */
            'labels' => array(
                'name' => __('Categories', 'sage'), /* name of the taxonomy */
                'singular_name' => __('Category', 'sage'), /* single taxonomy name */
                'search_items' =>  __('Search Categories', 'sage'), /* search title for taxomony */
                'all_items' => __('All Categories', 'sage'), /* all title for taxonomies */
                'parent_item' => __('Parent Category', 'sage'), /* parent title for taxonomy */
                'parent_item_colon' => __('Parent Category:', 'sage'), /* parent taxonomy title */
                'edit_item' => __('Edit Category', 'sage'), /* edit taxonomy title */
                'update_item' => __('Update Category', 'sage'), /* update title for taxonomy */
                'add_new_item' => __('Add New Category', 'sage'), /* add new title for taxonomy */
                'new_item_name' => __('New Category Name', 'sage') /* name title for taxonomy */
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

    // Now register the taxonomy
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

    // Now register the taxonomy
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

    // Post custom taxonomy
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
    // Now register the taxonomy
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


    // Post custom taxonomy
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
    // Now register the taxonomy
    register_taxonomy(
        'topic', array('post'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'topic' ),
        )
    );
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
            'has_archive'   => false
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

    // Now register the taxonomy
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
}

add_action( 'init', 'cameronjonesweb_unregister_tags' );

/**
 * Removes tags from blog posts
 */
function cameronjonesweb_unregister_tags() {
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
