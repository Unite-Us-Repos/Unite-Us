<style>
  .service-icon-cards{min-height:240px}
  .service-icon-cards:hover .acf-icon-action{
    filter:brightness(0) saturate(100%) invert(100%) sepia(3%) saturate(5310%) hue-rotate(306deg) brightness(112%) contrast(102%)!important
  }

  /* Slider visuals, scoped to this component */
  .icon-slider .swiper{overflow:visible}                 /* allow off-right peek */
  .icon-slider .swiper-wrapper{height:auto!important;align-items:stretch!important}
  .icon-slider .swiper-slide{display:flex!important;height:auto!important}
</style>

@php
$s_settings = [
  'collapse_padding' => false,
  'fullscreen' => '',
];
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'] ?? $s_settings;

$card_count = is_countable($cards ?? []) ? count($cards ?? []) : 0;
$is_swiper = $card_count > 3; // slider only when more than 3 cards
@endphp

@if (!empty($background['has_divider']))
  @includeIf('dividers.waves')
@endif

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="relative @if (($background['color'] ?? '') == 'dark') text-white @endif icon-carousel component-section {{ $section_classes ?? '' }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] }} @endif">

  {{-- Headings --}}
  @if (($section["alignment"] ?? '') === 'center')
    <div class="component-inner-section">
      <div class="text-center mb-7">
        @if (!empty($section['subtitle']))
          @if (!empty($section['subtitle_display_as_pill']))
            <span class="@if (($background['color'] ?? '') === 'dark') bg-brand text-action-light-blue @else text-action @if (($background['color'] ?? '') === 'light-gradient') bg-white @else bg-light mix-blend-multiply @endif @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
          @else
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
          @endif
              {{ $section['subtitle'] }}
            </span>
        @endif
        @if (!empty($section['title'])) <h2 class="mb-6">{!! $section['title'] !!}</h2> @endif
        @if (!empty($section['description'])) <div class="text-lg"><div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div></div> @endif
        @if (!empty($buttons))
          @php $data = ['justify' => 'justify-center','mt' => 'mt-6']; @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
    </div>

  @elseif (($section["alignment"] ?? '') === 'left')
    <div class="component-inner-section">
      <div class="mb-6">
        @if (!empty($section['subtitle'])) <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">{{ $section['subtitle'] }}</span> @endif
        @if (!empty($section['title'])) <h2 class="mb-6">{!! $section['title'] !!}</h2> @endif
        @if (!empty($section['description'])) <div class="text-lg">{!! $section['description'] !!}</div> @endif
      </div>
    </div>

  @else
    <div class="component-inner-section">
      <div class="flex flex-col md:grid md:grid-cols-12 gap-3 mb-5">
        <div class="md:col-span-4">
          @if (!empty($section['subtitle'])) <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">{{ $section['subtitle'] }}</span> @endif
          @if (!empty($section['title'])) <h2 class="mb-0">{!! $section['title'] !!}</h2> @endif
        </div>
        <div class="md:col-span-8 text-lg">{!! $section['description'] ?? '' !!}</div>
      </div>
    </div>
  @endif

  {{-- Cards --}}
  <div class="relative z-10" style="padding:0;">
    @if (in_array(($section['id'] ?? ''), ['service-card-bg-half','service-cards-privacy']))
      <div class="absolute lg:hidden right-0 left-0 h-3/4 bg-dark z-10 -ml-4 -mr-4 bottom-0"></div>
    @endif

    @if (($background['color'] ?? '') != 'light-gradient' && !in_array(($section['id'] ?? ''), ['service-card-bg-half','service-cards-privacy']))
      <div class="absolute h-2/3 bg-white bottom-0 left-0 right-0 -ml-12 -mr-12 lg:hidden"></div>
    @endif

    {{-- INSIDE component-inner-section so left edge aligns with content width --}}
    <div class="component-inner-section">
      @if ($is_swiper)
        {{-- SLIDER (>3 cards) with off-right peek on desktop, no pagination --}}
        <div
          x-data="{ swiper: null }"
          x-init="
            const root = $el;
            const getPad = () => {
              const cis = root.closest('section')?.querySelector('.component-inner-section');
              const pl = cis ? parseFloat(getComputedStyle(cis).paddingLeft) : 24;
              return isNaN(pl) ? 24 : Math.round(pl);
            };
            const pad = getPad();

            swiper = new Swiper($refs.container, {
              grabCursor: true,
              speed: 500,
              watchOverflow: true,
              spaceBetween: 16,
              slidesPerView: 1.15,
              slidesOffsetBefore: pad,
              slidesOffsetAfter: pad + 48,
              breakpoints: {
                640:  { slidesPerView: 2.15, spaceBetween: 16, slidesOffsetBefore: pad, slidesOffsetAfter: pad + 64 },
                1024: { slidesPerView: 3.25, spaceBetween: 16, slidesOffsetBefore: pad, slidesOffsetAfter: pad + 220 }, /* off-right peek */
                1280: { slidesPerView: 3.5,  spaceBetween: 16, slidesOffsetBefore: pad, slidesOffsetAfter: pad + 280 }, /* bigger peek */
              },
            });

            const onResize = () => {
              const p = getPad();
              swiper.params.slidesOffsetBefore = p;
              swiper.params.slidesOffsetAfter  =
                window.innerWidth >= 1280 ? p + 280 :
                window.innerWidth >= 1024 ? p + 220 :
                window.innerWidth >= 640  ? p + 64  : p + 48;
              swiper.update();
            };
            window.addEventListener('resize', onResize);
          "
        >
          <div class="icon-slider relative">
            <div class="swiper" x-ref="container">
              <div class="swiper-wrapper pb-10 lg:gap-6">
                @foreach ($cards as $index => $card)
                  @php
                    $link = $card['link'] ?? null;
                    if (!empty($card['external_link'])) { $link = $card['external_link']; }
                    if (($card['link_type'] ?? '') === 'none') { $link = false; }
                  @endphp

                  <div class="swiper-slide" style="height:auto;">
                    <div class="service-icon-cards h-full group relative rounded-lg overflow-hidden">
                      <div class="bg-white text-brand transition-all relative flex items-start h-full
                          @if (!empty($card['bg_image'])) group-hover:bg-action-dark @else group-hover:bg-electric-purple @endif
                          @if (!empty($card['custom_icon'])) gradient-border @endif">

                        @if (!empty($card['bg_image']))
                          <div class="absolute inset-0 z-[1]">
                            @if ($link)<a class="no-underline" href="{{ $link }}" @if (!empty($card['is_blank'])) target="_blank" @endif aria-label="{{ strip_tags($card['title'] ?? '') }}">@endif
                              <img class="lazy w-full h-full object-cover opacity-0 group-hover:opacity-20"
                                   data-src="{{ $card['bg_image']['sizes']['large'] }}"
                                   alt="{{ $card['bg_image']['alt'] }}" />
                            @if ($link)</a>@endif
                          </div>
                        @endif

                        @if (!empty($card['thumbnail']))
                          <div class="absolute top-10 left-0 right-0 px-3 h-1/2 z-[1]">
                            @if ($link)<a class="no-underline" href="{{ $link }}" @if (!empty($card['is_blank'])) target="_blank" @endif aria-label="{{ strip_tags($card['title'] ?? '') }}">@endif
                              <img class="lazy w-full h-full object-contain"
                                   data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}"
                                   alt="{{ $card['thumbnail']['alt'] }}" />
                            @if ($link)</a>@endif
                          </div>
                        @endif

                        <div class="relative z-10 w-full h-full p-9 text-lg lg:text-4xl">
                          @if ($link)
                            <a class="absolute inset-0 p-9 text-brand group-hover:text-white no-underline"
                               href="{{ $link }}" @if (!empty($card['is_blank'])) target="_blank" @endif></a>
                          @endif

                          <div class="relative">
                            @isset($card["icon"])
                              @if (!empty($card["custom_icon"]))
                                <span class="w-14 h-14 p-2 flex justify-center items-center rounded-full">
                                  <img class="lazy h-full w-full custom-icon service-icon"
                                       data-src="{{ $card['custom_icon']['url'] }}"
                                       alt="{{ $card['custom_icon']['alt'] ?? 'Custom Icon' }}" />
                                </span>
                              @elseif (!empty($card["icon"]))
                                <span class="mb-5 block
                                  @if (!empty($alternate)) bg-{{ $icon_color_class }} @else bg-light @endif
                                  @if (($icon_color_class ?? '') === 'electric-purple' || ($icon_color_class ?? '') === 'white')
                                    group-hover:bg-white
                                  @else
                                    group-hover:bg-action
                                  @endif
                                  w-10 h-10 p-2 flex justify-center items-center rounded-full">
                                  <img class="lazy h-full w-full acf-icon-{{ $icon_color_class ?? 'light' }} service-icon"
                                       data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                                </span>
                              @endif
                            @endisset

                            @if (!empty($card['title'])) <h3 class="text-xl font-semibold mb-4">{!! $card['title'] !!}</h3> @endif
                            @if (!empty($card['description'])) <div class="text-lg w-full">{!! $card['description'] !!}</div> @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>

      @else
        {{-- Grid fallback (<=3 cards), stays inside content width --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach ($cards as $index => $card)
            @php
              $link = $card['link'] ?? null;
              if (!empty($card['external_link'])) { $link = $card['external_link']; }
              if (($card['link_type'] ?? '') === 'none') { $link = false; }
            @endphp

            <div class="h-full">
              <div class="service-icon-cards h-full group relative rounded-lg overflow-hidden">
                <div class="bg-white text-brand transition-all relative flex items-start h-full
                    @if (!empty($card['bg_image'])) group-hover:bg-action-dark @else group-hover:bg-electric-purple @endif
                    @if (!empty($card['custom_icon'])) gradient-border @endif">

                  @if (!empty($card['bg_image']))
                    <div class="absolute inset-0 z-[1]">
                      @if ($link)<a class="no-underline" href="{{ $link }}" @if (!empty($card['is_blank'])) target="_blank" @endif aria-label="{{ strip_tags($card['title'] ?? '') }}">@endif
                        <img class="lazy w-full h-full object-cover opacity-0 group-hover:opacity-20"
                             data-src="{{ $card['bg_image']['sizes']['large'] }}"
                             alt="{{ $card['bg_image']['alt'] }}" />
                      @if ($link)</a>@endif
                    </div>
                  @endif

                  @if (!empty($card['thumbnail']))
                    <div class="absolute top-10 left-0 right-0 px-3 h-1/2 z-[1]">
                      @if ($link)<a class="no-underline" href="{{ $link }}" @if (!empty($card['is_blank'])) target="_blank" @endif aria-label="{{ strip_tags($card['title'] ?? '') }}">@endif
                        <img class="lazy w-full h-full object-contain"
                             data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}"
                             alt="{{ $card['thumbnail']['alt'] }}" />
                      @if ($link)</a>@endif
                    </div>
                  @endif

                  <div class="relative z-10 w-full h-full p-9 text-lg lg:text-4xl">
                    @if ($link)
                      <a class="absolute inset-0 p-9 text-brand group-hover:text-white no-underline"
                         href="{{ $link }}" @if (!empty($card['is_blank'])) target="_blank" @endif></a>
                    @endif

                    <div class="relative">
                      @isset($card["icon"])
                        @if (!empty($card["custom_icon"]))
                          <span class="w-14 h-14 p-2 flex justify-center items-center rounded-full">
                            <img class="lazy h-full w-full custom-icon service-icon"
                                 data-src="{{ $card['custom_icon']['url'] }}"
                                 alt="{{ $card['custom_icon']['alt'] ?? 'Custom Icon' }}" />
                          </span>
                        @elseif (!empty($card["icon"]))
                          <span class="mb-5 block
                            @if (!empty($alternate)) bg-{{ $icon_color_class }} @else bg-light @endif
                            @if (($icon_color_class ?? '') === 'electric-purple' || ($icon_color_class ?? '') === 'white')
                              group-hover:bg-white
                            @else
                              group-hover:bg-action
                            @endif
                            w-10 h-10 p-2 flex justify-center items-center rounded-full">
                            <img class="lazy h-full w-full acf-icon-{{ $icon_color_class ?? 'light' }} service-icon"
                                 data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                          </span>
                        @endif
                      @endisset

                      @if (!empty($card['title'])) <h3 class="text-xl font-semibold mb-4">{!! $card['title'] !!}</h3> @endif
                      @if (!empty($card['description'])) <div class="text-lg w-full">{!! $card['description'] !!}</div> @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  @if (($background['color'] ?? '') === 'dark')
    <div class="absolute h-1/3 lg:h-1/3 bg-white bottom-0 left-0 right-0 hidden lg:block"></div>
  @endif
</section>
