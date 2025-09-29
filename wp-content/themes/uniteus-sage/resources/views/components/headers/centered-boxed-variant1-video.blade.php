@php $section_settings = $acf["components"][$index]['layout_settings']['section_settings']; $video_type = 'vimeo'; @endphp
<div class="relative" x-data="videoController">
<section class="relative z-10 max-w-7xl mx-auto component-section @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
    <!-- Overlay -->
    @if ($background['image'])
    <div class="absolute inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden">
      <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}" srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w" sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
    </div>
    @endif

    <div class="relative w-full py-6 text-center z-20">

      <div class="component-inner-section">
        <div class="relative max-w-4xl mx-auto">

          @isset ($section['logo'])
            <x-image-link
              :image="$section['logo']"
              image-size="medium"
              :lazy="true"
              classes="mb-8 max-w-xs h-auto mx-auto"
              link-classes=""
            />
          @endisset

          @if ($section['subtitle'])
          <div class="text-action-light-blue font-semibold text-base mb-4">
            {!! $section['subtitle'] !!}
          </div>
          @endif

          <!-- play button -->
          @include('components.headers.partials.video-modal-play-button')
          <!-- end play button -->

          @if ($section['is_header'] === 'h1')
          <h1 class="mb-0 !text-5xl !font-semibold tracking-tight @if (($background['color'] == 'light') || $background['color'] == 'light-gradient') text-brand @else text-white @endif md:text-5xl lg:text-6xl">
            {!! $section['title'] !!}
          </h1>
          @elseif ($section['is_header'] === 'h2')
          <h2 class="mb-0 !text-5xl !font-semibold tracking-tight @if (($background['color'] == 'light') || $background['color'] == 'light-gradient') text-brand @else text-white @endif md:text-5xl lg:text-6xl">
            {!! $section['title'] !!}
          </h2>
          @else
          <div class="mb-0 !text-5xl !font-semibold tracking-tight @if (($background['color'] == 'light') || $background['color'] == 'light-gradient') text-brand @else text-white @endif md:text-5xl lg:text-6xl">
            {!! $section['title'] !!}
          </div>
          @endif
        </div>

        <div class="relative max-w-3xl mx-auto mt-6">
          @if ($section['description'])
          <div class="@if (($background['color'] == 'light') OR $background['color'] == 'light-gradient') text-brand @else text-white @endif text-lg font-semibold">
            {!! $section['description'] !!}
          </div>
          @endif

          @if ($buttons)
            @php
              $data = [ 'justify' => 'justify-center', ];
            @endphp

            @include('components.action-buttons', $data)
          @endif

          @if ($video_modal['video_url'])
            <div class="mt-8">
              <a href="#" id="video-hero-link" class="relative trigger-play inline-block no-underline text-white hover:text-white font-semibold text-xl pb-1">
                {{ $video_modal['button_text'] }}
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- shadow svg -->
    <div class="absolute hidden lg:flex inset-0 z-10 justify-center align-center">
      @include('components.headers.partials.gradient-svg')
    </div>

    @if ($background['overlay'])
      <div class="absolute border border-white inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden bg-brand opacity-75"></div>
    @endif

    @if ($background['video'])
      <div class="absolute inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden">
        {{-- <div class="absolute inset-0 hero-radial-bg"></div> --}}
        <video id="bgVideo" autoplay loop muted playsinline class="lazy w-full h-full object-cover max-w-none">
          <source data-src="{{ $background['video'] }}" type="video/mp4" />Your browser does not support the video tag.
        </video>
      </div>
    @endif
  </section>

<div class="mx-auto max-w-7xl sm:mt-10 flex justify-center align-middle relative" style="z-index: 1">

@if ($display_anchor_links)
  @include('components.headers.partials.anchor-links', $anchorLinksData)
@endif

@if (str_contains($style, 'stats'))
  @include('components.headers.partials.stats')
@endif
</div>
<div class="absolute bottom-0 left-0 right-0 bg-light h-full md:h-96"></div>
</div>

<style>
  .hero-radial-bg {
    background: linear-gradient(0deg, #0B1538, #0B1538),
    radial-gradient(56.31% 56.31% at 50% 50%, rgba(11, 21, 56, 0) 0%, #0B1538 100%);
    opacity: 0.70;
  }
</style>
