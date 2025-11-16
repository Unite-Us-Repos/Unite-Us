@php
    $job_id = 0;
    $job_title = '';
    $title_override = false;
    if ($section['title']) {
        $job_title = $section['title'];
    }

    // --- Desktop hero intrinsic sizes (unchanged) ---
    $bgSrc = $bgW = $bgH = null;
    if (!empty($background['image'])) {
        $bg = $background['image'];
        $bgSrc = $bg['sizes']['2048x2048'] ?? ($bg['url'] ?? null);
        $bgW = $bg['sizes']['2048x2048-width'] ?? ($bg['width'] ?? null);
        $bgH = $bg['sizes']['2048x2048-height'] ?? ($bg['height'] ?? null);
    }

    // preserve existing (unused now) mobile logo vars for compatibility
    $mobSrc = $mobW = $mobH = null;
    if (!empty($section['logo']['sizes'])) {
        $mobSrc = $section['logo']['sizes']['medium'] ?? ($section['logo']['url'] ?? null);
        $mobW = $section['logo']['sizes']['medium-width'] ?? ($section['logo']['width'] ?? null);
        $mobH = $section['logo']['sizes']['medium-height'] ?? ($section['logo']['height'] ?? null);
    }
@endphp
@if (!empty($bgSrc))
  <link rel="preload" as="image"
        href="{{ $bgSrc }}"
        imagesizes="100vw"
        media="(min-width: 768px)">
