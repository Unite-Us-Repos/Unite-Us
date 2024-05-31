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
  if (isset($tab['sessions'])) {
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
}
@endphp
@if ($team)
<section class="component-section collapse-padding-t hidden">
  <div class="component-inner-section">
    <div class="flex flex-col">
      @isset ($section['title'])
      <h2 class="text-center">
        {{ $section['title'] }}
      </h2>
      @endisset
    </div>
    <ul role="list" class="list-none mb-0 mx-auto grid grid-cols-2 gap-x-6 gap-y-9 sm:grid-cols-3 md:grid-cols-4 lg:gap-x-20 lg:gap-y-10 xl:grid-cols-5">
      @foreach ($team as $member)

        @php
        
          $fit = 'object-cover';
          if (!$member['image']) {
            $member['thumbnail_url'] = get_template_directory_uri() . '/resources/icons/acf/person.svg';
            $fit = 'object-contain';
          } else {
            $member['thumbnail_url'] = $member['image']['sizes']['medium_large'];
          }

          $link = false;

          $full_name = $member['name'];
          $member['position'] = $member['title'];
          $member['thumbnail_alt'] = '';

          if (!$full_name) {
            continue;
          }

          @endphp
        <li class="mb-0">
          @if ($link)
          <a href="{{ $member['permalink'] }}" class="no-underline">
            @endif
            <div>
              @if ($member['thumbnail_url'])
              <img class="lazy mx-auto h-36 w-36 rounded-full object-cover lg:w-44 lg:h-44" data-src="{{ $member['thumbnail_url'] }}" alt="{{ $member['thumbnail_alt'] }}">
              @endif
              <div class="text-center mt-6">
                <div class="mb-0">
                  <h3 class="font-bold text-brand text-lg sm:text-xl mb-0">{!! $full_name !!}</h3>
                  <div class="text-action text-sm sm:text-base">{!! $member['position'] !!}</div>
                </div>
              </div>
            </div>
          @if ($link)
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
      <!-- More people... -->
    </ul>
  </div>
</section>
@endif

