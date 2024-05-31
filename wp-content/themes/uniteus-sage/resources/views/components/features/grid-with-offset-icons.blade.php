@php
$columns = $columns['value'];
@endphp

@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
    <div class="flex flex-col text-{{ $section['alignment'] }}">
      @if ($section['subtitle'])
        <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
          {{ $section['subtitle'] }}
        </span>
      @endif
      @if ($section['title'])
        <h2>{!! $section['title'] !!}</h2>
      @endif
    </div>
    <div class="mt-12">
      <div class="flex flex-col flex-wrap justify-center gap-y-6 sm:flex-row">
        @foreach ($cards as $index => $card)
        @php
          $link = $card['button_link'];
          if ('internal' == $card['link_type']) {
            $link = $card['page_link'];
          }
        @endphp
        <div class="text-center sm:basis-6/12 @if ($columns) md:basis-{{ $columns }} @else sm:basis-2/6 @endif pt-6">
          <div class="relative h-full rounded-lg bg-light mx-3 px-6 py-8">
              <div class="absolute top-0 left-0 right-0 @if ('custom' == $card['icon_type']) -mt-12 @else -mt-8 @endif h-16 flex justify-center items-center">
                @isset ($card["icon"])
                  @if (!empty($card["icon"]))
                    @if ('round' == $card['icon_type'])
                      <span class="inline-flex w-12 h-12  items-center justify-center rounded-full border-4 border-action bg-brand p-2 shadow-lg">
                    @else
                    <span class="inline-flex items-center justify-center rounded-md bg-action p-3 shadow-lg">
                    @endif
                      <img class="h-8 w-8" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                    </span>
                  @endif
                @endisset
              </span>

              @if ('custom' == $card['icon_type'])
                @if (!empty($card["custom_icon"]))
                  <span class="inline-flex items-center">
                    <img class="h-20 w-20 object-contain" src="{{ $card['custom_icon']['sizes']['medium'] }}" alt="" />
                  </span>
                @endif
              @endif
              </div>
              <div class="mt-5">
                @if ($card['title'])
                <h3 class="mb-5 text-lg font-semibold tracking-tight">{{ $card['title'] }}</h3>
                @endif
                @if ($card['description'])
                  <div>
                    {!! $card['description'] !!}
                  </div>
                @endif

                @if ($link)
                  <a href="{{ $link }}" class="button button-hollow inline-block" @if ($card['is_blank']) target=="_blank" @endif>
                    @if ($card['button_text']) {{ $card['button_text'] }} @else Learn More @endif
                  </a>
                @endif
              </div>
            </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>
</section>
