<section class="component-section">
  <div class="component-inner-section">
    @if ($section['title'] || $section['description'])
      <div class="text-center max-w-5xl mx-auto">
        @if ($section['title'])
          <h2>{{ $section['title'] }}</h2>
        @endif
        @if ($section['description'])
          {!! $section['description'] !!}
        @endif
      </div>
    @endif

    @if ($cards)
      <div class="mt-10 max-w-lg mx-auto grid gap-8 lg:grid-cols-3 lg:max-w-none">
        @foreach ($cards as $index => $card)
          <div class="relative flex flex-col rounded-lg shadow-lg overflow-hidden">
            <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>
            <div class="flex-1 bg-white flex flex-col justify-between pt-4">
              <div class="flex-1 px-6 py-10">
                @if ($card['subtitle'])
                <p class="leading-normal text-sm font-medium text-action mb-2">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">{{ $card['subtitle'] }}</span>
                </p>
                @endif

                <h3 class="mb-6">{!! $card['title'] !!}</h3>
                {!! $card['excerpt'] !!}
              </div>


              <div class="bg-light hover:bg-blue-200">
                @if ($card['link'])
                  <a class="no-underline text-action font-semibold p-6 block" href="{{ $card['link'] }}" class="flex items-center text-action font-semibold" aria-label="Learn More - {{ $card['title'] }}">Learn More<span aria-hidden="true" class="ml-1"> &rarr;</span></a>
                @else
                  <span class="p-6 block">&nbsp;</span>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
