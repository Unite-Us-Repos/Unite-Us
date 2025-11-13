@if ($logos)
@php
  $enableLoop = 'true';
  $section_settings = $acf["components"][$index]['layout_settings']['section_settings'] ?? [];
  $swiper_ref = 'logos' . $index;
  $slides_per_view = count($logos);

  // ACF columns -> slidesPerView mapping
  // ACF value can be: 'auto', 'full', '2/4', '2/6', '1/4', '1/5', '1/6'
  $columns_choice = $carousel_settings['columns'] ?? ($columns ?? 'auto');
  $columns_map = [
    'auto' => 'auto',
    'full' => 1,
    '2/4'  => 2,
    '2/6'  => 3,
    '1/4'  => 4,
    '1/5'  => 5,
    '1/6'  => 6,
  ];
  $desktop_spv_raw = $columns_map[$columns_choice] ?? 'auto'; // ≥1280px

  // Build JS-ready values for each breakpoint
  $spv1280 = is_numeric($desktop_spv_raw) ? (int)$desktop_spv_raw : "'auto'";
  $spv920  = is_numeric($desktop_spv_raw) ? min(3, (int)$desktop_spv_raw) : "'auto'";
  $spv640  = is_numeric($desktop_spv_raw) ? min(2, (int)$desktop_spv_raw) : "'auto'";
@endphp

<style>
  /* Fade edges without needing a background color */
  .logos-rail.fade-edges{
    position:relative;
    -webkit-mask-image:linear-gradient(to right,transparent 0%,#000 6%,#000 94%,transparent 100%);
            mask-image:linear-gradient(to right,transparent 0%,#000 6%,#000 94%,transparent 100%);
  }
  /* Let slides show under the mask */
  .logos-rail .swiper{ overflow:visible; }

  /* If slidesPerView:'auto', let slides size to content */
  .logos-rail .swiper-slide{
    height:auto;
    display:flex;align-items:center;justify-content:center;
    width:auto;
  }
  .logos-rail img{
    filter:grayscale(100%);
    opacity:.9;
    mix-blend-mode:multiply;
  }
</style>

@if (!empty($background['has_divider']))
  @includeIf('dividers.waves')
@endif

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset
  class="component-section {{ $section_classes ?? '' }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] ?? '' }} @endif">

  <div style="background:inherit"
       class="component-inner-section @if (!empty($section_settings['fullscreen'])) fullscreen @endif">

    @if (!empty($section['title']) || !empty($section['description']))
      <div class="text-center max-w-4xl mx-auto">
        @if (!empty($section['title']))   <h2>{!! $section['title'] !!}</h2> @endif
        @if (!empty($section['description'])) {!! $section['description'] !!} @endif
      </div>
    @endif

    <div
      class="logos-rail fade-edges relative max-w-7xl mx-auto px-8 sm:px-14"
      x-data="{swiper: null}"
      x-init="swiper = new Swiper($refs.container, {
        autoplay: {
          delay: {{ isset($carousel_settings['autoplay_delay']) ? (int)$carousel_settings['autoplay_delay'] : 2500 }},
          disableOnInteraction: false,
          pauseOnMouseEnter: true
        },
        allowTouchMove: false,
        loop: true,
        watchOverflow: true,
        speed: 900,
        slidesPerGroup: 1,
        slidesPerView: 1,   /* mobile <640 */
        spaceBetween: 0,
        breakpoints: {
          640:  { slidesPerView: {!! $spv640  !!}, spaceBetween: 40 },
          920:  { slidesPerView: {!! $spv920  !!}, spaceBetween: 40 },
          1280: { slidesPerView: {!! $spv1280 !!}, spaceBetween: 40 },
        },
      });">

      <div class="swiper" x-ref="container">
        <div class="swiper-wrapper">
          @foreach ($logos as $index => $logo)
            <div class="swiper-slide bg-{{ $background['color'] ?? 'white' }} flex justify-center items-center">
              @if (!empty($logo['link']))
                <a href="{{ $logo['link'] }}" target="_blank" aria-label="{{ $logo['image']['alt'] ?? '' }}"
                   class="@if (($background['color'] ?? '') === 'ligh-gradient') bg-[#FBFDFE] @else bg-{{ $background['color'] ?? 'white' }} @endif">
              @endif

              @if (!empty($logo['image']))
                <img
                  class="object-contain w-48 h-20 mx-auto"
                  src="{{ $logo['image']['sizes']['medium'] }}"
                  alt="{{ $logo['image']['alt'] ?? '' }}" />
              @endif

              @if (!empty($logo['link']))
                </a>
              @endif
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</section>
@endif
