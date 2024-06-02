@php
$s_settings = [
        'collapse_padding' => false,
        'fullscreen' => '',
];
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">
    <div class="text-center mb-7">
      @if ($section['subtitle'])
        @if ($section['subtitle_display_as_pill'])
          <span class="@if ($background['color'] == 'dark') bg-brand text-action-light-blue @else text-action @if ($background['color'] == 'light-gradient') bg-white @else bg-light mix-blend-multiply @endif @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
        @else
          <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
        @endif
          {{ $section['subtitle'] }}
          </span>
      @endif
      <h2 class="mb-6">{!! $section['title'] !!}</h2>
      <div class="text-lg">
        <div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div>
      </div>
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-center',
              'mt' => 'mt-6',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
    </div>
  <div class="relative -mx-4">
  @if ($background['overlay'])
    <div class="absolute bottom-0 -mb-[1px] w-full h-[88%] border border-blue-900 sm:h-3/4 lg:h-3/6 bg-blue-900"></div>
  @endif
  <div class="component-inner-section">
    <div class="flex flex-col flex-wrap justify-center sm:flex-row">
        @foreach ($cards as $index => $card)
        <div class="sm:basis-6/12 @if ($columns) lg:basis-{{ $columns }} @else lg:basis-2/6 @endif">
        @if ($card["link"])
        <a class="no-underline" href="{{ $card['link'] }}" alt="{{ strip_tags($card['title']) }}">
        @endif

          <div
            x-data="{ expanded: (window.innerWidth <= 768) }"
            x-on:resize.window="expanded = (window.innerWidth >= 768) ? false : true"
            class="p-3">
            <div @mouseover="expanded = ! expanded" @mouseout="expanded = (window.innerWidth >= 768) ? false : true" class="relative flex items-end rounded-lg overflow-hidden group service-card">
              <div class="absolute bottom-0 w-full h-3/6 bg-blue-900"></div>

              <div class="card-overlay absolute inset-0 bg-brand opacity-75 group-hover:opacity-0 z-10"></div>
              @if ($card['bg_image'])
                <div style="z-index: 1;" class="absolute inset-0">
                    <img class="lazy w-full h-full object-cover" data-src="{{ $card['bg_image']['sizes']['large'] }}" alt="{{ $card['bg_image']['alt'] }}" />
                </div>
              @endif
              <div class="relative pointer-events-none z-10 w-full p-7 pb-0">
                <div class="absolute pointer-events-none inset-0 z-10 border-b-[15px] border-action transition ease-in-out delay-250 hidden md:block group-hover:opacity-0 group-hover:z-0"></div>
                <div class="absolute pointer-events-none inset-0 bg-gradient-service md:opacity-0 group-hover:opacity-100"></div>
                @if ($card['link'])
                <a class="no-underline" href="{{ $card['link'] }}">
                @endif
                <div class="relative text-white pb-6">

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
                        <div x-show="expanded" x-collapse.duration.400ms class="text-sm w-full">
                            {!! $card['description'] !!}
                        </div>
                      @endif
                    </div>
                @if ($card['link'])
                </a>
                @endif
                </div>
                  </div>
</div>
@if ($card["link"])
</a>
@endif

</div>
        @endforeach
  </div>
</section>
@if ($background['divider_bottom'])
<div class="section-divider -mx-1 relative h-5 sm:h-10 md:h-14 xl:h-20 -mt-2 -sm:mb-3 md:-mt-7 md:-mt-7 xl:-mt-10">
  <svg class="w-full h-auto" width="1358" height="80" preserveAspectRatio="none" viewBox="0 0 1358 80" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 71.0853L57.125 65.2401C113.75 59.3948 227 47.7043 340.25 53.5496C453.5 59.3948 566.75 82.7758 680 80.8274C793.25 78.879 906.5 51.6012 1019.75 45.7559C1133 39.9107 1246.25 55.498 1302.87 63.2917L1359.5 71.0853V0.942383H1302.87C1246.25 0.942383 1133 0.942383 1019.75 0.942383C906.5 0.942383 793.25 0.942383 680 0.942383C566.75 0.942383 453.5 0.942383 340.25 0.942383C227 0.942383 113.75 0.942383 57.125 0.942383H0.5V71.0853Z" fill="#172A44"></path>
  </svg>
</div>
@endif
