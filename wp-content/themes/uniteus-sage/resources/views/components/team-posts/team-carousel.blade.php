
<style>
.team-carousel.component-section,
.team-carousel .component-inner-section.no-padding {
  padding-left: 0 !important;
  padding-right: 0 !important;
}
</style>
@php
$show_link = true;
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
if ('manual' == $selection) {
  $team = App\View\Composers\Post::getTeam('', $posts);
} elseif ('by_state_manual' == $selection) {
  $team = App\View\Composers\Post::getTeam('', $posts, 'network_team');
  $show_link = false;
} elseif ('by_state' == $selection) {
  if (!$state_team) {
    $cat = get_term_by('slug', $postSlug, 'states');
    if ($cat) {
      $catID = $cat->term_id;
      $state_team = [$catID];
    }
  }
  $show_link = false;
  $team = App\View\Composers\Post::getTeam(array('slug' => 'states', 'ids' => $state_team), '', 'network_team');
} else {
  $team = App\View\Composers\Post::getTeam(array('slug' => 'team_category', 'ids' => $category));
}
$swiper_ref = 'team-' . $index;
$bg_color = isset($acf['components'][$index]['posts']['background']['color']) ? $acf['components'][$index]['posts']['background']['color'] : '';
$show_social = true;
$slides_per_view = count($team);
@endphp

@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

@if ($team)
<section class="team-carousel component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section no-padding relative" x-data="{swiper: null}" x-init="swiper = new Swiper($refs.container, {
        @if ($slides_per_view > 2)
          loop: true,
        @else
          loop: false,
        @endif
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        on: {
          afterInit: function() {
            var arrows =  document.querySelectorAll('.swiper-arrow-{{ $swiper_ref }}');

            if (this.isLocked) {
              arrows.forEach(function (el) {
                el.classList.add('hidden');
              });
            } else {
              arrows.forEach(function (el) {
                el.classList.remove('hidden');
              });
            }
          }
        },
        preventClicks: false,
        slidesPerView: 1.5,
        slidesPerGroup: 1,
        spaceBetween: 0,
        loopFillGroupWithBlank: false,
        breakpoints: {
          400: {
            slidesPerView: 2.55,
            @if ($slides_per_view > 2)
              loop: true,
            @else
              loop: false,
            @endif
          },
          640: {
            slidesPerView: 3,
            @if ($slides_per_view > 3)
              loop: true,
            @else
              loop: false,
            @endif
          },
          1024: {
            slidesPerView: 4,
            @if ($slides_per_view > 4)
              loop: true,
            @else
              loop: false,
            @endif
          },
          1280: {
            slidesPerView: '5',
            @if ($slides_per_view > 5)
              loop: true,
            @else
              loop: false,
            @endif
          },
        },
      });swiper.on('resize', function () {
        var arrows =  document.querySelectorAll('.swiper-arrow-{{ $swiper_ref }}');

        if (swiper.isLocked) {
          arrows.forEach(function (el) {
            el.classList.add('hidden');
          });
        } else {
          arrows.forEach(function (el) {
            el.classList.remove('hidden');
          });
        }
        });">
    <div class="component-inner-section">
      <div class="flex flex-col text-{{ $section['alignment'] }}">
        @isset ($section['title'])
        <h2>
          {{ $section['title'] }}
        </h2>
        @endisset
      </div>
    </div>
    @if (count($team) > 1)
    <div class="swiper-arrow-{{ $swiper_ref }} absolute left-12 sm:left-auto sm:right-28 top-24 sm:top-0">
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
    <div class="swiper mt-28 sm:mt-0" x-ref="container">
      <div class="swiper-wrapper flex">
        @foreach ($team as $index => $member)
        <div class="swiper-slide pb-8 relative @if (count($team) >= 4) lg:text-center  @endif">
          @php
          $fit = 'object-cover';
          if (!$member['thumbnail_url']) {
            $member['thumbnail_url'] = get_template_directory_uri() . '/resources/icons/acf/person.svg';
            $fit = 'object-contain';
          }
          @endphp

            <div class="space-y-4 px-4">
              @if ($member['thumbnail_url'])
                @if ($show_link)
                  <a href="{{ $member['permalink'] }}" class="no-underline w-full">
                @endif
                  <img class="mx-auto max-w-[192px] w-full h-auto rounded-full @if (count($team) == 4) lg:max-w-[192px] @endif aspect-square {{ $fit }}" src="{{ $member['thumbnail_url'] }}" alt="{{ $member['thumbnail_alt'] }}">
                @if ($show_link)
                  </a>
                @endif
                @else
              @endif
              <div class="text-center max-w-[192px] mx-auto">
                <div class="mb-0">
                  @if ($show_link)
                    <a href="{{ $member['permalink'] }}" class="no-underline w-full">
                  @endif
                  <h3 class="font-bold text-brand text-lg sm:text-xl mb-0">{{ $member['full_name'] }}</h3>
                  <p class="text-action text-sm sm:text-base">{{ $member['position'] }}</p>
                  @if ($show_link)
                    </a>
                  @endif
                </div>
                @if ($member['social_media_link'] && $show_social)
                <div class="social-media-links mt-6 flex items-center justify-center">
                    @foreach ($member['social_media_link'] as $link)
                      <a href="{{ $link['url'] }}" target="_blank" class="inline-block">
                        @isset ($link["icon"])
                          @if (!empty($link["icon"]))
                            <span class="inline-flex items-center justify-center text-gray-400 mx-2 shadow-lg">
                              <img class="lazy h-4 w-4" data-src="/wp-content/themes/uniteus-sage/resources/icons/social/{{ $link['icon'] }}.svg" alt="" />
                            </span>
                          @endif
                        @endisset
                      </a>
                    @endforeach
                  </div>
                @endif

              </div>
            </div>
        </div>
        @endforeach
      </div>
      <div class="swiper-pagination"></div>

    </div>

    @if (count($team) > 1)
    <div class="swiper-arrow-{{ $swiper_ref }} absolute right-12 top-24 sm:top-0 z-10">
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
</section>
@endif
