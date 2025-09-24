{{-- resources/views/components/service-icon-cards.blade.php --}}

<style>
  .article-cards.testimonials {
    border: solid 1px #2F71F4;
    border-radius: 1rem;
    overflow: hidden;
  }
  .testimonials .article-card::after {
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

    /* Gradient border with transparent center */
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
  // Defaults for section settings
  $s_settings = [
    'collapse_padding' => false,
    'fullscreen' => '',
  ];

  // Resolve section settings from ACF
  $section_settings = isset($acf['components'][$index]['layout_settings']['section_settings'])
    ? $acf['components'][$index]['layout_settings']['section_settings']
    : $s_settings;

  // Slider enabled only when $slider is true AND there are more than 3 cards
  $should_slider = !empty($slider) && $slider && is_countable($cards ?? []) && count($cards ?? []) > 3;
  $is_swiper = $should_slider;

  // Columns map for non-swiper grid
  $grid_count_array = [
    'full' => 1,
    '2/4' => 2,
    '2/6' => 3,
    '1/4' => 4,
    '1/5' => 5,
  ];
@endphp

@if (!empty($background['has_divider']))
  @includeIf('dividers.waves')
@endif

<section
  @isset ($section['id']) id="{{ $section['id'] }}" @endisset
  class="relative @if (($background['color'] ?? '') === 'dark') text-white @endif component-section {{ $section_classes ?? '' }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] }} @endif">

  @if (!empty($background['image']))
    <div class="absolute inset-0">
      <img
        fetchpriority="high"
        class="w-full h-full object-cover @if (($background['position'] ?? '') === 'top') object-top @endif @if (($background['position'] ?? '') === 'bottom') object-bottom @endif"
        src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    </div>
  @endif

  @if (!empty($section['logo']))
    <div class="logo-image">
      <img srcset="{{ $section['logo']['url'] }}" alt="{{ $section['logo']['alt'] }}">
    </div>
  @endif

  {{-- Heading / copy --}}
  @if (($section['alignment'] ?? '') === 'center')
    <div class="component-inner-section relative z-10">
      <div class="text-center mb-7">
        @if (!empty($section['subtitle']))
          @if (!empty($section['subtitle_display_as_pill']))
            <span class="@if (($background['color'] ?? '') === 'dark') bg-brand text-action-light-blue @else text-action @if (($background['color'] ?? '') === 'light-gradient') bg-white @else bg-light mix-blend-multiply @endif @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
          @else
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
          @endif
              {{ $section['subtitle'] }}
            </span>
        @endif

        @if (!empty($section['title']))
          <h2 class="mb-6">{!! $section['title'] !!}</h2>
        @endif

        @if (!empty($section['description']))
          <div class="text-lg">
            <div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div>
          </div>
        @endif

        @if (!empty($buttons))
          @php $data = ['justify' => 'justify-center', 'mt' => 'mt-6']; @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
    </div>

  @elseif (($section['alignment'] ?? '') === 'left')
    <div class="component-inner-section">
      <div class="mb-6">
        @if (!empty($section['subtitle']))
          <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
            {{ $section['subtitle'] }}
          </span>
        @endif
        @if (!empty($section['title']))
          <h2 class="mb-6">{!! $section['title'] !!}</h2>
        @endif
        @if (!empty($section['description']))
          <div class="text-lg">{!! $section['description'] !!}</div>
        @endif
      </div>
    </div>

  @else
    <div class="component-inner-section">
      <div class="flex flex-col md:grid md:grid-cols-12 gap-3 mb-5">
        <div class="md:col-span-4">
          @if (!empty($section['subtitle']))
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
              {{ $section['subtitle'] }}
            </span>
          @endif
          @if (!empty($section['title']))
            <h2 class="mb-0">{!! $section['title'] !!}</h2>
          @endif
        </div>
        <div class="md:col-span-8 text-lg">
          {!! $section['description'] ?? '' !!}
        </div>
      </div>
    </div>
  @endif

  {{-- Cards / Slider --}}
  <div class="component-inner-section relative z-10">
    @if (in_array(($section['id'] ?? ''), ['service-card-bg-half','service-cards-privacy']))
      <div class="absolute lg:hidden right-0 left-0 h-3/4 bg-dark z-10 -ml-4 -mr-4 bottom-0"></div>
    @endif

    <div>
      @if ($is_swiper)
        <style>
          /* Allow slides to peek beyond container for the off-page look */
          .swiper { overflow: visible; }
        </style>

        <div
          x-data="{ swiper: null }"
          x-init="
            const root = $el; // Alpine root
            const getPad = () => {
              const cis = root.closest('section')?.querySelector('.component-inner-section');
              const pl = cis ? parseFloat(getComputedStyle(cis).paddingLeft) : 24;
              return isNaN(pl) ? 24 : Math.round(pl);
            };
            const pad = getPad();

            swiper = new Swiper($refs.container, {
              grabCursor: true,
              speed: 500,
              watchOverflow: true,
              pagination: { el: $refs.pagination, clickable: true },
              /* Base */
              spaceBetween: 16,
              slidesPerView: 1.15,
              slidesOffsetBefore: pad,
              slidesOffsetAfter: pad + 48,

              breakpoints: {
                640:  {
                  slidesPerView: 2.15,
                  spaceBetween: 16,
                  slidesOffsetBefore: pad,
                  slidesOffsetAfter: pad + 64
                },
                1024: {
                  slidesPerView: 3.25,
                  spaceBetween: 16,
                  slidesOffsetBefore: pad,
                  slidesOffsetAfter: pad + 220  // off-right peek on desktop
                },
                1280: {
                  slidesPerView: 3.5,
                  spaceBetween: 16,
                  slidesOffsetBefore: pad,
                  slidesOffsetAfter: pad + 280
                },
              },
            });

            // Re-align on resize so it always matches the container gutter
            const onResize = () => {
              const p = getPad();
              swiper.params.slidesOffsetBefore = p;
              swiper.params.slidesOffsetAfter  =
                window.innerWidth >= 1280 ? p + 280 :
                window.innerWidth >= 1024 ? p + 220 :
                window.innerWidth >= 640  ? p + 64  : p + 48;
              swiper.update();
            };
            window.addEventListener('resize', onResize);
          "
        >
          {{-- Full-bleed track; we’ll offset inside via Swiper’s slidesOffsetBefore --}}
          <div class="relative">
            {{-- IMPORTANT: add `.testimonials` so border/hover CSS applies to slides too --}}
            <div class="swiper testimonials" x-ref="container">
              <div class="swiper-wrapper pb-10 lg:gap-6">
                @foreach ($cards as $i => $card)
                  @php
                    $link = $card['link'] ?? null;
                    if (!empty($card['external_link'])) { $link = $card['external_link']; }
                    if (($card['link_type'] ?? '') === 'none') { $link = false; }
                  @endphp

                  <div class="swiper-slide service-icon-cards h-full group text-white relative flex items-start overflow-hidden bg-transparent article-card relative z-10 w-full h-full p-9 text-lg lg:text-4xl">

       
                          @if ($link)
                            <a aria-label="{{ esc_html(strip_tags($card['title'] ?? '')) }}"
                               aria-describedby="article-card-{{ $i }}"
                               class="absolute inset-0 z-20 no-underline"
                               href="{{ $link }}" @if (!empty($card['is_blank'])) target="_blank" @endif>
                              <span class="sr-only">{!! $card['title'] ?? '' !!}</span>
                            </a>
                          @endif

                          <div class="relative">
                            @if (!empty($card['thumbnail']))
                              <div class="mb-4 rounded-lg overflow-hidden">
                                <img class="lazy w-full h-full aspect-video object-contain"
                                     decoding="async"
                                     data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}"
                                     alt="{{ $card['thumbnail']['alt'] }}" />
                              </div>
                            @endif

                            @if (!empty($card['title']))
                              <h3 id="article-card-{{ $i }}" class="text-xl font-semibold mb-4">{!! $card['title'] !!}</h3>
                            @endif

                            @if (!empty($card['description']))
                              <div class="text-base w-full">{!! $card['description'] !!}</div>
                            @endif
                          </div>
                        
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <div class="swiper-pagination mt-8 flex justify-center" x-ref="pagination"></div>
        </div>

      @else
        @php
          $grid_cols = 'lg:grid-cols-1';
          $md_grid_cols = '';
          if (!empty($columns) && $columns !== 'full') {
            $grid_cols = 'lg:grid-cols-' . ($grid_count_array[$columns] ?? 1);
            $md_grid_cols = 'md:grid-cols-2';
          }
        @endphp

        <div class="component-inner-section">
          <div class="no-swiper">
            {{-- Keep `.testimonials` here so border/hover apply in grid mode too --}}
            <div class="flex testimonials flex-col md:grid {{ $md_grid_cols }} {{ $grid_cols }} gap-6">
              @foreach ($cards as $i => $card)
                @php
                  $link = $card['link'] ?? null;
                  if (!empty($card['external_link'])) { $link = $card['external_link']; }
                  if (($card['link_type'] ?? '') === 'none') { $link = false; }
                @endphp

                <div>
                  <div class="service-icon-cards h-full group">
                    <div class="bg-transparent text-white relative flex items-start overflow-hidden group h-full">
                      <div class="article-card relative z-10 w-full h-full p-9 text-lg lg:text-4xl">
                        @if ($link)
                          <a aria-label="{{ esc_html(strip_tags($card['title'] ?? '')) }}"
                             aria-describedby="article-card-{{ $i }}"
                             class="absolute inset-0 z-20 no-underline"
                             href="{{ $link }}" @if (!empty($card['is_blank'])) target="_blank" @endif>
                            <span class="sr-only">{!! $card['title'] ?? '' !!}</span>
                          </a>
                        @endif

                        <div class="relative">
                          @if (!empty($card['thumbnail']))
                            <div class="mb-10 rounded-lg overflow-hidden">
                              <img class="lazy w-full h-full aspect-video object-contain"
                                   decoding="async"
                                   data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}"
                                   alt="{{ $card['thumbnail']['alt'] }}" />
                            </div>
                          @endif

                          @if (!empty($card['title']))
                            <h3 id="article-card-{{ $i }}" class="text-xl font-semibold mb-4">{!! $card['title'] !!}</h3>
                          @endif

                          @if (!empty($card['description']))
                            <div class="text-base w-full">{!! $card['description'] !!}</div>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      @endif

      @if (!empty($testimonials))
        @include('components.service-cards.partials.testimonials', ['testimonials' => $testimonials])
      @endif
    </div>
  </div>
