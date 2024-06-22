@php
$ppp = 4;
$state = '';
$post_type = 'post';
if (is_singular('network')) {
  $state = $post->post_name;
  $post_type = ['press', 'post'];
}
$press = [];
$total_press = [];

$total_press = App\View\Composers\Post::getNetworkPress($state, '-1', $post_type);
if ('by_category' == $selection) {
  $press = App\View\Composers\Post::getNetworkPress($state, '-1', $post_type);
} else {
  $press = App\View\Composers\Post::getNetworkPress($state, $ppp, $post_type);
}
$press = App\View\Composers\Post::getNetworkPress($state, $ppp, $post_type);


$background = [
  'color' => 'dark',
  'apply_to' => 'section',
  'has_divider' => 1,
  ];

$section = [
    'title' => 'Collaborating for a Healthier Community',
    'is_header' => 0,
    'alignment' => 'center',
    'subtitle' => 'See Our Partnerships in Action',
    'description' => '',
  ];
  if (isset($background['color'])) {
    $section_classes = 'bg-' . $background['color'];
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
<section class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section relative z-20
    @if ($section_settings['fullscreen']) fullscreen @endif">

    @if ($h_level === 1)

      <div class="relative">

        <div class="relative pt-20 pb-10 mb-10 z-10">
          @if ($section['title'] || $section['description'])
            <div class="text-center max-w-5xl mx-auto">
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
          <div class="text-center max-w-4xl mx-auto @if ($background['color'] == 'dark') text-white @endif">
            @if ($section['subtitle'])
              <div class="text-action-light-blue uppercase font-semibold mb-4">{{ $section['subtitle'] }}</div>
            @endif
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
      <div id="network-press" class="mt-10 mx-auto grid gap-8 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 lg:max-w-none">
        @foreach ($press as $index => $post)
          @php
            $post_cat = '';
            $post_taxonomies = get_the_terms($post['ID'], 'category');
            $press_taxonomies = get_the_terms($post['ID'], 'press_cat');

            $default_image = '';

            if ($press_taxonomies) {
                $post_cat = join(', ', wp_list_pluck($press_taxonomies, 'name'));

                $post_cat_name = $press_taxonomies[0]->name;
                //$post_cat_link = '/press_cat/' . $press_taxonomies[0]->slug .'/';
                $post_cat_link = '/press/';
            }

            if ($post_taxonomies) {
                $post_cat = join(', ', wp_list_pluck($post_taxonomies, 'name'));

                $post_cat_name = $post_taxonomies[0]->name;
                $post_cat_link = '/' . $post_taxonomies[0]->slug . '/';
            }

            $post_cat = str_replace('Local News', 'News', $post_cat);
            $post_cat_name = str_replace('Local News', 'News', $post_cat_name);

            $thumbnail_alt = $post['thumbnail_alt'];
            $thumbnail_url = $post['thumbnail_url'];

            if (!$thumbnail_url) {

              /*
              $state_term = get_term_by('name', $state, 'states');
              if ($state_term) {
                $default_image = get_field('state_taxonomy_default_image', 'states_' . $state_term->term_id);
                $thumbnail_url = $default_image['sizes']['medium_large'];
                $thumbnail_alt = $default_image['alt'];
              }
              */

              if (!$default_image) {
                $default_image  = '/wp-content/themes/uniteus-sage/public/images/unite-us-logo.svg';
                $thumbnail_url = $default_image;
              }
            }


          @endphp
          <div class="relative flex flex-col bg-white rounded-lg shadow-lg overflow-hidden">
            @if ($thumbnail_url)
            <div class="flex-shrink-0 related-gradient border-b-2 border-light">
              <img class="aspect-video w-full @if ($default_image) object-contain p-8 px-14 @else object-cover @endif mx-auto" src="{{ $thumbnail_url }}" alt="{{ $thumbnail_alt }}">
            </div>
            @endif
            <div class="flex-1 bg-white flex flex-col justify-between">
              <div class="flex-1 px-6 pt-7 pb-10">
                @isset ($post_cat)
                <a href="{{ $post_cat_link }}" class="leading-normal inline-block text-sm font-medium text-action mb-2">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    {{ $post_cat_name }}
                  </span>
                </a>
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
                {{ $post['date'] }}
                @isset ($post['excerpt'])
                  {!! $post['excerpt'] !!}
                @endisset
              </div>

              <div class="bg-light hover:bg-blue-200">
              @if ($post['permalink'])
                  <a
                    class="no-underline text-action flex gap-3 items-center font-semibold p-6"
                    href="{{ $post['permalink'] }}"
                    @if ($post['is_external']) target="_blank @endif">Read More<span aria-hidden="true" class="ml-1"> &rarr;</span></a>
                @else
                  <span class="p-6 block">
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11" fill="none">
                    <path d="M7.875 1.5105L12 5.6355M12 5.6355L7.875 9.7605M12 5.6355L1 5.6355" stroke="#216cff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  </span>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
      @if (count($total_press) > $ppp)
      <div class="mt-14 text-center">
        <button type="button" class="inline-flex button button-solid load-more-button loadmore-posts group" data-ajax-container="ajax-spotlight" data-ppp="{{ $ppp }}" data-current-page="1" data-template="kh" data-press-cat="{{ $category }}" data-post-type="post">
          <span class="mr-4 inline-block">Load More</span>
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path class="path-hover" fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#FFFFFF"/>
          </svg>
        </button>
      </div>      
      @endif
    </div>
    </div>
    @endif
    <div class="absolute inset-0 bg-white z-10" style="margin-top: 440px"></div>
</section>
@include('components.posts.partials.ajax')
