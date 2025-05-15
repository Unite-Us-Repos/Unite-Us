<style>
.service-icon-cards {
  min-height: 240px;
  position: relative;
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
.article-cards {
  border: solid 1px #2F71F4;
  border-radius: 1rem;
  overflow: hidden;
}
.article-card::after {
  content: '';
  display: block;
  padding-top: 100%;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 0;
  border-radius: 1rem;

  /* Create gradient border with transparent center */
  padding: 1px; /* Border thickness */
  background: linear-gradient(113.78deg, #2F71F4 0%, #2F71F4 48.34%, #9643FF 100%);
  mask:
    linear-gradient(#fff 0 0) content-box,
    linear-gradient(#fff 0 0);
  mask-composite: exclude;
  -webkit-mask:
    linear-gradient(#fff 0 0) content-box,
    linear-gradient(#fff 0 0);
  -webkit-mask-composite: xor;

  transition: all 0.5s linear;
}
</style>
@php
$s_settings = [
        'collapse_padding' => false,
        'fullscreen' => '',
];
$is_swiper = false;
$section_settings = isset($acf["components"][$index]['layout_settings']['section_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : $s_settings;
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="relative @if ($background['color'] == 'dark') text-white @endif icon-carousel component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
@if ($background['image'])
  <div class="absolute inset-0">
    <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
      srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
      sizes="(max-width: 600px) 300px, 1024px"
      alt="{{ $background['image']['alt'] }}">
  </div>
@endif
@if ('center' == $section["alignment"])
  <div class="component-inner-section relative z-10">
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



  <div class="relative z-10" style="padding: 0;">
    @if (($section['id'] == 'service-card-bg-half') OR ($section['id'] == 'service-cards-privacy'))
      <div class="absolute lg:hidden right-0 left-0 h-3/4 bg-dark z-10 -ml-4 -mr-4 bottom-0"></div>
    @endif
    <div>

      @if ($is_swiper)
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
     <div>
        <div class="swiper" x-ref="container">
        <div class="swiper-wrapper pb-10 lg:gap-6">
     @else
        @php
          $grid_count_array = [
            'full' => 1,
            '2/4' => 2,
            '2/6' => 3,
            '1/4' => 4,
            '1/5' => 5,
          ];
          $grid_cols = 'lg:grid-cols-1';
          $md_grid_cols = '';

          if ($columns && $columns != 'full') {
            $grid_cols = 'lg:grid-cols-' . $grid_count_array[$columns];
            $md_grid_cols = 'md:grid-cols-2';
          }
        @endphp
        <div class="component-inner-section">
        <div class="no-swiper">
        <div class="flex flex-col md:grid {{ $md_grid_cols }} {{ $grid_cols }} gap-6">
     @endif

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



        <div class="@if ($is_swiper) swiper-slide @endif" style="height: auto;">
          <div class="service-icon-cards h-full group">
            <div class="bg-transparent text-white relative flex items-start overflow-hidden group h-full

            ">


              <div class="article-card relative z-10 w-full h-full p-9 text-lg lg:text-4xl">
                  @if ($link)
                    <a aria-label="{{ esc_html(strip_tags($card['title'])) }}" aria-describedby="article-card-{{ $index }}" class="absolute inset-0 z-20 no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif"><span class="sr-only">{!! $card['title'] !!}</span></a>
                  @endif

                <div class="relative">

                @if ($card['thumbnail'])
                  <div class="mb-10 rounded-lg overflow-hidden">
                      <img class="lazy w-full h-full aspect-video object-contain" decoding="async" data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}" alt="{{ $card['thumbnail']['alt'] }}" />
                  </div>
                @endif


                  @if ($card['title'])
                  <h3 id="article-card-{{ $index }}" class="text-xl font-semibold mb-4">{!! $card['title'] !!}</h3>
                  @endif
                  @if ($card['description'])
                    <div class="text-base w-full">
                        {!! $card['description'] !!}
                    </div>
                  @endif
                </div>

              </div>
            </div>
        </div>
        </div>
      @endforeach
        </div>
        </div>

        @if ($testimonials)
          @include('components.service-cards.partials.testimonials', ['testimonials' => $testimonials])
        @endif
      </div>
    </div>
  </div>
</section>
@if ($background['divider_bottom'])
  @includeIf('dividers.waves-bottom')
@endif

<style>
  .article-card {
    transition: all 0.5s linear;
  }
  .article-card:hover {
    background: rgba(255, 255, 255, 0.8);
  }
</style>
