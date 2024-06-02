<style>
  .swiper-slide {
    height: auto;
  }
.date-tab {
  border: none;
  background: transparent;
  border-radius: 0;
  width: auto;
  height: auto;
  padding: 0 10px 13px 10px;
  transition: none;
}
.date-tab.swiper-pagination-bullet-active {
  color: #105890;
  font-weight: 800;
  border-bottom: solid 3px #2874AF;
  position:relative;
}
.date-tab.swiper-pagination-bullet-active::after {
  content: '';
  position:absolute;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 0 12px 10px 12px;
  border-color: transparent transparent #2874af transparent;
  bottom: 0;
  left: 50%;
  margin-left: -12px;
}
.swiper-pagination-timeline span {
}
.swiper-pagination-bullets-dynamic {
  font-size: 16px !important;
}
@media only screen and (min-width: 1024px) {
  .date-tab {
    padding: 0 22px 13px 22px;
  }
}

.swiper-pagination-bullet {
  height: auto !important;
  width: auto !important;
}

.swiper-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet, .swiper-pagination-horizontal.swiper-pagination-bullets .swiper-pagination-bullet {
  margin:0;
}

.swiper-pagination-bullets-dynamic .swiper-pagination-bullet {
  transform: scale(0.65);
}
.swiper-pagination-bullets-dynamic .swiper-pagination-bullet-active-prev,
.swiper-pagination-bullets-dynamic .swiper-pagination-bullet-active-next {
	transform: scale(0.75);
}

.swiper-pagination-bullets-dynamic .swiper-pagination-bullet-active, .swiper-pagination-bullets-dynamic .swiper-pagination-bullet-active-main {
  transform: scale(1);
}
.swiper-pagination {
  display: block;
}
</style>
@php
$timeline = $acf["components"][$index]["timeline"];
@endphp
@if ($timeline)
  @php
    $enableLoop = 'true';
    if (count($timeline) > 1) {
     // $enableLoop = 'true';
    }
  @endphp
@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
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
      class="relative max-w-7xl mx-auto sm:px-8 md:px-14"
      x-data="{swiper: null}"
      x-init='swiper = new Swiper($refs.container, {
        loop: false,
        setWrapperSize: true,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
          dynamicBullets: true,
          dynamicMainBullets: 1,
          renderBullet: function (index, className) {
            let date = this.slides[index].dataset.date;
            return "<span class=\"date-tab text-md " + className + "\">" + (date) + "</span>";
          },
        },
        slidesPerView: 1,
        spaceBetween: 30,
        breakpoints: {
          640: {
            slidesPerView: 1,
          },
          768: {
            slidesPerView: 1,
          },
          1024: {
            pagination: {
              dynamicBullets: false,
            },
            slidesPerView: 1,
          },
        },
      })'>
      @if (count($timeline) > 1)
        <div class="absolute inset-y-0 -left-4 sm:left-0 z-10 flex items-center">
          <button aria-label="previous" @click="swiper.slidePrev()"
            class="hidden text-action hover:text-action ease-out duration-300 sm:flex justify-center items-center  rounded-md bg-white shadow-md p-2 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
          </button>
        </div>
      @endif
      <div class="swiper" style="padding:40px 10px 20px 10px" x-ref="container">
        <div class="swiper-wrapper">
          @foreach ($cards as $index => $card)
          <div class="swiper-slide flex justify-center items-center bg-white rounded-3xl shadow-lg sm:h-full relative bg-white p-6 sm:px-16 sm:py-14" data-date="{{ $card['date'] }}">
            <div class="flex flex-col gap-10 md:grid grid-cols-12">
              @if ($card['image'])
                <div class="col-span-3 md:flex md:items-center md:justify-center">
                  <img class="mx-auto w-full h-auto max-w-[200px]"
                    src="{{ $card['image']['sizes']['medium'] }}"
                    alt="" />
                </div>
              @endif
              <div class="flex justify-center items-center @if ($card['image']) col-span-9 @else col-span-12 @endif text-lg">
                {!! $card['description'] !!}
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="swiper-pagination absolute top-0" style="bottom:initial !important"></div>
      </div>

      @if (count($timeline) > 1)
        <div class="absolute inset-y-0 -right-4 sm:right-0 z-10 flex items-center">
          <button aria-label="next" @click="swiper.slideNext()"
            class="hidden text-action hover:text-action ease-out duration-300 sm:flex justify-center items-center rounded-md bg-white shadow-md p-2 focus:outline-none">
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
