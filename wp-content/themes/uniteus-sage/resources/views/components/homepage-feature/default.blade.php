@php
    $s_settings = [
        'collapse_padding' => false,
        'fullscreen' => '',
    ];
@endphp
@if ($background['has_divider'])
    @includeIf('dividers.waves')
@endif

<section @isset($section['id']) id="{{ $section['id'] }}" @endisset
    class="component-section homepage-feature-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
    <div class="absolute inset-0">
        @if ($background['image'])
            <img fetchPriority="high"
                class="w-full h-full @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                src="{{ $background['image']['sizes']['medium'] }}"
                srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
                sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
        @endif
    </div>
    <div class="relative z-10 component-inner-section">
        <div class="text-center mb-7">
            @if (!empty($section['subtitle']))
                @php
                    $isPill = !empty($section['subtitle_display_as_pill']);
                    $bg = $background['color'] ?? '';

                    if ($isPill) {
                        // base pill classes
                        $classes = 'text-sm py-1 px-4 inline-block mb-6 rounded-full ';

                        if ($bg === 'dark') {
                            // dark background variant
                            $classes .= 'text-white bg-light/10';
                        } else {
                            // non-dark variants share text color
                            $classes .= 'text-action ';
                            $classes .= $bg === 'light-gradient' ? 'bg-white' : 'bg-light mix-blend-multiply';
                        }
                    } else {
                        // non-pill style
                        $classes = 'block text-base mb-8 font-semibold uppercase tracking-wider text-action';
                    }
                @endphp
                <span class="{{ $classes }}">{{ $section['subtitle'] }}</span>
            @endif

            <h2 class="max-w-lg mx-auto mb-6 text-white text-center">
                {!! $section['title'] !!}
            </h2>
            <div class="text-lg">
                <div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div>
            </div>
        </div>
    </div>
    <div class="z-10 relative">
        @if ($background['overlay'])
            <div
                class="absolute bottom-0 -mb-[1px] w-full h-[88%] border border-blue-900 sm:h-3/4 lg:h-3/6 bg-blue-900">
            </div>
        @endif
        <div class="component-inner-section">
            @php
                // Pull from locals or from the ACF group on $section
                $pillItems = $pills ?? ($section['pills'] ?? []);
                $cta = $link ?? ($section['link'] ?? null);
                $featured = $featured_image ?? ($section['featured_image'] ?? null);
                $featuredDesktop = $featured_image_desktop ?? ($section['featured_image_desktop'] ?? null);
                $icon = $icon ?? ($section['icon'] ?? null);
            @endphp

            {{-- Pills row --}}
            @if (!empty($pillItems))
                <div
                    class="mx-auto mt-2 flex max-w-3xl flex-wrap items-center justify-center gap-x-3 gap-y-3 sm:justify-center">
                    @foreach ($pillItems as $pill)
                        @php
                            // ACF "Dot Color" field is named bg_image in your JSON (color picker returns hex)
                            $dot = $pill['bg_image'] ?: '#2F71F4';
                        @endphp
                        <div>
                            <span
                                class="inline-flex items-center rounded-full bg-white/10 px-4 py-1 text-sm font-medium text-white/90 ring-1 ring-inset ring-white/15 backdrop-blur-[1px] hover:bg-white/15 transition-colors">
                                <span class="mr-2 inline-block h-2.5 w-2.5 rounded-full"
                                    style="background-color: {{ $dot }}"></span>
                                {!! $pill['title'] ?? '' !!}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Gradient CTA link --}}
            @if (!empty($cta) && !empty($cta['url']))
                <p class="mt-5 text-center">
                    <a href="{{ esc_url($cta['url']) }}" target="{{ $cta['target'] ?: '_self' }}"
                        class="inline-block font-semibold underline underline-offset-4 decoration-white/20 hover:decoration-transparent
                            bg-clip-text text-transparent bg-gradient-to-r from-[#56A2FF] via-[#7E6BFF] to-[#C26CFF]">
                        {{ $cta['title'] ?? 'See Customer Success Stories' }}
                    </a>
                </p>
            @endif
            <div class="relative mx-auto mt-10 md:mt-12 max-w-6xl">
                {{-- Desktop --}}
                @if (!empty($featuredDesktop['url']))
                    <figure class="relative mx-auto max-w-6xl hidden lg:block">
                    <img
                        class="lazy w-full h-auto object-cover"
                        data-src="{{ $featuredDesktop['sizes']['1536x1536'] ?? ($featuredDesktop['sizes']['large'] ?? $featuredDesktop['url']) }}"
                        alt="{{ $featuredDesktop['alt'] ?? ($featured['alt'] ?? strip_tags($section['title'] ?? '')) }}">
                    </figure>
                @endif

                {{-- Mobile / tablet --}}
                @if (!empty($featured['url']))
                    <figure class="relative mx-auto max-w-6xl lg:hidden">
                    <img
                        class="lazy w-full h-auto object-cover"
                        data-src="{{ $featured['sizes']['1536x1536'] ?? ($featured['sizes']['large'] ?? $featured['url']) }}"
                        alt="{{ $featured['alt'] ?? ($featuredDesktop['alt'] ?? strip_tags($section['title'] ?? '')) }}">
                    </figure>
                @endif

                 {{-- Desktop-only: featured icons repeater --}}
                    @php
                        $icons = $featured_icons ?? ($section['featured_icons'] ?? []);
                    @endphp
                    @if (!empty($icons))
                        <div class="hidden lg:flex">
                        @foreach ($icons as $row)
                            @php
                            // subfield assumed 'icon' (image array or ID)
                            $iconImg    = $row['icon'] ?? null;
                            $src     = '';
                            $altText = '';

                            if (is_array($iconImg) && !empty($iconImg['url'])) {
                                $src     = $iconImg['sizes']['medium'] ?? $iconImg['url'];
                                $altText = $iconImg['alt'] ?? '';
                            } elseif (!empty($iconImg)) { // ID fallback
                                $src     = wp_get_attachment_image_url($iconImg, 'medium');
                                $altText = get_post_meta($iconImg, '_wp_attachment_image_alt', true) ?: '';
                            }
                            @endphp

                            @if (!empty($src))
                            <div class="featured-icon-img shrink-0 absolute">
                                <img class="lazy" data-src="{{ $src }}" alt="{{ esc_attr($altText) }}">
                            </div>
                            @endif
                        @endforeach
                        </div>
                    @endif
                {{-- Icon below --}}
                @if (!empty($icon) && !empty($icon['url']))
                    <figure class="absolute mx-auto homepage-icon">
                        <img class="lazy w-full h-auto object-cover"
                            data-src="{{ $icon['sizes']['1536x1536'] ?? ($icon['sizes']['large'] ?? $icon['url']) }}"
                            alt="{{ $icon['alt'] ?: strip_tags($section['title'] ?? '') }}">
                    </figure>
                @endif
            </div>
            <div class="bottom-white-divider">
                <svg class="w-full h-full" width="1358" height="80" preserveAspectRatio="none" viewBox="0 0 1358 80"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 9.85705L56.625 15.7023C113.25 21.5475 226.5 33.238 339.75 27.3928C453 21.5475 566.25 -1.83344 679.5 0.114975C792.75 2.06339 906 29.3412 1019.25 35.1865C1132.5 41.0317 1245.75 25.4444 1302.37 17.6507L1359 9.85705V80H1302.37C1245.75 80 1132.5 80 1019.25 80C906 80 792.75 80 679.5 80C566.25 80 453 80 339.75 80C226.5 80 113.25 80 56.625 80H0V9.85705Z"
                        fill="#FFFFFF"></path>
                    <defs>
                        <linearGradient x1="679.5" y1="0" x2="679.5" y2="80"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#EEF5FC"></stop>
                            <stop offset="1" stop-color="#EEF5FC"></stop>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
@if ($background['divider_bottom'])
    @includeIf('dividers.waves-bottom')
@endif
