@php
if ('by_category' == $selection) {
  $ppp = 3;
  $articles = App\View\Composers\Post::getPosts($ppp, array('slug' => 'category', 'ids' => $category));
} else {
  $articles = App\View\Composers\Post::getPosts('', '', $posts);
}
$articles = json_decode(json_encode($articles)); // convert array to object
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="max-w-7xl mx-auto {{ $section_classes }}">
@foreach ($articles as $post)
@php
$type = App\View\Composers\Post::getType($post->ID);
$catSlug = App\View\Composers\Post::getPostCatSlug($post->ID);
$img_id = get_post_thumbnail_id($post->ID);
$alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
@endphp
<header>
    <section class="component-section relative">
      <div class="component-inner-section">
        <div class="absolute inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden">
          @if (get_the_post_thumbnail_url($post->ID))
            <img class="w-full h-full object-cover" src="@php echo get_the_post_thumbnail_url($post->ID) @endphp" alt="{{ $alt_text }}">
          @endif
        </div>
        <div class="absolute inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden bg-brand opacity-75"></div>
      <div class="relative mx-auto">

        <div class="px-0 sm:px-10 leading-loose relative z-10 lg:w-9/12">
            <div class="flex mb-6">
              <a href="/{{ $catSlug }}/">
                <span class="text-sm font-medium text-white mr-6">
                  <span class="inline-block bg-action font-medium rounded-full px-4 py-1">
                    {{ $type }}
                  </span>
                </span>
              </a>
            </div>
            <h1 class="entry-title leading-none mb-5 sm:mb-6 text-white text-4xl lg:text-5xl">
              <a class="text-white no-underline hover:text-white" href="{{ get_the_permalink($post->ID) }}">{!! $post->post_title !!}</a>
            </h1>

          <div class="flex text-center text-xl">
            <time class="text-white" datetime="{{ get_post_time('c', true) }}">
              {{ get_the_date('', $post->ID) }}
            </time>
          </div>
          <div class="mt-6">
            <a href="{{ get_the_permalink($post->ID) }}" class="button button-solid load-more-button loadmore-posts">
                Read More
              </a>
          </div>
        </div>
      </div>
    </section>
  </header>
  @endforeach
</section>
