<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">
    <div class="grid-cards grid-cards-{{ $style }} flex flex-col md:grid md:grid-cols-12 gap-8 w-full">
      @foreach ($cards as $card)

        <div
          @if ($card['id']) id="{{ ($card['id']) }}" @endif
          class="grid-card col-span-{{ $card['acfe_layout_col'] }}
            relative flex flex-col justify-end
            bg-light
            border-2 border-light
            rounded-lg overflow-hidden
            @if ($style == 'default') p-8 @endif
            "
          style="
          @isset($card['card_color']['color']) background-color: {{ $card['card_color']['color'] }}; border-color: {{ $card['card_color']['color'] }}; @endisset
          @isset($card['card_text_color']['color']) color: {{ $card['card_text_color']['color'] }}; @endisset
          ">

          @if (str_contains($card['card_layout'], 'two-col'))
          <div class="flex flex-col lg:grid grid-cols-2 gap-16 p-8 lg:p-16">
            <div class="relative z-20
              @if (str_contains($card['card_layout'], 'text-image')) lg:order-2 @endif
              ">
              @if ($card['card_image'])
                <img class="lazy w-full h-auto max-w-xl mx-auto"
                data-src="{{ $card['card_image']['sizes']['large'] }}"
                alt="{{ $card['card_image']['alt'] }}">
              @endif
            </div>
          @endif
          <div>
          <div class="relative z-20
            @if ($style == 'default' && !str_contains($card['card_layout'], 'two-col')) sm:mt-32 sm:pt-32 mt-36 pt-36 @endif
            @if ($style == 'solutions' && !str_contains($card['card_layout'], 'two-col')) p-8 lg:p-16 @endif">
          @if ($card['pill'])
            <div
              class="text-blue-600 font-semibold bg-white mix-blend-multiply text-sm py-1 px-4 inline-flex justify-center items-center gap-2 mb-3 rounded-full"
              @isset ($card['pill_color']['color']) style="background-color: {{ $card['pill_color']['color'] }}; @endisset
              @isset($card['pill_text_color']['color']) color: {{ $card['pill_text_color']['color'] }}; @endif
              ">
              <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_f_26446_7304)">
                <path d="M14.527 3.59107C12.3173 3.15964 11.8875 2.72981 11.4561 0.520134C11.4445 0.460737 11.3595 0.460737 11.3479 0.520134C10.9165 2.72981 10.4866 3.15964 8.27697 3.59107C8.21757 3.60268 8.21757 3.68762 8.27697 3.69923C10.4866 4.13065 10.9165 4.56049 11.3479 6.77016C11.3595 6.82956 11.4445 6.82956 11.4561 6.77016C11.8875 4.56049 12.3173 4.13065 14.527 3.69923C14.5864 3.68762 14.5864 3.60268 14.527 3.59107Z" fill="white"/>
                <path d="M15.3356 10.7547C14.0637 10.5068 13.8183 10.2615 13.5704 8.9895C13.5641 8.95662 13.5169 8.95662 13.5105 8.9895C13.2628 10.2614 13.0174 10.5068 11.7454 10.7547C11.7125 10.761 11.7125 10.8081 11.7454 10.8146C13.0173 11.0623 13.2627 11.3077 13.5105 12.5797C13.5169 12.6126 13.5639 12.6126 13.5704 12.5797C13.8182 11.3078 14.0636 11.0624 15.3356 10.8146C15.3685 10.8082 15.3685 10.761 15.3356 10.7547Z" fill="white"/>
                <path d="M11.3033 8.27876C7.52154 7.52151 6.72151 6.7216 5.96426 2.93974C5.93517 2.79418 5.72728 2.79418 5.69819 2.93974C4.94094 6.72148 4.14104 7.52151 0.35917 8.27876C0.21361 8.30785 0.21361 8.51574 0.35917 8.54483C4.14091 9.30208 4.94094 10.102 5.69819 13.8839C5.72728 14.0294 5.93517 14.0294 5.96426 13.8839C6.72151 10.1021 7.52142 9.30208 11.3033 8.54483C11.4488 8.51574 11.4488 8.30785 11.3033 8.27876Z" fill="white"/>
                </g>
                <defs>
                <filter id="filter0_f_26446_7304" x="0.138322" y="0.363908" width="15.3327" height="13.7407" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                <feGaussianBlur stdDeviation="0.055839" result="effect1_foregroundBlur_26446_7304"/>
                </filter>
                </defs>
              </svg>

              <span>{{ $card['pill'] }}</span>
            </div>
          @endif

          @if ($card['title'])
            <h2 class="text-2xl !font-normal mb-4">{!! $card['title'] !!}</h2>
          @endif
            <div style="color: {{ isset($card['card_text_color']['color']) ? $card['card_text_color']['color'] : 'inherit' }}">
              {!! $card['description'] !!}
            </div>
          </div>
          @if ($card['background_image'])
            <div class="absolute inset-0">
              @if ($card['mobile_background_image'])
                <img class="lazy w-full sm:hidden md:block lg:hidden h-full object-cover
                  @if ($style == 'default') object-top @endif
                  @if ($style == 'solutions') object-center @endif"
                data-src="{{ $card['mobile_background_image']['sizes']['large'] }}"
                alt="{{ $card['mobile_background_image']['alt'] }}">
              @endif
              <img class="lazy w-full @if ($card['mobile_background_image']) hidden sm:block md:hidden lg:block @endif h-full object-cover object-left-top" data-src="{{ $card['background_image']['sizes']['2048x2048'] }}" alt="{{ $card['background_image']['alt'] }}">
            </div>
          @endif

           @if (str_contains($card['card_layout'], 'two-col'))
            </div>
          @endif
        </div>

        @if ($card['key_points'])
          <div class="relative mt-8 px-8 sm:px-0 lg:px-8 z-20">
            @include('components.grid-cards.partials.key-points', ['key_points' => $card['key_points']])
          </div>
        @endif
      </div>

      @endforeach
  </div>
</section>
