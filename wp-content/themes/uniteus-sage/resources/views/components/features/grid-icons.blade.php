@php
$columns = $columns['label'];
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="features-form component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

    <div class="">

      <div>
        <div class="flex flex-col mb-10 text-{{ $section['alignment'] }}">
          @if ($section['subtitle'])
            <span class="block text-base mb-6 font-semibold uppercase tracking-wider text-action">
              {{ $section['subtitle'] }}
            </span>
          @endif
          <h2 class="mb-3">{!! $section['title'] !!}</h2>
          <div class="max-w-4xl text-lg">
            @if ($section['description'])
              {!! wpautop($section['description']) !!}
            @endif
          </div>
        </div>
      </div>

      <div class="flex flex-col text-lg sm:grid sm:grid-cols-{{ $columns }} gap-x-12 gap-y-10">
            @foreach ($cards as $index => $card)
            @php
              $link = $card['button_link'];
              if ('internal' == $card['link_type']) {
                $link = $card['page_link'];
              }
              if ('global' == $card['icon_type']) {
                $card['icon_type'] = 'round-flat';
              }
            @endphp
            <div class=" md:basis-6/12 @if ($columns) lg:basis-{{ $columns }} @else sm:basis-2/6 @endif">

              <div class="relative h-full @if ('left' == $icon_position) items-center flex gap-5 @endif">
                  <div class="h-16 flex justify-start items-center shrink-0">
                    @isset ($card["icon"])
                      @if (!empty($card["icon"]))
                        @if ('round' == $card['icon_type'])
                          <span class="inline-flex w-12 h-12  items-center justify-center rounded-full border-4 border-action bg-brand p-2 shadow-lg">
                        @elseif ('round-flat' == $card['icon_type'])
                          <span class="inline-flex items-center justify-center rounded-full text-action bg-light p-3">
                        @else
                          <span class="inline-flex items-center justify-center rounded-md bg-action p-3 shadow-lg">
                        @endif
                          <img
                            class="h-8 w-8"
                            src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg?v=2"
                            alt=""
                            style="filter: invert(43%) sepia(71%) saturate(4510%) hue-rotate(205deg) brightness(104%) contrast(105%);"
                            />
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
                      {!! $card['description'] !!}
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
