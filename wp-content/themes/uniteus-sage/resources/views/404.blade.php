@extends('layouts.app')

@section('content')
  @if (! have_posts())
    @php
    $data = get_field('error_404', 'options');

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
        <p>We can’t find the page you were looking for</p>
      </div>
    </section>
    @endif

  @endif
@endsection
