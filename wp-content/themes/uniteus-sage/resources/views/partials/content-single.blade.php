@php
    $recommended_press = App\View\Composers\Post::getPosts(4, '', '', [$post->ID]);
    if (!isset($layout)) {
        $layout = '';
    }
    $has_podcast_links = false;
    foreach ($podcast_links as $field_name => $link) {
        if (!empty($link)) {
            $has_podcast_links = true;
        }
    }
    $author_name = get_field('author_name', $post->ID); // Fetch the author name from ACF

    // Function to extract iframe src
    function extract_iframe_src($content)
    {
        if (preg_match('/<iframe[^>]+src="([^"]+)"[^>]*><\/iframe>/', $content, $match)) {
            return $match[1];
        }
        return '';
    }

    // Capture the content output
    ob_start();
    if ('default' == $layout) {
        the_content();
    }
    $content = ob_get_clean();

    // Extract video URL from the content
    $video_url = extract_iframe_src($content);

    // Schema Markup Variables for Webinar Posts
    $page_title = get_the_title();
    $meta_description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
    $page_url = get_permalink();
    $preview_image = get_the_post_thumbnail_url($post->ID, 'full');
    $publish_date = get_the_date('c', $post->ID);

    // Retrieve user-provided schema markup from ACF
    $acf_schema_markup = get_field('schema_markup', $post->ID);

    // Replace variables in user-provided schema markup
    $schema_markup = str_replace(
        [
            '{{ PageTitle }}',
            '{{ MetDescription }}',
            '{{ VideoURL }}',
            '{{ PageURL }}',
            '{{ PreviewImage }}',
            '{{ PublishDate }}',
        ],
        [$page_title, $meta_description, $video_url, $page_url, $preview_image, $publish_date],
        $acf_schema_markup,
    );
@endphp



