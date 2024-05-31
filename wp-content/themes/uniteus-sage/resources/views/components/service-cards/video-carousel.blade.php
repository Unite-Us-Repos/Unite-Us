<style>
.service-card {
  height: 320px;
}
</style>
@php
$s_settings = [
        'collapse_padding' => false,
        'fullscreen' => '',
];
$section_settings = isset($acf["components"][$index]['layout_settings']['section_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : $s_settings;
@endphp
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">
    <div class="text-{{ $section['alignment'] }} mb-6">
      @if ($section['subtitle'])
        <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
          {{ $section['subtitle'] }}
        </span>
      @endif
      <h2 class="mb-3">{!! $section['title'] !!}</h2>
      <div class="text-lg">
        {!! $section['description'] !!}
      </div>
    </div>
  </div>

  <div class="relative -mx-4">
  <div class="absolute bottom-0 -mb-[1px] w-full h-[88%] sm:h-3/4 lg:h-2/3" style="
  background:url(/wp-content/uploads/2022/12/dot-pattern.png) no-repeat center top; background-size: cover;"></div>

  <div class="component-inner-section">
    <div class="flex flex-col flex-wrap justify-center sm:flex-row pb-10 lg:pb-20">
        @foreach ($cards as $index => $card)
        @php
          $link = $card['link'];
          $external_link = $card['external_link'];

          if ($external_link) {
              $link = $external_link;
          }
        @endphp
        <div class="sm:basis-6/12 @if ($columns) lg:basis-{{ $columns }} @else lg:basis-2/6 @endif">
          <div class="p-3">
            <div class="relative flex items-end rounded-lg overflow-hidden group service-card">
              <div class="absolute bottom-0 w-full h-3/6 bg-blue-900"></div>

              <div class="card-overlay absolute inset-0 bg-brand opacity-75 group-hover:opacity-0 z-10"></div>
              @if ($card['bg_image'])
                <div style="z-index: 1;" class="absolute inset-0">
                  <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
                    <img class="lazy w-full h-full object-cover" data-src="{{ $card['bg_image']['sizes']['large'] }}" alt="{{ $card['bg_image']['alt'] }}" />
                  </a>
                </div>
              @endif
              <div class="relative pointer-events-none z-10 w-full p-7 pb-0">
                <div class="absolute pointer-events-none inset-0 z-10 border-b-[15px] border-morado transition ease-in-out delay-250 group-hover:opacity-0 group-hover:z-0"></div>
                <div class="absolute pointer-events-none inset-0 bg-gradient-clips group-hover:opacity-100"></div>
                @if ($link)
                <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif>
                @endif
                <div class="relative  text-white">

                    @isset ($card["icon"])
                      @if (!empty($card["icon"]))
                        <span class="mb-6 block">
                          <img class="lazy h-8 w-8" data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                        </span>
                      @endif
                    @endisset
                    @if ($card['title'])
                    <h3 class="mb-2 text-2xl font-bold leading-7 tracking-tight">{!! $card['title'] !!}</h3>
                    @endif
                    @if ($card['description'])
                      <div class="text-sm mb-7">
                        {!! $card['description'] !!}
                      </div>
                    @endif
                    </div>
                @if ($link)
                </a>
                @endif
                </div>
                  </div>
</div>
</div>
        @endforeach
  </div>
  </div>
  <div class="section-divider relative h-5 sm:h-10 md:h-14 xl:h-20" style="margin: 0 -7rem;bottom: -4px;">
  <svg width="1358" height="80" class="w-full" preserveAspectRatio="none" viewBox="0 0 1358 80" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 9.85705L56.5833 15.7023C113.167 21.5475 226.333 33.238 339.5 27.3928C452.667 21.5475 565.833 -1.83344 679 0.114975C792.167 2.06339 905.333 29.3412 1018.5 35.1865C1131.67 41.0317 1244.83 25.4444 1301.42 17.6507L1358 9.85705V80H1301.42C1244.83 80 1131.67 80 1018.5 80C905.333 80 792.167 80 679 80C565.833 80 452.667 80 339.5 80C226.333 80 113.167 80 56.5833 80H0V9.85705Z" fill="#EEF5FC"/>
  </svg>
</div>
</section>


