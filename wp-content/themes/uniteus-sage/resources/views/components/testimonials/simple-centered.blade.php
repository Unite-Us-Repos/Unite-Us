@if ($testimonials)
  @php
    $enableLoop = 'false';
    if (count($testimonials) > 1) {
      $enableLoop = 'true';
    }
  @endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
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
        loop: {{ $enableLoop }},
        autoHeight: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        slidesPerView: 1,
        spaceBetween: 0,
        breakpoints: {
          640: {
            slidesPerView: 1,
            autoHeight: false,
            spaceBetween: 0,
          },
          768: {
            slidesPerView: 1,
            spaceBetween: 0,
          },
          1024: {
            slidesPerView: 1,
            spaceBetween: 0,
          },
        },
      })">
      @if (count($testimonials) > 1)
        <div class="absolute inset-y-0 -left-4 sm:left-0 z-10 flex items-center">
          <button aria-label="previous" @click="swiper.slidePrev()"
            class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
          </button>
        </div>
      @endif
      <div class="swiper" x-ref="container">
        <div class="swiper-wrapper">
          @foreach ($testimonials as $index => $testimonial)
          <div class="swiper-slide relative">
            <blockquote class="testimonial-quote mb-2">
              <div class="max-w-5xl mx-auto text-center text-lg md:text-2xl md:leading-normal">
                {!! $testimonial['quote'] !!}
              </div>
              <footer class="mt-10">
                <div class="md:flex md:items-center md:justify-center">
                  @if ($testimonial['image'])
                    <div class="md:flex-shrink-0">
                      <img class="mx-auto h-10 w-10 md:mr-4 rounded-full"
                        src="{{ $testimonial['image']['sizes']['thumbnail'] }}"
                        alt="" />
                    </div>
                  @endif
                  <div class="mt-3 text-center md:mt-0 flex flex-col items-center md:flex-row">
                    <div class="text-sm sm:text-base font-semibold">{{ $testimonial['name'] }}</div>
                    @if ($testimonial['title_position'])
                      <div class="my-2 md:my-0 md:inline">
                        <svg class="hidden md:block mx-1 h-5 w-5 text-action" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M11 0h3L9 20H6l5-20z" />
                        </svg>
                      </div>
                      <div class="text-sm sm:text-base font-semibold md:text-left sm:max-w-sm lg:max-w-none">{{ $testimonial['title_position'] }}</div>
                    @endif
                  </div>
                </div>
                @if ($testimonial['company_logo'])
                  <div class="flex justify-center mt-8">
                    <span class="@if ('light-gradient' == $background['color']) bg-[#FBFDFE] @else bg-{{ $background['color'] }} @endif">
                      <img class="w-auto mix-blend-multiply h-auto max-w-[224px] max-h-16"
                        src="{{ $testimonial['company_logo']['sizes']['medium'] }}"
                        alt="" />
                    </span>
                  </div>
                @endif
              </footer>
            </blockquote>
          </div>
          @endforeach
        </div>
        <div class="swiper-pagination"></div>
      </div>

      @if (count($testimonials) > 1)
        <div class="absolute inset-y-0 -right-4 sm:right-0 z-10 flex items-center">
          <button aria-label="next" @click="swiper.slideNext()"
            class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </button>
        </div>
      @endif
    </div>
    </div>
  </section>
@endif
