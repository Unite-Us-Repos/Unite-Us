@if ($logos)
@php
  $enableLoop = 'true';
  $section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
  $swiper_ref = 'logos' . $index;
  $slides_per_view = count($logos);
  $large_slides = 4;
  if ($columns == '1/5') {
  $large_slides = 5;
  }
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div style="background:inherit" class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
    @if ($section['title'] || $section['description'])
      <div class="text-center max-w-4xl mx-auto">
        @if ($section['title'])
          <h2>{!! $section['title'] !!}</h2>
        @endif
        @if ($section['description'])
          {!! $section['description'] !!}
        @endif
      </div>
    @endif
    <div
      class="relative max-w-7xl mx-auto px-8 sm:px-14"
      x-data="{swiper: null}"
      x-init="swiper = new Swiper($refs.container, {
        loop: true,
        @if ($carousel_settings['autoplay'] == 'true')
        autoplay: {
          delay: {{ $carousel_settings['autoplay_delay'] }},
        },
        @endif
        slidesPerGroup: 1,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        on: {
          afterInit: function() {
            var arrows =  document.querySelectorAll('.swiper-arrow-{{ $swiper_ref }}');

            if (this.isLocked) {
              arrows.forEach(function (el) {
                el.classList.add('hidden');
              });
            } else {
              arrows.forEach(function (el) {
                el.classList.remove('hidden');
              });
            }
          }
        },
        slidesPerView: 1,
        spaceBetween: 0,
        breakpoints: {
          640: {
            slidesPerView: 2,
            @if ($slides_per_view > 2)
              loop: true,
              slidesPerGroup: 1,
            @else
              loop: false,
              slidesPerGroup: {{ $slides_per_view }},
              centerInsufficientSlides: true,
            @endif
            spaceBetween: 40,
          },
          920: {
            slidesPerView: 3,
            @if ($slides_per_view > 3)
              loop: true,
            @else
              loop: false,
              slidesPerGroup: {{ $slides_per_view }},
              centerInsufficientSlides: true,
            @endif
            spaceBetween: 40,
          },
          1280: {
            slidesPerView: {{ $large_slides }},
            @if ($slides_per_view > $large_slides)
              loop: true,
            @else
              loop: false,
              centerInsufficientSlides: true,
            @endif
            spaceBetween: 40,
          },
        },
      });swiper.on('resize', function () {
        var arrows =  document.querySelectorAll('.swiper-arrow-{{ $swiper_ref }}');

        if (this.isLocked) {
          arrows.forEach(function (el) {
            el.classList.add('hidden');
          });
        } else {
          arrows.forEach(function (el) {
            el.classList.remove('hidden');
          });
        }
      });">
      @if (count($logos) > 1)
      <div class="swiper-arrow-{{ $swiper_ref }} absolute left-0 top-1/2" style="margin-top: -20px">
        <button aria-label="previous" @click="swiper.slidePrev()"
          class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
          </svg>
        </button>
      </div>
      @endif
      <div class="swiper" x-ref="container">
        <div class="swiper-wrapper">
          @foreach ($logos as $index => $logo)
            <div style="height: auto;" class="swiper-slide bg-{{ $background['color'] }} flex justify-center items-center">

              @if ($logo['link'])
                <a
                  href="{{ $logo['link']}}"
                  class="@if ('ligh-gradient' == $background['color']) bg-[#FBFDFE] @else bg-{{ $background['color'] }} @endif"
                  target="_blank"
                >
              @endif
              @if ($logo['image'])

                <img
                  class="object-contain w-48 h-10 mx-auto mix-blend-multiply @if ('default' == $style) max-h-12 @else max-h-16 @endif"
                  src="{{ $logo['image']['sizes']['medium'] }}"
                  alt="{{ $logo['image']['alt'] }}"
                />

              @endif
              @if ($logo['link'])
                </a>
              @endif

            </div>
          @endforeach
        </div>
        <div class="swiper-pagination"></div>
      </div>
      @if (count($logos) > 1)
        <div class="swiper-arrow-{{ $swiper_ref }} absolute right-0 top-1/2" style="margin-top: -20px">
          <button aria-label="next" @click="swiper.slideNext()"
            class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
              stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </button>
        </div>
      @endif
    </div>
    </div>
  </section>
@endif
