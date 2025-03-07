<style>
.service-icon-cards {
  min-height: 240px;
}
.service-icon-cards:hover .acf-icon-action {
  filter: brightness(0) saturate(100%) invert(100%) sepia(3%) saturate(5310%) hue-rotate(306deg) brightness(112%) contrast(102%) !important;
}
@media (min-width: 1024px) {
  .icon-carousel .swiper-wrapper {
  justify-content: center;
        max-width: 80rem;
        margin: auto;    
        display: flex;
}
.icon-carousel .swiper-slide {
  flex-shrink: 1;
}
}
</style>
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
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="relative @if ($background['color'] == 'dark') text-white @endif icon-carousel component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
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



  <div class="relative z-10 -mx-4" style="padding: 0;">
    @if (($section['id'] == 'service-card-bg-half') OR ($section['id'] == 'service-cards-privacy'))
      <div class="absolute lg:hidden right-0 left-0 h-3/4 bg-dark z-10 -ml-4 -mr-4 bottom-0"></div>
    @endif
    <div>
    @if (($background['color'] != 'light-gradient') && ($section['id'] != 'service-card-bg-half') && ($section['id'] != 'service-cards-privacy'))
      <div class="absolute h-2/3 bg-white bottom-0 left-0 right-0 -ml-12 -mr-12 lg:hidden"></div>
      @endif


      <div x-data="{ swiper: null }" 
     x-init="
       if (window.innerWidth < 1024) {
         swiper = new Swiper($refs.container, {
           loop: false,
           grabCursor: true,
           pagination: {
             el: '.swiper-pagination',
             dynamicBullets: true,
             clickable: true,
           },
           preventClicks: false,
           slidesPerView: 1.25,
           spaceBetween: 25,
           breakpoints: {
             640: { slidesPerView: 2.25 },
             980: { slidesPerView: 3.25 },
             1024: { slidesPerView: 3.25 },
           },
         });
       }
     ">
      <div class="swiper !pl-6 sm:!pl-10 md:!pl-0" x-ref="container">
        <div class="swiper-wrapper pb-10">
      @foreach ($cards as $index => $card)
        @php
          $link = $card['link'];
          $external_link = $card['external_link'];

          if ($external_link) {
            $link = $external_link;
          }
          if ($card['link_type'] == 'none') {
            $link = false;
          }
        @endphp
        <div class="swiper-slide" style="height: auto;">
          <div class="service-icon-cards h-full group">
            <div class="bg-white text-brand transition-all hover:shadow-lg relative flex items-start rounded-lg overflow-hidden group h-full 
            @if ($background['color'] != 'light-gradient') shadow-lg @endif 
            @if ($card['bg_image']) group-hover:bg-action-dark  
            @else 
            group-hover:bg-electric-purple 
            @endif 
            @if (!empty($card['custom_icon'])) gradient-border @endif">

              @if ($card['bg_image'])
                <div style="z-index: 1;" class="absolute inset-0">
                  @if ($link)
                  <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
                  @endif
                    <img class="lazy w-full h-full object-cover opacity-0 group-hover:opacity-20" data-src="{{ $card['bg_image']['sizes']['large'] }}" alt="{{ $card['bg_image']['alt'] }}" />
                  @if ($link)
                  </a>
                  @endif
                </div>
              @endif

              @if ($card['thumbnail'])
                <div style="z-index: 1;" class="top-10 left-0 right-0 px-3 absolute h-1/2">
                  @if ($link)
                  <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
                  @endif
                    <img class="lazy w-full h-full object-contain" data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}" alt="{{ $card['thumbnail']['alt'] }}" />
                  @if ($link)
                  </a>
                  @endif
                </div>
              @endif

              <div class="relative z-10 w-full h-full p-9 text-lg lg:text-4xl">
                <div classs="absolute inset-0 z-10 border-b-[15px] border-action-dark transition ease-in-out delay-250 group-hover:opacity-0 group-hover:z-0"></div>
                @if ($link)
                <a class="absolute inset-0 p-9 text-brand group-hover:text-white no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif>
                @endif
                <div class="relative">
                  @isset($card["icon"])
                  {{-- Check for custom_icon and render in a separate wrapper --}}
                  @if (!empty($card["custom_icon"]))
                    <span class="w-14 h-14 p-2 flex justify-center items-center rounded-full">
                      <img class="lazy h-full w-full custom-icon service-icon" 
                        data-src="{{ $card['custom_icon']['url'] }}" 
                        alt="{{ $card['custom_icon']['alt'] ?? 'Custom Icon' }}" />
                    </span>
                  @elseif (!empty($card["icon"]))
                    {{-- Render default icon inside styled span --}}
                    <span class="mb-5 block bg-light
                    @if ($alternate) bg-{{ $icon_color_class }} @else bg-light @endif 
                    @if ($icon_color_class == 'electric-purple') 
                       group-hover:bg-white 
                     @elseif ($icon_color_class == 'white') 
                       group-hover:bg-white
                     @else 
                       group-hover:bg-action
                     @endif 
                   w-10 h-10 p-2 flex justify-center items-center rounded-full">
                     <img class="lazy h-full w-full acf-icon-{{ $icon_color_class}} service-icon" data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                   </span>
                  @endif
                @endisset
                  {{-- @isset ($card["icon"])
                    @if (!empty($card["icon"]))
                      <span class="mb-5 block bg-light
                       @if ($alternate) bg-{{ $icon_color_class }} @else bg-light @endif 
                       @if ($icon_color_class == 'electric-purple') 
                          group-hover:bg-white 
                        @elseif ($icon_color_class == 'white') 
                          group-hover:bg-white
                        @else 
                          group-hover:bg-action
                        @endif 
                      w-10 h-10 p-2 flex justify-center items-center rounded-full">
                        <img class="lazy h-full w-full acf-icon-{{ $icon_color_class}} service-icon" data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                      </span>
                    @endif
                  @endisset --}}
                  @if ($card['title'])
                  <h3 class="text-xl font-semibold mb-4">{!! $card['title'] !!}</h3>
                  @endif
                  @if ($card['description'])
                    <div class="text-lg w-full">
                        {!! $card['description'] !!}
                    </div>
                  @endif
                </div>
                @if ($link)
                </a>
                @endif
              </div>
            </div>
        </div>
        </div>
      @endforeach
        </div>
        </div>
        </div>
    </div>
  </div>
  @if ($background['color'] == 'dark')
  <div class="absolute h-1/3 lg:h-1/3 bg-white bottom-0 left-0 right-0 hidden lg:block"></div>
  @endif
</section>


