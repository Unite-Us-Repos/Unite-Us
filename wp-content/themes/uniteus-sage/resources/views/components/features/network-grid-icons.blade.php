{{-- resources/views/components/features/network-grid-icons.blade.php --}}

@php
  // Normalize inputs from ACF / caller
  $columns = isset($columns['value']) ? $columns['value'] : ($columns ?? null);

  $data = $recommendedPagesData ?? [];
  $features = $data['recommended_pages']['features'] ?? false;
  $section_settings = $data['recommended_pages']['section_settings'] ?? ($section_settings ?? []);
  $section_classes = '';

  // Background can live at the root or inside features
  $background = $data['background'] ?? [];
  if (!empty($background['color'])) {
    $section_classes = 'bg-' . $background['color'];
  }

  if ($features) {
    $section = $features['section'] ?? [];
    $cards = $features['cards'] ?? [];
    $background = $features['background'] ?? $background;

    if (!empty($background['color'])) {
      $section_classes = 'bg-' . $background['color'];
    }
  } else {
    $section = $section ?? [];
    $cards = $cards ?? [];
  }
@endphp

@if (!empty($background['has_divider']))
  @includeIf('dividers.waves')
@endif

<section
  @isset ($section['id']) id="{{ $section['id'] }}" @endisset
  class="component-section {{ $section_classes }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] ?? '' }} @endif"
>
  <div class="component-inner-section @if (!empty($section_settings['fullscreen'])) fullscreen @endif">

    {{-- Heading --}}
    <div>
      <div class="flex flex-col text-{{ $section['alignment'] ?? 'left' }}">
        @if (!empty($section['subtitle']))
          <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
            {{ $section['subtitle'] }}
          </span>
        @endif

        @if (!empty($section['title']))
          <h2>{!! $section['title'] !!}</h2>
        @endif
      </div>
    </div>

    {{-- Cards --}}
    @if (!empty($cards))
      <div class="flex flex-col flex-wrap lg:justify-center gap-y-6 sm:flex-row">
        @foreach ($cards as $index => $card)
          @php
            // Compute link from card settings
            $link = $card['button_link'] ?? '';
            if (!empty($card['link_type']) && $card['link_type'] === 'internal') {
              $link = $card['page_link'] ?? $link;
            }

            // ====== Unite Us Events normalization ======
            // If the card points to events.uniteus.com, always force it to the base URL.
            if (is_string($link) && preg_match('#^https?://(?:www\.)?events\.uniteus\.com#i', $link)) {
              $link = 'https://events.uniteus.com/';
            }

            // Remove any leftover [current_state] placeholders from any URL (defensive)
            if (is_string($link) && strpos($link, '[current_state]') !== false) {
              $link = preg_replace('/([?&])state=\[current_state\](?=$|&)/', '$1', $link);
              $link = str_replace('[current_state]', '', $link);
              $link = rtrim($link, '?&');
            }
          @endphp

          <div class="md:basis-6/12 @if (!empty($columns)) lg:basis-{{ $columns }} @else sm:basis-2/6 @endif pt-6">
            <div class="relative h-full px-5">
              <div class="h-16 flex justify-start items-center">
                @isset ($card['icon'])
                  @if (!empty($card['icon']))
                    @if (!empty($card['icon_type']) && $card['icon_type'] === 'round')
                      <span class="inline-flex w-12 h-12 items-center justify-center rounded-full border-4 border-action bg-brand p-2 shadow-lg">
                    @else
                      <span class="inline-flex items-center justify-center rounded-md bg-action p-3 shadow-lg">
                    @endif
                        <img class="h-8 w-8" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="">
                      </span>
                  @endif
                @endisset

                @if (!empty($card['icon_type']) && $card['icon_type'] === 'custom')
                  @if (!empty($card['custom_icon']['sizes']['medium']))
                    <span class="inline-flex items-center">
                      <img class="h-20 w-20 object-contain" src="{{ $card['custom_icon']['sizes']['medium'] }}" alt="">
                    </span>
                  @endif
                @endif
              </div>

              @if (!empty($card['title']))
                <h3 class="mb-5 mt-5 text-lg font-semibold tracking-tight">{{ $card['title'] }}</h3>
              @endif

              @if (!empty($card['description']))
                <div class="mb-5">
                  {!! $card['description'] !!}
                </div>
              @endif

              @if (!empty($link))
                <a
                  class="no-underline text-action font-semibold block"
                  href="{{ $link }}"
                  @if (!empty($card['is_blank'])) target="_blank" @endif
                >
                  @if (!empty($card['button_text'])) {{ $card['button_text'] }} @else Learn More @endif
                  <span aria-hidden="true" class="ml-1">→</span>
                </a>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @endif

  </div>
</section>
