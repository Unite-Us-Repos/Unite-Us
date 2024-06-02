@php
  $form_id = get_query_var('get-help');
  if (empty($form_id)) {
    $form_id = 0;
  }
  $form_content = '';
@endphp

@if ($isGetHelp)
  @include('partials.content-single-network-form')
@else

  {{-- Dynamically load ACF components --}}
  @if ($flexibleComponents)
    @foreach ($flexibleComponents as $index => $component)
        @includeFirst(['components.' . $component["component"] . '.' . $component["style"], 'components.' . $component["component"] . '.default'], $component["data"])
        {{-- Temporarily Inject Banner --}}
    @endforeach
  @endif

@endif
