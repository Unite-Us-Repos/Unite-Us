{{-- resources/views/components/network-articles.blade.php --}}

@php
  // ---------------------------------------------
  // Section settings (safe defaults)
  // ---------------------------------------------
  $s_settings = ['collapse_padding' => false, 'fullscreen' => ''];
  $section_settings = $acf['components'][$index]['layout_settings']['section_settings'] ?? $s_settings;

  // ---------------------------------------------
  // Fetch selected States from ACF (taxonomy field: pick_a_state)
  // Supports multiple; accepts term objects/arrays/IDs
  // ---------------------------------------------
  $selected_states_raw =
      $pick_a_state
      ?? ($acf['components'][$index]['pick_a_state'] ?? [])
      ?? [];

  $to_term_id = function ($t) {
      if (is_object($t) && isset($t->term_id)) return (int)$t->term_id;
      if (is_array($t)) return (int)($t['term_id'] ?? $t['id'] ?? $t['term'] ?? 0);
      return (int)$t;
  };
  $state_ids = array_values(array_filter(array_map($to_term_id, is_array($selected_states_raw) ? $selected_states_raw : [$selected_states_raw])));

  // ---------------------------------------------
  // Query Posts + Press by States
  // ---------------------------------------------
  $posts_per_page = $posts_per_page ?? 12;
  $args = [
    'post_type'           => ['post', 'press'],
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'orderby'             => 'date',
    'order'               => 'DESC',
    'posts_per_page'      => $posts_per_page,
    'tax_query'           => [],
  ];
  if (!empty($state_ids)) {
    $args['tax_query'][] = [
      'taxonomy' => 'states',
      'field'    => 'term_id',
      'terms'    => $state_ids,
      'operator' => 'IN',
    ];
  }

  $query = new WP_Query($args);
  $items = $query->posts ?? [];
  $item_count = (int)($query->post_count ?? 0);

  // ---------------------------------------------
  // Slider logic: only when enabled and > 3 items
  // ---------------------------------------------
  $should_slider = !empty($slider) && $slider && $item_count > 3;
  $is_swiper = $should_slider;

  // ---------------------------------------------
  // Grid columns map when NOT using slider
  // ACF "columns" choices: full, 2/4, 2/6, 1/4, 1/5
  // ---------------------------------------------
  $grid_count_array = ['full'=>1,'2/4'=>2,'2/6'=>3,'1/4'=>4,'1/5'=>5];

  // Fallback image if a post/press has no featured image
  $fallback_thumb = get_stylesheet_directory_uri() . '/public/images/Press-thumb.png';
@endphp

@if (!empty($background['has_divider']))
  @includeIf('dividers.waves')
@endif

<section
  @isset($section['id']) id="{{ $section['id'] }}" @endisset
  class="relative @if (($background['color'] ?? '') === 'dark') text-white @endif component-section {{ $section_classes ?? '' }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] }} @endif">

  {{-- Optional background image --}}
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

  {{-- Optional logo --}}
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
          @include('components.action-buttons', ['justify' => 'justify-center', 'mt' => 'mt-6'])
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

  {{-- Posts / Slider --}}
  <div class="component-inner-section relative z-10">
    @if (in_array(($section['id'] ?? ''), ['service-card-bg-half','service-cards-privacy']))
      <div class="absolute lg:hidden right-0 left-0 h-3/4 bg-dark z-10 -ml-4 -mr-4 bottom-0"></div>
    @endif

    <div>
      @if ($is_swiper && $item_count)
        <div
          x-data="{ swiper: null }"
          x-init="
            const root = $el;
            const getPad = () => {
              const cis = root.closest('section')?.querySelector('.component-inner-section');
              const pl = cis ? parseFloat(getComputedStyle(cis).paddingLeft) : 24;
              return isNaN(pl) ? 24 : Math.round(pl);
            };
            const pad = getPad();

            swiper = new Swiper($refs.container, {
              allowTouchMove: true,
              simulateTouch: true,
              touchStartPreventDefault: false,
              touchRatio: 1,
              threshold: 6,
              shortSwipes: true,
              longSwipes: true,
              longSwipesRatio: 0.35,
              preventClicks: true,
              preventClicksPropagation: true,
              grabCursor: true,
              speed: 500,
              watchOverflow: true,
              pagination: { el: $refs.pagination, clickable: true },
              spaceBetween: 16,
              slidesPerView: 1.15,
              slidesOffsetBefore: pad,
              slidesOffsetAfter: pad + 48,
              breakpoints: {
                640:  { slidesPerView: 2.15, spaceBetween: 16, slidesOffsetBefore: pad, slidesOffsetAfter: pad + 64 },
                1024: { slidesPerView: 3.25, spaceBetween: 16, slidesOffsetBefore: pad, slidesOffsetAfter: pad + 220 },
                1280: { slidesPerView: 3.5,  spaceBetween: 16, slidesOffsetBefore: pad, slidesOffsetAfter: pad + 280 },
              },
            });

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
          <div class="article-slider relative">
            <div class="swiper testimonials" x-ref="container">
              <div class="swiper-wrapper pb-10">
                @foreach ($items as $i => $item)
                  @php
                    $pid   = $item->ID;
                    $link  = get_permalink($pid);
                    $thumb = get_the_post_thumbnail_url($pid, 'medium_large') ?: $fallback_thumb;
                    $title = get_the_title($pid);
                    $desc  = get_the_excerpt($pid);
                  @endphp

                  <div class="swiper-slide">
                    <div class="service-icon-cards h-full group">
                      <div class="bg-transparent text-white relative overflow-hidden h-full">
                        <div class="article-card relative z-10 w-full text-lg lg:text-4xl">
                          <a aria-label="{{ esc_html(strip_tags($title)) }}"
                             aria-describedby="article-card-{{ $i }}"
                             class="absolute inset-0 z-20 no-underline"
                             href="{{ $link }}">
                            <span class="sr-only">{{ $title }}</span>
                          </a>

                          <div class="relative">
                            <div class="mb-6 rounded-lg overflow-hidden">
                              <img class="lazy w-full h-full aspect-video object-cover"
                                   decoding="async"
                                   data-src="{{ $thumb }}"
                                   alt="{{ esc_attr($title) }}" />
                            </div>

                            <h3 id="article-card-{{ $i }}" class="text-xl font-semibold mb-4">{!! $title !!}</h3>

                            {{-- @if (!empty($desc))
                              <div class="text-base w-full">{!! $desc !!}</div>
                            @endif --}}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <div class="swiper-pagination article-pagination mt-8 flex justify-center" x-ref="pagination"></div>
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

        <div class="component-inner-section p-0">
          <div class="no-swiper">
            <div class="flex testimonials flex-col md:grid {{ $md_grid_cols }} {{ $grid_cols }} gap-6">
              @foreach ($items as $i => $item)
                @php
                  $pid   = $item->ID;
                  $link  = get_permalink($pid);
                  $thumb = get_the_post_thumbnail_url($pid, 'medium_large') ?: $fallback_thumb;
                  $title = get_the_title($pid);
                  $desc  = get_the_excerpt($pid);
                @endphp

                <div class="h-full">
                  <div class="service-icon-cards h-full group">
                    <div class="bg-transparent text-white relative overflow-hidden h-full">
                      <div class="article-card relative z-10 w-full text-lg lg:text-4xl">
                        <a aria-label="{{ esc_html(strip_tags($title)) }}"
                           aria-describedby="article-card-{{ $i }}"
                           class="absolute inset-0 z-20 no-underline"
                           href="{{ $link }}">
                          <span class="sr-only">{{ $title }}</span>
                        </a>

                        <div class="relative">
                          <div class="mb-6 rounded-lg overflow-hidden">
                            <img class="lazy w-full h-full aspect-video object-cover"
                                 decoding="async"
                                 data-src="{{ $thumb }}"
                                 alt="{{ esc_attr($title) }}" />
                          </div>

                          <h3 id="article-card-{{ $i }}" class="text-xl font-semibold mb-4">{!! $title !!}</h3>

                          {{-- @if (!empty($desc))
                            <div class="text-base w-full">{!! $desc !!}</div>
                          @endif --}}
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
    </div>
  </div>
