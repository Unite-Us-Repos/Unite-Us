<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }}">
  <div class="component-inner-section @if ('dark' == $background['color']) is-dark-bg text-white @endif">
    <div class="flex flex-col md:flex-row md:justify-between gap-10">
      <div class="">
      @if ($section['title'])
        <h2 class="text-center md:text-left mb-0">
          {!! $section['title'] !!}
        </h2>
      @endif
      </div>
      <div class="text-lg flex-shrink-0 justify-end">
        {!! $section['description'] !!}
        @if ($buttons)
          @php
          $mt = '';
          if (!$section['description'] OR (!$section['title'] && !$section['description'])) {
            $mt = 'mt-0';
          }
          if (!$section['description']) {
            $justify = 'justify-end';
          } else {
            $justify = 'justify-start';
          }
          @endphp
          @include('components.action-buttons', ['style', 'simple-justified', 'justify' => $justify, 'mt' => $mt])
        @endif
      </div>
    </div>
  </div>
</section>
