@php
use Illuminate\Support\Str;

$s_settings = [
    'collapse_padding' => false,
    'fullscreen' => '',
];
$section_settings = isset($acf['components'][$index]['layout_settings']['section_settings'])
    ? $acf['components'][$index]['layout_settings']['section_settings']
    : $s_settings;

$section = $acf['components'][$index]['keynote_speaker'] ?? [];
$background = $section['background'] ?? [];
$featured_image = $section['featured_image'] ?? null;
@endphp

@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

<section @isset($section['id']) id="{{ $section['id'] }}" @endisset
    class="keynote-speaker relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif -mb-4 lg:-mb-12">

    <!-- Background Image -->
    <div class="absolute inset-0">
      @if ($background['image'])
        <img fetchpriority="high" class="w-full h-full object-cover @if ($background['position'] == 'top') object-top @endif @if ($background['position'] == 'bottom') object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
          srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
          sizes="(max-width: 600px) 300px, 1024px"
          alt="{{ $background['image']['alt'] }}">
      @endif
    </div>
  
    <!-- Background Overlay -->
    @if ($background['overlay'])
      <div class="absolute inset-0 bg-brand opacity-75 bg-electric-purple-overlay"></div>
    @endif

    <!-- Content Section -->
    <div class="relative w-full">
      <div class="component-inner-section">
        <div class="lg:grid lg:grid-cols-12 lg:gap-10">

          <!-- Image Column -->
          <div class="lg:col-span-6">
            @isset($section['featured_image']['sizes'])
            <img class="lazy mb-6 rounded-lg w-full max-w-md mx-auto lg:absolute lg:-mt-40" data-src="{{ $section['featured_image']['sizes']['medium_large'] }}" alt="{{ $section['featured_image']['alt'] }}" />
            @endisset
          </div>

          <!-- Text Column -->
          <div class="lg:col-span-6 text-white">
            @isset($section['pill'])
            <div class="text-black bg-white uppercase py-1 px-4 inline-block mb-6">
              {{ $section['pill'] }}</div>
            @endisset

            @isset($section['title'])
            <h2 class="mb-6 text-white">{!! $section['title'] !!}</h2>
            @endisset

            @isset($section['subtitle'])
            <div class="mb-6 text-white italic text-xl w-3/4">{{ $section['subtitle'] }}</div>
            @endisset

            @isset($section['description'])
            <div class="mb-6 description text-white">
              {!! $section['description'] !!}
            </div>
            @endisset
          </div>

        </div>
      </div>
    </div>
</section>

@if ($background['divider_bottom'])
  @includeIf('dividers.waves-bottom')
@endif
