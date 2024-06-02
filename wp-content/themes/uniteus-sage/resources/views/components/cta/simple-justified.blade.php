<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }}">
  <div class="component-inner-section @if ('dark' == $background['color']) is-dark-bg text-white @endif">
    <div class="md:grid md:grid-cols-12 gap-10">
      <div class="md:col-span-5">
      @if ($section['title'])
        <h2 class="text-center md:text-left md:mb-0">
          {!! $section['title'] !!}
        </h2>
      @endif
      </div>
      <div class="text-lg md:col-span-7 justify-end">
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
