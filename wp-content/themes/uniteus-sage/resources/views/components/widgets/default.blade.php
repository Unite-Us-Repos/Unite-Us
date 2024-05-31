@php
$section = $acf["components"][$index]['section'];
$background = $acf["components"][$index]['background'];
$column_gap = $acf["components"][$index]['column_gap'];
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
$widgets = $acf["components"][$index]["widgets"];
$divider = true;
$columns = 0;
$lg_gap = '';
$responsive_gap = '';
if ($column_gap) {
  if ($column_gap > 8) {
    $column_gap_sm = (int) $column_gap/2;
  } else {
    $column_gap_sm = 6;
  }
  $responsive_gap = 'sm:gap-x-' . $column_gap_sm . ' lg:gap-x-' . $column_gap;
}

if (isset($widgets) && is_array($widgets)) {
  foreach ($widgets as $widget) {
    $columns += (int) $widget["acfe_layout_col"];
  }
}
if (!$columns) {
  $columns = 12;
}
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section @if ($background['apply_to'] == 'section') bg-{{ $background['color'] }} @endif {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
    <div class="inner-box @if ($background['apply_to'] == 'inner-container') rounded-xl p-10 lg:p-20 bg-{{ $background['color'] }} @endif">
      @if ($section['title'])
        <div class="flex flex-col text-{{ $section['alignment'] }}">
          <h2 class="order-2 @if ($background['color'] == 'dark') text-white @endif">
            {!! $section['title'] !!}
          </h2>
          @if ($section['subtitle'])
          <h3 class="text-action text-xl mb-3 order-1">{!! $section['subtitle'] !!}</h3>
          @endif

          @if ($section['description'])
            <div class="mb-6 section-description order-3 max-w-5xl @if ($section['alignment'] !== 'left') mx-auto @endif text-xl md:text-2xl">
              {!! $section['description'] !!}
            </div>
          @endif
        </div>
      @endif

    @if ($widgets)
      <div class="@if ($section_settings['fullscreen']) fullscreen @endif">
        @foreach ($widgets as $index => $widget)
            @isset ($widget['acf_fc_layout'])

              @if ($widget['acfe_layout_col'] && $index === 0)
                <div class="@if ($widget['acfe_layout_col'] != 'auto') grid lg:grid-cols-{{ $columns }} @else flex flex-wrap sm:justify-around @endif gap-6">
              @endif

              @if ($widget['acfe_layout_col'])
                <div class="@if ($widget['acfe_layout_col'] == 'auto') lg:col-auto @else lg:col-span-{{ $widget['acfe_layout_col'] }} @endif">
                  @includeIf('widgets.' . str_replace('_', '-', $widget["acf_fc_layout"]))
                </div>
              @endif

              @if ($widget['acfe_layout_col'] && $index+1 === count($widgets))
                </div>
              @endif

            @endisset
        @endforeach
      </div>
    @endif
    </div>
  </div>
</section>
