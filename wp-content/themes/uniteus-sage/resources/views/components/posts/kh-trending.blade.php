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
<section id="kh-trending" class="component-section {{ $section_classes }}">

  @if ($articles)
  <div class="component-inner-section">
    <div class="relative z-10 lg:grid-cols-2 flex justify-between border-b-2 border-blue-200">
      <div>
        <h2 class="text-brand relative z-10">Trending Content</h2>
      </div>
    </div>
    <div class="mt-10 max-w-lg mx-auto grid gap-12 lg:gap-7 lg:grid-cols-2 xl:grid-cols-3 lg:max-w-none">

      @foreach ($articles as $post)
      @php
      $type = App\View\Composers\Post::getType($post->ID);
      $catSlug = App\View\Composers\Post::getPostCatSlug($post->ID);
      $img_id = get_post_thumbnail_id($post->ID);
      $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
      @endphp


        <div class="grid grid-cols-3 gap-6">
          <div class="aspect-square">
            @if (get_the_post_thumbnail_url($post->ID))
            <a class="no-underline" href="{{ get_the_permalink($post->ID) }}" alt="{{ $post->post_title }}">
              <img class="object-cover aspect-square rounded-md"
              src="@php echo get_the_post_thumbnail_url($post->ID, 'medium') @endphp" alt="{{ $alt_text }}">
            </a>
            @endif
          </div>
          <div class="col-span-2">
            <div class="flex-1 bg-white flex flex-col justify-between">

              <div class="flex-1 mb-4">
                <p class="leading-normal text-sm font-medium text-action mb-2">
                  <a href="/{{ $catSlug }}/">
                    <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                      {{ $type }}
                    </span>
                  </a>
                </p>

                <h3 class="mb-1">
                  <a class="no-underline text-brand" href="{{ get_the_permalink($post->ID) }}">
                    {!! $post->post_title !!}
                  </a>
                </h3>
                {{ get_the_date('', $post->ID) }}
              </div>


              <div>
                <a class="no-underline text-action font-semibold" href="{{ get_the_permalink($post->ID) }}">
                  Read More<span aria-hidden="true" class="ml-1"> &rarr;</span>
                </a>

              </div>
            </div>
          </div>
        </div>
        @endforeach

    </div>
    @endif
</section>
