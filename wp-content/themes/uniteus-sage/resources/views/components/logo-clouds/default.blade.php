@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">
    @if ($section['title'])
      <h2 class="text-center mb-7">
        {!! $section['title'] !!}
      </h2>
    @endif
    @if ($section['description'])
        <div class="text-center text-lg"> {!! $section['description'] !!}</div>
    @endif
    <div class="@if ('grid-grayscale' == $style) grayscale opacity-70 @endif flex flex-wrap lg:flex-nowrap justify-center lg:justify-between sm:flex-row py-10">
      @if ($logos)
        @foreach ($logos as $logo)
          <div class="basis-1/2 md:basis-1/3 p-3 @if ('auto' != $columns) lg:basis-{{ $columns }} @else lg:basis-auto @endif">
            <div class="h-full flex justify-center h-full items-center @if ('default' == $style) bg-light p-8 @endif rounded-lg @if (('default' == $style) OR ('grid-white' == $style)) @endif rounded-lg">
              @if ($logo['link'])
                <a
                  href="{{ $logo['link']}}"
                  target="_blank"
                >
              @endif
              @if ($logo['image'])

                <img
                  class="grayscale w-auto @if ($logo['image_size'] == 'small') max-h-16 @elseif ($logo['image_size'] == 'smaller') max-h-12 @else max-h-20 @endif lazy"
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
