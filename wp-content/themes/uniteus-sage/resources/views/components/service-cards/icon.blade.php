@php
use Illuminate\Support\Str;
@endphp

  @php
  $s_settings = [
      'collapse_padding' => false,
      'fullscreen' => '',
  ];
  $section_settings = isset($acf["components"][$index]['layout_settings']['section_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : $s_settings;
  $alternate = !empty($alternate) ? 'icon-cards-alternate' : '';
  @endphp
  
  @if ($background['has_divider'])
    @includeIf('dividers.waves')
  @endif
  
  <section @isset($section['id']) id="{{ $section['id'] }}" @endisset class="relative @if ($background['color'] == 'dark') text-white @endif component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif {{ $alternate }}">
    @if ('center' == $section["alignment"])
    <div class="component-inner-section">
      <div class="text-center mb-7">
        @if ($section['subtitle'])
          @if ($section['subtitle_display_as_pill'])
            <span class="@if ($background['color'] == 'dark') bg-brand text-action-light-blue @else @if($section['purple_text']) text-electric-purple @else text-action @endif @if ($background['color'] == 'light-gradient') bg-white @else bg-light mix-blend-multiply @endif @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
          @else
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
          @endif
            {!! $section['subtitle'] !!}
            </span>
        @endif
        @if ($section['title'])
        <h2 class="width-30 m-auto mb-6">{!! $section['title'] !!}</h2>
        @endif
        @if ($section['description'])
        <div class="text-lg">
          <div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div>
        </div>
        @endif
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-center',
              'mt' => 'mt-6',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
    </div>
    @elseif ('left' == $section["alignment"])
    <div class="component-inner-section">
      <div class="mb-6">
        @if ($section['subtitle'])
          <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
            {{ $section['subtitle'] }}
          </span>
        @endif
        <h2 class="mb-6">{!! $section['title'] !!}</h2>
        <div class="text-lg">
          {!! $section['description'] !!}
        </div>
      </div>
    </div>
    @else
    <div class="component-inner-section">
      <div class="flex flex-col md:grid md:grid-cols-12 gap-3 mb-5">
        <div class="md:col-span-4">
          @if ($section['subtitle'])
            <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
              {{ $section['subtitle'] }}
            </span>
          @endif
          <h2 class="mb-0">{!! $section['title'] !!}</h2>
        </div>
        <div class="md:col-span-8 text-lg">
          {!! $section['description'] !!}
        </div>
      </div>
    </div>
    @endif
    <div class="relative component-inner-section z-10">
      @if (($section['id'] == 'service-card-bg-half') OR ($section['id'] == 'service-cards-privacy'))
        <div class="absolute lg:hidden right-0 left-0 h-3/4 bg-dark z-10 -ml-4 -mr-4 bottom-0"></div>
      @endif
      <div class="flex flex-col flex-wrap justify-center sm:flex-row -mx-2 relative z-10">
      @if (($background['color'] != 'light-gradient') && ($section['id'] != 'service-card-bg-half') && ($section['id'] != 'service-cards-privacy'))
        <div class="absolute h-2/3 bg-white bottom-0 left-0 right-0 -ml-12 -mr-12 lg:hidden"></div>
      @endif
  
      @foreach ($cards as $index => $card)
        @php
          $link = $card['link'];
          $external_link = $card['external_link'];
  
          if ($external_link) {
            $link = $external_link;
          } 
          if ($card['link_type'] == 'none') {
            $link = false;
          }
        @endphp
  @php
  // Convert the title to a slug format
  $card_title_slug = Str::slug(strip_tags($card['title']), '-');
@endphp
        <div class="relative sm:basis-6/12 p-3 @if ($columns) lg:basis-{{ $columns }} @else lg:basis-2/6 @endif">
          
          @if (($background['color'] == 'dark') && $loop->first)
            <div class="absolute h-1/2 bg-dark bottom-0 left-0 right-0 -ml-12 -mr-12 lg:hidden"></div>
          @endif
          @if ((($section['id'] != 'service-cards-privacy') && $loop->last) && ($section['id'] != 'care-coordination-care-team') )
            <div class="absolute h-1/2 left-0 right-0 bottom-0 bg-white lg:hidden" style="margin: 0 -300px -1px;"></div>
          @endif
          @if ($section['id'] == 'care-coordination-care-team')
            <div class="absolute h-1/2 left-0 right-0 bottom-0 bg-white hidden" style="margin: 0 -300px -1px;"></div>
          @endif
          @if (!empty($card['expandable_tile']))
            <div class="service-icon-card group expandable" data-card-id="card-{{ $index }}">
              <div class="even-height bg-white text-brand 
              @if ($background['color'] != 'light-gradient') shadow-lg @endif
              @if ($card['bg_image']) group-hover:bg-{{ $icon_color_class }} @else group-hover:bg-{{ $icon_color_class }} @endif 
              group-hover:text-white transition-all hover:shadow-lg border border-light relative flex items-start rounded-lg overflow-hidden group h-full">
                @if ($card['bg_image'])
                  <div style="z-index: 1;" class="absolute inset-0">
                    @if ($link)
                    <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
                    @endif
                      <img class="lazy w-full h-full object-cover opacity-0 group-hover:opacity-20" data-src="{{ $card['bg_image']['sizes']['large'] }}" alt="{{ $card['bg_image']['alt'] }}" />
                    @if ($link)
                    </a>
                    @endif
                  </div>
                @endif
                @if ($card['thumbnail'])
                  <div style="z-index: 1;" class="top-10 left-0 right-0 px-3 absolute h-1/2">
                    @if ($link)
                    <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
                    @endif
                      <img class="lazy w-full h-full object-contain" data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}" alt="{{ $card['thumbnail']['alt'] }}" />
                    @if ($link)
                    </a>
                    @endif
                  </div>
                @endif
                @if ($link)
                <span class="absolute arrow-icon">
                  <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.9215 1.38279H18.9632C18.9632 1.10653 18.8534 0.841573 18.6581 0.646223C18.4627 0.450872 18.1978 0.341125 17.9215 0.341125V1.38279ZM16.8798 13.8828C16.8798 14.1591 16.9896 14.424 17.1849 14.6194C17.3803 14.8147 17.6452 14.9245 17.9215 14.9245C18.1978 14.9245 18.4627 14.8147 18.6581 14.6194C18.8534 14.424 18.9632 14.1591 18.9632 13.8828H16.8798ZM5.42148 0.341125C5.14521 0.341125 4.88026 0.450872 4.68491 0.646223C4.48956 0.841573 4.37982 1.10653 4.37982 1.38279C4.37982 1.65906 4.48956 1.92401 4.68491 2.11936C4.88026 2.31471 5.14521 2.42446 5.42148 2.42446V0.341125ZM0.518356 17.313C0.418867 17.4091 0.33951 17.524 0.284918 17.6511C0.230325 17.7782 0.201589 17.9149 0.200387 18.0532C0.199185 18.1915 0.225541 18.3287 0.277917 18.4567C0.330293 18.5847 0.40764 18.701 0.505445 18.7988C0.60325 18.8966 0.719554 18.974 0.847571 19.0264C0.975588 19.0787 1.11275 19.1051 1.25107 19.1039C1.38938 19.1027 1.52607 19.0739 1.65315 19.0194C1.78024 18.9648 1.89518 18.8854 1.99127 18.7859L0.518356 17.313ZM16.8798 1.38279V13.8828H18.9632V1.38279H16.8798ZM17.9215 0.341125H5.42148V2.42446H17.9215V0.341125ZM17.185 0.646334L0.518356 17.313L1.99127 18.7859L18.6579 2.11925L17.185 0.646334Z" fill="#C7D8E8"/>
                  </svg>
                </span>
                @endif
                @if (!empty($card['expandable_tile']) && !empty($card['expanded_description']))
                  <span class="absolute chevron-icon">
                    <svg width="27" height="15" viewBox="0 0 27 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2.40014 1.59122L13.4896 12.6806L24.579 1.59122" stroke="#C7D8E8" stroke-width="3.16841" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>                    
                  </span>
                @endif
                <div class="relative z-10 w-full p-9 text-lg lg:text-4xl">
                  <div classs="absolute inset-0 z-10 border-b-[15px] border-action-dark transition ease-in-out delay-250 group-hover:opacity-0 group-hover:z-0"></div>
                  @if ($link)
                  <a class=" inset-0 text-brand group-hover:text-white no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif>
                  @endif
                  <div class="text-block relative">
                    @isset ($card["icon"])
                      @if (!empty($card["icon"]))
                      <span class="mb-5 bg-light 
                        @if ($icon_color_class == 'electric-purple') 
                          group-hover:bg-electric-purple-hover 
                        @elseif ($icon_color_class == 'white') 
                          group-hover:bg-white
                        @else 
                          group-hover:bg-action-dark-blue
                        @endif 
                        w-10 h-10 p-2 flex justify-center items-center rounded-full">
                          <img class="lazy h-full w-full acf-icon-{{ $icon_color_class }} service-icon" data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                      </span>
                      @endif
                    @endisset
                    @if ($card['title'])
                    <h3 class="text-xl font-semibold mb-4">{!! $card['title'] !!}</h3>
                    @endif
                    @if ($card['description'])
                      <div class="text-lg w-full">
                          {!! $card['description'] !!}
                      </div>
                    @endif
                    @if (!empty($card['expandable_tile']) && !empty($card['expanded_description']))
                      <div class="text-lg w-full expanded-description mt-4">
                          {!! $card['expanded_description'] !!}
                          <br/>
                          @if (!empty($card['text_link']))
                          <a href="{{ $card['text_link']['url'] }}?Managed_Care_Form_Submission={{ $card_title_slug }}" class="flex expanded-link mt-4 get-in-touch" data-title-slug="{{ $card_title_slug }}">
                            {{ $card['text_link']['title'] }} &nbsp;<svg width="14" height="11" viewBox="0 0 14 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.375 1.20837L12.5 5.33337M12.5 5.33337L8.375 9.45838M12.5 5.33337L1.5 5.33337" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                          </a>
                        @endif
                      </div>
                    @endif
                   
                  </div>
                  @if ($link)
                  </a>
                  @endif
                </div>
              </div>
            </div>
          @else
          <div class="service-icon-card h-full group">
            <div class="relative flex items-start rounded-lg overflow-hidden group h-full
            @if ($gradient_hover) hover-class @else group-hover:bg-{{ $icon_color_class }} @endif
              @if ($alternate) border-2 border-action @endif
              @if (!empty($card['custom_icon'])) gradient-border @else 
                bg-white text-brand border border-light @if (empty($card['custom_icon'])) group-hover:border-{{ $icon_color_class }} @endif 
                @if ($background['color'] != 'light-gradient') shadow-lg @endif
                @if ($card['bg_image'] && empty($card['custom_icon'])) group-hover:bg-{{ $icon_color_class }} @endif 
                @if (empty($card['custom_icon'])) group-hover:text-white @endif
                transition-all @if (empty($card['custom_icon'])) hover:shadow-lg @endif
              @endif
            ">
          
    
                @if ($card['bg_image'])
                  <div style="z-index: 1;" class="absolute inset-0">
                    @if ($link)
                    <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
                    @endif
                      <img class="lazy w-full h-full object-cover opacity-0 group-hover:opacity-20" data-src="{{ $card['bg_image']['sizes']['large'] }}" alt="{{ $card['bg_image']['alt'] }}" />
                    @if ($link)
                    </a>
                    @endif
                  </div>
                @endif
    
                @if ($card['thumbnail'])
                  <div style="z-index: 1;" class="top-10 left-0 right-0 px-3 absolute h-1/2">
                    @if ($link)
                    <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
                    @endif
                      <img class="lazy w-full h-full object-contain" data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}" alt="{{ $card['thumbnail']['alt'] }}" />
                    @if ($link)
                    </a>
                    @endif
                  </div>
                @endif
                @if ($link)
                  <span class="absolute arrow-icon">
                    @if (!$alternate)
                      <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.9215 1.38279H18.9632C18.9632 1.10653 18.8534 0.841573 18.6581 0.646223C18.4627 0.450872 18.1978 0.341125 17.9215 0.341125V1.38279ZM16.8798 13.8828C16.8798 14.1591 16.9896 14.424 17.1849 14.6194C17.3803 14.8147 17.6452 14.9245 17.9215 14.9245C18.1978 14.9245 18.4627 14.8147 18.6581 14.6194C18.8534 14.424 18.9632 14.1591 18.9632 13.8828H16.8798ZM5.42148 0.341125C5.14521 0.341125 4.88026 0.450872 4.68491 0.646223C4.48956 0.841573 4.37982 1.10653 4.37982 1.38279C4.37982 1.65906 4.48956 1.92401 4.68491 2.11936C4.88026 2.31471 5.14521 2.42446 5.42148 2.42446V0.341125ZM0.518356 17.313C0.418867 17.4091 0.33951 17.524 0.284918 17.6511C0.230325 17.7782 0.201589 17.9149 0.200387 18.0532C0.199185 18.1915 0.225541 18.3287 0.277917 18.4567C0.330293 18.5847 0.40764 18.701 0.505445 18.7988C0.60325 18.8966 0.719554 18.974 0.847571 19.0264C0.975588 19.0787 1.11275 19.1051 1.25107 19.1039C1.38938 19.1027 1.52607 19.0739 1.65315 19.0194C1.78024 18.9648 1.89518 18.8854 1.99127 18.7859L0.518356 17.313ZM16.8798 1.38279V13.8828H18.9632V1.38279H16.8798ZM17.9215 0.341125H5.42148V2.42446H17.9215V0.341125ZM17.185 0.646334L0.518356 17.313L1.99127 18.7859L18.6579 2.11925L17.185 0.646334Z" fill="#C7D8E8"/>
                      </svg>
                    @else
                      <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.9215 1.38279H18.9632C18.9632 1.10653 18.8534 0.841573 18.6581 0.646223C18.4627 0.450872 18.1978 0.341125 17.9215 0.341125V1.38279ZM16.8798 13.8828C16.8798 14.1591 16.9896 14.424 17.1849 14.6194C17.3803 14.8147 17.6452 14.9245 17.9215 14.9245C18.1978 14.9245 18.4627 14.8147 18.6581 14.6194C18.8534 14.424 18.9632 14.1591 18.9632 13.8828H16.8798ZM5.42148 0.341125C5.14521 0.341125 4.88026 0.450872 4.68491 0.646223C4.48956 0.841573 4.37982 1.10653 4.37982 1.38279C4.37982 1.65906 4.48956 1.92401 4.68491 2.11936C4.88026 2.31471 5.14521 2.42446 5.42148 2.42446V0.341125ZM0.518356 17.313C0.418867 17.4091 0.33951 17.524 0.284918 17.6511C0.230325 17.7782 0.201589 17.9149 0.200387 18.0532C0.199185 18.1915 0.225541 18.3287 0.277917 18.4567C0.330293 18.5847 0.40764 18.701 0.505445 18.7988C0.60325 18.8966 0.719554 18.974 0.847571 19.0264C0.975588 19.0787 1.11275 19.1051 1.25107 19.1039C1.38938 19.1027 1.52607 19.0739 1.65315 19.0194C1.78024 18.9648 1.89518 18.8854 1.99127 18.7859L0.518356 17.313ZM16.8798 1.38279V13.8828H18.9632V1.38279H16.8798ZM17.9215 0.341125H5.42148V2.42446H17.9215V0.341125ZM17.185 0.646334L0.518356 17.313L1.99127 18.7859L18.6579 2.11925L17.185 0.646334Z" fill="#216cff"/>
                      </svg>
                    @endif
                  </span>
                @endif

                @if (!empty($card['expandable_tile']) && !empty($card['expanded_description']))
                  <span class="absolute chevron-icon">
                    <svg width="27" height="15" viewBox="0 0 27 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2.40014 1.59122L13.4896 12.6806L24.579 1.59122" stroke="#C7D8E8" stroke-width="3.16841" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>                    
                  </span>
                @endif
                <div class="relative z-10 w-full h-full text-lg lg:text-4xl @if ($gradient_hover) hover-class @endif">
                  <div classs="absolute inset-0 z-10 border-b-[15px] border-action-dark transition ease-in-out delay-250 group-hover:opacity-0 group-hover:z-0"></div>
                  @if ($link)
                  <a class=" inset-0 text-brand group-hover:text-white no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif>
                  @endif
                  <div class="p-9 relative @if ($alternate) flex gap-3 @endif">
                    <div>
                      @isset($card["icon"])
                        {{-- Check for custom_icon and render in a separate wrapper --}}
                        @if (!empty($card["custom_icon"]))
                          <span class="w-14 h-14 p-2 flex justify-center items-center rounded-full">
                            <img class="lazy h-full w-full custom-icon service-icon" 
                              data-src="{{ $card['custom_icon']['url'] }}" 
                              alt="{{ $card['custom_icon']['alt'] ?? 'Custom Icon' }}" />
                          </span>
                        @elseif (!empty($card["icon"]))
                          {{-- Render default icon inside styled span --}}
                          <span class="mb-5 @if ($alternate) bg-{{ $icon_color_class }} @else bg-light @endif 
                            group-hover:bg-white w-10 h-10 p-2 flex justify-center items-center rounded-full">
                            <img class="lazy h-full w-full 
                              @if ($alternate) acf-icon-white @else acf-icon-{{ $icon_color_class }} @endif 
                              service-icon group-hover:group-hover-icon" 
                              data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                          </span>
                        @endif
                      @endisset
                    </div>
                    
                    <div>
                      @if ($card['title'])
                      <h3 class="@if ($alternate) text-action text-xxl group-hover:text-white font-bold @else text-xl font-semibold @endif  mb-4">{!! $card['title'] !!}</h3>
                      @endif
                      @if ($card['description'])
                        <div class="@if ($alternate) text-md @else text-lg @endif w-full">
                            {!! $card['description'] !!}
                        </div>
                      @endif
                      @if (!empty($card['expandable_tile']) && !empty($card['expanded_description']))
                        <div class="text-lg w-full expanded-description mt-4">
                            {!! $card['expanded_description'] !!}
                        </div>
                      @endif
                    </div>
                  </div>
                  @if ($link)
                  </a>
                  @endif
                </div>
              </div>
            </div>
          @endif
        </div>
      @endforeach
    </div>
  </section>
  