</section>

@if (!empty($background['divider_bottom']))
  @includeIf('dividers.waves-bottom')
@endif

@php
  // Hard reset query state so downstream components (FAQs, Tabs, etc.) see the correct global post.
  wp_reset_postdata();
  wp_reset_query();
@endphp

<style>
  .article-slider .swiper { overflow: visible; } /* allow off-right peek */

  /* Equal-height for slides */
  .article-slider .swiper-wrapper { height:auto !important; align-items:stretch !important; }
  .article-slider .swiper-slide   { display:flex !important; height:auto !important; }

  .article-card{
    position:relative; display:flex; flex-direction:column;
    border-radius:1rem; padding:2rem; transition:all .5s linear;
    backface-visibility:hidden; transform:translateZ(0);
    flex:1 1 auto; height:100%;
  }
  .article-card::after{
    content:''; position:absolute; inset:0; z-index:0; border-radius:1rem; padding:1px;
    background:linear-gradient(113.78deg,#2F71F4 0%,#2F71F4 48.34%,#9643FF 100%);
    mask:linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask-composite:exclude;
    -webkit-mask:linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite:xor;
    transition:all .5s linear; pointer-events:none;
  }

  .service-icon-cards:hover .article-card,
  .article-card:hover,
  .article-card:focus-within{
    background:
      linear-gradient(0deg, rgba(255,255,255,.05), rgba(255,255,255,.05)),
      linear-gradient(0deg, rgba(47,113,244,.08), rgba(47,113,244,.08)),
      linear-gradient(117.36deg, rgba(150,67,255,0) 36.69%, rgba(150,67,255,.08) 100%);
  }

  .article-slider .article-card .relative{ display:flex; flex-direction:column; flex:1 1 auto; position:relative; z-index:1; }

  .article-pagination.swiper-pagination{ display:flex; align-items:center; }
  .article-pagination .swiper-pagination-bullets.swiper-pagination-horizontal{ position:static; display:flex; align-items:center; justify-content:center; }
  .article-pagination .swiper-pagination-bullet{
    width:10px; height:10px; margin:0 10px !important; border-radius:9999px;
    background:rgba(157,180,197,.28); opacity:.5; transform:none !important; box-shadow:none; cursor:pointer;
  }
  .article-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active{
    width:20px; height:20px; background:transparent; border:4px solid rgba(157,180,197,.25); position:relative; opacity:1;
  }
  .article-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active::after{
    content:""; position:absolute; inset:1px; border-radius:9999px; background:rgba(157,180,197,.8); opacity:1;
  }
  .article-pagination .swiper-pagination-bullet:focus-visible{ outline:2px solid rgba(157,180,197,.9); outline-offset:2px; }
  .article-pagination .swiper-pagination-bullet:hover{ background:rgba(157,180,197,.45); }
</style>
