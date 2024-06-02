@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
$h_level = 2;
$is_heading = $section["is_header"];
if ($is_heading) {
  $h_level = 1;
}
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif" @if ($background['color'] == 'custom') style="background-color: {{ $background['custom_color'] }} @endif">
  <div class="relative z-10 component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
    <div class="flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 gap-10 lg:gap-28 @if ($background['color'] == 'dark') text-white @endif" style="@if ($background['color'] == 'custom') color: {{ $background['text_color'] }} @endif">

      <div class="text-lg">
        @if ($section['subtitle'])
          <div class="subtitle">
            {{ $section['subtitle'] }}
          </div>
        @endif
        @isset ($section['logo']['sizes'])
          <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
        @endisset
        <h{{ $h_level }}>{!! $section['title'] !!}</h{{ $h_level }}>
        <div class="text-lg">
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
</section>
