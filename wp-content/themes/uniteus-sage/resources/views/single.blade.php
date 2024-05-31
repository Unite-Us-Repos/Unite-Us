@php
if (!is_array($acf)) {
  $acf = [];
}
$page_layout = get_post_type();

if (isset($acf['layout'])) {
  $page_layout = str_replace('_', '-', $acf['layout']);
}
@endphp
@extends('layouts.app')
@section('content')
  @if (post_password_required())
    @include('partials.content-password-protected')
  @else
    @while(have_posts()) @php(the_post())
      @includeFirst(['partials.content-single-' . $page_layout, 'partials.content-single'], $acf)
    @endwhile
  @endif
@endsection
