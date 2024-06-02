@php
$h_level = '2';
if ('by_category' == $selection) {
  $ppp = 3;
  $press = App\View\Composers\Post::getPosts($ppp, array('slug' => 'category', 'ids' => $category));
} else {
  $press = App\View\Composers\Post::getPosts('', '', $posts);
}
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

<section class="component-section {{ $section_classes }}" @if ($h_level === '1') style="padding-top:0 !important;" @endif>


      <div class="relative">

        <div class="absolute inset-0 -mb-24 -mx-4 {{ $section_classes }}"></div>


    <div class="component-inner-section relative z-10">
    <div class="relative z-10 lg:grid-cols-2 flex justify-between">
          <div>
            <h2 class="text-brand relative z-10">All Content</h2>
          </div>

        </div>

        <div id="kh-top">
          <div id="kh-filters" class="ajax-filters kh-filters relative z-20">
            @php
              echo do_shortcode('[searchandfilter slug="kh-all"]');
            @endphp
          </div>
        </div>

        <div id="filterBadges" class="relative flex flex-wrap items-center gap-y-4 py-10 z-10"></div>

      <div id="kh-search-results">
        @php
        echo do_shortcode('[searchandfilter slug="kh-all" show="results"]');
        @endphp
      </div>
    </div>
    </div>

</section>
