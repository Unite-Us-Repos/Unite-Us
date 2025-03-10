@php
$ppp = 4;
$slug = '';
$cat_name = '';
if ('by_category' == $selection) {
  $press = App\View\Composers\Post::getPosts($ppp, array('slug' => 'category', 'ids' => $category));
  $cat_obj = get_category($category);
  $slug = $cat_obj->slug;
  $cat_name = $cat_obj->name;
} else {
  $press = App\View\Composers\Post::getPosts('', '', $posts);
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

      <div class="component-inner-section">
        @if ($section['title'] || $section['description'])
          <div class="text-{{ $section['alignment'] }}">
            @if ($section['title'])
              <h2>{{ $section['title'] }}</h2>
            @endif
            @if ($section['description'])
              {!! $section['description'] !!}
            @endif
          </div>
        @endif
      </div>

    @endif

    @if ($press)
    <div class="component-inner-section">
      <div id="ajax-spotlight" class="mt-10 max-w-lg mx-auto grid gap-8 lg:grid-cols-2 xl:grid-cols-4 lg:max-w-none">
        @foreach ($press as $index => $post)


        <div class="relative max-w-md w-full sm:mb-0 mx-auto flex flex-col rounded-lg shadow-lg overflow-hidden">
      @isset ($post['thumbnail_url'])
		  <div class="flex-shrink-0 bg-white border-b-2 border-light">
      @if ($post['permalink'])
        <a
          href="{{ $post['permalink'] }}"
          @if ($post['is_external']) target="_blank @endif">
      @endif
			  <img class="lazy aspect-video w-full object-cover" data-src="{{ $post['thumbnail_url'] }}" alt="{{ $post['thumbnail_alt'] }}">
        @if ($post['permalink'])
        </a>
      @endif
		  </div>
		  @endisset
		  <div class="flex-1 bg-white flex flex-col justify-between">
			<div class="flex-1 px-6 pt-7 mb-6">

			  <p class="leading-normal text-sm font-medium text-action mb-2">
				<a href="/podcast/">
				  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
					{{ $cat_name }}
				  </span>
				</a>
			  </p>


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
                {{ $post['date'] }}
                @isset ($post['excerpt'])
                  {!! $post['excerpt'] !!}
                @endisset
              </div>

              <div class="bg-light hover:bg-blue-200">
              @if ($post['permalink'])
                  <a
                    class="no-underline text-action font-semibold p-6 block"
                    href="{{ $post['permalink'] }}"
                    @if ($post['is_external']) target="_blank @endif">Read More<span aria-hidden="true" class="ml-1"> &rarr;</span></a>
                @else
                  <span class="p-6 block">&nbsp;</span>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
      @if ($total_press+1 > $ppp)
      <div class="mt-14 text-center">
        <button type="button" class="inline-flex button button-solid load-more-button loadmore-posts" data-ajax-container="ajax-spotlight" data-ppp="{{ $ppp }}" data-current-page="1" data-template="kh" data-press-cat="{{ $category }}" data-post-type="post">
          <span class="mr-4 inline-block">Load More</span> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"/></svg>
        </button>
      </div>
      @endif
    </div>
    </div>
    @endif
</section>
@include('components.posts.partials.ajax')
