@php
if ('manual' == $selection) {
  $team = App\View\Composers\Post::getTeam('', $posts, 'presenter');
} else {
  $team = App\View\Composers\Post::getTeam(array('slug' => 'presenter_category', 'ids' => $category), '', 'presenter');
}
$show_social = true;
@endphp

@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section {{ $section_classes }}">
  <div class="component-inner-section">
    <div class="flex flex-col text-{{ $section['alignment'] }}">
      @isset ($section['title'])
      <h2 class="">
        {{ $section['title'] }}
      </h2>
      @endisset
    </div>

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
            <div>
              @if ($member['thumbnail_url'])
              <img class="lazy mx-auto h-36 w-36 rounded-full object-cover lg:w-44 lg:h-44" data-src="{{ $member['thumbnail_url'] }}" alt="{{ $member['thumbnail_alt'] }}">
              @endif
              <div class="text-center mt-6">
                <div class="mb-0">
                  <h3 class="font-bold text-brand text-lg sm:text-xl mb-0">{{ $member['full_name'] }}</h3>
                  <p class="text-action text-sm sm:text-base">{{ $member['position'] }}</p>
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

        </li>
      @endforeach
      <!-- More people... -->
    </ul>
  </div>
</section>
