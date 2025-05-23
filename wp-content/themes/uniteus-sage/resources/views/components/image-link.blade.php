@if ($imageUrl)
  @php
    $imgAttributes = [
      'alt' => $alt,
      'class' => trim(($lazy ? 'lazy ' : '') . $classes),
    ];

    if ($lazy) {
      $imgAttributes['data-src'] = $imageUrl;
      if ($srcset) {
        $imgAttributes['data-srcset'] = $srcset;
        $imgAttributes['data-sizes'] = $sizes;
      }
    } else {
      $imgAttributes['src'] = $imageUrl;
      if ($srcset) {
        $imgAttributes['srcset'] = $srcset;
        $imgAttributes['sizes'] = '100vw';
      }
      $imgAttributes['loading'] = 'lazy';
    }
  @endphp

  @if ($url)
    <a href="{{ $url }}" class="{{ $linkClasses }}" target="{{ $target }}" rel="{{ $target === '_blank' ? 'noopener noreferrer' : '' }}">
      <img {!! html_attributes($imgAttributes) !!}>
    </a>
  @else
    <img {!! html_attributes($imgAttributes) !!}>
  @endif
@endif
