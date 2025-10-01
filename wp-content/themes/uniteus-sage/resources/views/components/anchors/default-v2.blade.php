{{-- resources/views/components/anchors/default-v2.blade.php --}}

@php
  $flex_index = $index ?? 0;
@endphp

@if (!empty($background['has_divider']))
  @includeIf('dividers.waves')
@endif

<style>
  /* Left anchors */
  .anchor-icon img{filter:grayscale(1);opacity:.6}
  .anchor-icon:hover img,.active-anchor .anchor-icon img{
    filter:invert(43%) sepia(71%) saturate(4510%) hue-rotate(205deg) brightness(104%) contrast(105%);
    opacity:1
  }
  .anchor-li{border-left:3px solid transparent}
  .anchor-li:hover,.active-anchor.anchor-li{border-color:#216CFF;font-weight:700}
  .active-anchor.anchor-li a{color:#0B1538}

  /* Key Benefits tile – gradient hover */
  .kb-tile{
    position:relative;border:1px solid #C7D8E8;border-radius:.75rem;
    transition:transform .25s ease, border-color .25s ease;
    overflow:hidden;background:transparent
  }
  .kb-tile:hover{transform:translateY(-2px);border-color:transparent}
  .kb-tile::before{
    content:"";position:absolute;inset:0;border-radius:.75rem;opacity:0;pointer-events:none;
    background:linear-gradient(113.78deg,#2F71F4 0%,#2F71F4 48.34%,#9643FF 100%);
    transition:opacity .25s ease
  }
  .kb-tile:hover::before{opacity:1}
  .kb-tile > .kb-inner{position:relative;z-index:1}
  .kb-tile:hover .kb-title,.kb-tile:hover .kb-desc{color:#fff;-webkit-text-fill-color: #fff;}

  /* Article list hover bar */
  .article-link{position:relative;border-top:1px solid #C7D8E8}
  .article-link:hover{border-top-width:2px;border-color:#216CFF}
  .article-link .hover-a{opacity:0;transition:opacity .2s ease}
  .article-link:hover .hover-a{opacity:1}
  .article-link .hover-b{opacity:1;transition:opacity .2s ease}
  .article-link:hover .hover-b{opacity:0}

  /* Logos pagination dots */
  .swiper-pagination-bullet{background:rgba(157,180,197,.28);opacity:.5}
  .swiper-pagination-bullet-active{
    width:20px;height:20px;background:transparent;border:4px solid rgba(157,180,197,.25);opacity:1
  }
  .swiper-pagination-bullet-active::after{
    content:"";position:absolute;inset:1px;border-radius:9999px;background:rgba(157,180,197,.8)
  }
</style>

<section
  class="component-section {{ $section_classes ?? '' }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] }} @endif"
  @isset($section['id']) id="{{ $section['id'] }}" @endisset
>
  <div
    x-data="{
      navHeight: 90,
      calculateTop(){ const n=document.querySelector('.navbar'); if(n){ this.navHeight=n.offsetHeight } }
    }"
    x-init="calculateTop()"
    class="component-inner-section @if (!empty($section_settings['fullscreen'])) fullscreen @endif"
  >
    {{-- Header --}}
    <div class="text-center mb-6">
      @if (!empty($section['subtitle']))
        @if (!empty($section['subtitle_display_as_pill']))
          <span class="@if (($background['color'] ?? '')==='dark') bg-brand text-action-light-blue @else text-action bg-light mix-blend-multiply @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
        @else
          <span class="block text-base mb-3 font-semibold uppercase tracking-wider @if (($background['color'] ?? '')==='dark') text-action-light-blue @else text-action @endif">
        @endif
          {{ $section['subtitle'] }}
        </span>
      @endif

      @if (!empty($section['title']))
        <h2 class="mb-3 @if (($background['color'] ?? '')==='dark') text-white @endif">{!! $section['title'] !!}</h2>
      @endif

      @if (!empty($section['description']))
        <div class="width-40 mx-auto text-lg @if (($background['color'] ?? '')==='dark') text-white @endif">
          {!! $section['description'] !!}
        </div>
      @endif
    </div>

    @if (!empty($cards))
      <div x-data="{ showSlide: '0' }" class="relative flex flex-col lg:grid lg:grid-cols-12 gap-6 pt-4">
        {{-- Left Anchor Nav --}}
        <div class="col-span-3">
          <div class="sticky" :style="`top: ${navHeight + 8}px;`">
            <div class="uppercase text-action font-bold pb-4 hidden opacity-0 lg:block lg:opacity-100">
              {{ !empty($anchor_heading) ? $anchor_heading : 'Jump To' }}
            </div>
            <ul class="hidden lg:flex list-none flex-col gap-4" style="border-left:1px solid #C7D8E8;">
              @foreach ($cards as $idx => $card)
                @php
                  $anchor = sanitize_title($card['title'] ?? 'section-'.$idx);
                @endphp
                <li :class="showSlide == '{{ $idx }}' ? 'active-anchor' : ''" class="anchor-li" style="padding-left:30px;">
                  <a href="#{{ $anchor }}" class="anchor-icon flex gap-6 items-center no-underline text-xl text-gray-500">
                    {{ $card['title'] ?? '' }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>

          {{-- Mobile dropdown --}}
          <div class="sticky top-8 z-20 lg:hidden" style="margin-top:0;margin-bottom:2rem;">
            <div x-data="Components.menu({ open:false })" x-init="init()" @keydown.escape.stop="open=false; focusButton()" @click.away="onClickAway($event)" class="relative inline-block text-left w-full">
              <button type="button"
                class="inline-flex w-full justify-between items-center gap-x-1.5 rounded-md bg-white px-6 py-4 text-base font-semibold text-brand hover:bg-light hover:bg-opacity-30 shadow-md ring-1 ring-inset ring-light ring-opacity-50"
                id="menu-button" x-ref="button" @click="onButtonClick()" @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()" x-bind:aria-expanded="open.toString()" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()"
              >
                {{ !empty($anchor_heading) ? $anchor_heading : 'Jump To' }}
                <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 .353a1 1 0 0 1 .707.293l3 3a1 1 0 0 1-1.414 1.414L4 2.767 1.707 5.06A1 1 0 0 1 .293 3.646l3-3A1 1 0 0 1 4 .353ZM.293 9.646a1 1 0 0 1 1.414 0L4 11.939l2.293-2.293a1 1 0 1 1 1.414 1.414l-3 3a1 1 0 0 1-1.414 0l-3-3a1 1 0 0 1 0-1.414Z" fill="#216CFF"/></svg>
              </button>
              <div x-show="open" x-transition class="absolute left-0 right-0 w-full z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-ref="menu-items" role="menu" tabindex="-1">
                <div id="js-toc-navigation" class="py-4">
                  @foreach ($cards as $idx => $card)
                    @php $anchor = sanitize_title($card['title'] ?? 'section-'.$idx); @endphp
                    <a href="#{{ $anchor }}" class="mobile-nav-jump block no-underline px-6 py-2">{{ $card['title'] ?? '' }}</a>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Right content --}}
        <div class="col-span-9 flex flex-col gap-32">
          @foreach ($cards as $idx => $card)
            @php $anchor = sanitize_title($card['title'] ?? 'section-'.$idx); @endphp
            <div id="{{ $anchor }}" x-intersect.margin.0.0.-50%.0="showSlide='{{ $idx }}'">
              {{-- Title + Icon --}}
              <div class="group relative flex flex-col-reverse sm:flex-row sm:justify-between sm:items-end mb-0 gap-10">
                {{-- <h2 class="mb-0 text-4xl">{{ $card['title'] ?? '' }}</h2> --}}
                @isset($card['icon']['sizes'])
                  <img class="group-hover:icon-gray w-40 h-auto object-contain right-0 bottom-0"
                       src="{{ $card['icon']['sizes']['medium'] }}" alt="" style="max-height:90px;">
                @endisset
              </div>

              {{-- Description --}}
              @if (!empty($card['description']))
                <div class="text-lg">{!! $card['description'] !!}</div>
              @endif

              {{-- Blocks under description --}}
              @php
                $hasStats     = !empty($card['stats']);
                $hasArticles  = !empty($card['articles']);
                $hasManual    = !empty($card['manual_articles']);
                $hasPartners  = !empty($card['partners']);
                $hasFeature   = !empty($card['feature_box']) && !empty($card['feature_box']['content']);
              @endphp

              <div class="flex flex-col items-stretch gap-12 mt-10
                  @if ($hasStats && ($hasArticles || $hasManual)) md:grid md:grid-cols-12
                  @elseif ($hasStats && ($hasPartners || $hasFeature)) gap-4 md:flex-row @endif">

                {{-- Key Benefits --}}
                @if ($hasStats)
                  @php
                    $keyStatsClass = 'col-span-6 md:basis-1/2';
                    $keyStatClass  = 'md:col-span-3';
                    $numStats      = is_countable($card['stats']) ? count($card['stats']) : 0;
                    if ($hasArticles){
                      $keyStatsClass = 'col-span-6';
                      $keyStatClass  = 'col-span-6';
                    } elseif (!$hasPartners && !$hasFeature){
                      $keyStatsClass .= ' md:flex md:flex-wrap';
                      $keyStatClass   = $numStats % 2 === 0 ? 'md:basis-1/2' : 'md:basis-1/3';
                    }
                  @endphp

                  <div class="key-stats {{ $keyStatsClass }}">
                    <h3 class="uppercase text-action text-sm mb-4 mt-4">
                      {{ !empty($card['key_benefits_title']) ? $card['key_benefits_title'] : 'Key Benefits' }}
                    </h3>

                    @if ($hasArticles || $hasManual)
                      {{-- Grid when paired with articles --}}
                      <div class="grid grid-cols-12 gap-5">
                        @foreach ($card['stats'] as $stat)
                            @php
                            $isOrphan = $loop->last && ($loop->count % 2 === 1);
                            @endphp

                            <div class="kb-tile col-span-12 md:{{ $isOrphan ? 'col-span-12' : 'col-span-6' }} relative p-3 lg:p-6">
                            <div class="kb-inner {{ $isOrphan ? 'flex gap-4 items-center' : '' }} ">
                                <h2 class="kb-title font-extrabold text-3xl mb-2 leading-tight gradient-text">{!! $stat['label'] !!}</h2>
                                <div class="kb-desc text-sm text-brand">{!! $stat['description'] !!}</div>
                            </div>
                            @isset($stat['background_image']['sizes'])
                                <img class="absolute inset-0 w-full h-full object-cover opacity-10"
                                    src="{{ $stat['background_image']['sizes']['medium'] }}" alt="">
                            @endisset
                            </div>
                        @endforeach
                      </div>
                    @else
                      {{-- Flexible wrap when alone --}}
                      <div class="flex flex-wrap gap-4">
                        @foreach ($card['stats'] as $stat)
                          <div class="kb-tile {{ $keyStatClass }} relative p-3 lg:p-6">
                            <div class="kb-inner">
                              <h2 class="kb-title font-extrabold text-3xl mb-2 leading-tight gradient-text">{!! $stat['label'] !!}</h2>
                              <div class="kb-desc text-sm text-brand">{!! $stat['description'] !!}</div>
                            </div>
                            @isset($stat['background_image']['sizes'])
                              <img class="absolute inset-0 w-full h-full object-cover opacity-10" src="{{ $stat['background_image']['sizes']['medium'] }}" alt="">
                            @endisset
                          </div>
                        @endforeach
                      </div>
                    @endif
                  </div>
                @endif

                {{-- Articles (relationship) OR Manual Articles --}}
                @if ($hasArticles || $hasManual)
                  <div class="articles col-span-6 flex flex-col">
                    <h3 class="uppercase text-action text-sm mb-4 mt-4">
                        Resources
                    </h3>

                    @if ($hasArticles)
                      @foreach ($card['articles'] as $article)
                        <div class="text-lg">
                          <a class="article-link relative group block pt-6 pb-10 no-underline text-brand hover:font-semibold hover:text-action" href="{{ get_permalink($article->ID) }}" style="padding-right:2rem;">
                            {{ $article->post_title }}
                            <div class="absolute p-7 pr-0 flex justify-end inset-0 z-10 rounded-xl hover-b">
                              <img class="w-5 h-5" src="@asset('/images/top-right-arrow.svg')" alt="">
                            </div>
                            <div class="absolute p-7 pr-0 flex justify-end inset-0 z-10 rounded-xl hover-a">
                              <img class="w-5 h-5" src="@asset('/images/top-right-arrow-active.svg')" alt="">
                            </div>
                          </a>
                        </div>
                      @endforeach
                    @elseif ($hasManual)
                      @foreach ($card['manual_articles'] as $m)
                        @php
                          $m_title = $m['title'] ?? '';
                          $m_link  = $m['link']['url'] ?? '';
                          $m_target= $m['link']['target'] ?? '_self';
                        @endphp
                        @if ($m_title && $m_link)
                          <div class="text-lg">
                            <a class="article-link relative group block pt-6 pb-10 no-underline text-brand hover:font-semibold hover:text-action" href="{{ esc_url($m_link) }}" target="{{ esc_attr($m_target) }}" style="padding-right:2rem;">
                              {{ $m_title }}
                              <div class="absolute p-7 pr-0 flex justify-end inset-0 z-10 rounded-xl hover-b">
                                <img class="w-5 h-5" src="@asset('/images/top-right-arrow.svg')" alt="">
                              </div>
                              <div class="absolute p-7 pr-0 flex justify-end inset-0 z-10 rounded-xl hover-a">
                                <img class="w-5 h-5" src="@asset('/images/top-right-arrow-active.svg')" alt="">
                              </div>
                            </a>
                          </div>
                        @endif
                      @endforeach
                    @endif
                  </div>
                @endif
              </div>

              {{-- Partners --}}
              @if (!empty($card['partners']))
                <div class="partners col-span-6 flex flex-col md:basis-1/2 border-t">
                  <h3 class="uppercase text-action text-sm mb-4 mt-4">{{ !empty($card['partners_title']) ? $card['partners_title'] : 'Partners' }}</h3>
                  <div class="flex-row flex-wrap flex-1 flex gap-4 mt-4">
                    @foreach ($card['partners'] as $partner)
                      @if (!empty($partner['partner']['url']))
                        <div class="border rounded-lg shadow-sm bg-white p-4">
                          @if (!empty($partner['link']['url']))
                            <a href="{{ $partner['link']['url'] }}" target="{{ $partner['link']['target'] ?? '_self' }}" class="flex">
                              <img src="{{ $partner['partner']['url'] }}" alt="{{ $partner['partner']['alt'] ?? 'Partner logo' }}" class="h-auto object-contain partner-logo">
                            </a>
                          @else
                            <img src="{{ $partner['partner']['url'] }}" alt="{{ $partner['partner']['alt'] ?? 'Partner logo' }}" class="h-auto object-contain partner-logo">
                          @endif
                        </div>
                      @endif
                    @endforeach
                  </div>
                </div>
              @endif

              {{-- Feature Box --}}
              @if (!empty($card['feature_box']) && !empty($card['feature_box']['content']))
                @php
                  $feature = $card['feature_box'];
                  $hasLink = !empty($feature['link']['url']);
                  $hasIcon = !empty($feature['icon_right_aligned']['url']);
                @endphp

                <div class="feature-box col-span-6 flex flex-col md:basis-1/2 border-t shadow-lg rounded-lg bg-white group relative overflow-hidden mt-8">
                  @if ($hasLink)
                    <a href="{{ $feature['link']['url'] }}" target="{{ $feature['link']['target'] ?? '_self' }}" class="relative block p-6 pt-8 no-underline hover:no-underline">
                      <div class="absolute top-8 right-4">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="#C7D8E8" xmlns="http://www.w3.org/2000/svg" class="transition-colors duration-300 group-hover:fill-[#216CFF]"><path d="M19.529 1.131h1.118c0-.297-.118-.581-.327-.79a1.118 1.118 0 0 0-.79-.328v1.118ZM18.412 14.543c0 .296.118.58.327.79.21.209.494.327.79.327.297 0 .581-.118.79-.327.21-.21.328-.494.328-.79h-2.235ZM6.118.013a1.118 1.118 0 0 0-.79.328c-.21.209-.328.493-.328.79 0 .297.118.581.328.79.209.21.493.328.79.328V.013ZM.857 18.223c-.107.103-.192.227-.25.363a1.12 1.12 0 0 0-.058.433c0 .151.028.306.083.45.055.143.138.275.24.386.103.11.224.2.357.26.133.06.276.093.422.094.148.002.295-.03.431-.089.136-.059.26-.144.363-.251l1.58-1.58ZM18.412 1.13V14.543h2.235V1.13h-2.235ZM19.529.013H6.118v2.235H19.53V.013Zm-.79.327L.857 18.223l1.58 1.58L20.32 1.921 18.74.34Z"/></svg>
                      </div>
                  @endif

                  <div class="@if ($hasLink) p-0 @else p-6 pt-8 @endif relative">
                    @if (!empty($feature['pill_text']))
                      <span class="bg-light px-3 py-1 text-action text-sm rounded-full">{{ $feature['pill_text'] }}</span>
                    @endif
                    @if (!empty($feature['content']))
                      <div class="mt-4 text-gray-700">
                        @if (strpos($feature['content'], '<blockquote>') !== false)
                          <div class="mb-2">
                            <svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12.842C1.5 8.267 4.125 3.992 7.575 1.592l2.775 2.25C7.95 5.417 5.85 8.417 5.55 10.817c.075 0 .6-.15.975-.15 2.1 0 3.675 1.65 3.675 3.825 0 2.25-1.8 4.05-4.05 4.05-2.475 0-4.65-2.025-4.65-5.7Zm12 0c0-4.575 2.625-8.85 6.075-11.25l2.775 2.25c-2.4 1.575-4.5 4.575-4.8 6.975.15 0 .675-.15.975-.15 2.1 0 3.675 1.65 3.675 3.825 0 2.25-1.8 4.05-4.05 4.05-2.475 0-4.65-2.025-4.65-5.7Z" stroke="#2F71F4" stroke-width="1.25"/></svg>
                          </div>
                        @endif
                        {!! $feature['content'] !!}
                      </div>
                    @endif

                    @if ($hasIcon)
                      <div class="absolute right-8 top-8">
                        <img src="{{ $feature['icon_right_aligned']['url'] }}" alt="{{ $feature['icon_right_aligned']['alt'] ?? 'Icon' }}" class="h-15 object-contain">
                      </div>
                    @endif
                  </div>

                  @if ($hasLink)
                    </a>
                  @endif
                </div>
              @endif

              {{-- Logos slider --}}
              @if (!empty($card['logos']))
                @php $logos = $card['logos']; $swiper_ref = 'logos'.$idx; @endphp
                <div class="relative max-w-7xl mx-auto px-8 sm:px-14 mt-12" x-data="{ swiper:null }" x-init="$nextTick(()=> {
                  swiper=new Swiper($refs.container,{
                    loop: {{ (count($logos)>3) ? 'true':'false' }},
                    autoplay:false,slidesPerGroup:1,
                    pagination:{ el:'.swiper-pagination', clickable:true },
                    breakpoints:{ 0:{slidesPerView:1,spaceBetween:20},768:{slidesPerView:3,spaceBetween:40} },
                    on:{ afterInit:function(){ document.querySelectorAll('.swiper-arrow-{{ $swiper_ref }}').forEach(el=>el.classList.toggle('hidden',this.isLocked)); } }
                  });
                  swiper.on('resize', function(){ document.querySelectorAll('.swiper-arrow-{{ $swiper_ref }}').forEach(el=>el.classList.toggle('hidden',this.isLocked)); });
                })">
                  @if (count($logos) > 1)
                    <div class="swiper-arrow-{{ $swiper_ref }} absolute left-0 top-[20%]">
                      <button aria-label="previous" @click="swiper.slidePrev()" class="text-blue-300 hover:text-action transition flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 13.66 6 10.66m0 0L9 7.66M6 10.66h8M1 10.66C1 5.69 5.03 1.66 10 1.66s9 4.03 9 9-4.03 9-9 9-9-4.03-9-9Z" stroke="#C7D8E8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      </button>
                    </div>
                  @endif

                  <div class="swiper" x-ref="container">
                    <div class="swiper-wrapper">
                      @foreach ($logos as $logo)
                        <div class="swiper-slide flex justify-center items-center">
                          <img class="object-contain w-48 h-16 mx-auto mix-blend-multiply" src="{{ $logo['logo']['sizes']['medium'] }}" alt="{{ $logo['logo']['alt'] ?? 'Logo' }}">
                        </div>
                      @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                  </div>

                  @if (count($logos) > 1)
                    <div class="swiper-arrow-{{ $swiper_ref }} absolute right-0 top-[20%]">
                      <button aria-label="next" @click="swiper.slideNext()" class="text-blue-300 hover:text-action transition flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11 7.66 14 10.66m0 0-3 3m3-3H6M19 10.66c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9Z" stroke="#C7D8E8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                      </button>
                    </div>
                  @endif
                </div>
              @endif

              {{-- Two Columns --}}
              @if (!empty($card['two_columns']))
                @php
                  $two = $card['two_columns'];
                  $hasImage = !empty($two['image']['url']);
                @endphp
                <div class="two-columns grid grid-cols-1 md:grid-cols-2 gap-12 items-center mt-12">
                  <div class="flex flex-col space-y-4 order-2 md:order-1">
                    @if (!empty($two['pill']))
                      <span class="@if (!empty($two['white_bg'])) bg-white @else bg-light @endif px-3 py-1 text-action text-sm rounded-full inline-block w-fit">{{ $two['pill'] }}</span>
                    @endif
                    @if (!empty($two['heading'])) <h2>{{ $two['heading'] }}</h2> @endif
                    @if (!empty($two['content'])) <p class="text-gray-700">{{ $two['content'] }}</p> @endif
                  </div>
                  @if ($hasImage)
                    <div class="order-1 md:order-2">
                      <img src="{{ $two['image']['url'] }}" alt="{{ $two['image']['alt'] ?? 'Image' }}" class="w-full h-auto object-cover rounded-lg">
                    </div>
                  @endif
                </div>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>

@if (!empty($background['divider_bottom']))
  @includeIf('dividers.waves-bottom')
@endif
