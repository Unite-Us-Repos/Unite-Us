<?php

namespace App;

use App\Controllers\App;

/**
 * Return if Shortcodes already exists.
 */
if (class_exists('Shortcodes')) {
    return;
}

/**
 * Shortcodes
 */
class Shortcodes
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $shortcodes = [
            'hero_images',
            'date',
            'month',
            'day',
            'year',
            'current_state',
        ];

        return collect($shortcodes)
            ->map(function ($shortcode) {
                return add_shortcode($shortcode, [$this, strtr($shortcode, ['-' => '_'])]);
            });
    }

    /**
     * Box
     * Wraps content in a box.
     *
     * @param  array  $atts
     * @param  string $content
     * @return string
     */
    public function hero_images()
    {

        $images = get_field('hero_images', 'options');
        $img_html = '';

        if (!$images) {
            return;
        }

        foreach ($images as $index => $image) {
            $i = $index+1;
            $attachment_id = $image['ID'];
            $img_src = wp_get_attachment_image_url($attachment_id, 'medium');
            $img_src_lg = wp_get_attachment_image_url($attachment_id, '2048x2048');
            $img_srcset = wp_get_attachment_image_srcset($attachment_id);

            if ($i < 2) {
                $img_html .= '
                    <img class="heroImage" id="heroImage0' . $i . '" src="' . esc_url($img_src) . '"
                    srcset="' . $img_src . ' 300w, ' . $img_src_lg . ' 1024w"
                    sizes="(max-width: 600px) 300px, 1024px"
                    alt="">';
            } else {
                $img_html .= '
                <img class="heroImage lazy" id="heroImage0' . $i . '" data-src="' . esc_url($img_src) . '"
                data-srcset="' . $img_src . ' 300w, ' . $img_src_lg . ' 1024w"
                data-sizes="(max-width: 600px) 300px, 1024px"
                alt="">';
            }
        }

        return $img_html;

        //$view = view('partials.content-data-table')->with('section', $section)->render();

    }

    /**
     * Date
     * Returns the current date.
     *
     * @param  array  $atts
     * @param  string $content
     * @return string
     */
    public function date($atts, $content = null)
    {
        return date('F d, Y');
    }

    /**
     * Month
     * Returns the current month.
     *
     * @param  array  $atts
     * @param  string $content
     * @return string
     */
    public function month($atts, $content = null)
    {
        return date('F');
    }

    /**
    * Day
    * Returns the current day.
    *
    * @param  array  $atts
    * @param  string $content
    * @return string
    */
    public function day($atts, $content = null)
    {
        return date('d');
    }

    /**
     * Year
     * Returns the current year.
     *
     * @param  array  $atts
     * @param  string $content
     * @return string
     */
    public function year($atts, $content = null)
    {
        return date('Y');
    }

    public function current_state()
    {
        global $post;
        $state = '';
        if (get_post_type() == 'network') {
            return $post->post_name;
        }
    }
}

new Shortcodes();
