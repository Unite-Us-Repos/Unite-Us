@php
    use Illuminate\Support\Str;

    $s_settings = [
        'collapse_padding' => false,
        'fullscreen' => '',
    ];
    $section_settings = isset($acf['components'][$index]['layout_settings']['section_settings'])
        ? $acf['components'][$index]['layout_settings']['section_settings']
        : $s_settings;
@endphp

<section @isset($section['id']) id="{{ $section['id'] }}" @endisset
    class="reviews relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
    <div class="component-inner-section">

        @if ($review_credit)
            <div class="review-credit mb-6 text-center">
                <a href="https://www.g2.com/products/unite-us/" target="_blank">
                    <div class="wrapper mb-6 flex justify-center gap-2 items-center">
                        <div class="icon w-5">
                            @if ($review_credit['icon'])
                                @php
                                    // Get the file path of the SVG
                                    $svg_file = get_attached_file($review_credit['icon']['ID']);

                                    // Check if the file exists and is readable
                                    if (file_exists($svg_file) && is_readable($svg_file)) {
                                        // Get the SVG contents
                                        $svg_content = file_get_contents($svg_file);
                                        echo $svg_content;
                                    }
                                @endphp
                            @endif
                        </div>
                        @if ($review_credit['text'])
                            <div class="text-lg text-gray-400">{!! $review_credit['text'] !!}</div>
                        @endif
                    </div>
                </a>
            </div>
        @endif

        <div class="text-center mb-7">
            @isset ($section['logo']['sizes'])
              <img class="mb-8 max-w-xs h-auto mx-auto" src="{{ $section['logo']['sizes']['large'] }}" alt="{{ $section['logo']['alt'] }}"/>
            @endisset

            @if ($section['subtitle'])
                @if ($section['subtitle_display_as_pill'])
                    <span
                        class="@if ($section['purple_text']) text-electric-purple @else text-action @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
                @else
                    <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
                @endif
                {!! $section['subtitle'] !!}
                </span>
            @endif
            @if ($section['title'])
                <h2 class="m-auto mb-6">{!! $section['title'] !!}</h2>
            @endif
            @if ($section['description'])
                <div class="text-lg">
                    <div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="relative component-inner-section z-10"
        x-data="swiperComponent"
        x-init="initSwiper">
        @if (isset($reviews) && is_array($reviews) && count($reviews) > 0)
            <!-- Swiper -->
            <div class="swiper-container" x-ref="container">
                <div class="swiper-wrapper">
                    @foreach ($reviews as $review)
                        @php
                            $review_date = $review['date'];
                            $review_title = $review['review_title'];
                            $review_content = $review['review'];
                            $reviewer_name = $review['reviewer'];
                            $reviewer_title = $review['reviewer_title'];
                        @endphp
                        <div class="swiper-slide">
                            <div class="group relative p-4">
                                <div class="relative z-10 w-ful p-5 text-lg">
                                    <div class="stars-and-date flex justify-start items-center mb-5">
                                        <!-- Star SVGs for a 5-star rating -->
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg width="19" height="18" viewBox="0 0 19 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.48705 1.71386C8.84185 0.621894 10.3867 0.621894 10.7415 1.71386L12.0092 5.6154C12.1678 6.10374 12.6229 6.43437 13.1364 6.43437H17.2387C18.3869 6.43437 18.8643 7.9036 17.9354 8.57847L14.6165 10.9898C14.2011 11.2916 14.0273 11.8265 14.186 12.3149L15.4537 16.2164C15.8085 17.3084 14.5587 18.2164 13.6298 17.5416L10.3109 15.1303C9.89552 14.8285 9.33302 14.8285 8.91761 15.1303L5.59876 17.5416C4.66988 18.2164 3.42008 17.3084 3.77488 16.2164L5.04257 12.3149C5.20124 11.8265 5.02741 11.2916 4.61201 10.9898L1.29316 8.57847C0.364278 7.9036 0.84166 6.43437 1.98982 6.43437H6.09214C6.60561 6.43437 7.06069 6.10374 7.21936 5.6154L8.48705 1.71386Z"
                                                    fill="#9643FF" />
                                            </svg>
                                        @endfor
                                        <span class="pl-2 text-gray-500 text-xs">{{ $review_date }}</span>
                                    </div>
                                    <div class="text-block relative">
                                        @if ($review_title)
                                            <h3 class="text-lg font-semibold mb-4">{!! $review_title !!}</h3>
                                        @endif
                                        @if ($review_content)
                                            <div class="text-base w-full mb-4">
                                                {!! $review_content !!}
                                            </div>
                                        @endif
                                        <div class="review-meta text-sm">
                                            <span class="font-bold">{{ $reviewer_name }}</span><br /><span
                                                class="text-gray-500 text-xs">{{ $reviewer_title }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination dots -->
                <div class="swiper-pagination"></div>
            </div>
        @else
            <p>No reviews available.</p>
        @endif
    </div>
</section>

<script>
    function swiperComponent() {
        return {
            swiper: null,
            initSwiper() {
                const initSwiper = () => {
                    if (window.innerWidth < 768) {
                        if (!this.swiper) {
                            this.swiper = new Swiper(this.$refs.container, {
                                loop: false,
                                pagination: {
                                    el: '.swiper-pagination',
                                    clickable: true,
                                },
                                slidesPerView: 1,
                                spaceBetween: 10,
                                autoHeight: true,
                            });
                        }
                    } else {
                        if (this.swiper) {
                            this.swiper.destroy(true, true);
                            this.swiper = null;
                        }
                    }
                };

                // Initialize swiper on page load
                initSwiper();

                // Re-initialize swiper on window resize
                window.addEventListener('resize', initSwiper);
            }
        }
    }
</script>
