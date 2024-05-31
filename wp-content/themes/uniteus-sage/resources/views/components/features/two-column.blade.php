@php
$columns = $columns['value'];
@endphp

@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

    <div class="flex flex-wrap md:grid md:grid-cols-12 gap-10">

      <div class="md:col-span-4">
        <div class="flex flex-col text-{{ $section['alignment'] }}">
          @if ($section['subtitle'])
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
              {{ $section['subtitle'] }}
            </span>
          @endif
          <h2>{!! $section['title'] !!}</h2>
        </div>
      </div>

      <div class="md:col-span-8">
          <div class="flex flex-col flex-wrap justify-center md:grid md:grid-cols-2 gap-8">
            @foreach ($cards as $index => $card)
            @php
              $link = $card['button_link'];
              if ('internal' == $card['link_type']) {
                $link = $card['page_link'];
              }
            @endphp
            <div class="">
              <div class="relative h-full">
                  <div class="h-16 flex justify-start items-center">
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
                  @if ($card['title'])
                  <h3 class="mb-5 mt-5 text-lg font-semibold tracking-tight">{{ $card['title'] }}</h3>
                  @endif
                    @if ($card['description'])
                      <div class="mb-5">
                        {!! $card['description'] !!}
                      </div>
                    @endif

                    @if ($link)
                      <a class="no-underline text-action font-semibold block" href="{{ $link }}" @if ($card['is_blank']) target=="_blank" @endif>
                        @if ($card['button_text']) {{ $card['button_text'] }} @else Learn More @endif<span aria-hidden="true" class="ml-1">
                            →</span></a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
