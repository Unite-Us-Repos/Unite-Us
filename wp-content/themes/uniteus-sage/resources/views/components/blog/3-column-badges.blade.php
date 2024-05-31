@php
$is_header = isset($acf['components'][0]['cards']['is_header']) ? $acf['components'][0]['cards']['is_header'] : false;
$h_level = '2';
if ($is_header) {
  $h_level = '1';
}
@endphp
<section class="component-section" @if ($h_level === '1') style="padding-top:0 !important;" @endif>

    @if ($h_level === '1')

      <div class="relative">
        <div class="absolute inset-0 -mb-24 -mx-4 {{ $section_classes }}"></div>
        <div class="relative pt-20 lg:pt-32 pb-10 component-inner-section z-10">
          @if ($section['title'] || $section['description'])
            <div class="text-center max-w-5xl mx-auto">
              @if ($section['title'])
                <h{{ $h_level }}>{{ $section['title'] }}</h{{ $h_level }}>
              @endif
              @if ($section['description'])
                <div class="section-description max-w-5xl mx-auto text-xl">
                  {!! $section['description'] !!}
                </div>
              @endif
            </div>
          @endif
        </div>
      </div>

    @else

      <div class="component-inner-section">
        @if ($section['title'] || $section['desription'])
          <div class="text-center max-w-4xl mx-auto">
            @if ($section['title'])
              <h2>{{ $section['title'] }}</h2>
            @endif
            @if ($section['description'])
              {!! $section['description'] !!}
            @endif
          </div>
        @endif
      </div>

    @endif

    @if ($cards)
    <div class="component-inner-section">
      <div class="mt-10 max-w-lg mx-auto grid gap-8 lg:grid-cols-2 xl:grid-cols-3 lg:max-w-none">
        @foreach ($cards as $index => $card)
          <div class="relative flex flex-col rounded-lg shadow-lg overflow-hidden">
            <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>
            <div class="flex-shrink-0">
              <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1492724441997-5dc865305da7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80" alt="">
            </div>
            <div class="flex-1 bg-white flex flex-col justify-between pt-4">
              <div class="flex-1 px-6 py-10">
                @if ($card['subtitle'])
                <p class="leading-normal text-sm font-medium text-action mb-2">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    {!! $card['subtitle'] !!}
                  </span>
                </p>
                @endif

                <h3 class="mb-6">{!! $card['title'] !!}</h3>
                {!! $card['excerpt'] !!}
              </div>

              <div class="">
                @if ($card['buttons'])
                  @if (count($card['buttons']) > 1)
                    <div class="sm:grid sm:grid-cols-2">
                  @else
                    <div>
                  @endif
                  @foreach ($card['buttons'] as $index => $button)
                    @php
                      $isEven = false;
                      if ($index % 2 == 0) {
                        $isEven = true;
                      }
                    @endphp
                    @if ($button['link'])
                      <a
                        class="no-underline text-action font-semibold p-6 flex-1 block {{ $isEven ? 'bg-light hover:bg-blue-200' : 'bg-blue-200 hover:bg-blue-300' }}"
                        href="{{ $button['link'] }}"
                        @if ($button['is_blank']) target="_blank" @endif>
                        {{ $button['name'] }}<span aria-hidden="true" class="ml-1">&rarr;</span>
                      </a>
                    @else
                      <span class="p-6 block">&nbsp;ss</span>
                    @endif
                  @endforeach
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    @endif
</section>
