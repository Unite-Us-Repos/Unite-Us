@php
  if (!isset($acf)) {
          $acf = [];
  }
  if (!isset($index)) {
          $index = 0;
  }
  @endphp
  @php
  $case_type = $section['case_type'] ?? 'Uppercase';

  // Define case type classes
  $case_class = '';
  switch ($case_type) {
      case 'Uppercase':
          $case_class = 'uppercase';
          break;
      case 'Lowercase':
          $case_class = 'lowercase';
          break;
      case 'Capitalize':
          $case_class = 'capitalize';
          break;
      case 'Typed':
          $case_class = 'typed';
          break;
  }
  @endphp
  @if ($background['has_divider'])
    @includeIf('dividers.waves')
  @endif

  <section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
    @if ($background['image'])
      <div class="absolute inset-0">
        <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
          srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
          sizes="(max-width: 600px) 300px, 1024px"
          alt="{{ $background['image']['alt'] }}">
      </div>
    @endif

    @if ($background['overlay'])
      @if ($background['overlay_style'] == 'gradient-ltr')
        <div class="absolute inset-0" style="background: linear-gradient(to right, #0B1538 1%, #0B1538 5%, rgba(255, 255, 255, 0.5) 100%);">
          <div class="absolute inset-0">
            <svg width="632" height="448" viewBox="0 0 632 448" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_1_1025)">
              <g filter="url(#filter0_f_1_1025)">
              <circle cx="175.509" cy="-194.8" r="218.052" transform="rotate(14.5344 175.509 -194.8)" fill="#216CFF"/>
              </g>
              <g filter="url(#filter1_f_1_1025)">
              <circle cx="-35.5079" cy="-111.797" r="218.052" transform="rotate(14.5344 -35.5079 -111.797)" fill="#9643FF"/>
              </g>
              </g>
              <defs>
              <filter id="filter0_f_1_1025" x="-292.597" y="-662.906" width="936.211" height="936.211" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
              <feFlood flood-opacity="0" result="BackgroundImageFix"/>
              <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
              <feGaussianBlur stdDeviation="125" result="effect1_foregroundBlur_1_1025"/>
              </filter>
              <filter id="filter1_f_1_1025" x="-503.613" y="-579.902" width="936.211" height="936.211" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
              <feFlood flood-opacity="0" result="BackgroundImageFix"/>
              <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
              <feGaussianBlur stdDeviation="125" result="effect1_foregroundBlur_1_1025"/>
              </filter>
              <clipPath id="clip0_1_1025">
              <rect width="632" height="448" fill="white"/>
              </clipPath>
              </defs>
            </svg>
          </div>
        </div>
        @else
        <div class="absolute inset-0 bg-brand opacity-75"></div>
      @endif
    @endif
    <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif @if ($background['divider_bottom']) pb-10 @endif">

      <div class="relative z-10 md:relative flex flex-col lg:grid lg:grid-cols-2 gap-10 lg:gap-40">

        <div class="@if ($background['color'] == 'dark') text-white @endif lg:col-span-1 @if ('center' == $vertical_alignment) flex flex-col justify-center @endif text-lg">
          @if ($section['subtitle'])
            @if ($section['subtitle_display_as_pill'])
              <span class="grow-0 @if ($background['color'] == 'dark') bg-white bg-opacity-10 text-action-light-blue @else text-action @if ($background['color'] == 'light-gradient') bg-white @else bg-light mix-blend-multiply @endif @endif text-sm py-1 px-4 inline-block mb-6 rounded-full {{ $case_class }}">
            @else
              <span class="subtitle block pb-4 {{ $case_class }}">
            @endif
              {!! $section['subtitle'] !!}
              </span>
          @endif
          @isset ($section['logo']['sizes'])
            <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
          @endisset
          @if ($section['title'])

          @if ($section['is_header'] === 'h1')
          <h1 class="hfont-semibold mb-6 width-28 h2">{!! $section['title'] !!}</h1>
          @elseif ($section['is_header'] === 'h2')
              <h2 class="font-semibold mb-6 width-28 h2">{!! $section['title'] !!}</h2>
          @else
              <div class="font-semibold mb-6 width-28 h2">{!! $section['title'] !!}</div>
          @endif

          @endif

          @if ($section['description'])
            <div class="description">
              {!! $section['description'] !!}
            </div>
          @endif

          @isset ($extra_content)
            @if ('testimonial' == $extra_content)
              @if ($testimonial['quote'])
                <blockquote style="border: none;padding: 0;">
                  <div class="text-2xl text-brand text-center italic p-3 mt-6">
                    {!! $testimonial['quote'] !!}
                  </div>
                  <p class="text-brand font-semibold text-base text-center not-italic mt-3">{!! $testimonial['name'] !!} @if ($testimonial['title']), {!! $testimonial['title'] !!} @endif</p>
                </blockquote>
              @endif
            @endif

            @if ('mini-cards' == $extra_content)
              @if ($mini_cards)
                <div class="grid grid-cols-1 sm:grid-cols-2 mt-10 gap-3">
                  @foreach ($mini_cards as $card)
                    <div class="relative text-center sm:text-left border border-blue-200 rounded-xl p-6 group">
                      <div class="relative z-10">
                      <h2 class="font-extrabold text-3xl text-action mb-0 leading-10">{!! $card['title'] !!}</h2>
                      <div>{!! $card['description'] !!}</div>
                      </div>
                      <div class="absolute inset-0 mini-card-grad z-0 rounded-xl opacity-0 group-hover:opacity-100">

                      </div>
                    </div>
                  @endforeach
                </div>
              @endif
            @endif
          @endisset

          @if ($buttons)
            @php
              $data = [
                'justify' => 'justify-start',
              ];
            @endphp
            @include('components.action-buttons', $data)
          @endif
        </div>
        <div class="flex flex-col lg:col-span-1 @if ('center' == $vertical_alignment) justify-center @endif relative">

          @if ($mask_image)
          <div class="relative max-w-lg mx-auto" @if ($featured_image) style="background: url({{ $featured_image['sizes']['medium_large'] }}) no-repeat center center;background-size: 60%;" @endif>
            <img class="lazy" data-src="@asset('/images/network-mask-1.png')" alt="" />
          </div>
          @else
            @isset ($featured_image['sizes'])
              <img class="lazy rounded-lg w-full @if ($set_max_width_height) h-full aspect-square object-contain max-h-96 max-w-sm mx-auto @else max-w-md mx-auto lg:max-w-3xl @endif" data-src="@if ('image/gif' == wp_get_image_mime($featured_image['url'])) {{ $featured_image['url'] }} @else {{ $featured_image['sizes']['medium_large'] }} @endif" alt="{{ $featured_image['alt'] }}" />
            @endisset
          @endif

          @isset ($embeds)
            @if (!empty($embeds))
              <div class="rounded-lg responsive-embed">
                {!! $embeds !!}
              </div>
            @endif
          @endisset

          @isset ($code_editor)
            @if (!empty($code_editor))
              <div>
                {!! $code_editor !!}
              </div>
            @endif
          @endisset

          @isset ($form_code)
            @if (!empty($form_code))
              <div id="formIframe" class="rounded-md p-6 sm:p-10 bg-light-gradient shadow-md">
                <div class="flex justify-between items-center mb-2">
                  <h3 class="text-xl mb-0 font-medium capitalize">
                    @if ($form_bolded_title)
                      <span class="font-bold">{{ $form_bolded_title }} </span>
                    @endif
                    {{ $form_title }}
                  </h3>
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                    <path d="M12.0003 16.3018H20.0003M12.0003 21.6351H20.0003M22.667 28.3018H9.33366C7.8609 28.3018 6.66699 27.1079 6.66699 25.6351V6.96842C6.66699 5.49567 7.8609 4.30176 9.33366 4.30176H16.7814C17.135 4.30176 17.4741 4.44223 17.7242 4.69228L24.9431 11.9112C25.1932 12.1613 25.3337 12.5004 25.3337 12.854V25.6351C25.3337 27.1078 24.1398 28.3018 22.667 28.3018Z" stroke="#C7D8E8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                  @if ($form_description)
                  <p class="mb-6">{{ $form_description }}</p>
                  @endif
                {!! $form_code !!}
              </div>
            @endif
          @endisset


        </div>
      </div>
    </div>
  </section>
  @if ($background['divider_bottom'])
  <div class="-mt-6 md:-mt-10 relative z-10 inline-block w-full">
  <svg class="w-full h-auto" width="1359" height="81" viewBox="0 0 1359 81" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 10.1615L56.625 16.0067C113.25 21.852 226.5 33.5425 339.75 27.6972C453 21.852 566.25 -1.529 679.5 0.419418C792.75 2.36783 906 29.6456 1019.25 35.4909C1132.5 41.3361 1245.75 25.7488 1302.37 17.9552L1359 10.1615V80.3044H1302.37C1245.75 80.3044 1132.5 80.3044 1019.25 80.3044C906 80.3044 792.75 80.3044 679.5 80.3044C566.25 80.3044 453 80.3044 339.75 80.3044C226.5 80.3044 113.25 80.3044 56.625 80.3044H0V10.1615Z" fill="white"/>
  </svg>
  </div>
  @endif
  {{-- @if ($background['divider_bottom'])
    @includeIf('dividers.waves-bottom')
  @endif --}}
