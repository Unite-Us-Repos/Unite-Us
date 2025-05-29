{{--
  Template Name: Studies and Data
--}}
{{--
  Template Post Type: page
--}}
@extends('layouts.app')
@section('content')
  <section class="bg-brand relative component-section">
    <div class="absolute inset-0 opacity-75 bg-electric-purple-overlay"></div>
    <div class="relative w-full">

      <div class="component-inner-section">
        <div class="relative max-w-3xl">
          <div class="mb-6">
            @php
              $data = [
                'color' => 'white'
              ];
            @endphp
            @include('ui.breadcrumbs.simple-with-slashes', $data)
          </div>
          <h1 class="text-4xl font-extrabold tracking-tight mb-0 text-white md:text-5xl lg:text-6xl">
            {!! get_the_title() !!}
          </h1>
        </div>
      </div>
    </div>
  </section>
  <section id="kh-top" class="component-section">

    <div class="component-inner-section">
      <div id="kh-search-results">

        {!! do_shortcode('[searchandfilter slug="studies-data" show="results"]') !!}

      </div>
    </div>
  </section>
@endsection
<script>
jQuery().ready(function($) {
  $(document).on("sf:ajaxfinish", ".searchandfilter", function() {
    lazyLoadInstance.update(); // refresh lazy loading on ajax call
  });
});
</script>