</section>

@if (!empty($background['divider_bottom']))
  @includeIf('dividers.waves-bottom')
@endif

<style>
  .testimonials .article-card {
    transition: all 0.5s linear;
    border-radius: 1rem;
    min-height: 525px;
    padding: 2rem;
  }

  .button-hollow-gradient:hover,
  .testimonials .article-card:hover {
    background: linear-gradient(0deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.05)),
      linear-gradient(0deg, rgba(47, 113, 244, 0.08), rgba(47, 113, 244, 0.08)),
      linear-gradient(117.36deg, rgba(150, 67, 255, 0) 36.69%, rgba(150, 67, 255, 0.08) 100%);
  }

  .quotes {
    position: relative;
    padding-left: 1rem;
    padding-right: 1rem;
    quotes: """ """;
  }
  .quote-title { padding-left: 1rem; }

  .quotes::before {
    content: open-quote;
    font-size: 2rem;
    line-height: 1;
    position: absolute;
    left: 0;
    top: 0.25rem;
    color: #fff;
  }
  .quotes::after { content: none; }

  .quotes p:last-child { position: relative; display: inline !important; }
  .quotes p:last-child::after {
    content: close-quote;
    font-size: 2rem;
    line-height: 1;
    position: absolute;
    display: inline;
    color: #ffffff;
    vertical-align: bottom;
    margin-left: 0.25rem;
  }
  /* Keep pagination in flow under the slider */
