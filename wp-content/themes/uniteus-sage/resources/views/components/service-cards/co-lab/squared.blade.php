@php
  $isCenter = ('center' == $section["alignment"]) ? true : false;
@endphp
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">

    <div @class([
      'text-center' => $isCenter,
      'flex flex-col md:grid md:grid-cols-12 gap-3 mb-5' => !$isCenter,
      ])>

      <div class="@if (!$isCenter) md:col-span-4 @endif">
        @if ($section['subtitle'])
          <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
            {{ $section['subtitle'] }}
          </span>
        @endif

        @if ($section['title'])
          <h2 class="mb-6 font-syne font-bold">
            {!! $section['title'] !!}
          </h2>
        @endif
      </div>

      @isset ($section['description'])
        <div class="@if (!$isCenter) md:col-span-8 @endif mb-10 font-space text-lg font-normal max-w-4xl mx-auto">
          {!! $section['description'] !!}
        </div>
      @endisset
    </div>

    <div class="flex flex-col flex-wrap justify-center sm:flex-row -mx-3">
      @foreach ($cards as $card)
        <div class="md:w-1/2 lg:w-1/3">
          <div class="p-3">
            <div class="relative flex items-end rounded-lg overflow-hidden group service-card">

              <div
                class="card-overlay absolute inset-0 rounded-lg bg-white border border-redish group-hover:border-none group-hover:opacity-80 group-hover:bg-dark-blue group-hover:transition-none z-10">
              </div>

              @if ($card['bg_image'])
              <div style="z-index: 1;" class="absolute inset-0 group-hover:bg-dark-blue">
                  <img class="lazy w-full h-full object-cover transition-none opacity-0 mix-blend-luminosity group-hover:opacity-60 group-hover:transition-none"
                    data-src="{{ $card['bg_image']['sizes']['medium_large'] }}"
                    alt="">
              </div>
              @endif
              <div class="relative pointer-events-none z-10 w-full px-8 py-10">

                  <div class="relative text-brand group-hover:text-white">

                    <div class="w-12 h-12 mb-6 flex justify-center items-center">
                      <span class="text-redish">
                        @isset ($card['icon'])
                          <img class="h-12 w-12" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                        @endisset
                      </span>
                    </div>
                    <h3 class="font-syne text-2xl mb-3">{!! $card['title'] !!}</h3>
                    <div class="font-space text-sm">{!! wpautop($card['description']) !!}</div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
