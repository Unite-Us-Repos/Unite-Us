@php
$cat_slug = isset($acf['components'][$index]['posts']['category']->slug) ? $acf['components'][$index]['posts']['category']->slug : '';
$category = isset($acf['components'][$index]['posts']['category']->term_id) ? $acf['components'][$index]['posts']['category']->term_id : '';
$team = App\View\Composers\Post::getTeam($category, 3);
$bg_color = isset($acf['components'][$index]['posts']['background']['color']) ? $acf['components'][$index]['posts']['background']['color'] : '';
$show_social = true;
if ('unite-us' == $cat_slug) {
  $show_social = false;
}
@endphp

@if ('light-gradient' === $bg_color)
<div class="section-divider">
  <svg style="width:100%" width="1358" height="80" preserveAspectRatio="none" viewBox="0 0 1358 80" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 9.85705L56.625 15.7023C113.25 21.5475 226.5 33.238 339.75 27.3928C453 21.5475 566.25 -1.83344 679.5 0.114975C792.75 2.06339 906 29.3412 1019.25 35.1865C1132.5 41.0317 1245.75 25.4444 1302.37 17.6507L1359 9.85705V80H1302.37C1245.75 80 1132.5 80 1019.25 80C906 80 792.75 80 679.5 80C566.25 80 453 80 339.75 80C226.5 80 113.25 80 56.625 80H0V9.85705Z" fill="url(#paint0_linear_9150_27671)"/>
  <defs>
  <linearGradient id="paint0_linear_9150_27671" x1="679.5" y1="0" x2="679.5" y2="80" gradientUnits="userSpaceOnUse">
  <stop stop-color="#EEF5FC"/>
  <stop offset="1" stop-color="#EEF5FC"/>
  </linearGradient>
  </defs>
  </svg>
</div>
@endif
<section class="component-section {{ $section_classes }}">
  <div class="component-inner-section">
    @isset ($section['title'])
    <h2 class="">
      {{ $section['title'] }}
    </h2>
    @endisset

    <ul role="list" class="list-none mb-0 mx-auto grid grid-cols-2 gap-x-6 gap-y-9 sm:grid-cols-3 md:grid-cols-4 lg:gap-x-20 lg:gap-y-10 xl:grid-cols-5">
      @foreach ($team as $member)
        @php
          $fit = 'object-cover';
          if (!$member['thumbnail_url']) {
            $member['thumbnail_url'] = get_template_directory_uri() . '/resources/icons/acf/person.svg';
            $fit = 'object-contain';
          }
          @endphp
        <li class="mb-0">
          @if ('unite-us' == $cat_slug)
          <a href="{{ $member['permalink'] }}" class="no-underline">
            @endif
            <div>
              @if ($member['thumbnail_url'])
              <img class="mx-auto h-36 w-36 rounded-full lg:w-44 lg:h-44" src="{{ $member['thumbnail_url'] }}" alt="">
              @endif
              <div class="text-center mt-6">
                <div class="mb-0">
                  <h3 class="font-bold text-brand text-lg sm:text-xl mb-0">{{ $member['full_name'] }}</h3>
                  <p class="text-action text-sm sm:text-base">{{ $member['position'] }}</p>
                </div>
              </div>
            </div>
            @if ('unite-us' == $cat_slug)
          </a>
          @endif

          @if ($member['social_media_link'] && $show_social)
          <div class="social-media-links mt-6 flex items-center justify-center">
              @foreach ($member['social_media_link'] as $link)

                <a href="{{ $link['url'] }}" target="_blank" class="inline-block">
                  @isset ($link["icon"])
                    @if (!empty($link["icon"]))
                      <span class="inline-flex items-center justify-center rounded-md text-gray-400 mx-2 shadow-lg">
                        <img class="h-4 w-4" src="/wp-content/themes/uniteus-sage/resources/icons/social/{{ $link['icon'] }}.svg" />
                      </span>
                    @endif
                  @endisset
                </a>
              @endforeach
            </div>
          @endif

        </li>
      @endforeach
      <!-- More people... -->
    </ul>
  </div>
</section>
