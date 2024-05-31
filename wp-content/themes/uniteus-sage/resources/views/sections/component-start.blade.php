@php
$section_settings = isset($acf["components"][$index]['layout_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : false;
$background = isset($acf["components"][$index]['background']) ? $acf["components"][$index]['background'] : false;

if (!$section_settings) {
  $section_settings = [
    'collapse_padding' => '',
    'padding_class' => '',
    'fullscreen' => '',
    ];
}

if (!$background) {
  $background = [
    'has_divider' => '',
    ];
}
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
