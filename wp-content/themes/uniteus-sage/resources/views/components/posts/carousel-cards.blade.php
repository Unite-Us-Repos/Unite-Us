@php
$ppp = 8;
$slug = '';
$cat_name = '';
if ('by_category' == $selection) {
  $posts = App\View\Composers\Post::getPosts($ppp, array('slug' => 'category', 'ids' => $category));
  $cat_obj = get_category($category);
  $slug = $cat_obj->slug;
  $cat_name = $cat_obj->name;
} else {
  $posts = App\View\Composers\Post::getPosts('', '', $posts);
}
$total_press = count($press);
$h_level = 2;
$is_heading = $section["is_header"];
if ($is_heading) {
  $h_level = 1;
}
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section {{ $section_classes }} padding-collapse-b @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif" @if ($h_level === '1') style="padding-top:0 !important;" @endif>
  <div class="px-4">
    @if ($section['title'] || $section['description'])
      <div class="text-center mb-10 lg:mb-14 max-w-4xl mx-auto @if ($background['color'] == 'dark') text-white @endif">
        @if ($section['subtitle'])
          <div class="@if ($background['color'] == 'dark') text-action-light-blue @else text-action @endif uppercase font-semibold mb-4">{!! $section['subtitle'] !!}</div>
        @endif
        @if ($section['title'])
          <h2 class="mb-0">{{ $section['title'] }}</h2>
        @endif
        @if ($section['description'])
          {!! $section['description'] !!}
        @endif
      </div>
    @endif
  </div>

    @if ($posts) @php $enableLoop = 'false'; @endphp
      <div class="relative -mx-4" x-data="{swiper: null}" x-init="swiper = new Swiper($refs.container, {
        loop: {{ $enableLoop }},
        pagination: {
        el: '.swiper-pagination',
        dynamicBullets: true,
        clickable: true,
        },
        @if ($carousel_settings['autoplay'] == 'true')
        autoplay: {
          delay: {{ $carousel_settings['autoplay_delay'] }},
        },
        @endif
        preventClicks: false,
        slidesPerView: 1.25,
        slidesPerGroup: 1,
        spaceBetween: 25,
        breakpoints: {
          640: {
            slidesPerView: 2.25,
          },
          980: {
            slidesPerView: 3.25,
          },
          1024: {
            slidesPerView: 3.25,
          },
          1280: {
            slidesPerView: 4.25,
          },
          1440: {
            slidesPerView: 4.25,
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
        <div class="swiper !pl-6 sm:!pl-10 lg:!pl-20" x-ref="container">
          <div class="swiper-wrapper mb-12 pb-10">
            @foreach ($posts as $post)
            @php
            $type = App\View\Composers\Post::getType($post['ID']);
            $catSlug = App\View\Composers\Post::getPostCatSlug($post['ID']);
            @endphp
            <div class="swiper-slide relative pb-4" style="height: auto;">

            @php
        $type = App\View\Composers\Post::getType($post['ID']);
        $catSlug = App\View\Composers\Post::getPostCatSlug($post['ID']);
        @endphp
        <div class="relative h-full flex flex-col rounded-lg shadow-lg overflow-hidden">
          @isset ($post['thumbnail_url'])
          <div class="flex-shrink-0 bg-white border-b-2 border-light">
            @if ($post['permalink'])
              <a class="no-underline" href="{{ $post['permalink'] }}">
            @endif
            <img class="rfy-image aspect-video w-full object-cover lazy" data-src="{{ $post['thumbnail_url'] }}" alt="{{ $post['thumbnail_alt'] }}">
            @if ($post['permalink'])
              </a>
            @endif
          </div>
          @endisset
          <div class="flex-1 bg-white flex flex-col justify-between">
            <div class="flex-1 px-6 pt-7 pb-10">
              <p class="leading-normal text-sm font-medium text-action mb-2">
                <a href="/{{ $catSlug }}/">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    {{ $type }}
                  </span>
                </a>
              </p>

              <h3 class="mb-1 rfy-title">
                @if ($post['permalink'])
                <a class="no-underline text-brand" href="{{ $post['permalink'] }}">
                  @endif
                  {!! $post['post_title'] !!}
                  @if ($post['permalink'])
                </a>
                @endif
              </h3>
              {{ $post['date'] }}
            </div>

            <div class="bg-light hover:bg-blue-200">
              @if ($post['permalink'])
              <a class="rfy-read-more no-underline text-action font-semibold p-6 block" href="{{ $post['permalink'] }}">Read More<span aria-hidden="true" class="ml-1">
                  &rarr;</span></a>
              @else
              <span class="p-6 block">&nbsp;</span>
              @endif
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
                View All
                </a>
            </div>
            <div class="swiper-slide swiper-no-swiping flex justify-start items-center" style="height:auto;">
              &nbsp;
            </div>
          </div>
          <div class="swiper-pagination !block pb-10"></div>

        </div>

        <div class="absolute left-0 right-0 bottom-0 bg-white h-2/3"></div>

      </div>
    @endif
    </section>
    {{-- @if (get_post_type() == '1c')
      @includeIf('partials.content-page-event-speakers')
      @includeIf('partials.content-page-event-speakers-mobile')
    @endif --}}
