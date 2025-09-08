@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
@endphp
<div class="max-w-7xl mx-auto">
<section @isset($section['id']) id="{{ $section['id'] }}" @endisset class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <!-- Overlay -->

  <div class="absolute inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden">
    @if ($background['image'])
      <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    @endif
  </div>

  <div class="relative w-full text-center z-20">

    <div class="component-inner-section">
      <div class="relative max-w-4xl mx-auto">
        @if (!$hide_breadcrumbs)
          <div class="mb-9 sm:mb-10">
            @php
            $home_color = 'white';
            $bread_text = 'white';
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
            <div class="gradient-pill text-sm py-1 px-4 inline-block mb-6 rounded-full">
          @else
            <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
          @endif
            {!! $section['subtitle'] !!}
          </div>
        @endif

        @if ($section['is_header'] === 'h1')
        <h1 class="h1 mb-0 text-4xl font-extrabold tracking-tight @if (($background['color'] == 'light') || $background['color'] == 'light-gradient') text-brand @else text-white @endif md:text-5xl lg:text-6xl">
          {!! $section['title'] !!}
        </h1>
        @elseif ($section['is_header'] === 'h2')
            <h2 class="h1 mb-0 text-4xl font-extrabold tracking-tight @if (($background['color'] == 'light') || $background['color'] == 'light-gradient') text-brand @else text-white @endif md:text-5xl lg:text-6xl">
              {!! $section['title'] !!}
            </h2>
        @else
            <div class="h1 mb-0 text-4xl font-extrabold tracking-tight @if (($background['color'] == 'light') || $background['color'] == 'light-gradient') text-brand @else text-white @endif md:text-5xl lg:text-6xl">
              {!! $section['title'] !!}
            </div>
        @endif



      </div>

      <div class="relative max-w-3xl mx-auto mt-10">
        @if ($section['description'])
          <div class="@if (($background['color'] == 'light') OR $background['color'] == 'light-gradient') text-brand @else text-white @endif text-lg font-semibold">
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

  <div class="absolute inset-0 z-10 flex items-center align-center">
      <svg width="987" height="543" viewBox="0 0 987 543" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g filter="url(#filter0_f_26186_37821)">
        <g opacity="0.6" filter="url(#filter1_f_26186_37821)">
        <ellipse cx="463.618" cy="314.842" rx="164.779" ry="143.712" fill="#003DB6"/>
        </g>
        <g filter="url(#filter2_f_26186_37821)">
        <ellipse cx="219.203" cy="155.947" rx="219.203" ry="155.947" transform="matrix(1 0 0 -1 212.152 492.839)" fill="#9C53FC" fill-opacity="0.8"/>
        </g>
        <g opacity="0.6" filter="url(#filter3_f_26186_37821)">
        <ellipse cx="603.101" cy="234.63" rx="171.747" ry="185.164" fill="#216BFE"/>
        </g>
        </g>
        <defs>
        <filter id="filter0_f_26186_37821" x="3.77448" y="-158.913" width="979.451" height="860.129" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
        <feGaussianBlur stdDeviation="104.189" result="effect1_foregroundBlur_26186_37821"/>
        </filter>
        <filter id="filter1_f_26186_37821" x="87.1263" y="-40.5827" width="752.983" height="710.85" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
        <feGaussianBlur stdDeviation="105.856" result="effect1_foregroundBlur_26186_37821"/>
        </filter>
        <filter id="filter2_f_26186_37821" x="0.439987" y="-30.7678" width="861.831" height="735.319" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
        <feGaussianBlur stdDeviation="105.856" result="effect1_foregroundBlur_26186_37821"/>
        </filter>
        <filter id="filter3_f_26186_37821" x="219.642" y="-162.247" width="766.918" height="793.754" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
        <feGaussianBlur stdDeviation="105.856" result="effect1_foregroundBlur_26186_37821"/>
        </filter>
        </defs>
      </svg>
    </div>

  @if ($background['overlay'])
    <div class="absolute inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden bg-brand opacity-75"></div>
  @endif
</section>
</div>
