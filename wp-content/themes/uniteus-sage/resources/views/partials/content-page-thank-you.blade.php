@php
if (!isset($layout)) {
  $layout = '';
}

$post_id = '';
$page_slug = get_query_var('page_slug');
if ($page_slug) {
$args = [
    'post_type'      => ['post', 'page'],
    'status' => 'publish',
    'posts_per_page' => 1,
    'post_name__in'  => [$page_slug],
    ];
$q = get_posts( $args );
$post = $q[0];
$post_id = $q[0]->ID;
$fields = get_fields($post_id);
$layout = get_field('layout', $post_id);
} else {
  $post_id = $post->ID;
}

$background = [
  'color' => 'dark',
  ];
$color = [];

$type = '';
$download = '';

//$image = isset($acf['featured_image']) ? $acf['featured_image']['sizes']['medium_large'] : false;

$image = get_the_post_thumbnail_url($post_id, 'medium_large');


$acf = isset($fields['gated_page']) ? $fields['gated_page'] : [];

if (isset($fields['gated_page']) OR ('download' == $layout)) {
  $section_classes = 'bg-dark-blue';

} else {
  $section_classes = 'bg-light-gradient';
}

$doc = urldecode(get_query_var('doc'));

if ('download' == $layout) {
  $download = isset($download_page['document']) ? $download_page['document'] : '';
  $doc = $download;
}

$terms = get_the_terms($post_id, 'category');
$terms_industry = get_the_terms($post_id, 'industry');
$terms_topic = get_the_terms($post_id, 'topic');

if ($terms) {
  foreach ($terms as $term) {
    $type = $term->name;
  }
}

if ($terms_topic) {
  $terms_topic = array_splice($terms_topic, 0, 6);
}

$base = '/';

$acf['description'] = '<a id="docDownload" class="button button-solid mt-2" href="' . $doc . '" download target="_blank">Download the ' . $type . '</a>';
$acf['title'] = isset($acf['title']) ? $acf['title'] : $post->post_title;

@endphp
@if (isset($fields['gated_page']) OR $download)
<div class="bg-dark-blue" style="height: 60px;"></div>
<section class="relative component-section {{ $section_classes }}" @if ($image) style="background-image: url({{ $image }});background-repeat: no-repeat; background-size: auto 100%; background-position: center center;" @endif>
  <div class="absolute inset-0 bg-dark-blue opacity-95"></div>

@else

<section class="relative component-section bg-light-gradient">

@endif
  <div class="component-inner-section relative z-10">


    @if (isset($fields['gated_page']) OR $download)
      @if ($image)
        <img class="w-full h-full object-contain max-w-lg mx-auto mb-6" style="max-height: 265px" src="{{ $image }}" alt="" />
      @endif

      @if ('gated' == $layout)
        <div class="text-action-light-blue text-2xl lg:text-3xl text-center mb-6">Your Download is Ready</div>
      @endif
      @if ($acf['title'] || $acf['description'])
        <div class="text-white text-center max-w-5xl mx-auto">
          @if ($acf['title'])
            <h1 class="h2 font-bold mb-6">{!! $acf['title'] !!}</h1>
          @endif

        <div class="flex gap-3 flex-wrap justify-center items-center max-w-xl mx-auto">
        @php


          if ($terms) {
            foreach ($terms as $term) {
              echo '<a href="' . $base . $term->slug . '/" class="no-underline rounded-full py-0.5 px-3 text-sm text-white hover:text-white" style="background: #425C77;">' . $term->name . '</a>';
            }
          }

          if ($terms_industry) {
            $base = '/industry/';
            foreach ($terms_industry as $term) {
              echo '<a href="' . $base . $term->slug . '/" class="no-underline rounded-full py-0.5 px-3 text-sm text-white hover:text-white" style="background: #425C77;">' . $term->name . '</a>';
            }
          }

          if ($terms_topic) {
            $base = '/topic/';
            foreach ($terms_topic as $term) {
              echo '<a href="' . $base . $term->slug . '/" class="no-underline rounded-full py-0.5 px-3 text-sm text-white hover:text-white" style="background: #425C77;">' . $term->name . '</a>';
            }
          }
        @endphp

        </div>

          @if ($acf['description'] && $doc)
            <div class="text-lg mt-6">
              {!! $acf['description'] !!}
            </div>
          @endif
        </div>
      @endif

    @else
    @php
      $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
      if (!$image) {
        $image = '/wp-content/uploads/2023/11/thank-you-featured.png';
      }
    @endphp

    @if ($image)
      <img class="max-w-lg mx-auto mb-6" src="{{ $image }}" alt="" />
    @endif
  <p class="text-center text-2xl text-action">Thank you!</p>
  @if (!$acf['title'] == 'demo')
      <h1 class="text-center text-3xl lg:text-5xl my-6">{!! $acf['title'] !!}</h1>
@endif
  <p class="text-center text-lg">Someone from our team will get back to you within one day.</p>
    @endif
  </div>
</section>
@if (isset($fields['gated_page']) OR $download)
@includeIf('dividers.waves-bottom', [$background['color'] => 'bg-dark-blue'])
@endif
