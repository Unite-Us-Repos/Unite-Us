@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
$h_level = 2;
$is_heading = $section["is_header"];
if ($is_heading) {
  $h_level = 1;
}

// Define background and text classes
$background_classes = '';
$text_classes = 'text-white';
switch ($background['color']) {
    case 'white':
        $background_classes = 'bg-white';
        $text_classes = 'text-dark';
        break;
    case 'light':
        $background_classes = 'bg-light';
        $text_classes = 'text-brand';
        break;
    case 'dark':
        $background_classes = 'bg-dark';
        break;
    case 'light-gradient':
        $background_classes = 'bg-light-gradient';
        $text_classes = 'text-brand';
        break;
    case 'dark-gradient':
        $background_classes = 'bg-dark-gradient';
        break;
    case 'custom':
        $background_classes = 'bg-custom';
        $text_classes = 'text-white';
        break;
}

// Override text color if overlay is present
if ($background['overlay']) {
    $text_classes = 'text-white';
}
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="relative component-section {{ $section_classes }} {{ $background_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif" @if ($background['color'] == 'custom') style="background-color: {{ $background['custom_color'] }} @endif">
  <div class="relative z-10 component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
    <div class="flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 gap-10 lg:gap-28 {{ $text_classes }}" style="@if ($background['color'] == 'custom') color: {{ $background['text_color'] }} @endif">

      <div class="text-lg {{ $text_classes }}">
        @if ($section['subtitle'])
          <div class="subtitle {{ $text_classes }}">
            {{ $section['subtitle'] }}
          </div>
        @endif
        @isset ($section['logo']['sizes'])
          <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
        @endisset
        <h{{ $h_level }} class="mb-0 text-4xl font-extrabold tracking-tight {{ $text_classes }} md:text-5xl lg:text-6xl">
          {!! $section['title'] !!}
        </h{{ $h_level }}>
        <div class="text-lg {{ $text_classes }}">
          {!! $section['description'] !!}
        </div>
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-start',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>

      <div class="relative lg:row-start-1 lg:col-start-2">
        @isset ($code_editor)
          @if (!empty($code_editor))
            <div id="formIframe" class="rounded-lg shadow-lg bg-white p-10 embed-form text-brand">
              {!! $code_editor !!}
            </div>
          @endif
        @endisset
      </div>
    </div>
  </div>
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
  
</section>
