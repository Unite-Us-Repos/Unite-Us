<section class="header-hero relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <!-- Overlay -->

  <div class="absolute inset-0">
    @if ($background['image'])
      <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    @endif
  </div>

  @if ($background['overlay'])
  <div class="absolute inset-0 bg-brand opacity-75"></div>
  @endif

  <div class="relative w-full text-left">

    <div class="component-inner-section">
      <div class="relative">
        @if (!$hide_breadcrumbs)
          <div class="mb-9 sm:mb-10">
            @php
            $bread_text = 'dark';
            if ($background['color'])
            $data = [
              'color' => $bread_text,
              'align' => 'center'
            ];
            @endphp
            @include('ui.breadcrumbs.simple-with-slashes', $data)
          </div>
        @endif
        @isset ($section['logo']['sizes'])
          <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
        @endisset

        @if ($section['subtitle'])
          <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
            {!! $section['subtitle'] !!}
          </div>
        @endif

          @if ($section['is_header'])
          <div class="mb-0 font-extrabold @if (($background['color'] == 'light') OR $background['color'] == 'light-gradient') text-brand @else text-white @endif text-5xl lg:text-6xl">
            {!! $section['title'] !!}
          </div>
          @else
          <h1 class="mb-0 font-extrabold @if (($background['color'] == 'light') OR $background['color'] == 'light-gradient') text-brand @else text-white @endif text-5xl lg:text-6xl">
            {!! $section['title'] !!}
          </h1>
          @endif

        
      </div>

      <div class="relative max-w-2xl mt-10">
        @if ($section['description'])
          <div class="@if (($background['color'] == 'light') OR $background['color'] == 'light-gradient') text-brand @else text-white @endif text-lg font-semibold">
            {!! $section['description'] !!}
          </div>
        @endif
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-center',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
    </div>
    <div class="p-8"></div>
  </div>
</section>


@if ($cta_cards)
  <section class="relative component-section padding-collapse-t -mt-16">
  <div class="component-inner-section">
    <div class="mx-auto flex flex-col lg:grid gap-6 lg:grid-cols-12">

    @foreach ($cta_cards as $card)

      @if ($loop->first)
      <div class="col-span-8 relative h-full flex flex-col bg-light rounded-lg shadow-lg overflow-hidden pt-4">
        <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>

        <div class="flex flex-col md:grid grid-cols-12">
          <div class="col-span-8 order-2 md:order-1">
            <div class="flex-1 flex flex-col justify-between">
              <div class="flex-1 px-14 py-10 text-center md:text-left">

                <h3 class="mb-6 text-2xl sm:text-3xl">{!! $card['title'] !!}</h3>
                <div class="text-lg sm:text-xl">
                  {!! $card['description'] !!}

                  @if ($card['button'])
                    <p>
                      <a href="{{ $card['button']['link'] }}" @if ($card['button']['is_blank'] == 'is_blank') target="_blank" @endif class="button  flex items-center gap-3  button-solid" style="font-weight:400 !important;text-decoration:none !important;">
                        {{ $card['button']['text'] }}
                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g id="External link">
                          <g id="Icon">
                          <path d="M11 3.9375C10.4477 3.9375 10 4.38522 10 4.9375C10 5.48978 10.4477 5.9375 11 5.9375H13.5858L7.29289 12.2304C6.90237 12.6209 6.90237 13.2541 7.29289 13.6446C7.68342 14.0351 8.31658 14.0351 8.70711 13.6446L15 7.35171V9.9375C15 10.4898 15.4477 10.9375 16 10.9375C16.5523 10.9375 17 10.4898 17 9.9375V4.9375C17 4.38522 16.5523 3.9375 16 3.9375H11Z" fill="#3B8BCA"/>
                          <path d="M5 5.9375C3.89543 5.9375 3 6.83293 3 7.9375V15.9375C3 17.0421 3.89543 17.9375 5 17.9375H13C14.1046 17.9375 15 17.0421 15 15.9375V12.9375C15 12.3852 14.5523 11.9375 14 11.9375C13.4477 11.9375 13 12.3852 13 12.9375V15.9375H5V7.9375L8 7.9375C8.55228 7.9375 9 7.48978 9 6.9375C9 6.38522 8.55228 5.9375 8 5.9375H5Z" fill="#3B8BCA"/>
                          </g>
                          </g>
                        </svg>
                      </a>
                    </p>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="col-span-4 flex content-center items-center  py-10 pb-0 md:pb-10 md:pr-6 order-1 md:order-2">

            <img class="max-w-xs w-full h-auto mx-auto" src="https://uniteustailstg.wpengine.com/wp-content/uploads/2023/08/access-unite-us-learn.png" alt="" />
          </div>
        </div>
      </div>
      @endif


      @if ($loop->last)
      <div class="col-span-4 relative h-full flex flex-col bg-brand rounded-lg shadow-lg overflow-hidden">
        <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>
        <div class=text-white flex-1 flex flex-col justify-between pt-4">
          <div class="flex-1 px-14 py-10 text-center md:text-left">

            <h3 class="mb-6 text-2xl">{!! $card['title'] !!}</h3>
            <div class="text-base">
              {!! $card['description'] !!}
              @if ($card['button'])
                <p>
                  <a href="{{ $card['button']['link'] }}" @if ($card['button']['is_blank'] == 'is_blank') target="_blank" @endif class="button  flex items-center gap-3  button-solid" style="font-weight:400 !important;text-decoration:none !important;">
                    {{ $card['button']['text'] }}
                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g id="Add user">
                      <g id="Icon">
                      <path d="M8 9.9375C9.65685 9.9375 11 8.59435 11 6.9375C11 5.28065 9.65685 3.9375 8 3.9375C6.34315 3.9375 5 5.28065 5 6.9375C5 8.59435 6.34315 9.9375 8 9.9375Z" fill="#3B8BCA"/>
                      <path d="M8 11.9375C11.3137 11.9375 14 14.6238 14 17.9375H2C2 14.6238 4.68629 11.9375 8 11.9375Z" fill="#3B8BCA"/>
                      <path d="M16 7.9375C16 7.38522 15.5523 6.9375 15 6.9375C14.4477 6.9375 14 7.38522 14 7.9375V8.9375H13C12.4477 8.9375 12 9.38521 12 9.9375C12 10.4898 12.4477 10.9375 13 10.9375H14V11.9375C14 12.4898 14.4477 12.9375 15 12.9375C15.5523 12.9375 16 12.4898 16 11.9375V10.9375H17C17.5523 10.9375 18 10.4898 18 9.9375C18 9.38522 17.5523 8.9375 17 8.9375H16V7.9375Z" fill="#3B8BCA"/>
                      </g>
                      </g>
                    </svg>
                  </a>
                </p>
              @endif
            </div>
          </div>

        </div>
      </div>
      @endif
      @endforeach

    </div>
  </div>
  </section>
@endif
