<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'siteName' => $this->siteName(),
            'currentYear' => $this->currentYear(),
            'getFooterMenu' => $this->getFooterMenu(),
            'flexibleComponents' => $this->flexibleComponents(),
            'pageBreadcrumbs' => $this->pageBreadcrumbs(),
            'campaignAd' => $this->getCampaignAd(),
            'mainMenuItems' => $this->getMenuItems('Main Nav'),
            'footerMenuItems' => $this->getMenuItems('Footer Nav'),
            'socialMediaIcons' => $this->getSocialMediaIcons(),
            'postSlug' => $this->getPostSlug(),
        ];
    }

    public static function getPostSlug()
    {
        global $post;
        return $post->post_name;
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }

    /**
     * Returns the current year.
     *
     * @return string
     */
    public function currentYear()
    {
        return date('Y');
    }

public function getMenuItems($menu_name = 'Main Menu')
{
    $items = wp_get_nav_menu_items($menu_name) ?: [];
    if (!$items) return [];

    // Ensure proper order
    usort($items, fn($a,$b) => (int)$a->menu_order <=> (int)$b->menu_order);

    // Group items by parent id
    $by_parent = [];
    foreach ($items as $it) {
        $by_parent[(int)$it->menu_item_parent][] = $it;
    }

    $makeNode = function($it) {
        $anchor = get_field('anchor', $it->ID);
        $icon   = get_field('menu_icon', $it->ID);

        $url = $it->url;
        if ($anchor) $url .= '#' . $anchor;

        return [
            'anchor'      => $anchor ?: '',
            'ID'          => (int)$it->ID,
            'title'       => $it->title,
            'url'         => $url,
            'classes'     => is_array($it->classes) ? $it->classes : [],
            'description' => $it->description,
            'icon'        => $icon,
            'children'    => [], // filled recursively
        ];
    };

    $build = function(int $parent_id) use (&$build, $by_parent, $makeNode) {
        $branch = [];
        foreach ($by_parent[$parent_id] ?? [] as $it) {
            $node = $makeNode($it);
            $node['children'] = $build((int)$it->ID);
            $branch[$it->ID] = $node; // keep keys stable like your old structure
        }
        return $branch;
    };

    return $build(0);
}

    /**
     * Returns selected menu.
     *
     * @return string
     */
    public function getFooterMenu($theme_location = 'null')
    {
        $menu = wp_nav_menu(array(
            'theme_location' => $theme_location,
            'container' => false,
            'menu_class' => '',
            'fallback_cb' => '__return_false',
            'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
            'depth' => 2,
            'echo' => false
        ));

        return $menu;
    }

    public function getSocialMediaIcons()
    {
        $items = get_field('social_media', 'options');
        $path = get_template_directory_uri() . '/resources/icons/social/';
        $links = [];
        if (!isset($items['social_media_link'])) {
            return $links;
        }
        foreach ($items['social_media_link'] as $index => $item) {
            $label = str_replace('-', ' ', $item['icon']);
            $label = ucwords($label);

            $links[$index]['url'] = $item['url'];
            $links[$index]['label'] = $label;
            $links[$index]['icon'] = $item['icon'] = $path . $item['icon'] . '.svg?v=1';
        }
        return $links;
    }

    /**
     * Returns list of acf layouts.
     *
     * @return array
     */
    public function flexibleComponents()
    {
        $components = [];
        $data       = [];
        $style      = '';

        //$cc         = [];
        // check if the flexible content field has rows of data
        if (have_rows('components')) {
            // loop over the ACF flexible fields for this page / post
            $components_data = $this->fetchAcfData();

            $i = 0;
            foreach ($components_data as $i => $cdata) {
                foreach ($cdata as $component_data) {
                    $component = $component_data['acf_fc_layout'];
                    $component_alias = str_replace('_', '-', $component);
                    $component_style = '';

                    if (!isset($component_data[$component])) {
                      continue;
                    }

                    $s_settings = [
                        'collapse_padding' => false,
                        'fullscreen' => '',
                    ];

                    $c_settings = [
                        'autoplay' => false,
                        'autoplay_delay' => '3000',
                    ];

                    $section_settings = isset($component_data['layout_settings']['section_settings']) ? $component_data['layout_settings']['section_settings'] : $s_settings;
                    $carousel_settings = isset($component_data['layout_settings']['carousel_settings']) ? $component_data['layout_settings']['carousel_settings'] : $c_settings;

                    $data = $component_data[$component];
                    $has_style = isset($data["style"]);
                    $data['section_classes'] = '';
                    $data['section_settings'] = $section_settings;
                    $data['carousel_settings'] = $carousel_settings;

                    if (isset($data['background']['color'])) {
                        $data['section_classes'] = 'bg-' . $data['background']['color'];
                    }

                    if (isset($data['background']['divider_bottom']) && ($data['background']['divider_bottom']) && (strpos($data['background']['color'], 'gradient'))) {
                        $data['section_classes'] = $data['section_classes'] . '-bottom-up';
                    }

                    if (isset($data['background']['seamless_sections']) && ($data['background']['seamless_sections'])) {
                        $data['section_classes'] = $data['section_classes'] . ' seamless-section';
                    }

                    if (isset($data['section']['title'])) {
                        $data['section']['title'] = $this->doUnderline($data['section']['title']);
                    }

                    $component = str_replace('_', '-', $component);

                    if ($has_style) {
                        $style = $data["style"];
                        $style = str_replace('_', '-', $style);
                        $component_style = '.' . $style;
                    }

                    // check if component exists
                    if (\View::exists('components.' . $component . $component_style)
                        || \View::exists('components.' . $component . '.default')) {

                        // fix for non grouped items
                        if (!is_array($data)) {
                            $data = array($data);
                        }

                        $components[] = [
                            'component' => $component_alias,
                            'style' => $style,
                            'data'   => $data
                        ];
                    }
                }
            }
        }

        return $components;
    }

    /**
     * Fetch all ACF group fields from "components" flexible content
     */
    protected function fetchAcfData()
    {
        $acf_data   = [];
        $components = get_field('components');
        foreach ($components as $index => $component) {
            $acf_data[$index][$component["acf_fc_layout"]] = $component;
        }

        return $acf_data;
    }

    static function queryPosts($post_type='', $p = '')
    {
        $args = [
            'post_type'         => $post_type,
            'posts_per_page'    => -1,
        ];

        if ($p) {
            $args['p'] = $p;
        }

        $postItems = [];
        $index = 0;

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $slug = get_post_field('post_name', get_post());
                $postItems[$post_type][$index]['permalink']        = get_the_permalink();
                $postItems[$post_type][$index]['thumbnail_url']     = get_the_post_thumbnail_url(get_the_ID(), 'large');

                $index++;
            }
        }

        wp_reset_postdata();

        return $postItems;
    }

    protected function pageBreadcrumbs()
    {
        global $post;

        $breadcrumbs = [
            'parents' => [],
            'current_page' => '',
            'children' => [],
        ];

        // Standard page
        if (isset($post->post_parent)) {

            // If child page, get parents
            $anc = get_post_ancestors($post->ID);

            // Get parents in the right order
            $anc = array_reverse($anc);

            // Parent page loop
            if (!isset($parents)) $parents = null;
            foreach ($anc as $ancestor) {
                $breadcrumbs['parents'][] = [
                    'permalink' => get_permalink($ancestor),
                    'title' => get_the_title($ancestor),
                ];
            }
        }

        // Current page
        $breadcrumbs['current_page'] = [
            'permalink' => get_permalink(),
            'title' => get_the_title(),
        ];

        if ('post' === get_post_type() || 'page' === get_post_type()) {
            $breadcrumbs['parents'][] = [
                'permalink' => '/knowledge-hub/',
                'title' => 'Knowledge Hub',
            ];

            $breadcrumbs['current_page'] = false;
        }

        if ('team' === get_post_type()) {
            $breadcrumbs['parents'][] = [
                'permalink' => '/team/',
                'title' => 'Team',
            ];
        }

        if ('press' === get_post_type()) {
            $breadcrumbs['parents'][] = [
                'permalink' => '/press/',
                'title' => 'Press',
            ];

            $breadcrumbs['current_page'] = false;
        }

        if ('network' === get_post_type()) {
            $breadcrumbs['parents'][] = [
                'permalink' => '/networks/',
                'title' => 'Networks',
            ];

            $isGetHelp = false;

            global $wp_query, $post;
            $var = 'get-help';
            $post_type = get_post_type($post->ID);

            if (isset($wp_query->query_vars[$var])) {
                $isGetHelp = true;
            }

            if ($isGetHelp) {
                $breadcrumbs['children'][] = [
                    'permalink' => get_permalink() . 'get-help/',
                    'title' => 'Get Help',
                ];
            }
        }

        // exclude job page from breadscrumb
        if (is_page('job')) {
            $breadcrumbs['current_page'] = false;
        }

        return $breadcrumbs;
    }

    /**
     * Parse string and replace brackets with html tags
     *
     * Return @string
     */
    public function doUnderline($string) {
        $underline = preg_replace_callback("/[\[{\(].*?[\]}\)]/", function($m){
            return preg_replace('/\[|\]/',"", '<span class="custom-underline">' . $m[0] . '</span>');
        }, $string);

        return $underline;
    }

    public function getCampaignAd() {
        return 'hello';
    }
}
