@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif"
  @if ($section_settings['padding_class'] == 'padding-collapse') style="padding: 0;" @endif>
  <div class="component-inner-section relative @if ($section_settings['fullscreen']) fullscreen @endif" @if ($section_settings['padding_class'] == 'padding-collapse') style="padding: 0;" @endif>

  @if ($section['title'] || $section['description'])
      @if ($section['title'])
        <h2>{{ $section['title'] }}</h2>
      @endif
      @if ($section['description'])
      <div class="text-lg">
        {!! $section['description'] !!}
      </div>
      @endif
  @endif

  <div class="text-lg">
    {!! $html_editor !!}
  </div>
  </div>
</section>
