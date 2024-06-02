{{--
  Template Name: Journey Page
--}}

@extends('layouts.app')

@section('content')
  @if (post_password_required())
    @include('partials.content-password-protected')
  @else
    @while(have_posts()) @php(the_post())
      @include('partials.content-page-journey')
    @endwhile
  @endif
@endsection
