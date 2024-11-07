<!-- Swiper CSS (include this in your main layout or head) -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

@php
    $columns = $widget['logos']['columns'] ?? '1/4';
    $large_slides = ($columns == '1/5') ? 5 : 4; // Adjusts slides based on column selection
    $is_grayscale = $widget['logos']['is_grayscale'] ?? false;
    $swiper_ref = 'logos' . $loop->index; // Unique reference for each swiper instance
@endphp

<div class="swiper-container relative z-10">
  <!-- Swiper Wrapper -->
  <div class="swiper-wrapper">
      @foreach ($widget['logos']['logos'] as $logo)
        <div class="swiper-slide py-4">
          <div class="slide shadow-md p-4 bg-white flex justify-center items-center rounded-lg">
              @if ($logo['link'])
                  <a href="{{ $logo['link'] }}" target="_blank">
              @endif
              @if ($logo['image'])
                  <img class="w-full h-auto object-contain max-h-16 {{ $is_grayscale ? 'grayscale' : '' }}" 
                       src="{{ $logo['image']['sizes']['medium'] }}" 
                       alt="{{ $logo['image']['alt'] }}" />
              @endif
              @if ($logo['link'])
                  </a>
              @endif
          </div>
        </div>
      @endforeach
  </div>
</div>

<!-- Swiper JavaScript (include this in your main layout or at the end of the body) -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Swiper Initialization Script with Height Adjustment -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.swiper-container', {
      loop: true,
      autoplay: {
        delay: 3000, // Delay between transitions (3 seconds)
        disableOnInteraction: false // Keeps autoplay running even after interaction
      },
      slidesPerView: 1,
      spaceBetween: 10,
      breakpoints: {
        640: { slidesPerView: 1 },
        768: { slidesPerView: 3 },
        1280: { slidesPerView: {{ $large_slides }} }
      },
      on: {
        init: function () {
          setEqualHeight();
        },
        resize: function () {
          setEqualHeight();
        }
      }
    });

    function setEqualHeight() {
      const slides = document.querySelectorAll('.swiper-slide .slide');
      let maxHeight = 0;

      // Reset heights first
      slides.forEach(slide => {
        slide.style.height = 'auto';
      });

      // Calculate max height
      slides.forEach(slide => {
        maxHeight = Math.max(maxHeight, slide.offsetHeight);
      });

      // Apply max height to all slides
      slides.forEach(slide => {
        slide.style.height = `${maxHeight}px`;
      });
    }
  });
</script>
