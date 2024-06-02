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
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ('dark' == $background['color']) is-dark-bg text-white @endif">
  <div class="component-inner-section text-center">
  @if ($section['subtitle'])
      <div class="text-marketing-11 font-semibold text-center uppercase mb-6">{{ $section['subtitle'] }}</div>
    @endif

    @if ($section['title'])
      <h{{ $h_level }} class="mb-6">
        {!! $section['title'] !!}
      </h{{ $h_level }}>
    @endif
    @if ($section['description'])
      <div class="cta-description text-lg max-w-4xl mx-auto">
        {!! $section['description'] !!}
      </div>
    @endif
    @if ($buttons)
      <div>
      @php
          $mt = '';
          if (!$section['description'] OR (!$section['title'] && !$section['description'])) {
            $mt = 'mt-0';
          }
          @endphp
          @include('components.action-buttons', ['mt' => $mt])
      </div>
    @endif
  </div>
</section>
