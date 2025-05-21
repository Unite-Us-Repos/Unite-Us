<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * HelpMenu Composer
 *
 * This class is responsible for providing data to the help menu view.
 * It retrieves the help menu data from the theme's data and encodes it as JSON.
 *
 * @package App\View\Composers
 */
class Swiper extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'components.service-cards.icon-carousel-*',
        'components.service-cards.partials.swiper',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function with()
    {
        return [
            'swiperJsSettings'      => $this->swiperJsSettings(),
            'swiperJsSettingsJson'  => $this->swiperJsSettingsJson(),
        ];
    }

    /**
     * Function to generate SwiperJS settings from data properties
     *
     * @return array|bool SwiperJS configuration array or false if slider is disabled
     */
    function swiperJsSettings()
    {
        // Use settings from data property
        $settings = $this->data->swiper ?? [];

        // Check if slider is enabled
        if (!($settings['swiperjs_enabled'] ?? false)) {
            return false;
        }

        // Prepare Swiper settings object
        $result = array();

        // Generate slider ID
        $slider_id = $settings['swiperjs_slider_id'] ?? '';
        if (empty($slider_id)) {
            $slider_id = 'swiper-' . uniqid();
        }
        //$result['id'] = sanitize_title($slider_id);

        // Basic slide behavior settings - group these together
        $result['slidesPerView'] = intval($settings['swiperjs_slides_per_view']) ?? 1;
        $result['spaceBetween'] = intval($settings['swiperjs_space_between']) ?? 0;
        $result['speed'] = intval($settings['swiperjs_speed']) ?? 300;
        $result['loop'] = $settings['swiperjs_loop'] ? true : false;
        $result['effect'] = $settings['swiperjs_effect'] ?? 'slide';

        // Add resistance parameters to prevent slides from flying off screen
        $result['resistance'] = true;
        //$result['resistanceRatio'] = 0.85;

        // Add touch behavior improvements
        $result['grabCursor'] = true;
        //$result['preventClicks'] = true;
        //$result['preventClicksPropagation'] = true;
        //$result['touchReleaseOnEdges'] = true;

        // Allow slides to overflow the container
        //$result['watchOverflow'] = true;
        //$result['slidePerGroup'] = 1;

        // Autoplay settings
        if ($settings['swiperjs_autoplay'] ?? false) {
            $result['autoplay'] = array(
                'delay' => intval($settings['swiperjs_autoplay_delay']) ?? 3000,
                'disableOnInteraction' => $settings['swiperjs_disable_on_interaction'] ?? false,
                'pauseOnMouseEnter' => $settings['swiperjs_pause_on_hover'] ?? false,
            );
        }

        // Navigation with proper element selectors
        $result['navigation'] = array(
            'nextEl' => '.swiper-button-next',
            'prevEl' => '.swiper-button-prev',
        );

        // Pagination with proper element selector
        if ($settings['swiperjs_pagination'] ?? false) {
            $result['pagination'] = array(
                'el' => '.swiper-pagination',
                'type' => $settings['swiperjs_pagination_type'] ?? 'bullets',
                'clickable' => true,
            );
        } else {
            $result['pagination'] = array(
                'el' => '.swiper-pagination',
            );
        }

        // Scrollbar with proper element selector
        $result['scrollbar'] = array(
            'el' => '.swiper-scrollbar',
            'enabled' => $settings['swiperjs_scrollbar'] ?? false,
            'draggable' => true,
        );

        // Responsive breakpoints
        $breakpoints = $settings['swiperjs_breakpoints'] ?? [];
        if (is_array($breakpoints) && !empty($breakpoints)) {
            $result['breakpoints'] = array();
            foreach ($breakpoints as $breakpoint) {
                $width = intval($breakpoint['width']);
                $result['breakpoints'][$width] = array(
                    'slidesPerView' => intval($breakpoint['slides_per_view']),
                    'spaceBetween' => intval($breakpoint['space_between']),
                );
            }
        }

        return $result;
    }

    /**
     * Get the SwiperJS settings as a JSON string for use in Alpine.js x-data.
     * Ensures the output is properly formatted for direct use in HTML attributes.
     *
     * @return string Formatted JSON for x-data attribute
     */
    public function swiperJsSettingsJson()
    {
        // Get the SwiperJS settings
        // This will return an array of settings or false if the slider is disabled
        $settings = $this->swiperJsSettings();

        // If no settings or disabled, return empty object
        if (!$settings) {
            return '{}';
        }

        // Convert the settings array to JSON
        $json = json_encode($settings, JSON_PRETTY_PRINT);

        return $json;
    }
}
