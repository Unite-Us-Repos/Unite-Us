<div x-data="{ swiper: null }" x-init="
        // Initialize Swiper and make it globally accessible
        swiper = new Swiper($refs.container, {
          grabCursor: false,
          effect: 'fade',
          preventClicks: true,
          slidesPerView: 1
        });

        // Store the swiper instance globally for accordion to access
        window.swiperInstance = swiper;
      ">
  <div class="swiper" x-ref="container">
    <div class="swiper-wrapper">
      @foreach ($faqs as $index => $faq)
        <div class="swiper-slide bg-white h-auto">
          <img class="w-full h-auto aspect-square object-contain object-center"
              src="{{ $faq['image']['sizes']['medium_large'] }}"
              alt="" />
        </div>
      @endforeach
    </div>
  </div>
