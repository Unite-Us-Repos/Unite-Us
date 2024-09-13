@php
    $job_id = 0;
    $job_title = '';
    $title_override = false;
    if ($section['title']) {
        $job_title = $section['title'];
    }
@endphp
<style>
     .hero-v1 {
        overflow: hidden;
    }
     .hero-accent-smile {
        position: absolute;
        bottom: 1rem;
        left: 0;
        z-index: 20;
        height: 220px;
    }
    .bg-image {
        max-height: 900px;
    }
    @media (min-width: 1024px) {
        .text-wrapper {
            max-width: 720px;
            margin: auto;
        }
        .feature-image {
            max-width: 813px;
            margin: auto;
        }
        .floating-accents {
            max-width: 720px;
            margin: auto;
            height: 0;
        }
    }
    @media (min-width: 1920px) {
        .hero-accent-smile {
            max-height: 20rem;
        }
    }
</style>
<section
    class="relative hero-v2 lg:py-12 -mb-1 {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">

    <div class="absolute inset-0">
        @if ($background['image'])
            <img fetchPriority="high"
                class="w-full h-full object-cover bg-image lg:hidden @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                src="@asset('/images/v2-bg-mobile.png')" alt="{{ $background['image']['alt'] }}">
            <img fetchPriority="high"
                class="w-full h-full object-cover bg-image hidden lg:block @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                src="{{ $background['image']['sizes']['2048x2048'] }}" alt="{{ $background['image']['alt'] }}">
        @endif
    </div>

    <div class="relative w-full z-20">

        <div class="component-inner-section">
            <div class="relative flex flex-col">

                <div class="relative">

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

                    <div class="relative z-10 component-section lg:pt-8">
                        <div class="lg:text-center text-wrapper">
                            @if ($section['subtitle'])
                                <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
                                    {!! $section['subtitle'] !!}
                                </div>
                            @endif
                            <h1
                                class="mb-0 text-4xl lg:text-5xl font-extrabold tracking-tight @if ($background['color'] == 'light') text-brand @else text-white @endif">
                                {!! $job_title !!}
                            </h1>

                            @if ($section['description'])
                                <div
                                    class="mt-6 @if ($background['color'] == 'light') text-brand @else text-white @endif text-xl">
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
                            <div class="absolute top-0 bottom-0 right-0 z-20 hidden lg:block inset-0 floating-accents">
                                <img class="absolute lazy" data-src="@asset('/images/hp-tile-purple.png')" alt=""
                                   style="left: -41%;
                                   width: 65px;
                                   top: -10rem" />
                                <img class="absolute lazy" data-src="@asset('/images/hp-graphic-3b.png')" alt=""
                                   style="left: -27%;
                                   width: 198px;
                                   top: -6rem;" /> 
                                <img class="absolute lazy" data-src="@asset('/images/hp-graphic-4.png')" alt=""
                                   style="left: -38%;
                                   width: 175px;
                                   top: 7rem;" /> 
                                <img class="absolute lazy" data-src="@asset('/images/hp-tile-red.png')" alt=""
                                   style="right: -21%;
                                   width: 65px;
                                   top: 16rem;" /> 
                                <img class="absolute lazy" data-src="@asset('/images/hp-graphic-2.png')" alt=""
                                   style="right: -40%;
                                    width: 164px;
                                    top: 8rem;" />
                                <img class="absolute lazy" data-src="@asset('/images/hp-graphic-1b.png')" alt=""
                                   style="right: -22%;
                                    width: 164px;
                                    " />
                                <img class="absolute lazy" data-src="@asset('/images/hp-tile-yellow.png')" alt=""
                                   style="right: -36%;
                                   width: 65px;
                                   bottom: 49%;" /> 
                           </div>
                        </div>
                        @isset($section['logo']['sizes'])
                            <img class="w-full h-auto hidden lg:block feature-image" src="{{ $section['logo']['sizes']['large'] }}" alt="{{ $section['logo']['alt'] }}"  />
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img class="w-full h-auto lg:hidden relative" src="@asset('/images/PeopleMobileb.png')" alt="hero image" />
    <img class="w-full h-auto hidden lg:block hero-accent-smile" data-src="@asset('/images/hero-accent-smile-v2b.png')" src="@asset('/images/hero-accent-smile-v2.png')" alt="accent" />
</section>
