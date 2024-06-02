<div class="relative lg:-mt-16">
  <div class="absolute w-[120%] bottom-0 h-1/2 bg-white -ml-4"></div>

  <div class="relative z-20 md:grid md:grid-cols-2 ml-4 sm:ml-8 md:-ml-0 -mr-4">
    <div></div>
    @if ($posts) @php $enableLoop = 'false'; @endphp
      <div class="relative" x-data="{swiper: null}" x-init="swiper = new Swiper($refs.container, {
        loop: {{ $enableLoop }},
        pagination: false,
        preventClicks: false,
        slidesPerView: 1.25,
        slidesPerGroup: 1,
        spaceBetween: 25,
        breakpoints: {
          640: {
            slidesPerView: 2.25,
          },
          768: {
            slidesPerView: 1.25,
          },
          1024: {
            slidesPerView: 2.25,
          },
          1280: {
            slidesPerView: 2.25,
          },
        },
      });swiper.on('slideChange', function () {
        var current = swiper.activeIndex;
        if ({{ count($posts) }} === current) {
          swiper.allowSlideNext = false;
        } else {
          swiper.allowSlideNext = true;
        }
      });swiper.on('resize', function () {
        swiper.slideTo(0)
      });">
        <div class="swiper" x-ref="container">
          <div class="swiper-wrapper">
            @foreach ($posts as $post)
            @php
            $type = App\View\Composers\Post::getType($post->ID);
            $catSlug = App\View\Composers\Post::getPostCatSlug($post->ID);
            @endphp
            <div class="swiper-slide relative pb-4" style="height: auto;">

              <div class="relative min-h-[300px] bg-action flex flex-1 h-full border-t-[15px] border-action rounded-[8px] shadow-md overflow-hidden">
                <div class="flex-1 bg-white flex flex-col justify-between">
                  <div class="flex-1 px-6 pt-7 pb-10">
                    <p class="leading-normal text-sm font-medium text-action mb-2">
                      <a href="/{{ $catSlug }}/">
                        <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                          {{ $type }}
                        </span>
                      </a>
                    </p>

                    <h3 class="mb-1">
                      <a id="banner-card-{{ $loop->index+1 }}" class="no-underline text-brand" href="{{ get_the_permalink($post->ID) }}">
                        {!! $post->post_title !!}
                      </a>
                    </h3>
                    {{ get_the_date('', $post->ID) }}
                  </div>

                  <div class="bg-light hover:bg-blue-200">
                    <a id="banner-card-read-more-{{ $loop->index+1 }}" class="no-underline text-action font-semibold p-6 block" href="{{ get_the_permalink($post->ID) }}" aria-label="Read More - {{ $post->post_title }}">Read More<span aria-hidden="true" class="ml-1">
                        →</span></a>
                  </div>
                </div>
              </div>

            </div>


            @endforeach
            <div class="swiper-slide flex justify-start items-center" style="height: auto;">

                <a class="text-xl text-action hover:text-action-dark mt-10 no-underline text-center mx-6" href="/knowledge-hub/">
                  <span class="flex justify-center items-center mb-4 w-24 h-24 bg-action rounded-full text-white font-extrablod">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>

                  </span>
                View More
                </a>
            </div>
            <div class="swiper-slide swiper-no-swiping flex justify-start items-center" style="height:auto;">
              &nbsp;
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
