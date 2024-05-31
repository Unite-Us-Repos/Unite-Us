@php
if ('by_category' == $selection) {
  $ppp = 2;
  $articles = App\View\Composers\Post::getPosts($ppp, array('slug' => 'category', 'ids' => $category), '', $featured_posts);
} else {
  $articles = App\View\Composers\Post::getPosts('', '', $posts);
}
$latest = App\View\Composers\Post::getPosts(2);

if (!isset($posts)) {
  $featured_posts = [];
}
$featured_posts = App\View\Composers\Post::getPosts('', '', $posts);
$featured_posts = json_decode(json_encode($featured_posts)); // convert array to object
$articles = json_decode(json_encode($articles)); // convert array to object
$latest = json_decode(json_encode($latest)); // convert array to object
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

<section class="component-section {{ $section_classes }}">
<div class="component-inner-section">

  @isset ($section['title'])
    <h2 class="text-center">
      {!! $section['title'] !!}
    </h2>
    @endisset
  @if ($articles)



    <div class="flex flex-col lg:grid lg:grid-cols-2 gap-8">
      <div class="flex flex-col">

      <h2 class="text-action text-sm font-normal uppercase relative  pt-4 border-t-2 border-blue-300">Featured</h2>

@if ($featured_posts)
@foreach ($featured_posts as $index => $post)
@php
$type = App\View\Composers\Post::getType($post->ID);
$catSlug = App\View\Composers\Post::getPostCatSlug($post->ID);
$thumbUrl = get_the_post_thumbnail_url($post->ID, 'medium_large');
$img_id = get_post_thumbnail_id($post->ID);
$alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
@endphp

<div class="relative flex flex-1 flex-col justify-end rounded-lg overflow-hidden group min-h-[360px]">
  <div class="absolute bottom-0 w-full h-3/6 bg-blue-900"></div>

  <div class="card-overlay pointer-events-none absolute inset-0 bg-brand opacity-75 z-10"></div>
  @if ($thumbUrl)
    <div class="absolute inset-0">
      <a id="whats-new-{{ $loop->index+1 }}" href="{{ get_the_permalink($post->ID) }}" alt="{{ $post->post_title }}">
        <img class="lazy w-full h-full object-cover" data-src="{{ $thumbUrl }}" alt="{{ $alt_text }}" />
      </a>
    </div>
  @endif
  <div class="relative pointer-events-none z-10 w-full p-7 pb-0">
    <div class="absolute inset-0 z-10 border-b-[15px] border-action transition ease-in-out delay-250 group-hover:opacity-0 group-hover:z-0"></div>
    <div class="absolute inset-0 bg-gradient-service md:opacity-0 group-hover:opacity-100"></div>
    <div class="relative leading-loose text-white">
        <div class="flex mb-4" style="pointer-events:all">
          <a href="/{{ $catSlug }}/">
            <span class="text-sm font-medium text-white pr-6">
              <span class="inline-block bg-action font-medium rounded-full px-4 py-1">
                {{ $type }}
              </span>
            </span>
          </a>
        </div>
        <h3 class="entry-title leading-none mb-3 sm:pr-8 text-white text-2xl lg:text-3xl">
          <a class="no-underline text-white hover:text-white" href="{{ get_the_permalink($post->ID) }}">
            {!! $post->post_title !!}
          </a>
        </h3>
        <div class="text-white text-lg">
          {{ get_the_date('', $post->ID) }}
        </div>

          <div class="mb-2 mt-6 group-hover:mt-9 service-description group-hover:h-12">
            <a id="whats-new-read-more-{{ $loop->index+1 }}" class="no-underline text-lg text-white hover:text-white font-base"
              href="{{ get_the_permalink($post->ID) }}"
              aria-label="Read More - {!! $post->post_title !!}"
              >
              Read More <span class="sr-only"> -{!! $post->post_title !!}</span><span aria-hidden="true" class="ml-1"> →</span>
            </a>
          </div>
        </div>
</div>
      </div>
@break
  @endforeach
@endif


      </div>

        <div>

              <h2 class="text-action text-sm font-normal uppercase relative  pt-4 border-t-2 border-blue-300">Most Recent</h2>

          <div class="mt-6 grid gap-14 lg:max-w-none">
      @if ($latest)
        @foreach ($latest as $index => $post)
        @php
        $type = App\View\Composers\Post::getType($post->ID);
        $catSlug = App\View\Composers\Post::getPostCatSlug($post->ID);
        $img_id = get_post_thumbnail_id($post->ID);
        $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
        @endphp


          <div class="grid grid-cols-5 gap-5">
            <div class="col-span-2 sm:col-span-1">
              @if (get_the_post_thumbnail_url($post->ID))
              <a href="{{ get_the_permalink($post->ID) }}" alt="">
                <img class="lazy object-cover aspect-square rounded-md"
                data-src="@php echo get_the_post_thumbnail_url($post->ID, 'thumbnail') @endphp" alt="{{ $alt_text }}">
              </a>
              @endif
            </div>
            <div class="col-span-3 sm:col-span-4">
              <div class="flex-1 flex flex-col justify-between">

                <div class="flex-1 mb-2">
                  <p class="leading-normal text-sm font-medium text-action mb-4">
                    <a href="/{{ $catSlug }}/">
                      <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                        {{ $type }}
                      </span>
                    </a>
                  </p>

                  <h3 class="mb-1">
                    <a id="whats-new-{{ $loop->index+2 }}" class="no-underline text-brand" href="{{ get_the_permalink($post->ID) }}">
                      {!! $post->post_title !!}
                    </a>
                  </h3>
                  <div class="text-sm sm:text-base">{{ get_the_date('', $post->ID) }}</div>
                </div>

                <div class="mt-3">
                  <a
                    id="whats-new-read-more-{{ $loop->index+2 }}"
                    class="no-underline text-action font-semibold"
                    href="{{ get_the_permalink($post->ID) }}"
                    aria-label="Read More - {{ $post->post_title }}"
                    >
                      Read More<span aria-hidden="true" class="ml-1"> &rarr;</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        @endif
        <div class="w-full flex flex-col -mt-6 justify-end">
          <a href="/knowledge-hub/" class="button button-hollow w-full mb-0">
           View All
                      </a>
        </div>
      </div>
</div>

    </div>
    @endif
</section>
