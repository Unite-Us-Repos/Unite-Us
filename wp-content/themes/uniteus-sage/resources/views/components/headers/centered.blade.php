@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
@endphp
<section class="header-hero relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <!-- Overlay -->


  @if ($background['image'])
    <div class="absolute inset-0">
      <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    </div>
  @endif


  @if ($background['overlay'])
  <div class="absolute inset-0 bg-brand opacity-75"></div>
  @endif

  <div class="relative w-full text-center">

    <div class="component-inner-section">
      <div class="relative max-w-4xl mx-auto">
        @if (!$hide_breadcrumbs)
          <div class="mb-9 sm:mb-10">
            @php
            $bread_text = 'dark';
            if ($background['color'])
            $data = [
              'color' => $bread_text,
              'align' => 'center'
            ];
            @endphp
            @include('ui.breadcrumbs.simple-with-slashes', $data)
          </div>
        @endif
        @isset ($section['logo']['sizes'])
          <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
        @endisset

        @if ($section['subtitle'])
          @if ($section['subtitle_display_as_pill'])
            <div class="text-action bg-light mix-blend-multiply text-sm py-1 px-4 inline-block mb-6 rounded-full">
          @else
            <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
          @endif
            {!! $section['subtitle'] !!}
          </div>
        @endif
        <h1 class="mb-0 text-4xl font-extrabold tracking-tight @if (($background['color'] == 'light') OR $background['color'] == 'light-gradient') text-brand @else text-white @endif md:text-5xl lg:text-6xl">
          {!! $section['title'] !!}
        </h1>
      </div>

      <div class="relative max-w-4xl mx-auto mt-10">
        @if ($section['description'])
          <div class="@if (($background['color'] == 'light') OR $background['color'] == 'light-gradient') text-brand @else text-white @endif text-xl">
            {!! $section['description'] !!}
          </div>
        @endif
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-center',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
    </div>
  </div>
</section>
