{{--
  Template Name: Event Landing Page
  Template Post Type: page, 1c
--}}

@extends('layouts.app')

@section('content')
  @if (post_password_required())
    @include('partials.content-password-protected')
  @else
    @while(have_posts()) @php(the_post())
      @includeIf('partials.content-page-event')
    @endwhile
  @endif
@endsection
