{{--
  Template Name: Thank You Page
--}}

@extends('layouts.app')

@section('content')
  @if (post_password_required())
    @include('partials.content-password-protected')
  @else
    @while(have_posts()) @php(the_post())
      @include('partials.content-page-thank-you')
      @include('partials.content-page-flexible-thank-you')
    @endwhile
  @endif
@endsection
