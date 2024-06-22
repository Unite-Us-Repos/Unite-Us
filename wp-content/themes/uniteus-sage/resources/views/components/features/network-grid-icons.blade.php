@php
$columns = $columns['value'];
@endphp

@php
$data = $recommendedPagesData;
$features = isset($data['recommended_pages']['features']) ? $data['recommended_pages']['features'] : false;
$section_settings = isset($data['recommended_pages']['section_settings']) ? $data['recommended_pages']['section_settings'] : $section_settings;

if (isset($data['background']['color'])) {
                    $data['section_classes'] = 'bg-' . $data['background']['color'];
                }

if (isset($features)) {
  $section = $features['section'];
  $cards = $features['cards'];
  $background = $features['background'];
  if (isset($background['color'])) {
    $section_classes = 'bg-' . $background['color'];
  }
}

$current_state = do_shortcode('[current_state]');
@endphp

@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

    <div class="">

      <div>
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
      </div>

      @if ($cards)
      <div class="flex flex-col flex-wrap lg:justify-center gap-y-6 sm:flex-row">
            @foreach ($cards as $index => $card)
            @php
              $link = $card['button_link'];
              if ('internal' == $card['link_type']) {
                $link = $card['page_link'];
              }

              if ($current_state) {
              $link = str_replace('[current_state]', $current_state, $link);
              }
            @endphp
            <div class=" md:basis-6/12 @if ($columns) lg:basis-{{ $columns }} @else sm:basis-2/6 @endif pt-6">

              <div class="relative h-full test px-5">
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
      @endif
    </div>
  </div>
</section>
