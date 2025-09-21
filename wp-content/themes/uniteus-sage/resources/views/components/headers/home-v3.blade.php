@php
    $job_id = 0;
    $job_title = '';
    $title_override = false;
    if ($section['title']) {
        $job_title = $section['title'];
    }

    // --- New: grab intrinsic sizes for background & mobile hero images ---
    $bgSrc = $bgW = $bgH = null;
    if (!empty($background['image'])) {
        $bg = $background['image'];
        $bgSrc = $bg['sizes']['2048x2048'] ?? ($bg['url'] ?? null);
        $bgW   = $bg['sizes']['2048x2048-width']  ?? ($bg['width']  ?? null);
        $bgH   = $bg['sizes']['2048x2048-height'] ?? ($bg['height'] ?? null);
    }

    $mobSrc = $mobW = $mobH = null;
    if (!empty($section['logo']['sizes'])) {
        $mobSrc = $section['logo']['sizes']['medium'] ?? ($section['logo']['url'] ?? null);
        $mobW   = $section['logo']['sizes']['medium-width']  ?? ($section['logo']['width']  ?? null);
        $mobH   = $section['logo']['sizes']['medium-height'] ?? ($section['logo']['height'] ?? null);
    }
@endphp

{{-- Optional: ideally move this preload into <head>. Kept here for convenience. --}}
@if(!empty($bgSrc))
<link rel="preload" as="image" href="{{ $bgSrc }}" imagesizes="100vw">
@endif

<style>
    /* New: reserve a stable hero height to prevent CLS */
    .hero-v3 { min-height: clamp(520px, 70vh, 820px); }
    @media (max-width: 768px) {
        .hero-v3 { padding-top: 0 !important; min-height: 560px; }
    }
</style>

<section
    class="relative hero-v3 component-section md:!py-24 {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
    <!-- Overlay -->

    <div class="absolute flex justify-end top-0 bottom-0 right-0 z-20" style="width: 50%">
        <img class="absolute hidden lg:block" fetchpriority="high" src="@asset('/images/herov3-blue-bar.png')" alt=""
            width="208" height="208"
            style="right: 8%;
      width: 208px;
      top: 7%" />
        <img class="absolute" fetchpriority="high" src="@asset('/images/herov3-heart-home-pink.png')" alt=""
            width="230" height="230"
            style="right: 0;
      width: 230px;
      bottom: 0" />
    </div>
    <div class="absolute bg-homev3 inset-0 bg-brand z-10 hidden md:block" style="width: 50%;">
        <img class="absolute" fetchpriority="high" src="@asset('/images/herov3-food-green.png')" alt=""
            width="230" height="230"
            style="right: -130px;
    width: 230px;
    top: 0" />
        <img class="absolute" fetchpriority="high" src="@asset('/images/herov3-profile-chart-blue.png')" alt=""
            width="140" height="140"
            style="right: -80px;
    width: 140px;
    bottom: 33%;" />
        <img class="absolute hidden lg:block" fetchpriority="high" src="@asset('/images/herov3-grad-bar-purple.png')" alt=""
            width="160" height="160"
            style="right: -225px;
    width: 160px;
    bottom: 13%;" />
    </div>
    <div class="absolute inset-0">
        @if ($background['image'])
            <img fetchpriority="high" decoding="async"
                class="hero-desktop hidden md:block w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                src="{{ $bgSrc }}" @if($bgW) width="{{ $bgW }}" @endif @if($bgH) height="{{ $bgH }}" @endif alt="{{ $background['image']['alt'] }}">

{{--
            <img class="md:hidden w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                src="{{ $background['logo']['sizes']['medium'] }}" alt="{{ $background['logo']['alt'] }}"> --}}
        @endif
    </div>

    @if ($background['overlay'])
        <div class="absolute inset-0 bg-brand opacity-75"></div>
    @endif

    <div class="relative w-full z-20">

        <div class="component-inner-section">
            <div class="relative flex flex-col md:grid md:grid-cols-2">

                <div class="relative order-2 md:order-1">
                    <div class="absolute bg-homev3 inset-0 bg-brand z-10 md:hidden"
                        style="margin: -7rem -3rem -5rem -3rem"></div>

                    @if (!$hide_breadcrumbs)
                        <div class="mb-6">
                            @php
                                $data = [
                                    'color' => 'white',
                                ];
                            @endphp
                            @include('ui.breadcrumbs.simple-with-slashes', $data)
                        </div>
                    @endif

                    <div class="relative z-10 -mt-12 md:mt-0">
                        <div class="py-12" style="max-width: 500px">
                            @if ($section['subtitle'])
                                <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
                                    {!! $section['subtitle'] !!}
                                </div>
                            @endif
                            @if ($section['is_header'] === 'h1')
                            <h1 class="h1 mb-0 text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight @if ($background['color'] == 'light') text-brand @else text-white @endif">
                                {!! $job_title !!}
                            </h1>
                            @elseif ($section['is_header'] === 'h2')
                                <h2 class="h1 mb-0 text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight @if ($background['color'] == 'light') text-brand @else text-white @endif">
                                    {!! $job_title !!}
                                </h2>
                            @else
                                <div class="h1 mb-0 text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight @if ($background['color'] == 'light') text-brand @else text-white @endif">
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
                                @php
                                    $data = [
                                        'justify' => 'justify-start',
                                    ];
                                @endphp
                                @include('components.action-buttons', $data)
                            @endif
                        </div>
                    </div>
                </div>

                <div class="relative order-1 md:order-2 -mx-12">
                    {{-- New: convert custom lazy → native lazy + add intrinsic sizes --}}
                    <img class="absolute md:hidden" src="@asset('/images/herov3-food.png')" loading="lazy" decoding="async" alt=""
                        width="190" height="190"
                        style="
            transform: scaleX(-1);
            right: 2rem;
            width: 190px;
            top: 0" />
                    <img class="absolute md:hidden" src="@asset('/images/herov3-blue-bar.png')" loading="lazy" decoding="async" alt=""
                        width="112" height="112"
                        style="
            left: 3rem;
            width: 112px;
            top: 2rem" />
                    <img class="absolute md:hidden" src="@asset('/images/herov3-profile-chart.png')" loading="lazy" decoding="async" alt=""
                        width="117" height="117"
                        style="
            bottom: 13rem;
            width: 117px;
            right: 3rem" />
                    <img class="absolute md:hidden" src="@asset('/images/herov3-heart-home.png')" loading="lazy" decoding="async" alt=""
                        width="170" height="170"
                        style="
            transform: scaleX(-1);
            left: 1rem;
            width: 170px;
            bottom: 6.5rem;" />
                    @isset($section['logo']['sizes'])
                        <img fetchpriority="high" decoding="async" class="hero-mobile w-full h-auto md:hidden" src="{{ $mobSrc }}"
                            @if($mobW) width="{{ $mobW }}" @endif @if($mobH) height="{{ $mobH }}" @endif
                            alt="{{ $section['logo']['alt'] }}" />
                    @endisset
                </div>
            </div>
        </div>
    </div>
</section>
