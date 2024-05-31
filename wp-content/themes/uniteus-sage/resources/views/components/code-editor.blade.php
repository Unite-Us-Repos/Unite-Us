<div class="bg-white py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
@if ($section['title'] || $section['description'])
  <div class="text-center max-w-4xl mx-auto">
    @if ($section['title'])
      <h2>{{ $section['title'] }}</h2>
    @endif
    @if ($section['description'])
    <div class="text-xl">
      {!! $section['description'] !!}
    </div>
    @endif
  </div>
@endif

{!! $code_editor !!}

</div>
