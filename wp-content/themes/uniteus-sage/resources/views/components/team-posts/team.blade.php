@php
if ('manual' == $selection) {
  $team = App\View\Composers\Post::getTeam('', $posts);
} elseif ('static' == $selection) {
  $team = isset($static_members) ? $static_members : '';
} elseif ('by_state_manual' == $selection) {
  $team = App\View\Composers\Post::getTeam('', $posts, 'network_team');
} else {
  $team = App\View\Composers\Post::getTeam(array('slug' => 'team_category', 'ids' => $category));
}
$bg_color = isset($acf['components'][$index]['posts']['background']['color']) ? $acf['components'][$index]['posts']['background']['color'] : '';
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
    <ul role="list" class="list-none mb-0 flex flex-wrap justify-center">
      @foreach ($team as $member)
        @php
          $fit = 'object-cover';
          if (!$member['thumbnail_url']) {
            $member['thumbnail_url'] = get_template_directory_uri() . '/resources/icons/acf/person.svg';
            $fit = 'object-contain';
          }

          $link = true;

          $full_name = isset($member['full_name']) ? $member['full_name'] : '';

          if ('static' == $selection) {
            $full_name = $member['first_name'] . ' ' . $member['middle_name'] . ' ' . $member['last_name'];
            $full_name = preg_replace('/\s+/', ' ', $full_name);
            $link = false;
            $member['thumbnail_alt'] = '';
          }
          @endphp
        <li class="mb-0 basis-1/2 md:basis-1/3 lg:basis-1/4">
          <div class="p-5">
          @if ($link)
          <a href="{{ $member['permalink'] }}" class="no-underline">
            @endif
            <div>
              @if ($member['thumbnail_url'])
              <img class="lazy mx-auto h-36 w-36 rounded-full object-cover lg:w-44 lg:h-44" data-src="{{ $member['thumbnail_url'] }}" alt="{{ $member['thumbnail_alt'] }}">
              @endif
              <div class="text-center mt-6">
                <div class="mb-0">
                  <h3 class="font-bold text-brand text-lg sm:text-xl mb-0">{{ $full_name }}</h3>
                  <p class="text-action text-sm sm:text-base">{{ $member['position'] }}</p>
                </div>
              </div>
            </div>
          @if ($link)
          </a>
          @endif

          @if ($member['social_media_link'] && $show_social)
          <div class="social-media-links mt-6 flex items-center justify-center">
              @foreach ($member['social_media_link'] as $link)
                @php
                  if ($link['links_to_bio']) {
                    $link['url'] = $member['permalink'];
                  }

                @endphp

                <a href="{{ $link['url'] }}" @if (!$link['links_to_bio']) target="_blank" @endif class="inline-block">
                  @isset ($link["icon"])
                    @if (!empty($link["icon"]))
                      <span class="inline-flex items-center justify-center rounded-ful mx-2">
                        <img class="lazy h-5 w-5" data-src="/wp-content/themes/uniteus-sage/resources/icons/social/{{ $link['icon'] }}.svg" alt="" />
                      </span>
                    @endif
                  @endisset
                </a>
              @endforeach
            </div>
          @endif
          </div>
        </li>
      @endforeach
      <!-- More people... -->
    </ul>
  </div>
</section>
