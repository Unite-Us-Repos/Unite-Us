@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'] ?? [];
$apply_grayscale = (!empty($is_grayscale) && $is_grayscale) || (($style ?? null) === 'grid-grayscale');
@endphp

@if (!empty($background['has_divider']))
  @includeIf('dividers.waves')
@endif

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section relative {{ $section_classes ?? '' }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">
    @if (!empty($section['title']))
      <h2 class="text-center mb-7">{!! $section['title'] !!}</h2>
    @endif

    @if (!empty($section['description']))
      <div class="text-center text-lg">{!! $section['description'] !!}</div>
    @endif

    {{-- Grid: max 6 columns; wraps automatically; all logos centered --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-12 gap-y-8 py-10">
      @if (!empty($logos))
        @foreach ($logos as $logo)
          <div class="p-3">
            <div class="h-full flex justify-center items-center rounded-lg @if (($style ?? '') === 'default') bg-light p-8 @endif">
              @if (!empty($logo['link']))
                <a href="{{ $logo['link'] }}" target="_blank" class="block">
              @endif

              @if (!empty($logo['image']))
                <img
                  class="lazy block mx-auto w-auto {{ $apply_grayscale ? 'grayscale' : '' }} @if (($logo['image_size'] ?? '') === 'small') max-h-16 @elseif (($logo['image_size'] ?? '') === 'smaller') max-h-12 @else max-h-20 @endif"
                  data-src="{{ $logo['image']['sizes']['medium'] }}"
                  alt="{{ $logo['image']['alt'] }}"
                />
              @endif

              @if (!empty($logo['link']))
                </a>
              @endif
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</section>
