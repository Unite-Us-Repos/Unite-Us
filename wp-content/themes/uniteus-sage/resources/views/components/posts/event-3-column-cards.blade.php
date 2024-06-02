@php
$state =  isset($_GET['state']) ? $_GET['state'] : '';

$ppp = 3;
$slug = '';
$cat_name = '';
$all_1c_posts = App\View\Composers\Post::getPosts();
$posts = App\View\Composers\Post::getPosts($ppp);

$total_press = count($all_1c_posts);
$h_level = 2;
$is_heading = $section["is_header"];
if ($is_heading) {
  $h_level = 1;
}
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

<section class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

    @if ($h_level === 1)

      <div class="relative">

        <div class="relative pt-20 pb-10 mb-10 z-10">
          @if ($section['title'] || $section['description'])
            <div class="text-whitetext-center max-w-5xl mx-auto">
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
        <h2 class="relative z-10 mt-10">{{ $section['subtitle'] }}</h2>
      @endif
      </div>

    @else

      <div>
        @if ($section['title'] || $section['description'])
          <div class="">
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
    <div>
      <div id="ajax-spotlight" class="mt-10 max-w-lg mx-auto grid gap-8 lg:grid-cols-2 xl:grid-cols-3 lg:max-w-none">
        @foreach ($posts as $index => $post)

          @php
          $type = '';
          $terms = get_the_terms($post['ID'], 'event_type');
          if ($terms) {
            $type = $terms[0]->name;
          }

          $dates = [
            'September 10, 2024',
            'November 9, 2023',
            'August 15, 2023',
            //'November 2-3, 2022',
            ];

          $times = [
            'Starting at 8:30 am',
            '2:00 pm — 4:00 pm',
            '9:00 am — 5:00 pm',
            //'2:00 pm — 4:00 pm',
            ];
          @endphp
          <div class="relative group flex flex-col rounded-lg shadow-lg overflow-hidden">
          @if ($post['permalink'])
            <a class="absolute inset-0 z-40"
              class="no-underline text-brand"
              href="{{ $post['permalink'] }}"
              @if ($post['is_external']) target="_blank @endif">
                <span class="sr-only">{!! $post['post_title'] !!}</span>
            </a>
          @endif
          <div class="absolute inset-0 related-gradient opacity-0 group-hover:opacity-100"></div>
            <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>
            @isset ($post['thumbnail_url'])
            <div class="flex-shrink-0 bg-white border-b-2 border-light z-10">
              <img class="aspect-[5/2] w-full object-cover mx-auto" src="{{ $post['thumbnail_url'] }}" alt="{{ $post['thumbnail_alt'] }}">
            </div>
            @endisset
            <div class="flex-1 bg-white flex flex-col justify-between">
              <div class="flex-1 px-6 pt-7 pb-10 z-10">
                @isset ($post['subtitle'])
                <p class="leading-normal text-sm font-medium text-action mb-2">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    National
                  </span>
                </p>
                @endisset

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




                <div class="flex flex-wrap gap-3 mt-4">
                <div class="inline-flex gap-2 px-2 py-1 justify-center items-start no-underline text-brand hover:shadow-inner border-2 border-pale-blue-dark rounded-[16px]">
                    <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="21" viewBox="0 0 19 21" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M5.69991 2.61328C5.17524 2.61328 4.74991 3.061 4.74991 3.61328V4.61328H3.79991C2.75056 4.61328 1.8999 5.50871 1.8999 6.61328V16.6133C1.8999 17.7179 2.75056 18.6133 3.79991 18.6133H15.1999C16.2493 18.6133 17.0999 17.7179 17.0999 16.6133V6.61328C17.0999 5.50871 16.2493 4.61328 15.1999 4.61328H14.2499V3.61328C14.2499 3.061 13.8246 2.61328 13.2999 2.61328C12.7752 2.61328 12.3499 3.061 12.3499 3.61328V4.61328H6.64991V3.61328C6.64991 3.061 6.22458 2.61328 5.69991 2.61328ZM5.69991 7.61328C5.17524 7.61328 4.74991 8.061 4.74991 8.61328C4.74991 9.16557 5.17524 9.61328 5.69991 9.61328H13.2999C13.8246 9.61328 14.2499 9.16557 14.2499 8.61328C14.2499 8.061 13.8246 7.61328 13.2999 7.61328H5.69991Z" fill="#2874AF"/>
                    </svg>
                    </span>
                    <span class="text-brand text-sm">
                      <div class="">
                        <span class="mec-start-time">{{ $dates[$index] }}</span></span>
                      </div>
                    </span>
                </div>

                <div class="inline-flex gap-2 px-2 py-1 justify-center items-start no-underline text-brand hover:shadow-inner border-2 border-pale-blue-dark rounded-[16px]">
                    <span>
                      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0014 18C14.1987 18 17.6014 14.4183 17.6014 10C17.6014 5.58172 14.1987 2 10.0014 2C5.804 2 2.40137 5.58172 2.40137 10C2.40137 14.4183 5.804 18 10.0014 18ZM10.9514 6C10.9514 5.44772 10.526 5 10.0014 5C9.47669 5 9.05136 5.44772 9.05136 6V10C9.05136 10.2652 9.15145 10.5196 9.32961 10.7071L12.0166 13.5355C12.3876 13.9261 12.9891 13.9261 13.3601 13.5355C13.7311 13.145 13.7311 12.5118 13.3601 12.1213L10.9514 9.58579V6Z" fill="#2874AF"></path>
                      </svg>
                    </span>
                    <span class="text-brand text-sm">
                      <div class="">
                      {{ $times[$index] }}
                      </div>
                    </span>
                </div>

                <div class="inline-flex gap-2 px-2 py-1 justify-center items-start no-underline text-brand hover:shadow-inner border-2 border-pale-blue-dark rounded-[16px]">
                    <span>
                    <svg width="14" height="17" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7634 2.05025C14.3604 4.78392 14.3604 9.21608 11.7634 11.9497L7.06113 16.8995L2.35887 11.9497C-0.238114 9.21608 -0.238114 4.78392 2.35887 2.05025C4.95586 -0.683417 9.16641 -0.683418 11.7634 2.05025ZM7.06148 8.99996C8.11082 8.99996 8.96148 8.10453 8.96148 6.99996C8.96148 5.89539 8.11082 4.99996 7.06148 4.99996C6.01214 4.99996 5.16148 5.89539 5.16148 6.99996C5.16148 8.10453 6.01214 8.99996 7.06148 8.99996Z" fill="#2874AF"></path>
                    </svg>
                    </span>
                    @if ($type)
                    <span class="text-brand text-sm">
                      <div class="">
                        <span class="mec-start-time">{{ $type }}</span></span>
                      </div>
                    </span>
                    @endif
                </div>


</div>

              </div>

            </div>
          </div>
        @endforeach
      </div>
      @if ($total_press > $ppp)
        <div class="mt-14 text-center">
          <button type="button" class="inline-flex button button-solid load-more-button loadmore-posts" data-post-type="1c" data-ajax-container="ajax-spotlight" data-ppp="{{ $ppp }}" data-current-page="1" data-template="1c-event" data-press-cat="{{ $category }}">
            <span class="mr-4 inline-block">Load More</span> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"/></svg>
          </button>
        </div>
      @endif
    </div>
    </div>
    @endif
</section>
@include('components.posts.partials.ajax')
