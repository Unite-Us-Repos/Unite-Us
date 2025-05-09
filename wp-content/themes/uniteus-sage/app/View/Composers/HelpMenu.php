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
class HelpMenu extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'components.service-cards.icon-help',
        'components.service-cards.partials.help-menu',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function with()
    {
        return [
            'helpMenuData'      => $this->helpMenuData(),
            'helpMenuDataJson'  => $this->helpMenuDataJson(),
        ];
    }

    /**
     * Get the help menu data.
     *
     * @return array
     */
    public function helpMenuData()
    {
        $menu_items = $this->data->help_menu['help_items'] ?? [];
        // Get first option
        if (isset($this->data->help_menu['settings']['select_text_prompt'])) {
            // Add to help_menu['help_items'] array as first item
            $menu_items = array_merge(
                [
                    [
                        'title' => $this->data->help_menu['settings']['select_text_prompt'],
                        'description' => 'sd',
                    ],
                ],
                $menu_items
            );
        }
        return $menu_items;
    }

    /**
     * Get the help menu data as JSON.
     * Convert the array to a JSON string with proper HTML encoding.
     *
     * @return string
     */
    public function helpMenuDataJson()
    {
        return json_encode($this->helpMenuData(), JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_UNICODE);
    }
}
