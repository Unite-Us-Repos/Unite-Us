@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="absolute bottom-0 border border-blue-900 -ml-4 w-full h-3/6 -mb-[1px] bg-blue-900"></div>

  <div class="component-inner-section relative @if ($section_settings['fullscreen']) fullscreen @endif">
    <div class="bg-light w-full rounded-2xl flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 lg:gap-20">

      <div class="@if ($featured_image) order-2 @endif p-9 md:p-20 flex flex-col @if ('center' == $vertical_alignment) justify-center @endif text-lg @if ('text_image' == $layout) md:order-1 @else md:order-2 @endif lg:mb-0">
        @if ($section['subtitle'])
          <div class="subtitle n-case mb-3">
            {{ $section['subtitle'] }}
          </div>
        @endif
        
        @if ($section['is_header'] === 'h1')
        <h1 class="mb-0 h2">
            {!! $section['title'] !!}
        </h1>
        @elseif ($section['is_header'] === 'h2')
            <h2 class="mb-0 h2">
                {!! $section['title'] !!}
            </h2>
        @else
            <div class="mb-0 h2">
                {!! $section['title'] !!}
            </div>
        @endif
    

        {!! $section['description'] !!}
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-start',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>

      <div class="relative pt-0 p-9 md:p-9 @if ($featured_image) pb-0 md:p-0  @endif flex flex-col @if ('center' == $vertical_alignment) justify-center @endif @if ('text_image' == $layout) md:order-2 @else  md:order-1 @endif">
        @if ($featured_image)
          <img class="lazy rounded-lg w-full max-w-sm mx-auto lg:max-w-md" data-src="{{ $featured_image['sizes']['large'] }}" alt="{{ $featured_image['alt'] }}" />
        @endif

        @isset ($embeds)
          @if (!empty($embeds))
            <div class="rounded-lg responsive-embed">
              {!! $embeds !!}
            </div>
          @endif
        @endisset

        @isset ($code_editor)
          @if (!empty($code_editor))
            <div class="">
              {!! $code_editor !!}
            </div>
          @endif
        @endisset
      </div>
    </div>
  </div>
</section>
