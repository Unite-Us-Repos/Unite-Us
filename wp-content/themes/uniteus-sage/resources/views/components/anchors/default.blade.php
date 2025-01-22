@php
    $flex_index = $index;
@endphp
@if ($background['has_divider'])
    @includeIf('dividers.waves')
@endif

<style>
    .anchor-icon img {
        filter: grayscale(1);
        opacity: .6;
    }

    .anchor-icon:hover img,
    .active-anchor .anchor-icon img {
        filter: invert(43%) sepia(71%) saturate(4510%) hue-rotate(205deg) brightness(104%) contrast(105%);
        opacity: 1;
    }

    .anchor-li {
        border-left: solid 3px transparent;
    }

    .anchor-li:hover,
    .active-anchor.anchor-li {
        border-color: #216CFF;
        font-weight: 700;
    }

    .active-anchor.anchor-li a {
        color: #0B1538;
    }
</style>
<section
    class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif"
    @isset($section['id']) id="{{ $section['id'] }}" @endisset>
    <div x-data="{
        navHeight: 90, // Default navbar height
        calculateTop() {
            const nav = document.querySelector('.navbar');
            if (nav) {
                this.navHeight = nav.offsetHeight;
            }
        }
    }" x-init="calculateTop()"
        class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

        <div class="text-center mb-6">
            @if ($section['subtitle'])
                @if ($section['subtitle_display_as_pill'])
                    <span
                        class="@if ($background['color'] == 'dark') bg-brand text-action-light-blue @else text-action bg-light  mix-blend-multiply @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
                    @else
                        <span
                            class="block text-base mb-3 font-semibold uppercase tracking-wider @if ('dark' == $background['color']) text-action-light-blue @else text-action @endif">
                @endif
                {{ $section['subtitle'] }}
                </span>
            @endif
            <h2 class="mb-3 @if ('dark' == $background['color']) text-white @endif">{!! $section['title'] !!}</h2>
            <div class=" width-40 mx-auto text-lg @if ('dark' == $background['color']) text-white @endif">
                {!! $section['description'] !!}
            </div>
        </div>

        @if ($cards)
            <div x-data="{ showSlide: '0' }"
                class="relative flex flex-col lg:grid lg:grid-cols-12 gap-6 pt-4 @if (!empty($alternate) && $alternate) alternate @endif">
                <div class="col-span-3">
                    <div class="sticky" :style="`top: ${navHeight + 8}px;`">
                        <div class="uppercase text-action font-bold pb-4 hidden opacity-0 lg:block lg:opacity-100">
                            @if (!empty($anchor_heading)) {{ $anchor_heading }}
                            @else
                                Jump To @endif
                        </div>
                        <ul class="hidden lg:flex  list-none flex-col gap-4 border-l border-blue-300"
                            style="border-left: solid 1px #C7D8E8 !important;">

                            @foreach ($cards as $index => $card)
                                @php
                                    $anchor = strtolower($card['title']);
                                    $anchor = str_replace(' ', '-', $anchor);
                                @endphp
                                <li :class="showSlide == '{{ $index }}' ? 'active-anchor' : ''" class="anchor-li"
                                    style="padding-left: 30px;">
                                    <a href="#{{ $anchor }}"
                                        class="anchor-icon flex gap-6 items-center no-underline text-xl text-gray-500">
                                        @isset($card['icon']['sizes'])
                                            <img class="w-12 h-12 object-contain"
                                                src="{{ $card['icon']['sizes']['medium'] }}" alt="" />
                                        @endisset
                                        {{ $card['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="sticky top-8 z-20 lg:hidden" style="margin-top: 0rem; margin-bottom: 2rem;">
                        <div x-data="Components.menu({ open: false })" x-init="init()"
                            @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)"
                            class="relative inline-block text-left w-full">
                            <div>
                                <button type="button"
                                    class="inline-flex w-full justify-between items-center gap-x-1.5 rounded-md bg-white px-6 py-4 text-base font-semibold text-brand hover:bg-light hover:bg-opacity-30 shadow-md ring-1 ring-inset ring-light ring-opacity-50"
                                    id="menu-button" x-ref="button" @click="onButtonClick()"
                                    @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()"
                                    aria-expanded="true" aria-haspopup="true" x-bind:aria-expanded="open.toString()"
                                    @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()">
                                    Jump To
                                    <svg width="8" height="15" viewBox="0 0 8 15" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4 0.353027C4.26522 0.353027 4.51957 0.458384 4.70711 0.645921L7.70711 3.64592C8.09763 4.03645 8.09763 4.66961 7.70711 5.06013C7.31658 5.45066 6.68342 5.45066 6.29289 5.06013L4 2.76724L1.70711 5.06013C1.31658 5.45066 0.683417 5.45066 0.292893 5.06013C-0.0976311 4.66961 -0.097631 4.03644 0.292893 3.64592L3.29289 0.64592C3.48043 0.458384 3.73478 0.353027 4 0.353027ZM0.292893 9.64592C0.683417 9.2554 1.31658 9.2554 1.70711 9.64592L4 11.9388L6.29289 9.64592C6.68342 9.2554 7.31658 9.2554 7.70711 9.64592C8.09763 10.0364 8.09763 10.6696 7.70711 11.0601L4.70711 14.0601C4.31658 14.4507 3.68342 14.4507 3.29289 14.0601L0.292893 11.0601C-0.0976311 10.6696 -0.0976311 10.0364 0.292893 9.64592Z"
                                            fill="#216CFF" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute left-0 right-0 w-full z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state."
                                x-bind:aria-activedescendant="activeDescendant" role="menu"
                                aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
                                @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()"
                                @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()"
                                @keyup.space.prevent="open = false; focusButton()">
                                <div id="js-toc-navigation" class="py-4" role="none">
                                    @foreach ($cards as $index => $card)
                                        @php
                                            $anchor = strtolower($card['title']);
                                            $anchor = str_replace(' ', '-', $anchor);
                                        @endphp
                                        <a href="#{{ $anchor }}"
                                            class="mobile-nav-jump block no-underline px-6 py-2">{{ $card['title'] }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-9 flex flex-col gap-32">
                    @foreach ($cards as $index => $card)
                        @php
                            $anchor = strtolower($card['title']);
                            $anchor = str_replace(' ', '-', $anchor);
                        @endphp
                        <div id="{{ $anchor }}"
                            x-intersect.margin.0.0.-50%.0="showSlide = '{{ $index }}'">
                            <div
                                class="group relative flex flex-col-reverse sm:flex-row sm:justify-between sm:items-end mb-0 gap-10">
                                @if (empty($alternate) || !$alternate)
                                    <h2 class="mb-0 text-4xl">{{ $card['title'] }}</h2>
                                @endif
                                @isset($card['icon']['sizes'])
                                    <img class="group-hover:icon-gray w-40 h-auto object-contain right-0 bottom-0"
                                        src="{{ $card['icon']['sizes']['medium'] }}" alt=""
                                        style="max-height: 90px;" />
                                @endisset
                            </div>
                            <div class="text-lg">
                                {!! $card['description'] !!}
                            </div>


                            <div
                                class="flex flex-col gap-12 mt-10
                @if ($card['stats'] && $card['articles']) md:grid md:grid-cols-12 
                @elseif ($card['stats'] && ($card['partners'] || $card['feature_box']['content'])) 
                    gap-4 md:flex-row @endif">
                                @php
                                    $keyStatsClass = 'key-stats col-span-6 md:basis-1/2';
                                    // Add flex class ONLY if "Stats" exist, but "Partners" and "Articles" do NOT exist
                                    if (
                                        !empty($card['stats']) &&
                                        empty($card['partners']) &&
                                        empty($card['articles']) & empty($card['feature_box']['content'])
                                    ) {
                                        $keyStatsClass .= ' md:flex md:flex-wrap !md:gap-0';
                                        $numStats = count($card['stats'] ?? []);
                                        $keyStatClass = $numStats % 2 == 0 ? 'md:basis-1/2' : 'md:basis-1/3';
                                    }
                                @endphp
                                @if ($card['stats'])
                                    @if (empty($alternate) || !$alternate)
                                        <div class="col-span-6">
                                            <h3>Key Stats</h3>
                                            <div class="grid grid-cols-12 gap-5">
                                                @foreach ($card['stats'] as $stat)
                                                    <div
                                                        class="@if ($card['stats'] && $card['articles']) col-span-6 @else col-span-6 md:col-span-3 @endif relative border border-blue-200 rounded-xl p-3 lg:p-6 group">
                                                        <div class="relative z-10 text-action group-hover:text-white">
                                                            <h2 class="font-extrabold text-3xl mb-4 leading-tight">
                                                                {!! $stat['label'] !!}</h2>
                                                            <div class="text-sm text-brand group-hover:text-white">
                                                                {!! $stat['description'] !!}</div>
                                                        </div>
                                                        <div
                                                            class="absolute inset-0 bg-action z-0 rounded-xl opacity-0 group-hover:opacity-100">
                                                            @isset($stat['background_image']['sizes'])
                                                                <img class="opacity-10 w-full h-full object-cover"
                                                                    src="{{ $stat['background_image']['sizes']['medium'] }}"
                                                                    alt="" />
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                </div>
                            </div>
                        @else
                            <div class="key-stats col-span-6 md:basis-1/2 border-t">
                                <h3 class="uppercase text-action text-sm mb-4 mt-4">Key Stats</h3>
                                <div class="grid">
                                    <div class="grid-cols-6 {{ $keyStatsClass }}">
                                        @foreach ($card['stats'] as $stat)
                                            <div class="relative p-3 pl-0 flex gap-4 {{ $keyStatClass }}">
                                                <div class="icon pt-1">
                                                    <svg width="17" height="17" viewBox="0 0 17 17"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M8.53027 16.945C12.9486 16.945 16.5303 13.3633 16.5303 8.94501C16.5303 4.52673 12.9486 0.945007 8.53027 0.945007C4.112 0.945007 0.530273 4.52673 0.530273 8.94501C0.530273 13.3633 4.112 16.945 8.53027 16.945ZM12.2374 7.65211C12.6279 7.26159 12.6279 6.62842 12.2374 6.2379C11.8469 5.84738 11.2137 5.84738 10.8232 6.2379L7.53027 9.53079L6.23738 8.2379C5.84686 7.84738 5.21369 7.84738 4.82317 8.2379C4.43264 8.62842 4.43264 9.26159 4.82317 9.65211L6.82317 11.6521C7.21369 12.0426 7.84686 12.0426 8.23738 11.6521L12.2374 7.65211Z"
                                                            fill="#2F71F4" />
                                                    </svg>
                                                </div>
                                                <div class="text-md text-brand">
                                                    {!! $stat['description'] !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
            @endif
            @if (!empty($card['partners']))
                <div class="partners col-span-6 flex flex-col md:basis-1/2 border-t">
                    <h3 class="uppercase text-action text-sm mb-4 mt-4">Partners</h3>
                    <div class="flex-col md:flex-row flex-wrap flex-1 flex gap-4 mt-4">
                        @foreach ($card['partners'] as $partner)
                            @if (!empty($partner['partner']['url']))
                                <div class="flex-classes border rounded-lg shadow-sm bg-white p-4">
                                    @if (!empty($partner['link']['url']))
                                        <a href="{{ $partner['link']['url'] }}"
                                            target="{{ $partner['link']['target'] ?? '_self' }}"
                                            class="partner-link flex-classes">
                                            <img src="{{ $partner['partner']['url'] }}"
                                                alt="{{ $partner['partner']['alt'] ?? 'Partner logo' }}"
                                                class="partner-logo h-auto object-contain" />
                                        </a>
                                    @else
                                        <img src="{{ $partner['partner']['url'] }}"
                                            alt="{{ $partner['partner']['alt'] ?? 'Partner logo' }}"
                                            class="partner-logo h-auto object-contain" />
                                    @endif
                                </div>
                            @else
                                <p>No image available for this partner.</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            @if (!empty($card['feature_box']) && !empty($card['feature_box']['content']))
                @php
                    $feature = $card['feature_box'];
                    $hasLink = !empty($feature['link']['url']);
                    $hasIcon = !empty($feature['icon_right_aligned']['url']);
                    $hasPill = !empty($feature['pill_text']);
                    $hasContent = !empty($feature['content']);
                @endphp

                <div
                    class="feature-box col-span-6 flex flex-col md:basis-1/2 border-t shadow-lg rounded-lg bg-white group relative overflow-hidden">
                    {{-- Wrap in a link if it exists --}}
                    @if ($hasLink)
                        <a href="{{ $feature['link']['url'] }}" target="{{ $feature['link']['target'] ?? '_self' }}"
                            class="relative block p-6 no-underline hover:no-underline">
                            {{-- External link icon at the top --}}
                            <div class="absolute top-8 right-4">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="#C7D8E8"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="transition-colors duration-300 group-hover:fill-[#216CFF]">
                                    <path
                                        d="M19.5294 1.13083H20.647C20.647 0.834412 20.5293 0.550134 20.3197 0.340535C20.1101 0.130935 19.8258 0.0131836 19.5294 0.0131836V1.13083ZM18.4117 14.5426C18.4117 14.839 18.5295 15.1233 18.7391 15.3329C18.9487 15.5425 19.2329 15.6602 19.5294 15.6602C19.8258 15.6602 20.1101 15.5425 20.3197 15.3329C20.5293 15.1233 20.647 14.839 20.647 14.5426H18.4117ZM6.11759 0.0131836C5.82118 0.0131836 5.5369 0.130935 5.3273 0.340535C5.1177 0.550134 4.99995 0.834412 4.99995 1.13083C4.99995 1.42725 5.1177 1.71153 5.3273 1.92113C5.5369 2.13073 5.82118 2.24848 6.11759 2.24848V0.0131836ZM0.856829 18.223C0.750083 18.3261 0.664938 18.4494 0.606363 18.5858C0.547788 18.7221 0.516957 18.8688 0.515667 19.0172C0.514378 19.1656 0.542656 19.3128 0.598852 19.4501C0.655049 19.5875 0.738037 19.7123 0.842976 19.8172C0.947915 19.9222 1.0727 20.0051 1.21006 20.0613C1.34741 20.1175 1.49458 20.1458 1.64298 20.1445C1.79138 20.1432 1.93804 20.1124 2.0744 20.0538C2.21076 19.9953 2.33408 19.9101 2.43718 19.8034L0.856829 18.223ZM18.4117 1.13083V14.5426H20.647V1.13083H18.4117ZM19.5294 0.0131836H6.11759V2.24848H19.5294V0.0131836ZM18.7392 0.340654L0.856829 18.223L2.43718 19.8034L20.3195 1.92101L18.7392 0.340654Z" />
                                </svg>
                            </div>
                    @endif
                    <div class="p-6 relative">
                        {{-- Pill Text --}}
                        @if ($hasPill)
                            <span class="bg-light px-3 py-1 text-action text-sm font-semibold rounded-full">
                                {{ $feature['pill_text'] }}
                            </span>
                        @endif

                        {{-- Content / WYSIWYG --}}
                        @if ($hasContent)
                            <div class="mt-4 text-gray-700">
                                {{-- Show Blockquote SVG if the content contains <blockquote> --}}
                                @if (strpos($feature['content'], '<blockquote>') !== false)
                                    <div class="mb-2">
                                        <svg width="24" height="20" viewBox="0 0 24 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M1.5 12.8418C1.5 8.2668 4.125 3.9918 7.575 1.5918L10.35 3.8418C7.95 5.4168 5.85 8.4168 5.55 10.8168C5.625 10.8168 6.15 10.6668 6.525 10.6668C8.625 10.6668 10.2 12.3168 10.2 14.4918C10.2 16.7418 8.4 18.5418 6.15 18.5418C3.675 18.5418 1.5 16.5168 1.5 12.8418ZM13.5 12.8418C13.5 8.2668 16.125 3.9918 19.575 1.5918L22.35 3.8418C19.95 5.4168 17.85 8.4168 17.55 10.8168C17.7 10.8168 18.225 10.6668 18.525 10.6668C20.625 10.6668 22.2 12.3168 22.2 14.4918C22.2 16.7418 20.4 18.5418 18.15 18.5418C15.675 18.5418 13.5 16.5168 13.5 12.8418Z"
                                                stroke="#2F71F4" stroke-width="1.25" />
                                        </svg>
                                    </div>
                                @endif
                                {!! $feature['content'] !!}
                            </div>
                        @endif

                        {{-- Right-aligned Icon --}}
                        @if ($hasIcon)
                            <div class="absolute right-8 top-8">
                                <img src="{{ $feature['icon_right_aligned']['url'] }}"
                                    alt="{{ $feature['icon_right_aligned']['alt'] ?? 'Icon' }}"
                                    class="h-15 object-contain">
                            </div>
                        @endif
                    </div>
                    {{-- Close link wrapper if present --}}
                    @if ($hasLink)
                        </a>
                    @endif
                </div>
            @endif


            @if ($card['articles'])
                <div class="articles col-span-6 flex flex-col">
                    <h3>Articles</h3>
                    @foreach ($card['articles'] as $article)
                        <div class="text-lg">
                            <a class="relative group block border-t border-blue-300 hover:border-t-2 hover:border-action pt-6 pb-10 no-underline text-brand hover:font-semibold hover:text-action"
                                href="{{ get_permalink($article->ID) }}" style="padding-right: 2rem;">
                                {{ $article->post_title }}

                                <div
                                    class="absolute p-7 pr-0 flex justify-end inset-0 z-10 rounded-xl group-hover:opacity-0">
                                    <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up.svg')" alt="" />
                                </div>
                                <div
                                    class="absolute p-7 pr-0 flex justify-end inset-0 z-10 rounded-xl opacity-0 group-hover:opacity-100">
                                    <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up-active.svg')" alt="" />
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @if (!empty($card['logos']))
            @php
                $logos = $card['logos'];
                $swiper_ref = 'logos' . $index;
            @endphp

            <div class="relative max-w-7xl mx-auto px-8 sm:px-14 mt-12" x-data="{ swiper: null }" x-init="$nextTick(() => {
                swiper = new Swiper($refs.container, {
                    loop: {{ count($logos) > 3 ? 'true' : 'false' }},
                    autoplay: false,
                    slidesPerGroup: 1,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        0: { slidesPerView: 1, spaceBetween: 20 },
                        768: { slidesPerView: 3, spaceBetween: 40 },
                    },
                    on: {
                        afterInit: function() {
                            document.querySelectorAll('.swiper-arrow-{{ $swiper_ref }}').forEach(el => {
                                el.classList.toggle('hidden', this.isLocked);
                            });
                        }
                    }
                });
            
                swiper.on('resize', function() {
                    document.querySelectorAll('.swiper-arrow-{{ $swiper_ref }}').forEach(el => {
                        el.classList.toggle('hidden', this.isLocked);
                    });
                });
            })">
                @if (count($logos) > 1)
                    <div class="swiper-arrow-{{ $swiper_ref }} absolute left-0 top-[20%]">
                        <button aria-label="previous" @click="swiper.slidePrev()"
                            class="text-blue-300 hover:text-action transition flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9 13.6602L6 10.6602M6 10.6602L9 7.66016M6 10.6602L14 10.6602M1 10.6602C1 5.68959 5.02944 1.66016 10 1.66016C14.9706 1.66016 19 5.68959 19 10.6602C19 15.6307 14.9706 19.6602 10 19.6602C5.02944 19.6602 1 15.6307 1 10.6602Z"
                                    stroke="#C7D8E8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                @endif

                <div class="swiper" x-ref="container">
                    <div class="swiper-wrapper">
                        @foreach ($logos as $logo)
                            <div class="swiper-slide flex justify-center items-center">
                                <img class="object-contain w-48 h-16 mx-auto mix-blend-multiply"
                                    src="{{ $logo['logo']['sizes']['medium'] }}"
                                    alt="{{ $logo['logo']['alt'] ?? 'Logo' }}" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                @if (count($logos) > 1)
                    <div class="swiper-arrow-{{ $swiper_ref }} absolute right-0 top-[20%]">
                        <button aria-label="next" @click="swiper.slideNext()"
                            class="text-blue-300 hover:text-action transition flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 7.66016L14 10.6602M14 10.6602L11 13.6602M14 10.6602L6 10.6602M19 10.6602C19 15.6307 14.9706 19.6602 10 19.6602C5.02944 19.6602 1 15.6307 1 10.6602C1 5.68959 5.02944 1.66016 10 1.66016C14.9706 1.66016 19 5.68959 19 10.6602Z"
                                    stroke="#C7D8E8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        @endif

        @if (!empty($card['two_columns']))
            @php
                $twoColumns = $card['two_columns'];
                $hasImage = !empty($twoColumns['image']['url']);
                $hasPill = !empty($twoColumns['pill']);
                $hasHeading = !empty($twoColumns['heading']);
                $hasContent = !empty($twoColumns['content']);
                $whiteBG = $twoColumns['white_bg'];
            @endphp

            <div class="two-columns grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                {{-- Left Side: Text Content --}}
                <div class="flex flex-col space-y-4">
                    @if ($hasPill)
                        <span class="@if ($whiteBG) bg-white @else bg-light @endif px-3 py-1 text-action text-sm rounded-full inline-block w-fit">
                            {{ $twoColumns['pill'] }}
                        </span>
                    @endif

                    @if ($hasHeading)
                        <h2>
                            {{ $twoColumns['heading'] }}
                        </h2>
                    @endif

                    @if ($hasContent)
                        <p class="text-gray-700">
                            {{ $twoColumns['content'] }}
                        </p>
                    @endif
                </div>

                {{-- Right Side: Image --}}
                @if ($hasImage)
                    <div>
                        <img src="{{ $twoColumns['image']['url'] }}" alt="{{ $twoColumns['image']['alt'] ?? 'Image' }}"
                            class="w-full h-auto object-cover rounded-lg">
                    </div>
                @endif
            </div>
        @endif


        </div>
        @endforeach
        </div>
        </div>
        @endif
    </section>
    @if ($background['divider_bottom'])
        @includeIf('dividers.waves-bottom')
    @endif
