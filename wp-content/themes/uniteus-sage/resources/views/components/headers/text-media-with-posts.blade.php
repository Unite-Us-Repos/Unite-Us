@php
$bg_color = isset($acf['components'][$index]['headers']['background']['color']) ? $acf['components'][$index]['headers']['background']['color'] : '';
$alignment = isset($acf['components'][$index]['headers']['alignment']) ? $acf['components'][$index]['headers']['alignment'] : 'default';
$manual = false;
@endphp
<style>
.heroImage {
  min-width: 268px;
  min-height: 268px;
}
</style>
<section class="bg-gray-800 relative component-section @if ($posts) padding-collapse-b @endif {{ $section_classes }}">
  <!-- Image Background Overlay -->
  @if ($background['image'])
  <div class="absolute inset-0">
      <img class="lazy w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="@asset('/images/lazy-placeholder.png')" data-src="{{ $background['image']['sizes']['2048x2048'] }}" alt="{{ $background['image']['alt'] }}">
  </div>
  @endif

  @if ($background['overlay'])
  <div class="absolute inset-0 bg-brand opacity-75"></div>
  @endif

    <div class="component-inner-section relative @if ($posts) pb-14 @endif">
      <div class="absolute flex-col justify-center z-20 left-12 mb-16 -bottom-72 lg:-bottom-56 xl:left-12 hidden md:flex">
        <svg width="28" height="146" viewBox="0 0 28 146" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M25.9512 132.309L13.9756 144.285M13.9756 144.285L1.99995 132.309M13.9756 144.285L13.9756 1.57643" stroke="#216CFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="flex flex-col items-center lg:flex-none lg:grid lg:grid-cols-2">
        <div class="relative order-2 lg:order-1">
          @if (!$hide_breadcrumbs)
            <div class="mb-9 sm:mb-10">
              @php
              $data = [
                'color' => 'white',
              ];
              @endphp
              @include('ui.breadcrumbs.simple-with-slashes', $data)
            </div>
          @endif

          @if ($section['subtitle'])
            <div class="@if ('light-gradient' === $bg_color) text-brand @else text-white @endif uppercase font-semibold text-xl mb-9 sm:mb-10">
              {!! $section['subtitle'] !!}
            </div>
          @endif
          <h1 class="text-4xl font-extrabold tracking-tight @if ('light-gradient' === $bg_color) text-brand @else text-white @endif md:text-5xl lg:text-6xl">
            {!! $section['title'] !!}
          </h1>

          @if ($section['description'])
            <div class="@if ('light-gradient' === $bg_color) text-brand @else text-white @endif text-xl">
              {!! $section['description'] !!}
            </div>
          @endif

          @if ($buttons)
            <div class="mt-8 flex relative z-10">
              @foreach ($buttons as $index => $button)
                @if ($index === 0)
                  <div class="inline-flex rounded-md shadow">
                    <a href="{{ $button['link']}}" class="button button-solid" @if ($button['is_blank']) target=="_blank" @endif>
                      {{ $button["name"]}}
                    </a>
                  </div>
                @else
                  <div class="ml-3 inline-flex">
                    <a href="{{ $button['link']}}" class="button button-hollow">
                      {{ $button["name"]}}
                    </a>
                  </div>
                @endif
              @endforeach
            </div>
          @endif
        </div>
        <div class="relative z-10 order-1 lg:order-2">
          @if ($widgets)
            @foreach ($widgets as $widget)
              @isset ($widget["acf_fc_layout"])
                @includeIf('widgets.' . str_replace('_', '-', $widget["acf_fc_layout"]))
              @endisset
            @endforeach
          @endif
        </div>
      </div>
    </div>



<!-- Overlapping cards -->
  @if ($posts)
   @includeIf('components.headers.content-tri-colored-cards')

   @if ($manual)
    <section class="max-w-7xl left-0 right-0 mx-auto absolute z-10 px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 gap-y-20 lg:grid-cols-3 lg:gap-y-0 lg:gap-x-8">
        @foreach ($posts as $index => $card)
          <div class="flex flex-col bg-white shadow-lg rounded-2xl">
            <div class="flex-1 relative p-8 px-6 md:px-8">
              <h3 class="text-action text-center text-2xl font-bold mb-0">
                @isset ($link)
                  <a href="">
                @endif
                {{ $card['title'] }}
                @isset ($link)
                  </a>
                @endisset
              </h3>
              @isset ($description)
                <p class="mt-4">Varius facilisi mauris sed sit. Non sed et duis dui leo, vulputate id malesuada non. Cras aliquet purus dui laoreet diam sed lacus, fames.</p>
              @endisset
            </div>
            @isset ($link)
            <div class="p-6 bg-light rounded-bl-2xl rounded-br-2xl md:px-8">
              <a href="#" class="text-action font-semibold">Contact us<span aria-hidden="true"> &rarr;</span></a>
            </div>
            @endisset
          </div>
        @endforeach
      </div>
    </section>
    @endif

  @endif
  </div>
  </section>
