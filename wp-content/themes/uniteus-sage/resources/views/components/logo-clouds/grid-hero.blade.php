@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
@endphp
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif -mb-1">
  <div class="absolute inset-0 -mt-1">
    @if ($background['image'])
      <img class="lazy w-full full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="@asset('/images/lazy-placeholder.png')" data-src="{{ $background['image']['sizes']['2048x2048'] }}" alt="{{ $background['image']['alt'] }}">
    @endif
  </div>
    @if ($background['image'])
    <img class="lazy w-full h-full object-cover opacity-0" data-src="{{ $background['image']['sizes']['large'] }}" alt="{{ $background['image']['alt'] }}" />
    @endif
</section>
<section class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

    <div class="@if ('grid-grayscale' == $style) grayscale opacity-70 @endif flex lg:gap-5 flex-wrap justify-center xl:justify-between items-center py-10">
      @if ($logos)
        @foreach ($logos as $logo)
          <div class="basis-1/2 @if ('auto' == $columns) sm:basis-auto @endif @if ('auto' != $columns) @if ($columns) lg:basis-{{ $columns }} @else sm:basis-1/4 @endif @endif">
            <div class="flex justify-center h-full items-center @if (('default' == $style) OR ('grid-white' == $style)) p-4 sm:py-8 sm:px-8 @else p-3 @endif @if ('default' == $style) bg-light @endif rounded-lg">
              @if ($logo['link'])
                <a
                  href="{{ $logo['link']}}"
                  target="_blank"
                >
              @endif
              @if ($logo['image'])

                <img
                  class="w-auto @if ($logo['image_size'] == 'small') max-h-16 @elseif ($logo['image_size'] == 'smaller') max-h-12 @else max-h-20 @endif lazy"
                  data-src="{{ $logo['image']['sizes']['medium'] }}"
                  alt="{{ $logo['image']['alt'] }}"
                />

              @endif
              @if ($logo['link'])
                </a>
              @endif
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</section>
@if ($background['has_divider'])
<div class="section-divider -mt-1 -mx-1 relative h-5 sm:h-10 md:h-14 xl:h-20">
  <svg class="w-full h-auto" width="1358" height="80" preserveAspectRatio="none" viewBox="0 0 1358 80" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 71.0853L57.125 65.2401C113.75 59.3948 227 47.7043 340.25 53.5496C453.5 59.3948 566.75 82.7758 680 80.8274C793.25 78.879 906.5 51.6012 1019.75 45.7559C1133 39.9107 1246.25 55.498 1302.87 63.2917L1359.5 71.0853V0.942383H1302.87C1246.25 0.942383 1133 0.942383 1019.75 0.942383C906.5 0.942383 793.25 0.942383 680 0.942383C566.75 0.942383 453.5 0.942383 340.25 0.942383C227 0.942383 113.75 0.942383 57.125 0.942383H0.5V71.0853Z" fill="#172A44"></path>
  </svg>
</div>
@endif
