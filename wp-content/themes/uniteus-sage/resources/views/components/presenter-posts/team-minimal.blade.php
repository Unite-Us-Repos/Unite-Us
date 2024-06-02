@php
if ('manual' == $selection) {
  $team = App\View\Composers\Post::getTeam('', $posts, 'presenter');
} else {
  $team = App\View\Composers\Post::getTeam(array('slug' => 'presenter_category', 'ids' => $category), '', 'presenter');
}
$show_social = true;
$clickable = false;
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

    <ul role="list" class="list-none mb-0 mx-auto grid gap-9 sm:grid-cols-2 md:grid-cols-4 lg:gap-10">
      @foreach ($team as $member)
        @php
          $fit = 'object-cover';
          if (!$member['thumbnail_url']) {
            $member['thumbnail_url'] = get_template_directory_uri() . '/resources/icons/acf/person.svg';
            $fit = 'object-contain';
          }
          @endphp
        <li class="mb-0">

          @if ($clickable)
          <a href="{{ $member['permalink'] }}" class="no-underline">
          @endif
            <div>
              <div class="flex mt-6 gap-3 items-start max-w-xs">
                <img src="/wp-content/themes/uniteus-sage/resources/images/user-circle.svg" alt="">
                <div class="mb-0">
                  <h3 class="font-medium text-brand text-lg leading-[1.5] mb-1.5">{{ $member['full_name'] }}</h3>
                  <p class="text-action font-medium leading-[1.5] text-lg">{{ $member['position'] }}</p>
                </div>
              </div>
            </div>
          @if ($clickable)
          </a>
          @endif

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
    </ul>
  </div>
</section>