@endif
<style>
    /* Reserve desktop hero height (kept from your original) */
    .hero-v3 { min-height: clamp(520px, 70vh, 820px); }

    @media (max-width: 768px) {
        .hero-v3 { padding: 0 !important; min-height: 560px; }
    }

    /* NEW: mobile text block uses your provided blue background image */
    .mobile-copy-bg{
        background-image: url("@asset('/images/hero-bg.png')");
        background-image: image-set(
            url("@asset('/images/hero-bg.webp')") type('image/webp'),
            url("@asset('/images/hero-bg.png')") type('image/png')
        );
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    @media (min-width: 640px) {
        .hero-v3 .component-inner-section {
            padding-left: 0;
            padding-right: 0;
        }
    }
    @media (min-width: 1024px) {
        .hero-v3 .component-inner-section {
            padding-left: 2rem;
            padding-right: 2rem;
        }
    }
</style>

<section
    class="relative hero-v3 component-section md:!py-24 {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">

    <!-- Desktop-only right-half decorative wrapper (HIDE on mobile) -->
    <div class="absolute justify-end top-0 bottom-0 right-0 z-20 hidden md:flex" style="width: 50%">
        <img class="absolute hidden lg:block" fetchpriority="high" src="@asset('/images/herov3-blue-bar.png')" alt="" width="208"
             height="208" style="right: 8%; width: 208px; top: 7%" />
        <img class="absolute" fetchpriority="high" src="@asset('/images/herov3-heart-home-pink.png')" alt="" width="230" height="230"
             style="right: 0; width: 230px; bottom: 0" />
    </div>

    <!-- Desktop-only right-half blue/pattern panel + accents (unchanged) -->
    <div class="absolute bg-homev3 inset-0 bg-brand z-10 hidden md:block" style="width: 50%;">
        <img class="absolute" fetchpriority="high" src="@asset('/images/herov3-food-green.png')" alt="" width="230" height="230"
             style="right: -130px; width: 230px; top: 0" />
        <img class="absolute" fetchpriority="high" src="@asset('/images/herov3-profile-chart-blue.png')" alt="" width="140" height="140"
             style="right: -80px; width: 140px; bottom: 33%;" />
        <img class="absolute hidden lg:block" fetchpriority="high" src="@asset('/images/herov3-grad-bar-purple.png')" alt="" width="160"
             height="160" style="right: -225px; width: 160px; bottom: 13%;" />
    </div>

    <!-- Desktop background image (unchanged) -->
    <div class="absolute inset-0">
        @if ($background['image'])
            <img fetchpriority="high" decoding="async"
                 class="hero-desktop hidden md:block w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                 src="{{ $bgSrc }}" @if ($bgW) width="{{ $bgW }}" @endif @if ($bgH) height="{{ $bgH }}" @endif
                 alt="{{ $background['image']['alt'] }}">
        @endif
    </div>

    @if ($background['overlay'])
        <div class="absolute inset-0 bg-brand opacity-75 hidden md:block"></div>
    @endif

    <div class="relative w-full z-20">
        <div class="component-inner-section">

            <!-- ********** MOBILE-ONLY BLOCKS (CLS-safe) ********** -->

            {{-- ********** MOBILE-ONLY LCP IMAGE (responsive WebP) ********** --}}
            @php
            // Try to read intrinsic size of Mobile-412.webp for correct aspect ratio reservation
            $m412Url  = asset('images/Mobile-412.webp');
            $m412Path = function_exists('get_theme_file_path') ? get_theme_file_path('resources/images/Mobile-412.webp') : null;
            [$m412W, $m412H] = [412, 445]; // safe fallback (matches PSI’s displayed ~412x445)
            if ($m412Path && file_exists($m412Path)) {
                $info = @getimagesize($m412Path);
                if ($info) { [$m412W, $m412H] = [$info[0], $info[1]]; }
            }
            @endphp

            <picture class="block md:hidden">
            <source type="image/webp"
                    srcset="{{ $m412Url }} 412w"
                    sizes="100vw">
            <img fetchpriority="high" loading="eager" decoding="async"
                src="{{ $m412Url }}" width="{{ $m412W }}" height="{{ $m412H }}"
                class="w-full h-auto block" alt="">
            </picture>


            <!-- Mobile text/CTAs on blue background image -->
            <div class="md:hidden mobile-copy-bg text-white px-6 sm:px-8 py-10">
                @if ($section['subtitle'])
                    <div class="text-action-light-blue uppercase font-semibold text-base mb-4">
                        {!! $section['subtitle'] !!}
                    </div>
                @endif

                @if ($section['is_header'] === 'h1')
                    <h1 class="h1 mb-6 text-4xl font-extrabold tracking-tight">{!! $job_title !!}</h1>
                @elseif ($section['is_header'] === 'h2')
                    <h2 class="h1 mb-6 text-4xl font-extrabold tracking-tight">{!! $job_title !!}</h2>
                @else
                    <div class="h1 mb-6 text-4xl font-extrabold tracking-tight">{!! $job_title !!}</div>
                @endif

                @if ($section['description'])
                    <div class="text-lg leading-relaxed opacity-90">
                        {!! $section['description'] !!}
                    </div>
                @endif

                @if ($buttons)
                    @php $data = ['justify' => 'justify-start']; @endphp
                    <div class="mt-8">@include('components.action-buttons', $data)</div>
                @endif
            </div>

            <!-- ********** DESKTOP (original) ********** -->
            <div class="relative hidden md:grid md:grid-cols-2">

                <!-- Left: original text overlay -->
                <div class="relative order-2 md:order-1">
                    <!-- (remove mobile overlay) -->
                    {{-- <div class="absolute bg-homev3 inset-0 bg-brand z-10 md:hidden" style="margin: -7rem -3rem -5rem -3rem"></div> --}}

                    @if (!$hide_breadcrumbs)
                        <div class="mb-6">
                            @php $data = ['color' => 'white']; @endphp
                            @include('ui.breadcrumbs.simple-with-slashes', $data)
                        </div>
                    @endif

                    <div class="relative z-10 -mt-12 md:mt-0">
                        <div class="py-12 px-4" style="max-width: 500px">
                            @if ($section['subtitle'])
                                <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
                                    {!! $section['subtitle'] !!}
                                </div>
                            @endif
                            @if ($section['is_header'] === 'h1')
                                <h1
                                    class="h1 mb-0 text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight @if ($background['color'] == 'light') text-brand @else text-white @endif">
                                    {!! $job_title !!}
                                </h1>
                            @elseif ($section['is_header'] === 'h2')
                                <h2
                                    class="h1 mb-0 text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight @if ($background['color'] == 'light') text-brand @else text-white @endif">
                                    {!! $job_title !!}
                                </h2>
                            @else
                                <div
                                    class="h1 mb-0 text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight @if ($background['color'] == 'light') text-brand @else text-white @endif">
                                    {!! $job_title !!}
                                </div>
                            @endif
                            @if ($section['description'])
                                <div
                                    class="mt-6 @if ($background['color'] == 'light') text-brand @else text-white @endif text-xl">
                                    {!! $section['description'] !!}
                                </div>
                            @endif
                            @if ($buttons)
                                @php $data = ['justify' => 'justify-start']; @endphp
                                @include('components.action-buttons', $data)
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right: keep column for layout parity (no mobile accents here) -->
                <div class="relative order-1 md:order-2 -mx-12">
                    {{-- (Mobile-only accent images removed) --}}
                </div>
            </div>
        </div>
    </div>
</section>
