@php (the_content()) @endphp
@php
$skin = str_replace('.blade.php', '', get_page_template_slug());
$skin = str_replace('template-', '', $skin);

@endphp
{{-- Dynamically load ACF components --}}
@if ($flexibleComponents)
  @foreach ($flexibleComponents as $index => $component)
      @includeFirst(
        [
          'components.' . $component["component"] . '.' . $skin . '.' . $component["style"],
          'components.' . $component["component"] . '.' . $skin . '.' . 'default',
          'components.' . $component["component"] . '.' . $component["style"],
          'components.' . $component["component"] . '.default'
        ], $component["data"])
  @endforeach
@endif
