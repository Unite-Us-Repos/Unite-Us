@php (the_content()) @endphp
@php
$skin = str_replace('.blade.php', '', get_page_template_slug());
$skin = str_replace('template-', '', $skin);
$page_slug = get_query_var('page_slug');
if ($page_slug == 'demo') {
  $page_slug = '';
}
@endphp
{{-- Dynamically load ACF components --}}
@if ($flexibleComponents)
  @foreach ($flexibleComponents as $index => $component)
      @if (($page_slug) && (strstr($component['data']['section']['id'], 'gated')))
      @includeFirst(
        [
          'components.' . $component["component"] . '.' . $skin . '.' . $component["style"],
          'components.' . $component["component"] . '.' . $skin . '.' . 'default',
          'components.' . $component["component"] . '.' . $component["style"],
          'components.' . $component["component"] . '.default'
        ], $component["data"])
      @endif


      @if ((!$page_slug) && (!strstr($component['data']['section']['id'], 'gated')))
      @includeFirst(
        [
          'components.' . $component["component"] . '.' . $skin . '.' . $component["style"],
          'components.' . $component["component"] . '.' . $skin . '.' . 'default',
          'components.' . $component["component"] . '.' . $component["style"],
          'components.' . $component["component"] . '.default'
        ], $component["data"])
      @endif
  @endforeach
@endif
