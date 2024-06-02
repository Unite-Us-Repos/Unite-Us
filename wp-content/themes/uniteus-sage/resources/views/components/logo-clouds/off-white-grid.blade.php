<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section">
  <div class="component-inner-section">
    @if ($section['title'])
      <h2 class="text-center">
        {{ $section['title'] }}
      </h2>
    @endif
    <div class="@if ($is_grayscale) grayscale opacity-70 @endif flex lg:gap-5 flex-wrap lg:flex-nowrap justify-center lg:justify-between items-center">
      @if ($logos)
        @foreach ($logos as $logo)
          <div class="basis-1/2 md:basis-1/3 xl:basis-auto @if ('auto' != $columns) @if ($columns) lg:basis-{{ $columns }} @else sm:basis-1/4 @endif @endif">

          <div class="flex justify-center items-center @if (!$is_grayscale) py-8 px-8 bg-light @endif rounded-lg">
            @if ($logo['link'])
              <a
                href="{{ $logo['link']}}"
              >
            @endif
            @if ($logo['image'])
              <img
                class="@if (!$is_grayscale) max-h-12 @else max-h-16 @endif"
                src="{{ $logo['image']['sizes']['medium'] }}"
                alt="{{ $logo['image']['alt'] }}"
              />
            @endif
            @if ($logo['link'])
              </a>
            @endif
          </div>
        @endforeach
      @endif
    </div>
  </div>
</section>
