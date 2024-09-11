@php
    $job_id = 0;
    $job_title = '';
    $title_override = false;
    if ($section['title']) {
        $job_title = $section['title'];
    }
@endphp
<style>
    @media (min-width: 1024px) {
        .text-wrapper {
            max-width: 720px;
            margin: auto;
        }
        .feature-image {
            max-width: 880px;
            margin: auto;
        }
        .bg-image {
            max-height: 835px;
        }
        .floating-accents {
            max-width: 720px;
            margin: auto;
            height: 0;
        }
    }
</style>
<section
    class="relative hero-v3 component-section md:py-24 {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">

    <div class="absolute inset-0">
        @if ($background['image'])
            <img fetchPriority="high"
                class="w-full h-full object-cover bg-image @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                src="{{ $background['image']['sizes']['2048x2048'] }}" alt="{{ $background['image']['alt'] }}">
        @endif
    </div>

    <div class="relative w-full z-20">

        <div class="component-inner-section">
            <div class="relative flex flex-col">

                <div class="relative ">

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
                        <div class="py-12 lg:text-center text-wrapper">
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
                                   top: -7rem;" /> 
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
                            <img class="w-full h-auto lg:hidden" src="{{ $section['logo']['sizes']['large'] }}"
                            alt="{{ $section['logo']['alt'] }}" />
                            <img class="w-full h-auto hidden lg:block feature-image" data-src="@asset('/images/main-pic-v1b.png')" src="@asset('/images/main-pic-v1b.png')"
                            alt="{{ $section['logo']['alt'] }}" />
                        @endisset

                  
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
