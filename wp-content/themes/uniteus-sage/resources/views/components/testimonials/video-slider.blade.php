@if ($testimonials)
    @php
        $enableLoop = count($testimonials) > 1 ? 'true' : 'false';
    @endphp

    @if (!empty($background['has_divider']))
        @includeIf('dividers.waves')
    @endif

    <section
        class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
        <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
            <div class="absolute inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden">
                @if ($background['image'])
                    <img fetchpriority="high"
                        class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                        src="{{ $background['image']['sizes']['medium'] }}"
                        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
                        sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
                @endif
            </div>
            {{-- Subtitle --}}
            @if (!empty($section['subtitle']))
                @if (!empty($section['subtitle_display_as_pill']))
                    <div class="border-action border text-sm py-1 px-4 inline-block mb-6 rounded-full text-brand">
                    @else
                        <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
                @endif
                {!! $section['subtitle'] !!}
        </div>
@endif

{{-- Title / Description --}}
@if (!empty($section['title']) || !empty($section['description']))
    <div class="text-left max-w-xl">
        @if (!empty($section['title']))
            <h2>{!! $section['title'] !!}</h2>
        @endif
        @if (!empty($section['description']))
            {!! $section['description'] !!}
        @endif
    </div>
@endif

{{-- Slider --}}
<div class="relative mx-auto" x-data="{ swiper: null }" x-init="swiper = new Swiper($refs.container, {
    loop: {{ count($testimonials) > 4 ? 'true' : 'false' }}, // better for desktop
    watchOverflow: true,
    autoHeight: false,
    speed: 500,
    pagination: { el: '.swiper-pagination', clickable: true },

    // base
    slidesPerView: 1,
    slidesPerGroup: 1,
    spaceBetween: 0,

    breakpoints: {
        640: {
            slidesPerView: 1,
            slidesPerGroup: 1,
            spaceBetween: 0,
        },
        768: {
            slidesPerView: 2,
            slidesPerGroup: 2,
            spaceBetween: 20, // <-- number
        },
        1024: {
            slidesPerView: 4,
            slidesPerGroup: 4,
            spaceBetween: 20, // <-- number
        },
    },

    // keeps groups full when looping
    loopFillGroupWithBlank: true,
})">
    @if (count($testimonials) > 1)
        {{-- Prev --}}
        <div class="absolute slider-prev">
            <button aria-label="previous" @click="swiper.slidePrev()"
                class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24"
                    stroke="#216cff" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                </svg>
            </button>
        </div>
    @endif

    @if (count($testimonials) > 1)
        {{-- Next --}}
        <div class="absolute slider-next">
            <button aria-label="next" @click="swiper.slideNext()"
                class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24"
                    stroke="#216cff" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
    @endif

    <div class="swiper mt-12" x-ref="container">
        <div class="swiper-wrapper">
            @foreach ($testimonials as $index => $testimonial)
                <div class="swiper-slide relative pr-0" x-data="{
                    playing: false,
                    play() {
                        const wrap = this.$refs.videoWrap;
                        const frame = wrap ? wrap.querySelector('iframe') : null;
                        if (frame) {
                            const src = frame.getAttribute('src') || '';
                            if (!/autoplay=1/.test(src)) {
                                const sep = src.includes('?') ? '&' : '?';
                                frame.setAttribute('src', src + sep + 'autoplay=1&playsinline=1');
                            }
                        }
                        this.playing = true;
                    }
                }">
                    <div class="relative mb-2">
                        <div x-ref="videoWrap" class="aspect-video-one-to-one rounded-2xl overflow-hidden bg-slate-200">
                            @if (!empty($testimonial['video']))
                                {{-- oEmbed HTML (YouTube/Vimeo, etc.) --}}
                                {!! $testimonial['video'] !!}
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-500">
                                    <span>No video provided</span>
                                </div>
                            @endif
                        </div>

                        {{-- Overlay: gradient + title + play button (disappears on play) --}}
                        <div x-show="!playing" x-transition.opacity class="absolute inset-0 z-10">
                            <button type="button" @click.stop="play()"
                                aria-label="Play video{{ !empty($testimonial['name']) ? ': ' . $testimonial['name'] : '' }}"
                                class="group absolute inset-0 w-full h-full text-left cursor-pointer">
                                {{-- blue gradient band on bottom --}}
                                <div
                                    class="absolute rounded-lg inset-x-0 bottom-0 h-28 bg-gradient-to-t from-action/100 via-action/60 to-transparent">
                                </div>

                                {{-- Name text --}}
                                @if (!empty($testimonial['name']))
                                    <div
                                        class="absolute left-5 bottom-4 pr-16 text-white font-semibold text-base sm:text-lg">
                                        <img src="@asset('images/Icon-play.svg')" alt="" />
                                        {{ $testimonial['name'] }}
                                    </div>
                                @endif

                                {{-- Play icon (small) --}}

                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="swiper-pagination"></div>
    </div>


</div>
</div>
</section>
@endif
