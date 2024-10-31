@php
global $wpdb;

// Direct SQL query to get only the latest post
$latest_post = $wpdb->get_row("
    SELECT * 
    FROM $wpdb->posts 
    WHERE post_type = 'post' 
      AND post_status = 'publish' 
    ORDER BY post_date DESC 
    LIMIT 1
");
@endphp

@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

@if ($latest_post)
<section class="max-w-7xl mx-auto {{ $section_classes }}">
  <header>
    <section class="component-section relative">
      <div class="component-inner-section">
        <div class="absolute inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden">
          @if (get_the_post_thumbnail_url($latest_post->ID))
            <img class="w-full h-full object-cover" src="{{ get_the_post_thumbnail_url($latest_post->ID) }}" alt="{{ get_post_meta(get_post_thumbnail_id($latest_post->ID), '_wp_attachment_image_alt', true) }}">
          @endif
        </div>
        <div class="absolute inset-0 sm:left-8 sm:right-8 sm:rounded-lg overflow-hidden bg-brand opacity-75"></div>
        <div class="relative mx-auto">
          <div class="px-0 sm:px-10 leading-loose relative z-10 lg:w-9/12">
            <div class="flex mb-6">
              <a href="{{ get_permalink($latest_post->ID) }}">
                <span class="text-sm font-medium text-white mr-6">
                  <span class="inline-block bg-action font-medium rounded-full px-4 py-1">
                    {{ get_post_type_object($latest_post->post_type)->labels->singular_name }}
                  </span>
                </span>
              </a>
            </div>
            <h1 class="entry-title leading-none mb-5 sm:mb-6 text-white text-4xl lg:text-5xl">
              <a class="text-white no-underline hover:text-white" href="{{ get_permalink($latest_post->ID) }}">{!! $latest_post->post_title !!}</a>
            </h1>

            <div class="flex text-center text-xl">
              <time class="text-white" datetime="{{ get_post_time('c', true, $latest_post) }}">
                {{ get_the_date('', $latest_post->ID) }}
              </time>
            </div>
            <div class="mt-6">
              <a href="{{ get_permalink($latest_post->ID) }}" class="button button-solid load-more-button loadmore-posts">
                Read More
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </header>
</section>
@endif
