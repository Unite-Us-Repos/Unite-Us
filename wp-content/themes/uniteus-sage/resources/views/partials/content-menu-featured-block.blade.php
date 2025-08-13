@php
  // Only for the "Resources" menu item
  $is_resources_menu = isset($menu['classes']) && in_array('resources', $menu['classes'], true);

  $featured_image_url = '';
  $featured_pill = '';
  $featured_pill_subtext = '';
  $permalink = '';
  $button_text = '';

  if ($is_resources_menu) {
    $q = new \WP_Query([
      'post_type'      => 'any',
      'posts_per_page' => 1,
      'post_status'    => 'publish',
      'orderby'        => 'date',
      'order'          => 'DESC',
      'meta_query'     => [[
        'key'     => 'resources_featured_post', 
        'value'   => ['1', 1, true, 'true'],        // handle different stored forms
        'compare' => 'IN',
      ]],
    ]);

    if ($q->have_posts()) {
      $pid = $q->posts[0]->ID;

      $featured_pill         = get_field('resources_featured_pill', $pid) ?: '';
      $featured_pill_subtext = get_field('resources_featured_pill_subtext', $pid) ?: '';

      $img = get_field('resources_featured_image', $pid);
      if (is_array($img)) {
        $featured_image_url = $img['url'] ?? ($img['sizes']['large'] ?? $img['sizes']['medium'] ?? '');
      } elseif (is_numeric($img)) {
        $featured_image_url = wp_get_attachment_url($img) ?: '';
      } elseif (is_string($img)) {
        $featured_image_url = $img;
      }

      $permalink   = get_permalink($pid);
      $button_text = trim((string) get_field('resources_featured_button', $pid));
      if ($button_text === '') {
        $button_text = $featured_pill ? ('View ' . $featured_pill) : 'Read More';
      }
    }
    wp_reset_postdata();
  }
@endphp

@if ($is_resources_menu && $featured_image_url && $permalink)
  <div class="featured-block relative bg-cover bg-center p-4 px-8" style="background-image: url('{{ esc_url($featured_image_url) }}');">
    <div class="wrapper relative z-10 flex flex-col items-start">
      @if ($featured_pill)
        <div class="pill p-1 rounded-full flex items-center gap-2">
          <span class="tracking-2px bg-dark text-white px-2 py-1 rounded-full uppercase font-semibold">{{ $featured_pill }}</span>
          @if ($featured_pill_subtext)
            <span class="text-white flex items-center pr-4 gap-2">{{ $featured_pill_subtext }}
              <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.8331 1.04004L13.6695 5.87642M13.6695 5.87642L8.8331 10.7128M13.6695 5.87642L0.772461 5.87642" stroke="white" stroke-width="0.905178" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          @endif
        </div>
      @endif

      <a href="{{ esc_url($permalink) }}" class="menu-arrow btn bg-white text-dark font-semibold rounded-md">
        {{ $button_text }}
        <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7.43219 0.887695L11.0747 4.53021M11.0747 4.53021L7.43219 8.17273M11.0747 4.53021L1.36133 4.53021" stroke="#2C405A" stroke-opacity="0.5" stroke-width="1.25793" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>
  </div>
@endif
