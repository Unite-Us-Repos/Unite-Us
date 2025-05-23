<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageLink extends Component
{
    public $image;
    public $imageUrl;
    public $srcset;
    public $sizes;
    public $alt;
    public $url;
    public $target;
    public $lazy;
    public $classes;
    public $linkClasses;

    public function __construct($image, $imageSize = 'full', $lazy = false, $classes = '', $linkClasses = '')
    {
        $this->image = $image;
        $this->lazy = filter_var($lazy, FILTER_VALIDATE_BOOLEAN);
        $this->classes = $classes;

        // Ensure 'no-underline' and 'inline-block' are always present
        $linkClassList = explode(' ', $linkClasses);
        $defaults = ['no-underline', 'inline-block'];
        foreach ($defaults as $default) {
            if (!in_array($default, $linkClassList)) {
                $linkClassList[] = $default;
            }
        }
        $this->linkClasses = trim(implode(' ', array_unique($linkClassList)));

        // Pass image ID (integer) to get_field for ACF lookup
        $imageId = $image['ID'] ?? null;
        $linkProperties = $imageId ? get_field('image_link_properties', $imageId) : null;

        $internal = $linkProperties['internal_link'] ?? null;
        $external = $linkProperties['external_link'] ?? null;
        $targetNew = $linkProperties['target_new'] ?? false;

        $this->url = $external ?: $internal;
        $this->target = filter_var($targetNew, FILTER_VALIDATE_BOOLEAN) ? '_blank' : '_self';

        $this->alt = $image['alt'] ?? '';

        if ($imageSize === 'full') {
            $urlCandidate = $image['url'] ?? '';
        } else {
            $urlCandidate = $image['sizes'][$imageSize] ?? ($image['url'] ?? '');
        }
        if (is_array($urlCandidate)) {
            $this->imageUrl = $urlCandidate['url'] ?? '';
        } else {
            $this->imageUrl = $urlCandidate;
        }

        $this->srcset = $image['srcset'] ?? null;
        $this->sizes = $this->srcset ? 'auto' : null;
    }

    public function render()
    {
        return view('components.image-link');
    }
}
// This component is used to render an image with a link. It takes an image, its size, and other properties like lazy loading and classes.
// The component also handles the link properties, such as internal and external links, and whether to open in a new tab.
