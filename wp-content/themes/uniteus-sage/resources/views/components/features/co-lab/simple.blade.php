@php
  $isCenter = ('center' == $section["alignment"]) ? true : false;
@endphp
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">

    <div @class([
      'max-w-3xl mx-auto text-center' => $isCenter,
      'flex flex-col md:grid md:grid-cols-12 gap-3 mb-5' => !$isCenter,
      ])>

      <div class="@if (!$isCenter) md:col-span-4 @endif">
        @if ($section['subtitle'])
          <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
            {{ $section['subtitle'] }}
          </span>
        @endif

        @if ($section['title'])
          <h2 class="mb-6 font-syne font-bold">
            {!! $section['title'] !!}
          </h2>
        @endif
      </div>

      @isset ($section['description'])
        <div class="@if (!$isCenter) md:col-span-8 @endif mb-10 font-space text-lg font-normal max-w-4xl mx-auto">
          {!! $section['description'] !!}
        </div>
      @endisset
    </div>

    <div class="flex flex-col flex-wrap justify-center sm:flex-row -mx-3">
      @foreach ($cards as $index => $card)
        @php
          $link = $card['button_link'];
          if ('internal' == $card['link_type']) {
            $link = $card['page_link'];
          }
        @endphp

        <div class="w-full md:w-1/2 lg:w-1/3 font-space rounded-md hover:bg-light-gray/50 hover:shadow-lg p-8">
          <div class="w-12 h-12 mb-6 bg-blue-300/25 border border-blue-300/25 rounded-md flex justify-center items-center">
            <span class="text-redish">
              @isset ($card['icon'])
                <img style="width:20px !important;height:20px !important;" class="h-8 w-8" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
              @endisset
            </span>
          </div>
          <h3 class="font-syne text-lg mb-3">{!! $card['title'] !!}</h3>
          <div class="text-sm">{!! wpautop($card['description']) !!}</div>
        </div>

      @endforeach
    </div>
  </div>
</section>
