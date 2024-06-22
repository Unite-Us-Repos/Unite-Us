<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="relative component-section {{ $section_classes }}">
  <div class="absolute inset-0">
    @if ($background['image'])
      <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    @endif
  </div>
  <div class="relative component-inner-section @if ('dark' == $background['color']) is-dark-bg text-white @endif">
    <div class="md:grid md:grid-cols-12 gap-10">
      <div class="md:col-span-5">
      @if ($section['title'])
        <h2 class="text-center md:text-left md:mb-0 @if($background['image']) text-white @endif">
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
