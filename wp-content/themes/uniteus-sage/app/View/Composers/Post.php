<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.content-*',
        'single'
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        return [
            'title' => $this->title(),
            'acf' => $this->getAcfFields(),
            'team' => $this->getTeam(),
            'posts' => $this->getPosts(),
            'member' => $this->getMember(),
            'press' => $this->getPress(),
            'aboutUniteUs' => $this->getAboutUniteUs(),
            'type' => $this->getType(),
            'catSlug' => $this->getPostCatSlug(),
            'postSlug' => $this->getPostSlug(),
            'postType' => $this->getPostType(),
            'stateOptions' => $this->getStateOptions(),
            'socialButtons' => $this->getSocialButtons(),
            'socialPosts' => $this->getSocialPosts(),
            'postTopics' => $this->getPostTopics(),
            'isGetHelp' => $this->isGetHelp(),
            'networkFormSelect' => $this->getNetworkFormSelect(),
            'networkFormId' => $this->getNetworkFormId(),
            'networkHeaderText' => $this->networkHeaderText(),
            'networkFooterText' => $this->networkFooterText(),
            'getHelpPage' => $this->getHelpPage(),
            'anchorLinks' => $this->getAnchorLinks(),
            'networkActiveStates' => $this->getNetworkFormActiveStates(),
            'recommendedPagesData' => $this->getRecommendedPagesData(),
        ];
    }

    /**
     * Returns the post title.
     *
     * @return string
     */
    public function title()
    {
        if ($this->view->name() !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for "%s"', 'sage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }

    public static function getType($id = '')
    {
        global $post;

        $post_type = get_post_type($id);

        $taxonomy_list = [
            'post' => 'category',
            'press' => 'press_cat',
        ];

        $taxonomy = isset($taxonomy_list[$post_type]) ? $taxonomy_list[$post_type] : false;

        if (!$taxonomy) {
            $taxonomy = 'category';
        }

        if (!$id) {
            $id = $post->ID;
        }

        $label = '';

        if ($id) {
            $term_obj_list = get_the_terms($id, $taxonomy);
            $terms_string = join(', ', wp_list_pluck($term_obj_list, 'name'));
            return $terms_string;
        }

        return $label;
    }

    public static function getPostSlug()
    {
        global $post;
        return $post->post_name;
    }

    public static function getPostType()
    {
        global $post;
        return get_post_type($post);
    }

    public static function getPostCatSlug($id = '')
    {
        global $post;
        if (!$id) {
            $id = $post->ID;
        }

        $label = '';

        if ($id) {
            $term_obj_list = get_the_terms($id, 'category');
            $terms_string = join(', ', wp_list_pluck($term_obj_list, 'slug'));

            return $terms_string;
        }

        return $label;
    }

    public function getAcfFields()
    {
        $fields = get_fields(get_the_ID());

        if (isset($fields["components"]) && is_array($fields["components"])) {
            foreach ($fields["components"] as $index => $field) {
                if (isset($field["layout_settings"])) {
                    foreach ($field["layout_settings"] as $index => $settings) {
                        $fields[$index] = $settings;
                    }
                }
            }
        }

        return $fields;
    }

    /**
     * Returns member by post ID.
     *
     * @return array
     */
    public function getMember()
    {
        $args = [
            'post_type'         => 'team',
            'posts_per_page'    => -1,
            'p' => get_the_ID(),
        ];

        $posts = $this->queryPosts($args);

        if (isset($posts[0])) {
            return $posts[0];
        }

        return false;
    }

    public static function getPosts($ppp = -1, $taxonomy = '', $post_ids = '', $exclude_ids = '')
    {
        $args = [
            'post_type'         => 'post',
            'posts_per_page'    => $ppp,
            'post_status'       => 'publish',
        ];

        if ($post_ids) {
            $args['post__in']  = $post_ids;
            $args['orderby']   = 'post__in';
        }

        if ($exclude_ids) {
            $args['post__not_in']  = $exclude_ids;
        }

        if ($taxonomy) {
            $args['tax_query'] = array(
                array(
                    'taxonomy'  => $taxonomy['slug'],
                    'field'     => 'term_id',
                    'terms'     => $taxonomy['ids'],
                ),
            );
        }
        if (is_page('one-continuum')) {
            $args['post_type'] = '1c';
        }

        $postItems = [];
        $index = 0;

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $slug = get_post_field('post_name', get_post());
                $postItems[$index]['ID']            = get_the_ID();
                $postItems[$index]['permalink']     = get_the_permalink();
                $postItems[$index]['thumbnail_url'] = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');

                $postItems[$index]['thumbnail_url_lg'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_id = get_post_thumbnail_id(get_the_ID());
                $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                $postItems[$index]['thumbnail_alt'] = $alt_text;
                $postItems[$index]['post_title']    = get_the_title();
                $postItems[$index]['date']          = get_the_date('F j, Y');
                $postItems[$index]['slug']          = $slug;
                $postItems[$index]['is_external']   = false;

                $index++;
            }
        }

        wp_reset_postdata();

        if (count($postItems)) {
            return $postItems;
        }

        return [];
    }

    public function getStateOptions()
    {
        $options = '<option value="">All</option>';
        $selected = '';
        $the_state = isset($_GET['state']) ? $_GET['state'] : '';
        $taxonomy = 'states';
        $args = array(
           'hide_empty' => false
        );

        $states = get_terms($taxonomy, $args);

        foreach ($states as $index => $state) {
            if ('all' == $state->slug) {
                continue;
            }
            if ($the_state === $state->slug) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $options .= "<option value=\"{$state->slug}\" {$selected}>{$state->name}</option>";
        }
        return $options;
    }

    public function networkHeaderText()
    {
        $network_form_id = $this->getNetworkFormId();

        if (is_singular('network')) {
            $repeater = get_field('network_forms', $network_form_id);
            $slug = $this->getNetworkFormSlug();
            $new_repeater = [];
            $custom_text = '';

            if ($repeater && is_array($repeater)) {
                foreach ($repeater as $index => $form) {
                    $acf_index = $index;
                    if (is_numeric($index)) {
                        $acf_index = $index+1;
                    }
                    if ($form['network_form_slug']) {
                        $acf_index = $form['network_form_slug'];
                    }

                    if ($slug == $acf_index) {
                        $custom_text = $form['header_text'];
                    }

                    if ($custom_text) {
                        return $custom_text;
                    }
                    $new_repeater[$index] = $form;
                }
            }
        }

        $text = get_field('network_header_text', $network_form_id);
        if (!$text) {
            $text = get_field('network_header_text', 'option');
        }

        return $text;
    }

    public function networkFooterText()
    {
        $network_form_id = $this->getNetworkFormId();

        if (is_singular('network')) {
            $repeater = get_field('network_forms', $network_form_id);
            $slug = $this->getNetworkFormSlug();
            $new_repeater = [];
            $custom_text = '';

            if ($repeater && is_array($repeater)) {
                foreach ($repeater as $index => $form) {
                    $acf_index = $index;
                    if (is_numeric($index)) {
                        $acf_index = $index+1;
                    }
                    if ($form['network_form_slug']) {
                        $acf_index = $form['network_form_slug'];
                    }

                    if ($slug == $acf_index) {
                        $custom_text = $form['footer_text'];
                    }

                    if ($custom_text) {
                        return $custom_text;
                    }
                    $new_repeater[$index] = $form;
                }
            }
        }

        $text = get_field('network_footer_text', $network_form_id);
        if (!$text) {
            $text = get_field('network_footer_text', 'option');
        }

        return $text;
    }

    public static function getNetworkFormId()
    {
        global $post;
        $state = $post->post_name;
        $post_type = 'network_form';
        $args = [
            'post_type'         => $post_type,
            'posts_per_page'    => 1,
            'post_status'       => 'publish',
        ];

        $args['tax_query'] = array(
            array(
                'taxonomy'  => 'states',
                'field'     => 'slug',
                'terms'     => $state,
            ),
        );

        $postItems = [];
        $index = 0;

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $slug = get_post_field('post_name', get_post());
                $postItems[$index]['ID']                = get_the_ID();

                $index++;
            }
        }

        wp_reset_postdata();

        $form = $postItems;

        if (isset($form[0]['ID'])) {
            return $form[0]['ID'];
        }
        return false;
    }

    public function getNetworkFormSelect()
    {
        $network_form_id = $this->getNetworkFormId();
        $network_forms = get_field('network_forms', $network_form_id);
        $new_network_forms = [];
        $options = '';
        $new_array = [];
        if ($network_forms) {
            foreach ($network_forms as $index => $form) {
                if ($form['network_form_slug']) {
                    $index = $form['network_form_slug'];
                }
                if (isset($form['is_standalone_form']) && !$form['is_standalone_form']) {
                    $new_network_forms[$index] = $form;
                }
            }
            // re-build array
            foreach ($new_network_forms as $index => $forms) {
                if ($forms['network_locations']) {
                    foreach ($forms['network_locations'] as $form) {
                        $new_index = '';
                        $label = strtolower($form['label']);
                        $label = str_replace(' ', '-', $label);
                        if (is_numeric($index)) {
                            $new_index = $index+1;
                        } else {
                            $new_index = $index;
                        }
                        $new_array[$label]= [
                            'form_id' => $new_index,
                            'label' => $form['label'],
                        ];
                    }
                }
            }
            ksort($new_array); // order by alphabet ASC

            if ($new_array) {
                //$options = '<select class="w-full bor">';
                //$options .= '<option value="">All</option>';
                $options .= '<div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="w-full relative inline-block text-left">
                <div>
                  <button type="button" class="inline-flex w-full justify-between rounded-md border border-gray-300 bg-white px-4 py-2 text-sm  text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-action focus:ring-offset-2 focus:ring-offset-gray-100" id="menu-button" x-ref="button" @click="onButtonClick()" @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()" aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()">
                    Choose One
                    <svg class="-mr-1 ml-2 h-5 w-5" x-description="Heroicon name: mini/chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
            </svg>
                  </button>
                </div>


                  <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0" class="absolute w-full right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state." x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()" style="display: none;">
                    <div class="py-1" role="none">
                   ';
                // create array of forms
                $index = 0;
                foreach ($new_array as $form) {

                    // $options .= "<option value=\"{$form['form_id']}\">{$form['label']}</option>";
                    $link = get_the_permalink() . 'get-help/' . $form['form_id'] . '/';
                    $options .= '<a href="' . $link . '" class="no-underline block px-4 py-2 text-brand" :class="{ \'bg-gray-100 text-gray-900\': activeIndex === ' . $index . ', \'text-gray-700\': !(activeIndex === ' . $index . ') }" role="menuitem" tabindex="-1" id="menu-item-' . $index . '" @mouseenter="activeIndex = ' . $index . '" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">';
                    $options .= $form['label'];
                    $options .= '</a>';
                    $index++;
                }

                //$options .= '</select>';
                $options .= ' </div>
                </div>

            </div>';
            }
        }
        return $options;
    }

    public function getSocialButtons()
    {
        $social = do_shortcode('[addtoany]');

        return $social;
    }

    public function getSocialPosts()
    {
        $icon_path = get_template_directory_uri() . '/resources/icons/social/';

        $social_post = [
            'twitter' => [
                'label' => 'Tweet',
                'url' => 'https://twitter.com/intent/tweet',
                'icon' => $icon_path . 'twitter.svg',
            ],
            'facebook' => [
                'label' => 'Post',
                'url' => 'https://facebook.com',
                'icon' => $icon_path . 'facebook.svg',
            ],
        ];
        return $social_post;
    }

    public static function urlEncode($string = '')
    {
        $string = str_replace("’", "'", $string);
        $string = html_entity_decode($string);
        $string = urlencode(strip_tags($string));

        return $string;
    }

    public function getPostTopics()
    {
        $terms = get_the_terms(get_the_ID(), 'topic');
        $terms_html = '';
        if ($terms) {
            foreach ($terms as $term) {
                $terms_html .= '<a href="/topic/' . $term->slug . '/" class="mr-6">' . $term->name . '</a>';
            }

            return $terms_html;
        }
        return false;
    }

    public static function isGetHelp()
    {
        global $wp_query, $post;
        $var = 'get-help';
        $post_type = get_post_type($post->ID);
        if ('network' != $post_type) {
            return false;
        }

	    return isset($wp_query->query_vars[$var]);
    }

    public static function getNetworkFormSlug()
    {
        global $wp_query, $post;
        $var = 'get-help';
        $post_type = get_post_type($post->ID);
        if ('network' != $post_type) {
            return false;
        }

        if (!isset($wp_query->query_vars[$var])) {
            return false;
        }

	    return $wp_query->query_vars[$var];
    }

    public static function getHelpPage()
    {
        global $wp_query;
        $var = 'get-help';

	    if (isset($wp_query->query_vars[$var])) {
            return $wp_query->query_vars[$var];
        }
        return false;
    }

    public static function getTeam($taxonomy = '', $post_ids = '', $post_type = 'team')
    {
        $current_id = get_the_ID();

        $args = [
            'post_type'         => $post_type,
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
        ];

        if ($post_ids) {
            $args['post__in']  = $post_ids;
            $args['orderby']   = 'post__in';
        }

        if (is_singular()) {
            // exclude current team member from carousel
            $args['post__not_in'] = array($current_id);

            /*
            $args['tax_query'] = array(
                array(
                    'taxonomy'  => 'team_groups',
                    'field' 	=> 'slug',
                    'terms'	  	=> 'unite-us',
                ),
            );
            */
        }

        if ($taxonomy) {
            $args['tax_query'] = array(
                array(
                    'taxonomy'  => $taxonomy['slug'],
                    'field' 	=> 'term_id',
                    'terms'	  	=> $taxonomy['ids'],
                ),
            );
        }

        $postItems = [];
        $index = 0;

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $slug = get_post_field('post_name', get_post());
                $postItems[$index]['permalink']         = get_the_permalink();
                $postItems[$index]['thumbnail_url']     = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_id = get_post_thumbnail_id(get_the_ID());
                $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                $postItems[$index]['thumbnail_alt']     = $alt_text;
                $postItems[$index]['post_title']        = get_the_title();
                $postItems[$index]['slug']              = $slug;

                $postItems[$index]['bio']               = get_field('bio');
                $postItems[$index]['position']          = get_field('position');
                $postItems[$index]['first_name']        = get_field('first_name');
                $postItems[$index]['middle_name']       = get_field('middle_name');
                $postItems[$index]['last_name']         = get_field('last_name');
                $postItems[$index]['social_media_link'] = get_field('social_media_link');

                $full_name = $postItems[$index]['first_name'] . ' ' . $postItems[$index]['middle_name'] . ' ' . $postItems[$index]['last_name'];
                $full_name = preg_replace('/\s+/', ' ', $full_name);
                $postItems[$index]['full_name'] = $full_name;

                $index++;
            }
        }

        wp_reset_postdata();

        if (count($postItems)) {
            return $postItems;
        }

        return [];
    }

    public static function getPress($taxonomy = '', $ppp = -1, $post_ids = '', $state = '')
    {
        $current_id = get_the_ID();

        $args = [
            'post_type'         => 'press',
            'posts_per_page'    => $ppp,
            'post_status'       => 'publish',
        ];

        if ($post_ids) {
            $args['post__in']  = $post_ids;
            $args['orderby']   = 'post__in';
        }

        if ($state) {
            $args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy'  => 'states',
                    'field'     => 'slug',
                    'terms'     => array($state, 'all'),
                    'operator'  => 'IN',
                ),
                array(
                    'taxonomy'  => 'press_cat',
                    'field'     => 'term_id',
                    'terms'     => $taxonomy,
                ),
            );

        } else {
            if ($taxonomy) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy'  => 'press_cat',
                        'field'     => 'term_id',
                        'terms'     => $taxonomy,
                    ),
                );
            }
        }

        /*
        if ($category) {
            $args['meta_query'] = 'press_category';
            $args['meta_value'] = $category;
        }
        */

        if (is_singular()) {
            $args['post__not_in'] = array($current_id);
        }

        //$data = $this->queryPosts($args);

        $postItems = [];
        $index = 0;

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $post = $query->the_post();
                $slug = get_post_field('post_name', get_post());
                $link_type = get_field('link_type');
                $external_link = get_field('external_link');
                $postItems[$index]['ID']                = get_the_ID();
                $postItems[$index]['permalink']         = get_the_permalink();
                $postItems[$index]['thumbnail_url']     = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_id = get_post_thumbnail_id(get_the_ID());
                $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                $postItems[$index]['thumbnail_alt']     = $alt_text;
                $postItems[$index]['post_title']        = get_the_title();
                $postItems[$index]['date']              = get_the_date('F j, Y');
                $postItems[$index]['slug']              = $slug;
                $postItems[$index]['is_external']       = false;
                $subtitle = '&nbsp;';

                if ($external_link) {
                    $postItems[$index]['permalink']         = $external_link;
                    $postItems[$index]['is_external']       = true;
                }

                if ('team' === $args['post_type']) {
                    $postItems[$index]['bio']               = get_field('bio');
                    $postItems[$index]['position']          = get_field('position');
                    $postItems[$index]['first_name']        = get_field('first_name');
                    $postItems[$index]['middle_name']       = get_field('middle_name');
                    $postItems[$index]['last_name']         = get_field('last_name');

                    $full_name = $postItems[$index]['first_name'] . ' ' . $postItems[$index]['middle_name'] . ' ' . $postItems[$index]['last_name'];
                    $full_name = preg_replace('/\s+/', ' ', $full_name);
                    $postItems[$index]['full_name'] = $full_name;
                }

                if ('press' === $args['post_type']) {
                    $terms = wp_get_post_terms(get_the_ID(), 'states');
                    $state_label = '';
                    if (!$terms) $terms = [];

                    if ($terms) {
                        $state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
                    }

                    if ((count($terms) > 1) && $state) {
                        foreach ($terms as $term) {
                            $state_label = $term->name;
                        }
                    }

                    if ((count($terms) === 1)) {
                        foreach ($terms as $term) {
                            $state_label = $term->name;
                            if ($term->slug == 'all' AND $state != '') {
                                $state_label = ucwords(str_replace('-', ' ', $state));
                            }
                            if ($term->slug == 'all' AND $state == '') {
                                $state_label = 'Multistate';
                            }
                        }
                    }

                    if ((count($terms) > 1) && (!isset($state) OR $state == '')) {
                        $state_label = 'Multistate';
                    }

                    $subtitle = $state_label;

                    $postItems[$index]['subtitle']        = $subtitle;
                }

                $index++;
            }
        }

        wp_reset_postdata();

        if (count($postItems)) {
            return $postItems;
        }

        return [];
    }

    public static function getNetworkPress($state = '', $ppp = -1, $post_type = ['press', 'post'])
    {
        $current_id = get_the_ID();

        $args = [
            'post_type'         => $post_type,
            'posts_per_page'    => $ppp,
            'post_status'       => 'publish',
        ];

        if ($state) {
            $args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy'  => 'states',
                    'field'     => 'slug',
                    'terms'     => array($state),
                    'operator'  => 'IN',
                ),
            );

        } else {

        }

        /*
        if ($category) {
            $args['meta_query'] = 'press_category';
            $args['meta_value'] = $category;
        }
        */

        if (is_singular()) {
            $args['post__not_in'] = array($current_id);
        }

        //$data = $this->queryPosts($args);

        $postItems = [];
        $index = 0;

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $post = $query->the_post();
                $slug = get_post_field('post_name', get_post());
                $link_type = get_field('link_type');
                $external_link = get_field('external_link');
                $postItems[$index]['ID']                = get_the_ID();
                $postItems[$index]['permalink']         = get_the_permalink();
                $postItems[$index]['thumbnail_url']     = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_id = get_post_thumbnail_id(get_the_ID());
                $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                $postItems[$index]['thumbnail_alt']     = $alt_text;
                $postItems[$index]['post_title']        = get_the_title();
                $postItems[$index]['date']              = get_the_date('F j, Y');
                $postItems[$index]['slug']              = $slug;
                $postItems[$index]['is_external']       = false;
                $subtitle = '&nbsp;';

                if ($external_link) {
                    $postItems[$index]['permalink']         = $external_link;
                    $postItems[$index]['is_external']       = true;
                }

                if ('team' === $args['post_type']) {
                    $postItems[$index]['bio']               = get_field('bio');
                    $postItems[$index]['position']          = get_field('position');
                    $postItems[$index]['first_name']        = get_field('first_name');
                    $postItems[$index]['middle_name']       = get_field('middle_name');
                    $postItems[$index]['last_name']         = get_field('last_name');

                    $full_name = $postItems[$index]['first_name'] . ' ' . $postItems[$index]['middle_name'] . ' ' . $postItems[$index]['last_name'];
                    $full_name = preg_replace('/\s+/', ' ', $full_name);
                    $postItems[$index]['full_name'] = $full_name;
                }

                if ('press' === $args['post_type']) {
                    $terms = wp_get_post_terms(get_the_ID(), 'states');
                    $state_label = '';
                    if (!$terms) $terms = [];

                    if ($terms) {
                        $state = isset($_REQUEST['state']) ? $_REQUEST['state'] : '';
                    }

                    if ((count($terms) > 1) && $state) {
                        foreach ($terms as $term) {
                            $state_label = $term->name;
                        }
                    }

                    if ((count($terms) === 1)) {
                        foreach ($terms as $term) {
                            $state_label = $term->name;
                            if ($term->slug == 'all' AND $state != '') {
                                $state_label = ucwords(str_replace('-', ' ', $state));
                            }
                            if ($term->slug == 'all' AND $state == '') {
                                $state_label = 'Multistate';
                            }
                        }
                    }

                    if ((count($terms) > 1) && (!isset($state) OR $state == '')) {
                        $state_label = 'Multistate';
                    }

                    $subtitle = $state_label;

                    $postItems[$index]['subtitle']        = $subtitle;
                }

                $index++;
            }
        }

        wp_reset_postdata();

        if (count($postItems)) {
            return $postItems;
        }

        return [];
    }

    public function getAboutUniteUs()
    {
        $html = get_field('about_unite_us', 'options');

        return $html;
    }

    static function queryPosts($args = array())
    {
        $postItems = [];
        $index = 0;

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $slug = get_post_field('post_name', get_post());
                $postItems[$index]['ID']                = get_the_ID();
                $postItems[$index]['permalink']         = get_the_permalink();
                $postItems[$index]['thumbnail_url']     = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $img_id = get_post_thumbnail_id(get_the_ID());
                $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                $postItems[$index]['thumbnail_alt']     = $alt_text;
                $postItems[$index]['post_title']        = get_the_title();
                $postItems[$index]['slug']              = $slug;

                if ('team' === $args['post_type']) {
                    $postItems[$index]['bio']               = get_field('bio');
                    $postItems[$index]['position']          = get_field('position');
                    $postItems[$index]['first_name']        = get_field('first_name');
                    $postItems[$index]['middle_name']       = get_field('middle_name');
                    $postItems[$index]['last_name']         = get_field('last_name');

                    $full_name = $postItems[$index]['first_name'] . ' ' . $postItems[$index]['middle_name'] . ' ' . $postItems[$index]['last_name'];
                    $full_name = preg_replace('/\s+/', ' ', $full_name);
                    $postItems[$index]['full_name'] = $full_name;
                }

                if ('press' === $args['post_type']) {
                    $postItems[$index]['subtitle']               = 'Ipsum';
                }

                $index++;
            }
        }

        wp_reset_postdata();

        return $postItems;
    }

    public function getAnchorLinks() {
        $fields = get_fields(get_the_ID());
        $html = '';

        if (isset($fields['components']) && is_array($fields['components'])) {
            foreach ($fields['components'] as $index=> $field) {
                if (!isset($field[$field['acf_fc_layout']]['section']['id'])) {
                    continue;
                }
                $anchor = $field[$field['acf_fc_layout']]['section']['id'];
                $anchor = trim($anchor);
                $anchor = strtolower($anchor);
                $anchor = str_replace('  ', '-', $anchor);
                $anchor = str_replace('/', '-', $anchor);
                $anchor = str_replace(' ', '-', $anchor);

                $anchor_name = str_replace('-', ' ', $anchor);
                $anchor_name = ucwords($anchor_name);
                if (!empty($anchor)) {
                $html .= '<a href="#' . $anchor . '">' . $anchor_name . '</a>';
                }
            }

            return $html;
        }
        return false;
    }

    public static function getNetworkFormActiveStates()
    {
        $args = [
            'post_type'         => 'network_form',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
        ];

        $postItems = [];
        $index = 0;

        $query = new \WP_Query($args);
        $states = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $slug = get_post_field('post_name', get_post());
                $categories = get_the_terms(get_the_ID(), 'states');

                foreach ($categories as $cat) {
                    $states[] = $cat->slug;
                }

                $postItems[$index]['permalink']         = get_the_permalink();                $postItems[$index]['post_title']        = get_the_title();
                $postItems[$index]['slug']              = $slug;
                $postItems[$index]['states']        = $states;
                $index++;
            }
        }

        wp_reset_postdata();

        return $states;
    }

    private function  getGlobalTemplateData($field_set = '') {
        $template_data = get_fields('global-templates');

        if ($field_set) {
            return $template_data[$field_set];
        }
        return $template_data;
    }

    public function getRecommendedPagesData() {
        return $this->getGlobalTemplateData('recommended_pages');
    }
}