.swiper-pagination-bullets.swiper-pagination-horizontal {
  position: static;
      position: static;
    display: flex;
    align-items: center;
}

/* Base (inactive) bullets */
.swiper-pagination-bullet {
  width: 10px;
  height: 10px;
  margin: 0 10px !important;      /* spacing between dots */
  border-radius: 9999px;
  background: rgba(157, 180, 197, 0.28); /* subtle bluish-gray dot */
  opacity: 0.5;                       /* let color control the tone */
  transform: none !important;       /* prevent dynamic scaling */
  box-shadow: none;
  cursor: pointer;
}

/* Active bullet = ring + inner dot */
.swiper-pagination-bullet.swiper-pagination-bullet-active {
  width: 20px;
  height: 20px;
  background: transparent;                          /* ring only */
  border: 4px solid rgba(157, 180, 197, 0.25);      /* outer ring */
  position: relative;
  opacity: 1;
}

/* Inner filled dot for active */
.swiper-pagination-bullet.swiper-pagination-bullet-active::after {
  content: "";
  position: absolute;
  inset: 1px;                                       /* ring thickness */
  border-radius: 9999px;
  background: rgba(157, 180, 197, 0.8);   
  opacity: 1;         /* inner fill */
}

/* Optional: focus/hover states for accessibility */
.swiper-pagination-bullet:focus-visible {
  outline: 2px solid rgba(157, 180, 197, 0.9);
  outline-offset: 2px;
}
.swiper-pagination-bullet:hover {
  background: rgba(157, 180, 197, 0.45);
}

</style>
