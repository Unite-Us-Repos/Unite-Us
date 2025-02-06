@php
    $title = $section['title'];
    $small_font = $section['small_font'] ?? false;
    $stack_on_mobile = $section['stack_on_mobile'] ?? false; // ACF true/false toggle
    $mobile_image = $section['mobile_image'] ?? null; // ACF image field
    $alignment = $section['alignment'] ?? 'left'; // Default to 'left' if not set
@endphp

@if ($stack_on_mobile && $mobile_image)
    <!-- Mobile Image -->
    <div class="block md:hidden">
        <img src="{{ $mobile_image['url'] }}" alt="{{ $mobile_image['alt'] }}" class="w-full h-auto mb-4">
    </div>
@endif
<section @isset($section['id']) id="{{ $section['id'] }}" @endisset
    class="content-video-header relative component-section {{ $section_classes }} 
    @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif
    @if ('bottom' == $background['position']) !pb-48 @endif">
    <!-- Overlay -->

    <div class="absolute inset-0 @if ($stack_on_mobile && $mobile_image) hidden md:block @endif">
        @if ($background['image'])
            <img fetchPriority="high" class="hero-desktop w-full h-full object-cover 
                @if ('top' == $background['position']) object-top @endif 
                @if ('bottom' == $background['position']) object-bottom @endif"
                src="{{ $background['image']['sizes']['medium'] }}"
                srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
                sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
        @endif
    </div>

    @if ($background['overlay'] && !$stack_on_mobile && !$mobile_image)
        <div class="absolute inset-0 bg-brand opacity-75 bg-electric-purple-overlay"></div>
    @endif

    @isset($section['logo']['sizes'])
        <img class="relative md:hidden mb-6 max-w-[224px] h-auto mx-auto" src="{{ $section['logo']['sizes']['medium'] }}"
    alt="{{ $section['logo']['alt'] }}" />
    @endisset

    <div class="relative w-full">
        <div class="component-inner-section flex flex-col-reverse md:flex-row items-center gap-6           
        @if ($alignment === 'center') text-center md:text-left @endif"> 
            <div class="col md:w-1/2">  
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

                    @isset($section['logo']['sizes'])
                        <img class="hidden md:block mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}"
                            alt="{{ $section['logo']['alt'] }}" />
                    @endisset

                    @if ($section['subtitle'])
                        <div
                            class="
                    {{ $section['purple_text'] ? 'text-electric-purple' : 'text-action-light-blue' }} 
                    {{ $section['case_type'] == 'Uppercase' ? 'uppercase' : '' }} 
                    {{ $section['case_type'] == 'Lowercase' ? 'lowercase' : '' }} 
                    {{ $section['case_type'] == 'Camelcase' ? 'capitalize' : '' }} 
                    {{ $section['case_type'] == 'Typed' ? 'none' : '' }} 
                    @if ($section['subtitle_display_as_pill']) bg-light bg-opacity-10 text-action-light-blue text-sm py-1 px-4 mb-6 rounded-full
                        {{ $section['gradient_pill'] ? 'gradient-pill' : '' }}
                    @else 
                        font-semibold text-base mb-3 @endif
                    @if ($stack_on_mobile && $mobile_image) mx-auto md:ml-0 block md:inline-block w-fit @else inline-block @endif

                ">
                            {!! $section['subtitle'] !!}
                        </div>
                    @endif

                    @if ($section['is_header'] === 'h1')
                        <h1 class="width-30 h1 mb-0 tracking-tight 
                    @if ($background['color'] == 'light') text-brand @else text-white @endif
                    @if ($small_font) md:!text-4xl !font-semibold small-font @else font-extrabold md:text-5xl lg:text-6xl @endif">
                            {!! $title !!}
                        </h1>
                    @elseif ($section['is_header'] === 'h2')
                        <h2 class="width-30 h1 mb-0 tracking-tight 
                    @if ($background['color'] == 'light') text-brand @else text-white @endif
                    @if ($small_font) text-3xl font-semibold small-font @else font-extrabold md:text-5xl lg:text-6xl @endif">
                            {!! $title !!}
                        </h2>
                    @else
                        <div class="width-30 h1 mb-0 tracking-tight 
                    @if ($background['color'] == 'light') text-brand @else text-white @endif
                    @if ($small_font) text-3xl font-semibold small-font @else font-extrabold md:text-5xl lg:text-6xl @endif">
                            {!! $title !!}
                        </div>
                    @endif

                    @if ($section['description'])
                        <div class="width-30 mt-6 text-xl
                            @if ($background['color'] == 'light') text-brand @else text-white @endif">
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
            <div class="col w-full md:w-1/2">  
                @if ($video)
                <div class="video-wrapper w-full max-w-[570px] mx-auto md:mx-0">
                    {!! $video !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@if ($background['has_divider'])
    <div class="hero-divider">@includeIf('dividers.waves')</div>
@endif
