<div
  class="relative mt-14"
  x-data="{swiper: null}"
  x-init="swiper = new Swiper($refs.container, {
    loop: false,
    autoHeight: false,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    slidesPerView: 1,
    spaceBetween: 0,
  })">
  <div class="swiper" x-ref="container">
    <div class="swiper-wrapper">
      @foreach ($testimonials as $index => $testimonial)
      <div class="swiper-slide relative">
        <blockquote class="testimonial-quote">
          <div class="flex flex-col lg:grid lg:grid-cols-12">
            <div class="col-span-7">
              <div class="text-2xl md:text-3xl md:leading-normal">
                {!! $testimonial['quote'] !!}
              </div>
              <footer class="mt-4">
                <div class="md:flex">
                  @if ($testimonial['image'])
                    <div class="md:flex-shrink-0">
                      <img class="mx-auto h-10 w-10 md:mr-4 rounded-full"
                        src="{{ $testimonial['image']['sizes']['thumbnail'] }}"
                        alt="" />
                    </div>
                  @endif
                  <div class="mt-3 text-lg md:mt-0 flex flex-col md:flex-row">
                    <div>{{ $testimonial['name'] }}</div>
                    @if ($testimonial['title_position'])
                      <div>&nbsp; &mdash; &nbsp;{{ $testimonial['title_position'] }}</div>
                    @endif
                  </div>
                </div>
              </footer>
            </div>
            <div class="col-span-5 flex justify-end">
              @if ($testimonial['company_logo'])
                <div class="mt-8">
                    <img class="w-full h-auto max-w-xs max-h-16"
                      src="{{ $testimonial['company_logo']['sizes']['medium'] }}"
                      alt="" />
                </div>
              @endif
            </div>
          </div>
        </blockquote>
      </div>
      @endforeach
    </div>
    <div class="swiper-pagination"></div>
  </div>

  @if (count($testimonials) > 1)
    <button aria-label="previous" @click="swiper.slidePrev()"
      class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
      </svg>
    </button>
  @endif
  @if (count($testimonials) > 1)
    <button aria-label="next" @click="swiper.slideNext()"
      class="text-blue-300 hover:text-action ease-out duration-300 flex justify-center items-center w-10 h-10 rounded-full focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-[30px] w-[30px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </button>
  @endif
</div>
