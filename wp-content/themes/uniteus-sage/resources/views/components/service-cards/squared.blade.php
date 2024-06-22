<style>
  .service-card-squared {
    min-height: 360px;
  }
  </style>
  @php
  $s_settings = [
          'collapse_padding' => false,
          'fullscreen' => '',
  ];
  $section_settings = isset($acf["components"][$index]['layout_settings']['section_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : $s_settings;
  @endphp
  @if ($background['has_divider'])
    @includeIf('dividers.waves')
  @endif
  <section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="relative component-section @if ($background['color'] == 'dark') text-white @endif {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  @if ($background['image'])
      <div class="absolute inset-0">
        <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
          srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
          sizes="(max-width: 600px) 300px, 1024px"
          alt="{{ $background['image']['alt'] }}">
      </div>
    @endif
    @if ('center' == $section["alignment"])
    <div class="component-inner-section relative z-10">
      <div class="text-center mb-6">
        @if ($section['subtitle'])
          @if ($section['subtitle_display_as_pill'])
            <span class="@if ($background['color'] == 'dark') bg-white bg-opacity-10 text-action-light-blue @else text-action bg-light  mix-blend-multiply @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
          @else
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
          @endif
            {{ $section['subtitle'] }}
          </span>
        @endif
        <h2 class="mb-6 ">{!! $section['title'] !!}</h2>
        <div class="text-lg">
          <div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div>
        </div>
      </div>
    </div>
    @else
    <div class="component-inner-section">
      <div class="flex flex-col md:grid md:grid-cols-12 gap-3 mb-5">
        <div class="md:col-span-4">
          @if ($section['subtitle'])
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
              {{ $section['subtitle'] }}
            </span>
          @endif
          <h2 class="mb-0">{!! $section['title'] !!}</h2>
        </div>
        <div class="md:col-span-8 text-lg">
          {!! $section['description'] !!}
        </div>
      </div>
    </div>
    @endif
  
    <div class="relative -mx-4">
    <div class="component-inner-section">
      <div class="flex flex-col flex-wrap justify-center sm:flex-row">
          @foreach ($cards as $index => $card)
            @php
              $link = $card['link'];
              $external_link = $card['external_link'];
  
              if ($external_link) {
                $link = $external_link;
              }
              if ($card['link_type'] == 'none') {
                $link = false;
              }
            @endphp
          <div class="@if ($link) cursor-pointer @endif card-item w-full sm:basis-6/12 @if ($columns) lg:basis-{{ $columns }} @else lg:basis-2/6 @endif">
            <div
              x-data="{ isDesktop: window.innerWidth >= 1024 }"
              x-on:resize.window="isDesktop = window.innerWidth >= 1024"
              class="p-2 lg:p-3"
              >
              <div @if ($link) x-bind:click.prevent="isDesktop && (window.location.href='{{ $link }}')" @endif class="@if ($card['thumbnail']) products-gradient @else lg:bg-brand @endif shadow-2xl relative flex items-end rounded-lg overflow-hidden group service-card-squared ">
  
                <div @if ($link) x-bind:click.prevent="isDesktop && (window.location.href='{{ $link }}')" @endif class="card-overlay absolute inset-0  @if ($card['thumbnail']) @else lg:bg-brand opacity-75 group-hover:opacity-0 @endif z-10"></div>
                @if ($card['bg_image'])
                  <div style="z-index: 1;" class="absolute inset-0">
                    @if ($link)
                    <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
                    @endif
                      <img class="lazy w-full h-full object-cover" data-src="{{ $card['bg_image']['sizes']['large'] }}" alt="{{ $card['bg_image']['alt'] }}" />
                    @if ($link)
                    </a>
                    @endif
                  </div>
                @endif
  
                @if ($card['thumbnail'])
                  <div style="z-index: 1;" class="top-10 left-0 right-0 px-3 absolute h-1/2">
                    @if ($link)
                    <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
                    @endif
                      <img class="lazy w-full h-full object-contain" data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}" alt="{{ $card['thumbnail']['alt'] }}" />
                    @if ($link)
                    </a>
                    @endif
                  </div>
                @endif
  
                <div class="relative pointer-events-none z-10 w-full p-5 pb-0">
                  <div class="hidden md:block absolute pointer-events-none inset-0 z-10 border-b-[15px] border-action transition ease-in-out delay-250 group-hover:opacity-0 group-hover:z-0"></div>
                  <div class="absolute pointer-events-none inset-0 bg-gradient-service md:opacity-0 group-hover:opacity-100"></div>
                  @if ($link)
                  <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif>
                  @endif
                  <div class="relative text-white pb-4">
                      @isset ($card["icon"])
                        @if (!empty($card["icon"]))
                          <span class="mb-6 block">
                            <img class="lazy h-8 w-8 acf-icon-white" data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                          </span>
                        @endif
                      @endisset
                      <h3 class="text-2xl font-bold mb-3">{!! $card['title'] !!}</h3>
                        @if ($card['description'])
                          <div class="max-w-[280px] leading-snug w-full">
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
    </div>
    @if (($background['color'] == 'dark') && $background['has_divider'])
    <div class="absolute h-1/3 bg-white bottom-0 left-0 right-0 hidden lg:block"></div>
  @endif
  </section>
  @if ($background['divider_bottom'])
    @includeIf('dividers.waves-bottom')
  @endif
  