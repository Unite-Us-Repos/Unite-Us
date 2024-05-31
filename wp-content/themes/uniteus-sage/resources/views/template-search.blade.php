{{--
  Template Name: Search
--}}

@extends('layouts.app')

@section('content')
  <section class="bg-gray-800 relative component-section">
    <div class="absolute inset-0 bg-brand opacity-75"></div>
    <div class="relative w-full">
      <div class="component-inner-section">
        <div class="relative max-w-3xl">
          <h1 class="text-4xl font-extrabold tracking-tight mb-0 text-white md:text-5xl lg:text-6xl">
            {!! get_the_title() !!}
          </h1>
        </div>
      </div>
    </div>
  </section>

  <section id="kh-top" class="component-section">
    <div class="component-inner-section">
      <div id="search-filters" class="ajax-filters search-filters relative z-20 mb-9">
        @php
          echo do_shortcode('[searchandfilter slug="site-search"]');
        @endphp
      </div>

      <div id="kh-search-results">
        {!! do_shortcode('[searchandfilter slug="site-search" show="results"]') !!}
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
