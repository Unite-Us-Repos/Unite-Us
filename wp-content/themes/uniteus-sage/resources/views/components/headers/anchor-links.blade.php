<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="relative component-section -mx-4 sm:mx-0 {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
<div class="inset-0 absolute bg-light-gradient h-1/2"></div>

  <div class="component-inner-section px-10 @if ($section_settings['fullscreen']) fullscreen @else relative @endif overflow-hidden sm:rounded-lg">

      @if ($background['image'])
        <div class="absolute simple-parallax-hero inset-0 sm:rounded-lg bg-cover hidden sm:flex">
          <img class="lazy w-full h-auto object-cover" data-src="{{ $background['image']['sizes']['2048x2048'] }}"
            alt="{{ $background['image']['alt'] }}" style="object-position: top;" />
        </div>
      @endif

      @if ($background['video'])
        <div class="absolute left-0 top-0 -mt-14 -ml-14 sm:-mt-28 sm:-ml-28 z-10 simple-parallax">
          <img class="h-40 w-40 sm:h-80 sm:w-80" src="/wp-content/themes/uniteus-sage/resources/images/split-pod.svg" alt="" />
        </div>

        <div class="absolute inset-0 overflow-hidden bg-fixed bg-cover bg-center" style="background-image:url(https://uniteus.com/wp-content/uploads/2023/05/colab-hero.jpg);">
          <video autoplay loop muted playsinline class="lazy w-full h-full object-cover max-w-none">
            <source data-src="{{ $background['video'] }}" type="video/mp4" />Your browser does not support the video tag.
          </video>
        </div>
      @endif

      <div class="absolute inset-0 sm:rounded-lg bg-cover sm:hidden"
        style="background-image: url(https://uniteus.com/wp-content/uploads/2023/06/colab-hero-m.jpg); background-position:center center;">
      </div>

      @if ($background['overlay'])
        <div class="absolute inset-0 bg-dark-blue opacity-80"></div>

        @if (!$background['video'])
        <div class="absolute top-0 right-0 left-0 z-10 justify-start hidden sm:flex">
          <svg width="623" height="284" viewBox="0 0 623 284" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_f_15615_70830)">
              <circle cx="223.744" cy="-114.661" r="223.744" fill="#0043CA" fill-opacity="0.6" />
            </g>
            <defs>
              <filter id="filter0_f_15615_70830" x="-174.854" y="-513.258" width="797.194" height="797.195"
                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                <feGaussianBlur stdDeviation="87.4268" result="effect1_foregroundBlur_15615_70830" />
              </filter>
            </defs>
          </svg>
        </div>

        <div class="absolute bottom-0 right-0 left-0 z-10 justify-end hidden sm:flex">
          <svg width="497" height="260" viewBox="0 0 497 260" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_f_15615_70835)">
              <circle cx="347.23" cy="346.936" r="181.144" fill="#0043CA" fill-opacity="0.8" />
            </g>
            <defs>
              <filter id="filter0_f_15615_70835" x="0.840485" y="0.546295" width="692.78" height="692.78"
                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                <feGaussianBlur stdDeviation="82.6232" result="effect1_foregroundBlur_15615_70835" />
              </filter>
            </defs>
          </svg>
        </div>
        @endif
      @endif

      <div class="relative mx-auto">

        <div class="px-0 sm:px-10 leading-loose relative z-10 text-center">
          <div class="mb-10 flex justify-center">
          <svg width="220" height="63" viewBox="0 0 220 63" fill="none" xmlns="http://www.w3.org/2000/svg">
            <mask id="mask0_16439_70388" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="59" height="61">
            <path d="M9.60637 58.3609C1.24886 53.5656 -1.82736 43.1624 2.39223 34.6826L21.0401 45.3839C23.1635 46.603 25.8586 45.8716 27.0564 43.7855L10.0147 33.9782L9.33414 33.599C7.89131 32.732 6.55738 31.6483 5.35956 30.375C4.46119 29.3997 3.67172 28.3431 2.96392 27.1511C-2.04515 18.5088 0.949399 7.42824 9.63359 2.44334C17.9911 -2.37901 28.5809 0.167622 33.8622 8.05135L15.2143 18.7526C13.0909 19.9718 12.3831 22.6539 13.6082 24.7399L30.1326 15.2307C30.7043 14.8514 31.3304 14.4992 31.9566 14.1741C33.2633 13.5239 34.6517 13.0092 36.1217 12.6841C37.4012 12.386 38.7351 12.2506 40.1235 12.2506C50.1689 12.2506 58.3086 20.351 58.3086 30.3479C58.3086 40.3448 50.795 47.7951 41.3214 48.4182L41.3213 26.9885C41.3213 24.5503 39.3341 22.5997 36.9112 22.5997L36.9112 43.1624C36.8568 44.7879 36.5845 46.4134 36.0945 48.0118C35.7134 49.2851 35.1689 50.5043 34.4883 51.6963C29.4793 60.3657 18.345 63.3187 9.6336 58.3338L9.60637 58.3609Z" fill="#182A44"/>
            </mask>
            <g mask="url(#mask0_16439_70388)">
            <g clip-path="url(#clip0_16439_70388)">
            <rect width="154.273" height="72.7191" transform="translate(-62.2393 31.1504) rotate(-30)" fill="#182A44"/>
            <rect x="-62.2393" y="31.1504" width="206.445" height="96.8116" transform="rotate(-30 -62.2393 31.1504)" fill="#182A44"/>
            <g filter="url(#filter0_f_16439_70388)">
            <circle cx="140.414" cy="10.8567" r="55.7342" transform="rotate(-30 140.414 10.8567)" fill="#0043CA"/>
            </g>
            <g filter="url(#filter1_f_16439_70388)">
            <circle cx="-28.6996" cy="-13.1709" r="55.7342" transform="rotate(-30 -28.6996 -13.1709)" fill="#0043CA"/>
            </g>
            </g>
            </g>
            <path d="M94.9297 44.2503C91.8479 44.2503 89.2084 43.6607 87.0109 42.4816C84.8135 41.3025 83.1521 39.6813 82.0266 37.6178C80.9011 35.5544 80.3383 33.223 80.3383 30.6236C80.3383 27.9706 80.9279 25.6124 82.107 23.549C83.2861 21.4588 84.9609 19.8375 87.1315 18.6852C89.3289 17.5061 91.8881 16.9166 94.8091 16.9166C97.5692 16.9166 99.9274 17.3989 101.884 18.3637C103.867 19.3284 105.354 20.6013 106.346 22.1823C107.364 23.7366 107.873 25.4249 107.873 27.2471C107.873 27.5419 107.86 27.8367 107.833 28.1314H103.934C103.934 27.9438 103.934 27.7563 103.934 27.5687C103.934 26.3092 103.572 25.1435 102.848 24.0716C102.152 22.9997 101.12 22.1555 99.7533 21.5392C98.4134 20.896 96.8055 20.5745 94.9297 20.5745C92.893 20.5745 91.0976 21.0032 89.5433 21.8608C87.9891 22.6915 86.7966 23.8706 85.9658 25.3981C85.1351 26.8987 84.7197 28.6406 84.7197 30.6236C84.7197 32.5531 85.1217 34.2681 85.9256 35.7688C86.7564 37.2695 87.9489 38.4486 89.5031 39.3061C91.0574 40.1636 92.893 40.5924 95.0101 40.5924C96.8323 40.5924 98.4268 40.2976 99.7935 39.7081C101.187 39.1185 102.245 38.3146 102.969 37.2963C103.719 36.2511 104.094 35.0854 104.094 33.7991C104.094 33.6652 104.081 33.5312 104.054 33.3972H108.034C108.034 33.5848 108.034 33.7858 108.034 34.0001C108.034 35.876 107.511 37.591 106.466 39.1453C105.421 40.6996 103.907 41.9457 101.924 42.8836C99.9408 43.7947 97.6094 44.2503 94.9297 44.2503ZM121.749 44.1699C119.257 44.1699 117.14 43.7411 115.398 42.8836C113.683 41.9993 112.383 40.78 111.499 39.2257C110.641 37.6714 110.213 35.9028 110.213 33.9197C110.213 31.9367 110.641 30.1681 111.499 28.6138C112.383 27.0595 113.696 25.8402 115.438 24.9559C117.18 24.0448 119.284 23.5892 121.749 23.5892C124.188 23.5892 126.278 24.0448 128.02 24.9559C129.762 25.8402 131.075 27.0595 131.959 28.6138C132.843 30.1681 133.285 31.9367 133.285 33.9197C133.285 35.9028 132.843 37.6714 131.959 39.2257C131.075 40.7532 129.762 41.9591 128.02 42.8434C126.305 43.7277 124.214 44.1699 121.749 44.1699ZM121.709 40.7532C123.343 40.7532 124.724 40.4718 125.849 39.909C126.975 39.3195 127.819 38.5156 128.381 37.4972C128.944 36.4521 129.226 35.2596 129.226 33.9197C129.226 32.5531 128.944 31.3606 128.381 30.3422C127.819 29.2971 126.975 28.4798 125.849 27.8902C124.724 27.3007 123.343 27.0059 121.709 27.0059C120.101 27.0059 118.734 27.3007 117.609 27.8902C116.483 28.4798 115.639 29.2971 115.076 30.3422C114.514 31.3874 114.232 32.5799 114.232 33.9197C114.232 35.2596 114.514 36.4387 115.076 37.457C115.639 38.4754 116.47 39.2793 117.569 39.8688C118.694 40.4584 120.074 40.7532 121.709 40.7532ZM135.056 31.106H144.984V33.759H135.056V31.106ZM147.807 17.3587H152.108V40.11H167.342V43.8081H147.807V17.3587ZM168.787 38.06C168.787 36.9077 169.082 35.943 169.671 35.1658C170.261 34.3619 171.118 33.759 172.244 33.357C173.396 32.9282 174.83 32.7138 176.545 32.7138H186.071V31.6687C186.071 30.57 185.83 29.6589 185.348 28.9354C184.892 28.2118 184.169 27.6759 183.177 27.3275C182.186 26.9523 180.913 26.7647 179.359 26.7647C177.295 26.7647 175.754 27.0863 174.736 27.7295C173.744 28.3458 173.249 29.2301 173.249 30.3824C173.275 30.5968 173.289 30.8112 173.289 31.0256H169.47C169.47 30.6772 169.457 30.3422 169.43 30.0207C169.43 28.7076 169.805 27.5687 170.556 26.604C171.333 25.6392 172.472 24.9023 173.972 24.3931C175.5 23.8572 177.335 23.5892 179.479 23.5892C181.757 23.5892 183.686 23.9242 185.267 24.5941C186.875 25.2641 188.081 26.2422 188.885 27.5285C189.716 28.788 190.131 30.302 190.131 32.0707V43.8081H186.071C186.125 43.165 186.165 42.428 186.192 41.5973C186.246 40.7666 186.272 39.9358 186.272 39.1051H186.232C185.991 40.177 185.509 41.0881 184.785 41.8385C184.062 42.5888 183.083 43.165 181.851 43.5669C180.618 43.9421 179.091 44.1297 177.268 44.1297C175.446 44.1297 173.892 43.8751 172.606 43.3659C171.346 42.8568 170.395 42.1466 169.752 41.2355C169.108 40.3244 168.787 39.2659 168.787 38.06ZM177.992 40.9943C179.707 40.9943 181.167 40.7666 182.373 40.311C183.606 39.8286 184.531 39.1855 185.147 38.3816C185.763 37.5508 186.071 36.6263 186.071 35.608V35.3668H177.067C175.995 35.3668 175.138 35.4472 174.495 35.608C173.852 35.7688 173.356 36.0368 173.008 36.4119C172.686 36.7871 172.525 37.2963 172.525 37.9394C172.525 38.8505 172.954 39.5875 173.811 40.1502C174.696 40.713 176.089 40.9943 177.992 40.9943ZM206.322 44.1699C204.58 44.1699 203.066 43.9689 201.78 43.5669C200.52 43.165 199.515 42.6022 198.765 41.8787C198.015 41.1551 197.492 40.2976 197.197 39.3061H197.157C197.184 39.842 197.197 40.378 197.197 40.9139C197.224 41.4499 197.251 41.9725 197.278 42.4816C197.305 42.964 197.331 43.4061 197.358 43.8081H193.298V15.8313H197.358V25.5588C197.331 26.5772 197.305 27.6759 197.278 28.855H197.358C197.68 27.7831 198.216 26.8585 198.966 26.0814C199.716 25.3043 200.694 24.7013 201.9 24.2726C203.106 23.817 204.527 23.5892 206.161 23.5892C208.359 23.5892 210.248 24.0046 211.829 24.8353C213.437 25.666 214.656 26.8317 215.487 28.3324C216.318 29.8063 216.733 31.5347 216.733 33.5178C216.733 35.6616 216.304 37.5374 215.447 39.1453C214.616 40.7532 213.41 41.9993 211.829 42.8836C210.275 43.7411 208.439 44.1699 206.322 44.1699ZM205.397 40.7532C206.952 40.7532 208.265 40.4584 209.337 39.8688C210.435 39.2793 211.266 38.462 211.829 37.4168C212.392 36.3449 212.673 35.072 212.673 33.5982C212.673 32.3119 212.392 31.173 211.829 30.1815C211.293 29.1899 210.489 28.4128 209.417 27.8501C208.345 27.2873 207.032 27.0059 205.478 27.0059C203.843 27.0059 202.41 27.3007 201.177 27.8902C199.971 28.4798 199.033 29.3105 198.363 30.3824C197.693 31.4543 197.358 32.687 197.358 34.0805V34.8041C197.358 35.9296 197.68 36.9479 198.323 37.859C198.966 38.7433 199.891 39.4535 201.096 39.9894C202.302 40.4986 203.736 40.7532 205.397 40.7532Z" fill="#182A44"/>
            <defs>
            <filter id="filter0_f_16439_70388" x="16.7081" y="-112.849" width="247.411" height="247.411" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
            <feGaussianBlur stdDeviation="33.9809" result="effect1_foregroundBlur_16439_70388"/>
            </filter>
            <filter id="filter1_f_16439_70388" x="-152.405" y="-136.876" width="247.411" height="247.411" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
            <feGaussianBlur stdDeviation="33.9809" result="effect1_foregroundBlur_16439_70388"/>
            </filter>
            <clipPath id="clip0_16439_70388">
            <rect width="154.273" height="72.7191" fill="white" transform="translate(-62.2393 31.1504) rotate(-30)"/>
            </clipPath>
            </defs>
          </svg>

          </div>

          @if ($section['subtitle'])
            <div class="text-redish font-space text-lg mb-6">
              {!! $section['subtitle'] !!}
            </div>
          @endif

          @if ($section['title'])
            
            @if ($section['is_header'])
              <div class="text-white font-syne font-semibold text-4xl leading-none mb-6 sm:mb-10 lg:text-5xl">
                {!! $section['title'] !!}
              </div>
            @else
              <h1 class="text-white font-syne font-semibold text-4xl leading-none mb-6 sm:mb-10 lg:text-5xl">
                {!! $section['title'] !!}
              </h1>
            @endif

          @endif

          @if ($section['description'])
            <div class="description text-white font-space text-lg max-w-4xl mx-auto mb-10">
              {!! $section['description'] !!}
            </div>
          @endif

@if ($buttons)
            <div class="mt-10 flex relative z-10 justify-center gap-4">
              @foreach ($buttons as $index => $button)
                @if ($index === 0)
                  <div class="inline-flex rounded-md shadow">
                    <a href="{{ $button['link']}}"
                      class="button button-solid-redish bg-redish hover:bg-redish-dark hover:border-redish-dark"
                      @if ($button['is_blank']) target="_blank" @endif>
                      {{ $button["name"]}}
                    </a>
                  </div>
                @else
                  <div class="inline-flex">
                    <a href="{{ $button['link']}}"
                      class="button button-solid-redish bg-redish hover:bg-redish-dark hover:border-redish-dark">
                      {{ $button["name"]}}
                    </a>
                  </div>
                @endif
              @endforeach
            </div>
          @endif

        </div>
      </div>
    </div>
</section>
@if ($display_anchor_links)
  <div id="anchor-links" class="text-white bg-dark-blue flex justify-center gap-6 p-6">
    {!! $anchorLinks !!}
  </div>
@endif
