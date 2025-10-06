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

{{-- wrapper: max 6 per row, rows auto-wrap, last row centered --}}
<div class="@if (($style ?? null) === 'grid-grayscale') grayscale opacity-70 @endif
            flex flex-wrap justify-center gap-x-12 gap-y-4 py-10">

  @foreach ($logos as $logo)
    <div class="px-3
                basis-1/2        {{-- 2 per row on phones --}}
                sm:basis-1/3     {{-- 3 per row on small --}}
                md:basis-1/4     {{-- 4 per row on medium --}}
                lg:basis-1/6">   {{-- 6 per row on large+ --}}
      <div class="h-full flex items-center justify-center rounded-lg @if (($style ?? '') === 'default') bg-light p-8 @endif">
        @if (!empty($logo['link'])) <a href="{{ $logo['link'] }}" target="_blank" class="block"> @endif

        @if (!empty($logo['image']))
          <img
            class="lazy block mx-auto w-auto mix-blend-multiply
                   @if (!empty($apply_grayscale) && $apply_grayscale) grayscale @endif
                   @if (($logo['image_size'] ?? '') === 'small') max-h-16
                   @elseif (($logo['image_size'] ?? '') === 'smaller') max-h-12
                   @else max-h-20 @endif"
            data-src="{{ $logo['image']['sizes']['medium'] }}"
            alt="{{ $logo['image']['alt'] }}" />
        @endif

        @if (!empty($logo['link'])) </a> @endif
      </div>
    </div>
  @endforeach
</div>

  </div>
</section>
