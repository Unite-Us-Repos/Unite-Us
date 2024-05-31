@php
$h_level = 2;
$is_heading = $section["is_header"];
if ($is_heading) {
  $h_level = 1;
}
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section flex flex-col md:block md:relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
    <div class="mx-auto w-full max-w-7xl py-14 md:py-20 order-2">
      <div class="px-8 md:w-1/2 md:pr-14 xl:pr-28">
        @if ($section['subtitle'])
          <div class="subtitle">
            {{ $section['subtitle'] }}
          </div>
        @endif
        <h{{ $h_level }} class="form-page-title">{!! $section['title'] !!}</h{{ $h_level }}>
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
        @isset ($code_editor)
          @if (!empty($code_editor))
            <div id="formIframe" class="rounded-lg embed-form mt-6 lg:mt-10">
              {!! $code_editor !!}
            </div>
          @endif
        @endisset
      </div>
    </div>
    <div class="relative h-96 w-full md:absolute md:inset-y-0 md:right-0 md:h-full md:w-1/2">
      @if ($featured_image)
        <img class="absolute inset-0 h-full w-full object-cover" src="{{ $featured_image['sizes']['large'] }}" alt="{{ $featured_image['alt'] }}" />
      @endif
    </div>
  </div>
</section>
