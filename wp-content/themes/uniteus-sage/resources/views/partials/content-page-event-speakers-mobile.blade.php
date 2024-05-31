@php
$modules = $acf['components'];
$components = [];
foreach ($modules as $index => $module) {
  $components[$module['acf_fc_layout']] = $module;
}
@endphp
@php
$selection = 'static';
$show_social = true;
$section['title'] = 'Speakers';
@endphp
@php
$team = [];
if (!isset($tabs)) {
  $agendas = $components['agenda']['agenda']['agenda'];


  if (is_array($agendas)) {
  foreach ($agendas as $index=> $item) {
    $tabs[] = [
      'title' => date('l', strtotime($item['date'])),
      'summary' => $item['summary'],
      'sessions' => $item['sessions'],
      ];
  }
}

}
foreach ($tabs as $tab_index => $tab) {
  foreach ($tab['sessions'] as $s_index => $session) {
    if ($session['presenters']) {
      foreach ($session['presenters'] as $group) {
        if ($group['members']) {
          foreach ($group['members'] as $m) {
            $team[] = $m;
          }
        }
      }
    }
  }

}
@endphp




@if ($team)
@php
  $enableLoop = 'false';
  $slides_per_view = 5.5;
  $slides_per_view_840 = 3;
  $slides_per_view_1024 = 4;
  if (count($team) > 4) {
    $slides_per_view_840 = 3.5;
    $slides_per_view_1024 = 4.5;
  }
  if (count($team) == 4) {
    $slides_per_view = 4;
  }
  if (count($team) == 5) {
    $slides_per_view = 5;
  }
@endphp
<section class="bg-white relative md:hidden">
  <div class="relative max-w-7xl mx-auto rounded-3xl pl-10 py-10 pl-0" x-data="{swiper: null}" x-init="swiper = new Swiper($refs.container, {
        loop: {{ $enableLoop }},
        pagination: false,
        preventClicks: false,
        slidesPerView: 2.5,
        slidesPerGroup: 1,
        spaceBetween: 0,
        breakpoints: {
          640: {
            slidesPerView: 3.5,
          },
          840: {
            slidesPerView: {{ $slides_per_view_840 }},
          },
          1024: {
            slidesPerView: {{ $slides_per_view_1024 }},
          },
          1280: {
            slidesPerView: {{ $slides_per_view }},
            slidesPerGroup: 5,
          },
        },
      });swiper.on('slideChange', function () {
        var current = swiper.activeIndex;
        if ({{ count($posts) }} === current) {
          swiper.allowSlideNext = false;
        } else {
          swiper.allowSlideNext = true;
        }
      });swiper.on('resize', function () {
        swiper.slideTo(0)
      });">
    <h2 class="mx-8">Meet the Speakers</h2>
    @if (count($team) > 1)
    <div class="absolute left-7 sm:left-auto sm:right-28 sm:top-9 @if (count($team) == 4 OR count($team) == 5) lg:hidden @endif">
      <button aria-label="previous" @click="swiper.slidePrev()"
        class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
          stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
        </svg>
      </button>
    </div>
    <div class="absolute right-7 sm:top-9 z-10 @if (count($team) == 4 OR count($team) == 5) lg:hidden @endif">
      <button aria-label="next" @click="swiper.slideNext()"
        class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
          stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </button>
    </div>
    @endif
    <div class="swiper mt-28 sm:mt-0" x-ref="container">
      <div class="swiper-wrapper flex">
        @foreach ($team as $index => $member)
        <div class="swiper-slide relative px-3 sm:px-5">
        @php
          $fit = 'object-cover';
          if (!$member['image']) {
            $member['thumbnail_url'] = get_template_directory_uri() . '/resources/icons/acf/person.svg';
            $fit = 'object-contain';
          }

          $link = false;

          $full_name = $member['name'];
          $member['position'] = $member['title'];
          $member['thumbnail_url'] = $member['image']['sizes']['medium_large'];
          $member['thumbnail_alt'] = '';

          if (!$full_name) {
            continue;
          }

          @endphp

            <div class="space-y-4 @if (count($team) == 4 OR count($team) == 5) xl:px-8 @endif">
              @if ($member['thumbnail_url'])
                <img class="bg-brand mx-auto w-full h-auto rounded-full @if (count($team) == 4) lg:max-w-[192px] @endif aspect-square {{ $fit }}" src="{{ $member['thumbnail_url'] }}" alt="{{ $member['thumbnail_alt'] }}">
                @else
              @endif
              <div class="text-center max-w-[192px] mx-auto">
                <div class="mb-0">
                  <h3 class="font-bold text-brand text-lg sm:text-xl mb-0">{{ $full_name }}</h3>
                  <div class="text-action text-sm sm:text-base">{!! $member['position'] !!}</div>
                </div>
              </div>
            </div>

            @if ($member['social_media_link'] && $show_social)
              <div class="social-media-links mt-6 flex items-center justify-center">
                @foreach ($member['social_media_link'] as $link)

                  <a href="{{ $link['url'] }}" target="_blank" class="inline-block">
                    @isset ($link["icon"])
                      @if (!empty($link["icon"]))
                        <span class="inline-flex items-center justify-center rounded-md text-gray-400 mx-2 shadow-lg">
                          <img class="lazy h-4 w-4" data-src="/wp-content/themes/uniteus-sage/resources/icons/social/{{ $link['icon'] }}.svg" alt="" />
                        </span>
                      @endif
                    @endisset
                  </a>
                @endforeach
              </div>
            @endif

        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif

