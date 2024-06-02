{{--
  Template Name: Error 5xx
--}}

@extends('layouts.5xx')

@section('content')
  @if (have_posts())
    @php
    $data = get_field('error_5xx', 'options');

    @endphp

    @if ($data)
      @php
        $component = array_key_first($data);
        $data[$component]['section_classes'] = '';
      @endphp
      @includeIf('components.' . $component . '.' . $data[$component]['style'], $data[$component])
    @else
    <section class="component-section">
      <div class="component-inner-section">
        <h1>Oops!</h1>
        <p>This page is down momentarily, but our team is working on it and we should be back shortly. You can check back here for updates.</p>
      </div>
    </section>
    @endif

  @endif
@endsection
