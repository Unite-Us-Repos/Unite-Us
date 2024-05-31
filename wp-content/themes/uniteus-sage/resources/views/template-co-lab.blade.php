{{--
  Template Name: Co-Lab
--}}

@extends('layouts.app')
<link rel="preconnect"href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link fetchpriority="low" rel="preload" href="https://fonts.googleapis.com/css2?family=Space+Mono&family=Syne:wght@400;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Space+Mono&family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
</noscript>
@section('content')
  @if (post_password_required())
    @include('partials.content-password-protected')
  @else
    @while(have_posts()) @php(the_post())
      @include('partials.content-page-flexible')
    @endwhile
  @endif
@endsection
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var image = document.getElementsByClassName('simple-parallax');
    new simpleParallax(image, {
      delay: 0,
      orientation: 'down',
      scale: 1.5,
      transition: 'ease-in-out',
      overflow: true,
    });
    var image = document.getElementsByClassName('simple-parallax-hero');
    new simpleParallax(image, {
      delay: 0,
      orientation: 'up',
      scale: 1.5,
      transition: 'ease-in-out',
      overflow: false,
    });
  });
</script>
