@php
  $term = get_term_by('slug', 'leadership', 'team_category');
  if ($term) {
    $team = App\View\Composers\Post::getTeam(array('slug' => 'team_category', 'ids' => array($term->term_id) ));
  } else {
    $team = false;
  }
  $fit = 'object-cover';
  if (!$member['thumbnail_url']) {
    $member['thumbnail_url'] = get_template_directory_uri() . '/resources/icons/acf/person.svg';
    $fit = 'object-contain';
  }
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

@php
  // Fetch necessary fields
  $publishDate = get_the_date('c');
  $modifiedDate = get_the_modified_date('c');
  $firstName = get_field('first_name');
  $middleName = get_field('middle_name');
  $lastName = get_field('last_name');
  $description = get_field('bio');
  $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
  $pageURL = get_permalink();
  $socialMediaLinks = get_field('social_media_link');

  // Prepare social media URLs
  $socialMediaUrls = [];
  if ($socialMediaLinks) {
      foreach ($socialMediaLinks as $link) {
          if (isset($link['url'])) {
              $socialMediaUrls[] = '"' . $link['url'] . '"';
          }
      }
  }
  $socialMediaUrlsString = implode(', ', $socialMediaUrls);

  // Get schema markup from ACF
  $schemaMarkup = get_field('schema_markup');

  // Replace placeholders in the schema markup
  $schemaMarkup = str_replace([
    '{{Publish Date}}', 
    '{{Date Modified}}', 
    '{{First Name}}', 
    '{{Middle Name}}', 
    '{{Last Name}}', 
    '{{Description}}', 
    '{{Image}}', 
    '{{Page URL}}', 
    '{{Social Media URLs}}'
  ], [
    $publishDate, 
    $modifiedDate, 
    $firstName, 
    $middleName, 
    $lastName, 
    strip_tags($description), 
    $image, 
    $pageURL, 
    $socialMediaUrlsString
  ], $schemaMarkup);
@endphp

<!-- Insert the schema markup -->
{!! $schemaMarkup !!}

<section class="bg-white relative component-section">
  <div class="relative w-full">
    <div class="component-inner-section">
      <div class="lg:grid lg:grid-cols-2 lg:gap-16">
        <div class="">

          <div class="mb-8 sm:mb-10">
            @php
            $data = [
              'color' => 'brand'
            ];
            @endphp
            @include('ui.breadcrumbs.simple-with-slashes', $data)
          </div>

          <div class="max-w-xs mb-8 mx-auto sm:mb-10 sm:max-w-lg lg:hidden">
            @if ($member['thumbnail_url'])
              <img class="bg-brand max-w-lg mx-auto w-full h-auto rounded-full aspect-square {{ $fit }}" src="{{ $member['thumbnail_url'] }}" alt="{{ $member['thumbnail_alt'] }}">
            @endif
          </div>

          <h1 class="mb-1">
            {!! $member['first_name'] !!} {!! $member['middle_name'] !!} {!! $member['last_name'] !!}
          </h1>
          @if ($position)
            <h2 class="position">
              {{ $position }}
            </h2>
          @endif

          <div class="text-lg">
            @if ($member['bio'])
              {!! $member['bio'] !!}
            @endif
          </div>

          @if ($social_media_link)
            <div class="mt-10">
              @foreach ($social_media_link as $link)
                @php
                  if ($link['links_to_bio']) {
                    continue;
                  }
                    $pos = strpos(strtolower($link['icon']), 'linkedin');
                    if ($pos === false) {
                      $link['alt_text'] = 'view ' . $link['icon'] . ' profile';
                    } else {
                      $link['alt_text'] = 'view LinkedIn profile';
                    }

                @endphp
                <a href="{{ $link['url'] }}" target="_blank" aria-label="{{ $link['alt_text'] }}" class="button button-solid inline-block">
                  <img class="lazy acf-icon-white" data-src="/wp-content/themes/uniteus-sage/resources/icons/social/{{ $link['icon'] }}.svg" alt="{{ $link['alt_text'] }}" />
                </a>
              @endforeach
            </div>
          @endif

        </div>

        <div class="relative hidden lg:block lg:px-10 lg:row-start-1 lg:col-start-2">
          @if ($member['thumbnail_url'])
            <img class="bg-brand max-w-lg mx-auto w-full h-auto rounded-full aspect-square {{ $fit }}" src="{{ $member['thumbnail_url'] }}" alt="{{ $member['thumbnail_alt'] }}">
          @endif
      </div>
  </div>
</section>

@if ($team)
@php
  $enableLoop = 'true';
@endphp
<section class="bg-white relative px-6">
  <div class="bg-blue-900 absolute bottom-0 right-0 left-0 h-1/2" style="margin-bottom: -1px"></div>
  <div class="bg-light relative max-w-7xl mx-auto rounded-3xl pl-10 py-10 pl-0" x-data="{swiper: null}" x-init="swiper = new Swiper($refs.container, {
        loop: {{ $enableLoop }},
        pagination: false,
        preventClicks: false,
        slidesPerView: 1.5,
        slidesPerGroup: 1,
        spaceBetween: 0,
        breakpoints: {
          640: {
            slidesPerView: 2.5,
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
    <h2 class="text-center ml-10 mr-10 sm:text-left">More of Our Leadership</h2>
    @if (count($team) > 1)
    <div class="absolute left-12 sm:left-auto sm:right-28 top-24 sm:top-9 @if (count($team) == 4 OR count($team) == 5) lg:hidden @endif">
      <button aria-label="previous" @click="swiper.slidePrev()"
        class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
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
        <div class="swiper-slide relative px-5">
          @php
          $fit = 'object-cover';
          if (!$member['thumbnail_url']) {
            $member['thumbnail_url'] = get_template_directory_uri() . '/resources/icons/acf/person.svg';
            $fit = 'object-contain';
          }
          @endphp

          <a href="{{ $member['permalink'] }}" class="no-underline w-full">
            <div class="space-y-4 @if (count($team) == 4 OR count($team) == 5) xl:px-8 @endif">
              @if ($member['thumbnail_url'])
                <img class="bg-brand mx-auto w-full h-auto rounded-full @if (count($team) == 4) lg:max-w-[192px] @endif aspect-square {{ $fit }}" src="{{ $member['thumbnail_url'] }}" alt="{{ $member['thumbnail_alt'] }}">
                @else
              @endif
              <div class="text-center max-w-[192px] mx-auto">
                <div class="mb-0">
                  <h3 class="font-bold text-brand text-lg sm:text-xl mb-0">{{ $member['full_name'] }}</h3>
                  <p class="text-action text-sm sm:text-base">{{ $member['position'] }}</p>
                </div>
              </div>
            </div>
          </a>

        </div>
        @endforeach
      </div>
    </div>

    @if (count($team) > 1)
    <div class="absolute right-12 top-24 sm:top-9 z-10 @if (count($team) == 4 OR count($team) == 5) lg:hidden @endif">
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
  </div>
</section>
@endif
