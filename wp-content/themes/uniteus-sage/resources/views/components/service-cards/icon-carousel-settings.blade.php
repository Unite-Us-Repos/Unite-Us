
@php
$s_settings = [
        'collapse_padding' => false,
        'fullscreen' => '',
];
$section_settings = isset($acf["components"][$index]['layout_settings']['section_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : $s_settings;
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section
  @isset ($section['id'])
  id="{{ $section['id'] }}" @endisset
  class="relative
    @if ($background['color'] == 'dark') text-white @endif
    icon-carousel component-section {{ $section_classes }}
    @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif
    @if ($swiperJsSettings['slidesPerView'] == 'auto')
      !px-0 2xl:!px-4
    @endif
  ">
  @if ('center' == $section["alignment"])
    <div class="component-inner-section">
      <div class="text-center mb-7">
        @if ($section['subtitle'])
          @if ($section['subtitle_display_as_pill'])
            <span class="@if ($background['color'] == 'dark') bg-brand text-action-light-blue @else text-action @if ($background['color'] == 'light-gradient') bg-white @else bg-light mix-blend-multiply @endif @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
          @else
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
          @endif
            {{ $section['subtitle'] }}
            </span>
        @endif
        @if ($section['title'])
        <h2 class="mb-6">{!! $section['title'] !!}</h2>
        @endif
        @if ($section['description'])
        <div class="text-lg">
          <div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div>
        </div>
        @endif
          @if ($buttons)
            @php
              $data = [
                'justify' => 'justify-center',
                'mt' => 'mt-6',
              ];
            @endphp
            @include('components.action-buttons', $data)
          @endif
      </div>
    </div>

  @elseif ('left' == $section["alignment"])
    <div class="component-inner-section">
      <div class="mb-6">
        @if ($section['subtitle'])
          <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
            {{ $section['subtitle'] }}
          </span>
        @endif
        <h2 class="mb-6">{!! $section['title'] !!}</h2>
        <div class="text-lg">
          {!! $section['description'] !!}
        </div>
      </div>
    </div>
  @else
    <div class="component-inner-section">
      <div class="flex flex-col md:grid md:grid-cols-12 gap-3 mb-5">
        <div class="md:col-span-4">
          @if ($section['subtitle'])
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
              {{ $section['subtitle'] }}
            </span>
          @endif
          <h2 class="mb-0">{!! $section['title'] !!}</h2>
        </div>
        <div class="md:col-span-8 text-lg">
          {!! $section['description'] !!}
        </div>
      </div>
    </div>
  @endif

  <div class="relative z-10 @if ($swiperJsSettings['slidesPerView'] == 'auto') 2xl:max-w-7xl 2xl:px-8 2xl:mx-auto @else component-inner-section @endif">
    @if (($section['id'] == 'service-card-bg-half') OR ($section['id'] == 'service-cards-privacy'))
      <div class="absolute lg:hidden right-0 left-0 h-3/4 bg-dark z-10 -ml-4 -mr-4 bottom-0"></div>
    @endif
    @if (($background['color'] != 'dark') && ($background['color'] != 'light-gradient') && ($section['id'] != 'service-card-bg-half') && ($section['id'] != 'service-cards-privacy'))
      <div class="absolute h-2/3 bg-white bottom-0 left-0 right-0 -ml-12 -mr-12 lg:hidden"></div>
    @endif

      <div id="icon-slider-{{ $component_index }}"
        x-data="{ swiper: null }"
        x-init="
          const options = JSON.parse($el.dataset.swiperOptions);
          swiper = new Swiper($refs.swiperContainer, options);
          swiper.on('resize', () => swiper.update());
        "
        data-swiper-options='{!! $swiperJsSettingsJson !!}'>

        <div class="swiper @if ($swiperJsSettings['slidesPerView'] == 'auto') pl-0 sm:pl-8 xl:pl-[6.5rem] !pr-16 2xl:!px-0 @endif" x-ref="swiperContainer">
          <div class="swiper-wrapper md:pb-6">
            @foreach ($cards as $index => $card)
              <div class="swiper-slide !h-auto

                @if ($swiperJsSettings['slidesPerView'] == 'auto')
                  max-w-sm
                @endif
                ">
                @include('components.service-cards.partials.icon-card')
              </div>
            @endforeach
          </div>
        </div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-scrollbar"></div>
      </div>
  </div>
  @if ($background['color'] == 'dark')
  <div class="absolute h-1/4 bg-white bottom-0 left-0 right-0 hidden md:block"></div>
  @endif
</section>
