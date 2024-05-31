@php
$swiper_ref = 'gallery-' . $index;
$slides_per_view = count($images);
@endphp
<section class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif" @if ($background['color'] == 'custom') style="background-color: {{ $background['custom_color'] }} @endif">
  <div class="component-inner-section relative @if ($section_settings['fullscreen']) fullscreen !px-0 @endif">
    <div class="@if ('center' == $section['alignment']) text-center @endif @if ($background['color'] == 'dark') text-white @endif" style="@if ($background['color'] == 'custom') color: {{ $background['text_color'] }} @endif">
      @if ($section['title'] || $section['description'])
        @if ($section['title'])
          <h2 class="mb-6">{{ $section['title'] }}</h2>
        @endif
        @if ($section['description'])
        <div class="text-lg">
          {!! $section['description'] !!}
        </div>
        @endif
      @endif
    </div>

    @if ($images)
    <div x-data="{swiper: null}" x-init="swiper = new Swiper($refs.container, {
      @if ($slides_per_view > 2)
        loop: true,
      @else
        loop: false,
      @endif
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
      allowTouchMove: false,
      preventClicks: false,
      slidesPerView: 1.25,
      slidesPerGroup: 1,
      spaceBetween: 15,
      loopFillGroupWithBlank: false,
      breakpoints: {
        640: {
          slidesPerView: 1.25,
          @if ($slides_per_view > 2)
            loop: true,
          @else
            loop: false,
          @endif
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 25,
          @if ($slides_per_view > 3)
            loop: true,
          @else
            loop: false,
          @endif
        },
        1440: {
          slidesPerView: 4,
          @if ($slides_per_view > 4)
            loop: true,
          @else
            loop: false,
          @endif
        },
        1920: {
          slidesPerView: '5',
          @if ($slides_per_view > 5)
            loop: true,
          @else
            loop: false,
          @endif
        },
      },
    });swiper.on('resize', function () {
      var arrows =  document.querySelectorAll('.swiper-arrow-{{ $swiper_ref }}');

      if (swiper.isLocked) {
        arrows.forEach(function (el) {
          el.classList.add('hidden');
        });
      } else {
        arrows.forEach(function (el) {
          el.classList.remove('hidden');
        });
      }
      });">
      <div class="swiper sm:pt-14 sm:-mt-14" x-ref="container">

        <div class="swiper-wrapper">
          @foreach ($images as $index => $image)
            @php
              $url = $image['sizes']['large'];
              $video = get_field('video_url', $image['ID']);
              if ($video) {
                $url = $video;
              }
            @endphp
            <div class="swiper-slide">
              <a href="{{ $url }}" class="glightbox">
                <img src="{{ $image['sizes']['medium_large'] }}" alt="{{ $image['alt'] }}" class="rounded-xl sm:rounded-none gallery-item w-full h-full aspect-[240/200] sm:aspect-[400/300] object-cover" />
              </a>
            </div>
          @endforeach
        </div>
        @if (count($images) > 1)
        <div class="flex w-full justify-between sm:justify-end gap-8 pt-6 px-3 sm:p-0 sm:absolute sm:-top-0">
          <div class="swiper-arrow-{{ $swiper_ref }} acf-icon-white">
            <button aria-label="previous" @click="swiper.slidePrev()"
              class="text-brand hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
              </svg>
            </button>
          </div>

          <div class="swiper-arrow-{{ $swiper_ref }} acf-icon-white">
            <button aria-label="next" @click="swiper.slideNext()"
              class="text-brand hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </button>
          </div>
            </div>
        @endif
    </div>
  @endif
  </div>
</section>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script type="text/javascript">
  const lightbox = GLightbox();
</script>
