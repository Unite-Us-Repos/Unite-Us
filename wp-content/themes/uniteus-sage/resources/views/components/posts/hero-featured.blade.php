<style>
.podcast-gradient {
  background: rgb(0,0,0);
  background: linear-gradient(342deg, rgba(0,0,0,1) 0%, rgba(24,42,68,0) 50%);
}
</style>
@php
$hide_breadcrumbs = true;
$taxonomy = '';
$type = '';
$catSlug = '';
if ('by_category' == $selection) {
  $taxonomy = array('slug' => 'category', 'ids' => $category);
  $cat_obj = get_category($category);
  $slug = $cat_obj->slug;
  $cat_name = $cat_obj->name;
}
$featured_post = App\View\Composers\Post::getPosts(1, $taxonomy); // gets latest post
if (count($featured_post) === 1) {
  $featured_post = $featured_post[0];
}
$linkable_pill = false;
@endphp
<section class="header-hero bg-gray-800 relative component-section">
  <!-- Overlay -->

  <div class="absolute inset-0">
    @if ($background['image'])
      <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    @endif
  </div>

  @if ($background['overlay'])
  <div class="absolute inset-0 bg-brand opacity-75"></div>
  @endif

  <div class="relative w-full">

    <div class="component-inner-section">
      <div class="flex flex-col gap-10 lg:grid lg:grid-cols-2 lg:gap-28">
        <div class="order-1 lg:order-none">
          @if (!$hide_breadcrumbs)
            <div class="mb-9 sm:mb-10">
              @php
              $data = [
                'color' => 'white'
              ];
              @endphp
              @include('ui.breadcrumbs.simple-with-slashes', $data)
            </div>
          @endif
          @isset ($section['logo']['sizes'])
            <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="" />
          @endisset

          @if ($section['subtitle'])
            <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
              {!! $section['subtitle'] !!}
            </div>
          @endif
          <div class="leading-normal mb-5 text-white inline-flex items-center gap-4 text-sm bg-dark-blue rounded-2xl p-1">
            @if ($linkable_pill)
              <a class="no-underline" href="/{{ $slug }}/">
            @endif
            <span class="inline-block uppercase text-white bg-morado font-normal text-xs rounded-full px-[15px] py-1 pill-span">
              {{ $cat_name }}
            </span>
            @if ($linkable_pill)
              </a>
            @endif
            <span class="flex flex-row">
            @if ($linkable_pill)
              <a class="inline-flex no-underline" href="{{ $featured_post['permalink'] }}">
            @endif
            Latest Episode
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.29289 14.7071C6.90237 14.3166 6.90237 13.6834 7.29289 13.2929L10.5858 10L7.29289 6.70711C6.90237 6.31658 6.90237 5.68342 7.29289 5.29289C7.68342 4.90237 8.31658 4.90237 8.70711 5.29289L12.7071 9.29289C13.0976 9.68342 13.0976 10.3166 12.7071 10.7071L8.70711 14.7071C8.31658 15.0976 7.68342 15.0976 7.29289 14.7071Z" fill="#6B7280"/>
            </svg>
            @if ($linkable_pill)
              </a>
            @endif
            </span>
            </div>

          <h1 class="mb-5 text-4xl font-extrabold tracking-tight text-white md:text-5xl">
            {!! $featured_post['post_title'] !!}
          </h1>

          @if ($featured_post['post_title'])
            <div class="text-white text-xl">
              {!! get_the_excerpt($featured_post['ID']) !!}
            </div>
          @endif

          <a class="mt-10 button hover:bg-light button-solid-white items-center gap-4" href="{{ $featured_post['permalink'] }}"><span class="text-brand font-semibold">Watch or Listen to Episode</span>
            <span><svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.6667 1.16675L16.5 7.00008M16.5 7.00008L10.6667 12.8334M16.5 7.00008L1.5 7.00008" stroke="#712F79" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
          </a>
        </div>
        <div>
        @if($featured_post['thumbnail_url'])
        <div class="relative h-full w-full podcast-featured-image rounded-xl overflow-hidden">
          <div class="absolute inset-0 z-10 podcast-gradient"></div>
          <div class="absolute inset-0 right-10 bottom-10 z-20" style="background:url('@asset('images/podcast-logo-what-unites-us-white.png')') bottom right no-repeat;background-size: 123px;">
          </div>
          <img class="lazy w-full h-72 lg:h-full object-cover" data-src="{{ $featured_post['thumbnail_url'] }}" alt="{{ $featured_post['thumbnail_alt'] }}">
        </div>
        @endif
        </div>
      </div>
    </div>
  </div>
</section>
