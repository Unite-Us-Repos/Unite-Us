@php
if (!isset($ppp)) {
$ppp = 3;
}

if (!isset($template)) {
  $template = 'stacked';
}

$press = [];
$total_press = [];
$total_press = App\View\Composers\Post::getPress($category);
if ('by_category' == $selection) {
  $press = App\View\Composers\Post::getPress($category, $ppp);
} else {
  $press = App\View\Composers\Post::getPress('', $ppp, $posts);
}
$h_level = 2;
$is_heading = $section["is_header"];
if ($is_heading) {
  $h_level = 1;
}
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section {{ $section_classes }}">
<div class="component-inner-section">

    @if ($h_level === 1)

      <div class="relative">

        <div class="relative pt-20 pb-10 mb-10 component-inner-section z-10">
          @if ($section['title'] || $section['description'])
            <div class="text-{{ $section['alignment'] }} max-w-5xl mx-auto">
              @if ($section['title'])
                <h{{ $h_level }} @if ('1' === $h_level) class="text-5xl lg:text-6xl mb-10" @endif>{!! $section['title'] !!}</h{{ $h_level }}>
              @endif
              @if ($section['description'])
                <div class="section-description max-w-5xl mx-auto text-xl">
                  {!! $section['description'] !!}
                </div>
              @endif
            </div>
          @endif
        </div>
        @if ($section['subtitle'])
          <h2 class="relative z-10 component-inner-section mt-10">{{ $section['subtitle'] }}</h2>
        @endif
      </div>

    @else

      <div class="">
      @if ('stacked-cards-2col' == $style && $section['subtitle'])

      <div class="relative text-action bg-light text-sm py-1 px-4 inline-block mb-5 rounded-full">{{ $section['subtitle'] }}</div>
      @endif
        @if ($section['title'] || $section['description'])
          <div class="@if ('stacked-cards-2col' == $style) max-w-5xl @endif text-{{ $section['alignment'] }} @if ('center' == $section['alignment']) max-w-4xl mx-auto @endif">
            @if ($section['title'])
              <h2>{{ $section['title'] }}</h2>
            @endif

            @if ($section['description'])
              <div class="text-lg">
                {!! $section['description'] !!}
              </div>
            @endif
          </div>
        @endif
      </div>

    @endif

    @if ($press)
    <div class="">
      <div x-data="" id="ajax-container{{ $index }}" class="mt-10 flex flex-col @if ('stacked-cards-2col' == $style) lg:grid lg:grid-cols-2 @endif gap-6">


        @foreach ($press as $post)
          <div @click.prevent="window.location.href='{{ $post['permalink'] }}'" class="relative group cursor-pointer bg-white w-full flex flex-col md:flex-row gap-6 items-center p-6 rounded-lg border border-gray-300 shadow-lg overflow-hidden">
            @if ('stacked-cards-2col' == $style)
              <div class="absolute p-4 flex justify-end inset-0 z-10 rounded-xl group-hover:opacity-0">
                <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up.svg')" alt="" />
              </div>
              <div class="absolute p-4 flex justify-end inset-0 z-10 rounded-xl opacity-0 group-hover:opacity-100">
                <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up-active.svg')" alt="" />
              </div>
            @endif
            <div class="flex-shrink-0">
              @isset ($post['thumbnail_url'])
                <img class="aspect-video max-w-[125px] w-full object-contain mx-auto lazy" data-src="{{ $post['thumbnail_url'] }}" alt="{{ $post['thumbnail_alt'] }}">
              @endisset
            </div>
            <div class="flex-1 mr-6">
              <h3 class="mb-1">
                @if ($post['permalink'])
                  <a
                    class="no-underline text-brand"
                    href="{{ $post['permalink'] }}"
                    @if ($post['is_external']) target="_blank @endif">
                @endif
                {!! $post['post_title'] !!}
                @if ($post['permalink'])
                  </a>
                @endif
              </h3>
            </div>

            @if ('stacked-cards-2col' != $style)
              <div class="flex-shrink-0 w-full md:w-auto">
                @if ($post['permalink'])
                  <a
                    class="button button-hollow inline-block w-full md:w-auto font-normal p-6"
                    href="{{ $post['permalink'] }}"
                    @if ($post['is_external']) target="_blank @endif">Read More</a>
                @endif
              </div>
            @endif
          </div>
        @endforeach
      </div>
      @if (count($total_press) > $ppp)
        <div class="mt-14">
          <button type="button" class="inline-flex button button-solid load-more-button loadmore-posts" data-ajax-container="ajax-container{{ $index }}" data-ppp="{{ $ppp }}" data-current-page="1" data-template="{{ $template }}" data-press-cat="{{ $category }}">
            <span class="mr-4 inline-block">Load More</span> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"/></svg>
          </button>
        </div>
      @endif
    </div>
    </div>
    @endif
</section>
@include('components.posts.partials.ajax')
