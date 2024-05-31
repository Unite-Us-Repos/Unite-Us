@php
$ppp = 3;
$state =  isset($_GET['state']) ? $_GET['state'] : '';
if ('by_category' == $selection) {
  $total_press = App\View\Composers\Post::getPress($category, '-1', '', $state);
  $press = App\View\Composers\Post::getPress($category, $ppp, '', $state);
} else {
  $total_press = App\View\Composers\Post::getPress('', '-1', '', $posts);
  $press = App\View\Composers\Post::getPress('', $ppp, $posts);
}
$h_level = '2';
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section id="local-news" class="component-section relative" @if ($h_level === '1') style="padding-top:0 !important;" @endif>
@if ($background['image'])
    <div class="absolute inset-0">
      <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    </div>
  @endif

  @if ($background['overlay'])
    <div class="absolute inset-0 bg-blue-900 opacity-95" style="opacity:95%"></div>
  @endif

<div class="component-inner-section">

    @if ($h_level === '1')

      <div class="relative">
        <div class="absolute inset-0 -mb-24 -mx-4 {{ $section_classes }}"></div>
        <div class="relative py-20 lg:py-32 pb-10 z-10">
          @if ($section['title'] || $section['description'])
            <div class="text-center max-w-5xl mx-auto">
              @if ($section['title'])
                <h{{ $h_level }} class="mb-10>{!! $section['title'] !!}</h{{ $h_level }}>
              @endif
              @isset ($section['description'])
                <div class="section-description max-w-5xl mx-auto text-xl">
                  {!! $section['description'] !!}
                </div>
              @endisset
            </div>
          @endif
        </div>
      </div>

    @else
    @if (isset($section['title']) || isset($section['description']))
      <div>
          <div class="text-center max-w-4xl mx-auto">
            @if ($section['title'])
              <h2>{{ $section['title'] }}</h2>
            @endif
            @if ($section['description'])
              {!! $section['description'] !!}
            @endif
          </div>
      </div>
    @endif

    <div class="relative z-10 @if ($background['color'] == 'dark') text-white @endif">

      <div class="lg:grid-cols-2 flex justify-between border-b-2 @if ($background['color'] == 'dark') border-brand @else border-light @endif">
        <div>
          @if ($section['subtitle'])
            <h2 class="mb-6">{{ $section['subtitle'] }}</h2>
          @endif
        </div>

        <fieldset class="w-full max-w-sm">
          <label for="cat" class="sr-only">States</label>
          <div class="relative max-w-sm">
            <select name="cat" id="cat" class="postform appearance-none block w-full bg-none bg-white border border-1 rounded-md py-2 pl-3 pr-10 text-base text-gray-400 focus:outline-none focus:ring-2 focus:ring-action focus:ring-offset-2 sm:text-sm">
              {!! $stateOptions !!}
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 px-2 flex items-center">
              <!-- Heroicon name: solid/chevron-down -->
              <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </div>
          </div>
        </fieldset>
      </div>

      <div id="ajax-posts" class="mt-10 max-w-lg mx-auto grid gap-8 lg:grid-cols-2 xl:grid-cols-3 lg:max-w-none">

        @foreach ($press as $index => $post)
          <div class="relative flex flex-col overflow-hidden">

            <div class="flex-1 @if ($background['color'] !== 'dark') bg-white @endif flex flex-col justify-between">
              <div class="flex-1 pb-10">
                @isset ($post['subtitle'])
                <p class="leading-normal text-sm font-medium mb-2">
                  <span class="inline-block @if ($background['color'] == 'dark') bg-action text-white @else bg-light text-action @endif font-medium rounded-full px-[15px] py-1 pill-span">
                    {{ $post['subtitle'] }}
                  </span>
                </p>
                @endisset

                <h3 class="mb-1">
                  @if ($post['permalink'])
                    <a
                      class="no-underline @if ($background['color'] == 'dark') text-white hover:text-blue-400 @else text-brand @endif"
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

              <div>
              @if ($post['permalink'])
                  <a
                    class="no-underline text-action font-semibold block"
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
      @if (count($total_press) > $ppp)
        <button id="load-more-local-news" type="button" class="mt-14 inline-flex button button-solid load-more-button loadmore-posts" data-ajax-container="ajax-posts" data-ppp="{{ $ppp }}" data-current-page="1" data-template="local-news" data-press-cat="{{ $category }}" data-bg-color="{{ $background['color'] }}">
          <span class="mr-4 inline-block">Load More</span> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"/></svg>
        </button>
      @endif
    </div>
    @endif
</section>
<div class="hidden border-t-2"></div>
@include('components.posts.partials.ajax')
