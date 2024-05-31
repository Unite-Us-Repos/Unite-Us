@php
$is_header = isset($acf['components'][$index]['cards']['is_header']) ? $acf['components'][$index]['cards']['is_header'] : false;
$carousel = isset($acf['components'][$index]['cards']['is_carousel']) ? $acf['components'][$index]['cards']['is_carousel'] : false;
$h_level = '2';
if ($is_header) {
  $h_level = '1';
}
$swiper_ref = 'tri-card-' . $index;
@endphp
<section class="@if ($carousel) pl-0 sm:pl-10 xl:pl-20 py-14	pr-0 @else component-section @endif" @if ($h_level === '1') style="padding-top:0 !important;" @endif>

    @if ($h_level === '1')

      <div class="relative">
        <div class="absolute inset-0 -mb-24 -mx-4 {{ $section_classes }}"></div>
        <div class="relative pt-20 lg:pt-32 pb-10 component-inner-section z-10">
          @if ($section['title'] || $section['description'])
            <div class="text-{{ $section['alignment'] }} @if (!$carousel) max-w-5xl mx-auto @endif">
              @if ($section['title'])
                <h{{ $h_level }}>{{ $section['title'] }}</h{{ $h_level }}>
              @endif
              @if ($section['description'])
                <div class="section-description @if (!$carousel) max-w-5xl mx-auto @endif text-xl">
                  {!! $section['description'] !!}
                </div>
              @endif
            </div>
          @endif
        </div>
      </div>

    @else

      <div class="component-inner-section sm:px-0">
        @if ($section['title'] || $section['description'])
          <div class="text-{{ $section['alignment'] }} @if (!$carousel) max-w-4xl mx-auto @endif">
            @if ($section['title'])
              <h2>{{ $section['title'] }}</h2>
            @endif
            @if ($section['description'])
              {!! $section['description'] !!}
            @endif
          </div>
        @endif
      </div>

    @endif

    @if ($cards)
    @php
    $enableLoop = 'false';
    /*
    if (count($cards) > 1) {
      $enableLoop = 'true';
    }
    */
  @endphp
    @if ($carousel)
    <div
      class="relative w-full"
      x-data="{swiper: null}"
      x-init="swiper = new Swiper($refs.container, {
        loop: {{ $enableLoop }},
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        slidesPerView: 1.25,
        slidesPerGroup: 1,
        spaceBetween: 25,
        breakpoints: {
          640: {
            slidesPerView: 2.25,
          },
          768: {
            slidesPerView: 2.25,
          },
          1024: {
            slidesPerView: 3.25,
          },
          1280: {
            slidesPerView: 4.25,
          },
          1600: {
            slidesPerView: 5.25,
          },
        },
      })">
      <div class="component-inner-section relative flex justify-between pb-6">
        @if (count($cards) > 1)
          <div class="swiper-arrow-{{ $swiper_ref }} relative sm:absolute left-12 sm:left-auto sm:right-28 sm:-top-20 z-10">
            <button aria-label="previous" @click="swiper.slidePrev()"
              class="text-brand hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
              </svg>
            </button>
          </div>
          @endif

          @if (count($cards) > 1)
          <div class="swiper-arrow-{{ $swiper_ref }} relative sm:absolute right-12 sm:-top-20 z-10">
            <button aria-label="next" @click="swiper.slideNext()"
              class="text-brand hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </button>
          </div>
        @endif
      </div>

      <div class="swiper" x-ref="container">
        <div class="swiper-wrapper carousel-swiper flex items-center @if (count($cards) > 1) pb-16 @endif">
    @else
    <div class="component-inner-section">
      <div class="mt-10 max-w-lg mx-auto grid gap-8 lg:grid-cols-2 xl:grid-cols-3 lg:max-w-none">
        @endif
        @foreach ($cards as $index => $card)
          @if ($carousel)
          <div class="swiper-slide h-full relative px-6 sm:px-0">
            @endif
          <div class="relative h-full flex flex-col rounded-lg shadow-lg overflow-hidden">
            <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>
            <div class="flex-1 bg-white flex flex-col justify-between pt-4">
              <div class="flex-1 px-6 py-10">
                @if ($card['subtitle'])
                <p class="leading-normal text-sm font-medium text-action mb-2">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    {{ $card['subtitle'] }}
                  </span>
                </p>
                @endif

                <h3 class="mb-6">{!! $card['title'] !!}</h3>
                {!! $card['excerpt'] !!}
              </div>

              <div class="">
                @if ($card['buttons'])
                  @if (count($card['buttons']) > 1)
                    <div class="sm:grid sm:grid-cols-2">
                  @else
                    <div>
                  @endif
                  @foreach ($card['buttons'] as $index => $button)
                    @php
                      $isEven = false;
                      if ($index % 2 == 0) {
                        $isEven = true;
                      }
                    @endphp
                    @if ($button['link'])
                      <a
                        class="no-underline text-action font-semibold p-6 flex-1 block {{ $isEven ? 'bg-light hover:bg-blue-200' : 'bg-blue-200 hover:bg-blue-300' }}"
                        href="{{ $button['link'] }}"
                        @if ($button['is_blank']) target="_blank" @endif>
                        {{ $button['name'] }}<span aria-hidden="true" class="ml-1">&rarr;</span>
                      </a>
                    @else
                      <span class="p-6 block">&nbsp;</span>
                    @endif
                  @endforeach
                  </div>
                @endif
              </div>
            </div>
          </div>
          @if ($carousel)
                    </div>
            @endif
        @endforeach
        @if ($carousel)
        </div>
        <div class="swiper-pagination"></div>
      </div>

      </div>

          @else
      </div>
    </div>
    @endif
    @endif
</section>
