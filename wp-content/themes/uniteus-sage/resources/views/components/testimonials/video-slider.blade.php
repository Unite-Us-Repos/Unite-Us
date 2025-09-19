@if ($testimonials)
  @php
    $enableLoop = count($testimonials) > 1 ? 'true' : 'false';
  @endphp

{{-- put this near the top where you set $enableLoop --}}
@php
  $total           = count($testimonials);
  $enableLoop      = $total > 1 ? 'true' : 'false';
  $slidesMobile    = 1;                 // phones stay 1-up
  $slidesTablet    = min(2, $total);    // 2-up max on tablet
  $slidesDesktop   = min(4, $total);    // up to 4 on desktop; less if fewer slides
  $loopAdditional  = max(0, $slidesDesktop - 1); // helps smooth the loop with few slides
@endphp

  @if (!empty($background['has_divider']))
    @includeIf('dividers.waves')
  @endif

  <section class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif @if ($section_settings['fullscreen']) fullscreen !px-0 @endif">
    {{-- Background image --}}
    @if (!empty($background['image']))
      <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
        <img
          fetchpriority="high"
          class="w-full h-full object-cover
            @if (!empty($background['position']) && $background['position'] === 'top') object-top @endif
            @if (!empty($background['position']) && $background['position'] === 'bottom') object-bottom @endif"
          src="{{ $background['image']['sizes']['medium'] }}"
          srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
          sizes="(max-width: 600px) 300px, 1024px"
          alt="{{ $background['image']['alt'] ?? '' }}"
        >
      </div>
    @endif

    <div class="component-inner-section">
      {{-- Subtitle --}}
      @if (!empty($section['subtitle']))
        @if (!empty($section['subtitle_display_as_pill']))
          <div class="border-action border text-sm py-1 px-4 inline-block mb-6 rounded-full text-brand">
        @else
          <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
        @endif
            {!! $section['subtitle'] !!}
          </div>
      @endif

      {{-- Title / Description --}}
      @if (!empty($section['title']) || !empty($section['description']))
        <div class="text-left max-w-xl pb-8 lg:pb-0">
          @if (!empty($section['title']))
            <h2 class="mb-4">{!! $section['title'] !!}</h2>
          @endif
          @if (!empty($section['description']))
            {!! $section['description'] !!}
          @endif
        </div>
      @endif

      {{-- Slider --}}
      <div
        class="relative mx-auto"
        x-data="{ swiper: null }"
        x-init="swiper = new Swiper($refs.container, {
          loop: {{ $enableLoop }},
          watchOverflow: false,             // <- allow looping even when slidesPerView == total
          autoHeight: false,
          speed: 500,
          pagination: { el: '.swiper-pagination', clickable: true },

          // allow anchor clicks even after drags
          preventClicks: false,
          preventClicksPropagation: false,

          slidesPerView: {{ $slidesMobile }},
          slidesPerGroup: 1,
          spaceBetween: 0,

          // optional: smoother loops with small counts
          loopAdditionalSlides: {{ $loopAdditional }},

          breakpoints: {
            640:  { slidesPerView: {{ $slidesMobile }},  slidesPerGroup: 1, spaceBetween: 0  },
            768:  { slidesPerView: {{ $slidesTablet }},  slidesPerGroup: 1, spaceBetween: 20 },
            1024: { slidesPerView: {{ $slidesDesktop }}, slidesPerGroup: 1, spaceBetween: 20 },
          },
        })"
      >
        @if (count($testimonials) > 1)
          {{-- Prev --}}
          <div class="absolute slider-prev">
            <button aria-label="previous" @click="swiper.slidePrev()"
              class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="#216cff" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
              </svg>
            </button>
          </div>
        @endif

        @if (count($testimonials) > 1)
          {{-- Next --}}
          <div class="absolute slider-next">
            <button aria-label="next" @click="swiper.slideNext()"
              class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="#216cff" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </button>
          </div>
        @endif

        <div class="swiper mt-12" x-ref="container">
          <div class="swiper-wrapper">
            @foreach ($testimonials as $index => $testimonial)
              @php
                // 1) Build a usable video URL (watch page preferred)
                $videoUrl = $testimonial['video_url'] ?? null;

                // If only oEmbed HTML exists in 'video', extract src
                if (!$videoUrl && !empty($testimonial['video'])) {
                  if (preg_match('/src="([^"]+)"/', $testimonial['video'], $m)) {
                    $videoUrl = $m[1];
                  }
                }

                // Normalize YouTube/Vimeo to canonical watch URLs
                $youtubeId = null;
                $vimeoId   = null;

                if (!empty($videoUrl)) {
                  $parts = parse_url($videoUrl);
                  $host  = $parts['host']  ?? '';
                  $path  = $parts['path']  ?? '';
                  $query = $parts['query'] ?? '';

                  // YouTube
                  if (strpos($host, 'youtu.be') !== false) {
                    $youtubeId = trim($path, '/');
                  } elseif (strpos($host, 'youtube.com') !== false) {
                    if (preg_match('#/embed/([^/?]+)#', $path, $m)) {
                      $youtubeId = $m[1];
                    } elseif (preg_match('#/shorts/([^/?]+)#', $path, $m)) {
                      $youtubeId = $m[1];
                    } else {
                      parse_str($query, $q);
                      if (!empty($q['v'])) $youtubeId = $q['v'];
                    }
                  }

                  // Vimeo
                  if (strpos($host, 'vimeo.com') !== false || strpos($host, 'player.vimeo.com') !== false) {
                    if (preg_match('#/video/(\d+)#', $path, $m)) {
                      $vimeoId = $m[1];
                    } elseif (preg_match('#/(\d+)#', $path, $m)) {
                      $vimeoId = $m[1];
                    }
                  }

                  // Canonicalize
                  if ($youtubeId) {
                    $videoUrl = 'https://www.youtube.com/watch?v=' . $youtubeId;
                  } elseif ($vimeoId) {
                    $videoUrl = 'https://vimeo.com/' . $vimeoId;
                  }
                }

                // 2) Choose thumbnail: cover → YouTube → person image → placeholder
                $thumbUrl = null;
                if (!empty($testimonial['cover']['sizes']['large'])) {
                  $thumbUrl = $testimonial['cover']['sizes']['large'];
                } elseif ($youtubeId) {
                  $thumbUrl = 'https://i.ytimg.com/vi/' . $youtubeId . '/hqdefault.jpg';
                } elseif (!empty($testimonial['image']['sizes']['large'])) {
                  $thumbUrl = $testimonial['image']['sizes']['large'];
                } else {
                  // Update to your theme placeholder if you have one
                  $thumbUrl = asset('images/video-placeholder.jpg');
                }

                $name = $testimonial['name'] ?? '';
              @endphp

              <div class="swiper-slide relative pr-0">
                {{-- Clickable tile opens in a new tab --}}
                <a
                  @if (!empty($videoUrl)) href="{{ $videoUrl }}" target="_blank" rel="noopener noreferrer" @else role="button" aria-disabled="true" @endif
                  class="group block relative mb-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-action rounded-2xl overflow-hidden"
                  @if (!empty($name)) aria-label="Open video: {{ $name }}" @endif
                >
                  {{-- Keep square cards (swap to `aspect-video` for 16:9) --}}
                  <div class="aspect-video-one-to-one bg-slate-200">
                    @if (!empty($thumbUrl))
                      <img src="{{ $thumbUrl }}" alt="" class="w-full h-full object-none" loading="lazy">
                    @endif
                  </div>

                  {{-- Blue gradient + name + play icon --}}
                  <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-action/100 via-action/60 to-transparent"></div>

                  <div class="absolute left-5 bottom-4 right-4 flex items-center gap-3 pr-4">
                    <img src="@asset('images/Icon-play.svg')" alt="" class="w-8 h-8 lg:w-10 lg:h-10 shrink-0 pointer-events-none">
                    @if (!empty($name))
                      <div class="text-white font-semibold text-base sm:text-lg leading-tight">
                        {{ $name }}
                      </div>
                    @endif
                  </div>

                  {{-- Subtle hover outline --}}
                  <span class="absolute inset-0 rounded-2xl ring-1 ring-black/0 group-hover:ring-black/5 transition"></span>
                </a>
              </div>
            @endforeach
          </div>

          <div class="swiper-pagination"></div>
        </div>
      </div> {{-- /slider --}}
    </div> {{-- /component-inner-section --}}
  </section>
@endif