<article @php (post_class()) @endphp="@php (post_class()) @endphp">
  <header>
    <section class="relative component-section bg-brand">
      <div class="absolute inset-0">
        @if (get_the_post_thumbnail_url())
        <img fetchpriority="high" class="w-full h-full object-cover" src="{{ get_the_post_thumbnail_url(get_the_ID(), 'medium') }}"
          srcset="{{ get_the_post_thumbnail_url(get_the_ID(), 'medium') }} 300w, {{ get_the_post_thumbnail_url(get_the_ID(), '2048x2048') }} 1024w"
          sizes="(max-width: 600px) 300px, 1024px"
          alt="">
        @endif
      </div>
      <div class="absolute inset-0 bg-brand opacity-75"></div>
      <div class="component-inner-section relative z-10">
        <div class="max-w-5xl px-10 mx-auto leading-loose">
          <div class="flex justify-center mb-8 sm:mb-10">
            @php
            $data = [
              'color' => 'white'
            ];
            @endphp
            @include('ui.breadcrumbs.simple-with-slashes', $data)
          </div>
          <h1 class="entry-title text-center leading-none mb-8 sm:mb-10 text-white text-4xl lg:text-5xl">
            {!! $title !!}
          </h1>
          @if ($author_name)
            <span class="m-auto d-block text-center text-white text-lg mb-6">By: {{ $author_name }}</span>
          @endif
        </div>
        @include('partials.entry-meta')
      </div>
    </section>
  </header>

  <div class="component-section">
    <div class="max-w-4xl px-5 sm:px-16 mx-auto leading-loose">

      @isset ($video_link)
        @if ($video_link)
          <div class="responsive-embed rounded-lg overflow-hidden mb-10">
            {!! $video_link !!}
          </div>
        @endif
      @endisset

      @if ($has_podcast_links)
        <ul class="list-video-play podcast-single-play-list sm:flex sm:flex-wrap sm:gap-3 mb-12">
          @foreach ($podcast_links as $field_name => $link )
            @php
              $field_name_map = [
                  'spotify' => 'Spotify',
                  'apple_podcast' => 'Apple Podcast',
                  'buzzsprout' => 'BuzzSprout',
                  'youtube' => 'YouTube',
                  'rss' => 'RSS',
                ];
              $field_name = $field_name_map[$field_name];
            @endphp
            @if ($link)
              <li><a href="{{ $link }}" class="no-underline" target="_blank">{{ $field_name }}</a></li>
            @endif
          @endforeach
        </ul>
      @endif

      @if ('default' == $layout)
        {!! $content !!}
      @endif

      @php
        function set_flex_basis($columns) {
          if (!$columns) {
            return false;
          }
          if ($columns == 'auto') {
            return 'sm:flex-1';
          }
          if ($columns == '12') {
            return 'sm:basis-full';
          }
          return 'sm:basis-' . "$columns/12";
        }
      @endphp

      @isset ($columns)
      <div class="@isset($section_settings['fullscreen']) fullscreen @endisset">
        @foreach ($columns as $index => $widget)
          @isset ($widget['acf_fc_layout'])
            @php
              $layout_col = $widget['acfe_layout_col'];
              $flex_basis = set_flex_basis($layout_col);
            @endphp
            @if ($widget['acfe_layout_col'] && $index === 0)
              <div class="flex flex-col sm:flex-row sm:flex-wrap sm:justify-between gap-6 sm:gap-0 sm:-mx-3">
            @endif
            @if ($widget['acfe_layout_col'])
              <div class="@if ($widget['acfe_layout_col']) {{ $flex_basis }} @endif sm:p-3">
                @includeIf('widgets.' . str_replace('_', '-', $widget["acf_fc_layout"]))
              </div>
            @endif
            @if ($widget['acfe_layout_col'] && $index+1 === count($columns))
              </div>
            @endif
          @endisset
        @endforeach
      </div>
      @endisset
    </div>
  </div>

  <div class="max-w-4xl mb-10 mx-auto">
    @isset ($aboutUniteUs)
    <div id="newsAbout" class="bg-light sm:rounded-xl sm:mx-8 p-10 leading-loose">
      {!! $aboutUniteUs !!}
      <div class="my-6 border border-blue-300" style="width: 100px"></div>
      @if ($postTopics)
      <div class="flex items-center mb-3">
        <span class="text-lg font-bold mr-6">Topics: </span>
        {!! $postTopics !!}
      </div>
      @endif
      <div class="flex items-center">
        <span class="text-lg font-bold mr-6">Share: </span>
        {!! $socialButtons !!}
      </div>
    </div>
    @endisset
  </div>
</article>



{{-- RECOMMENDED FOR YOU --}}
<section class="component-section -mt-10">
  <div class="relative">
    <div class="component-inner-section relative z-10">
      <div class="relative z-10 lg:grid-cols-2 flex justify-center">
        <div>
          <div class="text-brand text-2xl sm:text-4xl relative font-semibold z-10 mb-10">Recommended for You</div>
        </div>
      </div>
      <div class="mx-auto grid gap-6 sm:gap-10 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($recommended_press as $index => $post)
        @php
        $type = App\View\Composers\Post::getType($post['ID']);
        $catSlug = App\View\Composers\Post::getPostCatSlug($post['ID']);
        @endphp
        <div class="relative flex flex-col rounded-lg shadow-lg overflow-hidden">
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
                <a
                  class="no-underline text-brand"
                  href="{{ $post['permalink'] }}"
                  aria-label="{{ htmlentities($post['post_title']) }}"
                  >{!! $post['post_title'] !!}</a>
                @endif
              </h3>
              {{ $post['date'] }}
            </div>
            <div class="bg-light hover:bg-blue-200">
              @if ($post['permalink'])
              <a
                class="rfy-read-more no-underline text-action font-semibold p-6 block"
                href="{{ $post['permalink'] }}"
                aria-label="Read More - {{ htmlentities($post['post_title']) }}"
                >Read More<span class="sr-only"> - {!! $post['post_title'] !!}</span><span aria-hidden="true" class="ml-1">&rarr;</span></a>
              @else
              <span class="p-6 block">&nbsp;</span>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>


{{-- Output the user-provided schema markup if it exists --}}
@if ($schema_markup)
  <script type="application/ld+json">
    {!! $schema_markup !!}
  </script>
@endif
