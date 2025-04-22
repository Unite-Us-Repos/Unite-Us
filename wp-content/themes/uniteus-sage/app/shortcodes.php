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
            'rotating_text',
            'typewriter',
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

    /**
     * Rotating Text Shortcode
     *
     * Creates a rotating text element using AlpineJS
     * Usage: [rotating_text words="Word1,Word2,Word3" default="Default"]
     */
    public function rotating_text($atts) {
        // Define shortcode attributes and defaults
        $atts = shortcode_atts(
            array(
                'words' => 'Word1,Word2,Word3',
                'default' => 'Starting Text',
                'delay' => 2000,
                'capitalize' => 'true',
                'add_period' => 'true'
            ),
            $atts,
            'rotating_text'
        );

        // Convert comma-separated words to a JavaScript array
        $words_array = explode(',', $atts['words']);
        $words_array = array_map('trim', $words_array);
        $words_json = json_encode($words_array);

        // Create the output
        $output = '<span class="rotating-title-text block text-action" ';
        $output .= 'x-data="typeWriter({ ';
        $output .= 'words: ' . esc_attr($words_json) . ', ';
        $output .= 'delay: ' . intval($atts['delay']) . ', ';
        $output .= 'capitalize: ' . $atts['capitalize'] . ', ';
        $output .= 'addPeriod: ' . $atts['add_period'] . ' })" ';
        $output .= 'x-text="currentText">' . esc_html($atts['default']) . ($atts['add_period'] === 'true' ? '.' : '') . '</span>';

        return $output;
    }

    public function typewriter($atts) {
        // Define shortcode attributes and defaults
        $atts = shortcode_atts(
            array(
                'prefix' => '',
                'phrases' => 'Word1,Word2,Word3',
                'typing_speed' => 100,
                'delete_speed' => 50,
                'pause_before_delete' => 3000,
                'pause_before_next' => 500,
                'loop' => 'true',
                'show_cursor' => 'true',
                'cursor_char' => '|',
                'class' => 'rotating-title-text',
            ),
            $atts,
            'typewriter'
        );

        // Convert comma-separated phrases to a JavaScript array
        $phrases_array = explode(',', $atts['phrases']);
        $phrases_array = array_map('trim', $phrases_array);
        $phrases_json = json_encode($phrases_array);

        // Create the prefix HTML if it exists
        $prefix_html = !empty($atts['prefix']) ? '<span class="typewriter-prefix">' . esc_html($atts['prefix']) . ' </span>' : '';

        // Build the class attribute
        $classes = 'typewriter-container ' . esc_attr($atts['class']);

        // Create the output
        $output = '<span class="' . $classes . '" ';
        $output .= 'x-data="typewriterEffect({ ';
        $output .= 'phrases: ' . esc_attr($phrases_json) . ', ';
        $output .= 'typingSpeed: ' . intval($atts['typing_speed']) . ', ';
        $output .= 'deleteSpeed: ' . intval($atts['delete_speed']) . ', ';
        $output .= 'pauseBeforeDelete: ' . intval($atts['pause_before_delete']) . ', ';
        $output .= 'pauseBeforeNext: ' . intval($atts['pause_before_next']) . ', ';
        $output .= 'loop: ' . $atts['loop'] . ', ';
        $output .= 'showCursor: ' . $atts['show_cursor'] . ', ';
        $output .= 'cursorChar: \'' . esc_attr($atts['cursor_char']) . '\'';
        $output .= '})">';

        // Add the prefix if provided
        $output .= $prefix_html;

        // Add the dynamic text and cursor
        $output .= '<span x-text="currentText"></span>';
        $output .= '<span x-html="getCursorHTML()"></span>';

        $output .= '</span>';

        return $output;
    }
}

new Shortcodes();
