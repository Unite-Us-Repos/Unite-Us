@php
    $recommended_press = App\View\Composers\Post::getPosts(4, '', '', [$post->ID]);
    if (!isset($layout)) {
        $layout = '';
    }

    $author_name = get_field('author_name', $post->ID); // Fetch the author name from ACF

@endphp
@php
    // Get the manual_or_select_author field to determine which method to use
    $author_selection_method = get_field('manual_or_select_author', $post->ID);
    $author_selection_method = get_field('manual_or_select_author', $post->ID);

    // Initialize variables for author name and image
    $selected_author_name = null;
    $author_image_url = null;

    if ($author_selection_method == 'manual') {
        // If 'Manual Entry' is selected
        $author_name = get_field('author_name', $post->ID); // Fetch the manually entered author name
    } elseif ($author_selection_method == 'select') {
        // If 'Select Author from List' is selected
        $selected_author = get_field('select_author'); // Fetch the author post object from ACF


        if ($selected_author) {
            $selected_author_name = get_the_title($selected_author); // Get the author name from the selected post
            $author_image_url = get_the_post_thumbnail_url($selected_author, 'small'); // Get the author's image (small size)
        }
    }
@endphp
@php
    $mobile_featured_image = get_field('mobile_featured_image'); // Fetch the ACF image array for mobile image
    $desktop_featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium'); // Regular featured image for tablet/desktop
@endphp
@php
    // Fetch terms for 'industry' and 'topic' taxonomies that are assigned to this post
    $industries = get_the_terms(get_the_ID(), 'industry');
    $topics = get_the_terms(get_the_ID(), 'topic');
@endphp

@php
$components = isset($acf['reports_component']['components']) ? $acf['reports_component']['components'] : null;
$show_jump_menu = false;

// Loop through the ACF flexible layouts and gather content
if ($components) {
  foreach ($components as $component) {
    $component_layout = $component['acf_fc_layout'];
    if ($component_layout == 'key_takeaways') {
      $show_jump_menu = true;
    }
  }
}
@endphp

<article class="report bg-light-gradient-short">
  <div class="flex flex-col lg:flex-row content-width">
      @if (get_field('display_menu'))


      <section class="report-menu-wrapper-outer w-full lg:w-1/4 lg:mt-4 lg:relative lg:ml-6 z-50 lg:z-10">
        <div class="report-menu-wrapper">
          <!-- Mobile menu wrapper - visible on mobile only -->
           @if ($show_jump_menu)
            <div class="report-mobile-menu-wrap flex w-full justify-between items-center lg:hidden p-4 px-8 fixed lg:relative top-[80px] left-0 right-0 z-40 bg-white shadow-md" id="reportMobileMenuToggle">
              <span class="text-white">Jump To</span>
              <span>
                <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M4 0C4.26522 5.96046e-08 4.51957 0.105357 4.70711 0.292893L7.70711 3.29289C8.09763 3.68342 8.09763 4.31658 7.70711 4.70711C7.31658 5.09763 6.68342 5.09763 6.29289 4.70711L4 2.41421L1.70711 4.70711C1.31658 5.09763 0.683417 5.09763 0.292893 4.70711C-0.0976311 4.31658 -0.097631 3.68342 0.292893 3.29289L3.29289 0.292893C3.48043 0.105357 3.73478 0 4 0ZM0.292893 9.29289C0.683417 8.90237 1.31658 8.90237 1.70711 9.29289L4 11.5858L6.29289 9.29289C6.68342 8.90237 7.31658 8.90237 7.70711 9.29289C8.09763 9.68342 8.09763 10.3166 7.70711 10.7071L4.70711 13.7071C4.31658 14.0976 3.68342 14.0976 3.29289 13.7071L0.292893 10.7071C-0.0976311 10.3166 -0.0976311 9.68342 0.292893 9.29289Z" fill="white"/>
                </svg>
              </span>
            </div>
            @endif

          <!-- Mobile menu with close (X) button -->
          <div id="reportMobileMenu" class="report-menu bg-white fixed top-[130px] rounded-2xl left-0 lg:static lg:block lg:w-auto lg:rounded-lg lg:shadow-lg z-50 lg:z-10 shadow-md hidden overflow-scroll">


            <!-- Close button (X) -->
            <div class="flex justify-end mb-4 absolute right-0 lg:hidden">
              <button id="reportMenuCloseBtn" class="pt-4 pr-4 text-gray-500 hover:text-action">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <div class="mb-4 px-8 pt-6 hidden lg:block">
              <a href="/knowledge-hub/" class="text-action text-sm uppercase font-bold no-underline flex items-center">
                <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.17871 0.821289L1 4M1 4L4.17871 7.17871M1 4L9.47656 4" stroke="#2F71F4" stroke-width="1.54119" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>&nbsp;Knowledge Hub
              </a>
            </div>

            <div class="pt-4 px-8 hidden lg:block">
              <h2 class="text-md font-semibold leading-tight">
                {!! get_the_title() !!} {{-- Post title --}}
              </h2>
            </div>

            @if ($show_jump_menu)
              <div class=" hidden lg:block border-t border-gray-300 pt-4"></div>

              <div class="pt-4">
                <nav>
                  <ul id="reportDynamicMenu" class="space-y-2 list-none">
                    <!-- Menu items will be inserted here -->
                  </ul>
                </nav>
              </div>
            @endif
          </div>
        </div>
      </section>



      @endif
    <section class="content w-full {{ get_field('display_menu') ? 'lg:w-3/4' : 'lg:w-full' }}">
      <header>
          <section class="relative component-section !pt-0 !pb-0">
              <div class="component-inner-section relative">
                  @if ($desktop_featured_image || $mobile_featured_image)
                      {{-- Desktop and tablet image (visible on screen sizes above 640px) --}}
                      @if ($desktop_featured_image)
                          <img fetchpriority="high" class="feature-img w-full h-full object-cover hidden sm:block mt-5"
                              src="{{ $desktop_featured_image }}"
                              srcset="{{ $desktop_featured_image }} 300w, {{ get_the_post_thumbnail_url(get_the_ID(), '2048x2048') }} 1024w"
                              sizes="(max-width: 1024px) 1024px, 2048px" alt="Featured Image">
                      @endif
                      <div class="mobile-image h-96 sm:hidden">
                          <div class="absolute inset-0">
                              {{-- Mobile image (visible on screen sizes below 640px) --}}
                              @if ($mobile_featured_image && !empty($mobile_featured_image['url']))
                                  <img fetchpriority="high" class="w-full h-full object-cover block sm:hidden"
                                      src="{{ $mobile_featured_image['url'] }}" alt="Mobile Featured Image">
                              @endif
                          </div>
                      </div>
                  @endif

                  @php
                  // Initialize an empty variable to store all content
                  $content = '';


                  // Add the content of the main editor
                  $content .= strip_tags(get_the_content());

                  // Get the ACF flexible content field
                  $components = isset($acf['reports_component']['components']) ? $acf['reports_component']['components'] : null;

                  // Loop through the ACF flexible layouts and gather content
                  if ($components) {

                    foreach ($components as $component) {

                        $component_layout = $component['acf_fc_layout'];

                        if ($component_layout == 'wysiwyg') {
                            // Get the content from the wysiwyg field
                            $content .= $component['wysiwyg'] ?? '';
                        }
                        // Check if the layout is one of the specified types
                        if (in_array($component_layout, ['blockquote', 'icon_and_highlight', 'spotlight'])) {
                            // Get the content from the specific layout
                            $content .= $component['text'] ?? '';
                        }
                        // Check if the layout is 'key_takeaways' and gather text from its subfields
                        if ($component_layout == 'key_takeaways') {
                            if (isset($component['takeaways'])) {
                                foreach ($component['takeaways'] as $takeaway) {
                                    $content .= $takeaway['text'] ?? '';
                                }
                            }
                        }
                        // Check if the layout is 'table' and gather text from its subfields
                        if ($component_layout == 'table') {
                            if (isset($component['table_display']['body'])) {
                                foreach ($component['table_display']['body'] as $row) {
                                    foreach ($row as $cell) {
                                        $content .= $cell['c'] ?? '';
                                    }
                                }
                            }
                        }
                    }
                  }

                  // Remove any HTML tags from the content
                  $content = strip_tags($content);

                  // Calculate the number of words
                  $word_count = str_word_count($content);


                  // Define the reading speed (words per minute)
                  $reading_speed = 200; // Average reading speed


                  // Calculate the reading time in minutes
                  $reading_time = ceil($word_count / $reading_speed);
              @endphp


              @if ($selected_author_name)
                  <div class="author absolute text-left p-2 bg-white flex flex-row align-items-center justify-center b-4">
                      @if ($author_image_url)
                          <img class="mx-auto rounded-full" src="{{ $author_image_url }}" alt="{{ $selected_author_name }}">
                      @endif
                      <span class="d-block text-sm px-4">
                          <span class="font-bold">{{ $selected_author_name }}</span><br />
                          <span class="text-medium-gray">{{ the_date() }} &bull; {{ $reading_time }} min read</span>
                      </span>
                  </div>
              @elseif ($author_name)
                  <div class="author absolute text-left p-2 bg-white flex flex-row align-items-center justify-center b-4">
                      <span class="d-block text-sm px-4">
                          <span class="font-bold">{{ $author_name }}</span><br />
                          <span class="text-medium-gray">{{ the_date() }} &bull; {{ $reading_time }} min read</span>
                      </span>
                  </div>
              @endif



              </div>

              <div class="component-inner-section relative z-10">
                  <div class="max-w-5xl pt-6 px-6 mt-4 mx-auto">
                      <h1 class="entry-title mb-8 sm:mb-10 text-4xl">
                          {!! $title !!}
                      </h1>
                  </div>
              </div>
              <div class="component-inner-section relative z-10">
                  <div class="categories flex flex-wrap max-w-5xl px-4 mx-auto">
                      @if ($industries && !is_wp_error($industries))
                          @foreach ($industries as $industry)
                              <div
                                  class="inline-block bg-light font-medium text-action rounded-full px-[15px] py-1 mr-4 mb-4 pill-span">
                                  {{ $industry->name }}</div>
                          @endforeach
                      @endif
                      @if ($topics && !is_wp_error($topics))
                          @foreach ($topics as $topic)
                              <div
                                  class="inline-block bg-light font-medium text-action rounded-full px-[15px] py-1 mr-4 mb-4 pill-span">
                                  {{ $topic->name }}</div>
                          @endforeach
                      @endif
                  </div>
              </div>
          </section>
      </header>
      <div class="report-inner-content component-section !pt-1">
        <div class="component-inner-section relative z-10">
          <div class="max-w-5xl pt-6 px-6 mx-auto highlight-intro">


            @php the_content(); @endphp


            {{-- ACF Flexible Content Loop --}}
            @if (have_rows('reports_component'))
            @while (have_rows('reports_component')) @php the_row(); @endphp

                @if (have_rows('components'))
                    @while (have_rows('components')) @php the_row(); @endphp
                        {{-- Get the ID from the ACF field --}}
                        @php
                            $section_id = get_sub_field('id') ? 'id="' . get_sub_field('id') . '"' : '';
                        @endphp
                        {{-- Check for the "blockquote" layout --}}
                        @if (get_row_layout() == 'blockquote')
                            <blockquote {!! $section_id !!} class="blockquote text-center text-blue-600 bg-light p-8 rounded-lg relative">
                              <img class="quote-icon" src="/wp-content/themes/uniteus-sage/resources/images/blockquote-icon.svg" alt="quote icon" />
                                {!! get_sub_field('text') !!}
                            </blockquote>

                        {{-- Check for the "buttons" layout --}}
                        @elseif (get_row_layout() == 'buttons')


                          @php
                              $buttons = get_sub_field('action_buttons');
                          @endphp


                          @if ($buttons)
                            @php
                                $layout = 'flex';
                                $margin = 'ml-3';
                                $show_arrow = false;
                                $click_action = '';
                                $button_layout = '';

                                if (!isset($justify)) {
                                  $justify = 'justify-start';
                                }

                                if (!isset($style)) {
                                  $style = 'simple-justified';
                                }

                                if (isset($button_layout) && ('text' == $button_layout)) {
                                  $layout = 'grid grid-cols-2 gap-x-6';
                                  $margin = '';
                                  $show_arrow = true;
                                }

                                if (isset($isAlert) && $isAlert) {
                                  $click_action = ' @click="localStorage.setItem(\'hideUuGlobalAlert\', \'' . $unique_id . '\'); hideAlert = true" ';
                                }

                                if (!isset($mt)) {
                                $mt = false;
                                }

                            @endphp


                            <div class="flex flex-wrap flex-col w-full sm:flex-row gap-6 pb-4 @if ('text' == $button_layout) mt-5 @elseif ('simple-justified' == $style && !$mt) mt-9 sm:mt-10 @elseif ($mt) {{ $mt }} @else mt-9 sm:mt-10 @endif button-layout-{{ $button_layout }} {{ $layout }} md:{{ $justify }}">
                              @foreach ($buttons as $index => $button)
                                @php
                                  if ('internal' == $button['link_type']) {
                                    $link = $button['page_link'];
                                  } else {
                                    $link = $button['link'];
                                  }

                                  if (isset($button_layout) && ('text' == $button_layout)) {
                                    $button['style'] = 'button-text';
                                  }

                                  if (!isset($classes)) {
                                    $classes = '';
                                  }

                                  if (!isset($styles)) {
                                    $styles = '';
                                  }

                                  // Define styles for each button
                                  $button_styles = '';
                                  if (isset($button['background_color']['color'])) {
                                    $button_styles .= ' background-color: ' . $button['background_color']['color'] . '; ';

                                    if ('button-hollow' == $button['style']) {
                                      $button_styles .= ' border-color: ' . $button['text_color']['color'] . '; ';
                                    } else {
                                      $button_styles .= ' border-color: ' . $button['background_color']['color'] . '; ';
                                    }
                                  }

                                  if (isset($button['text_color']['color'])) {
                                    $button_styles .= ' color: ' . $button['text_color']['color'] . '!important; ';
                                  }

                                  // Define hover styles for each button
                                  $button_hover_styles = '';
                                  if (isset($button['background_color_hover']['color'])) {
                                    $button_hover_styles .= 'background-color: ' . $button['background_color_hover']['color'] . '; ';
                                    if ('button-hollow' == $button['style']) {
                                      $button_hover_styles .= 'border-color: ' . $button['background_color_hover']['color'] . '; color: white !important;';
                                    } else {
                                      $button_hover_styles .= 'border-color: ' . $button['background_color_hover']['color'] . ';';
                                    }
                                  }
                                  if (isset($button['text_color_hover']['color'])) {
                                    $button_hover_styles .= 'color: ' . $button['text_color_hover']['color'] . '!important; ';
                                  }

                                  // Generate unique class names
                                  $button_class = 'button-id-' . $index;
                                  $button_hover_class = 'button-hover-' . $index;
                                @endphp
                                  <div class="@if ('text' != $button_layout) inline-flex @endif">
                                    <a href="{{ $link }}" {!! $click_action !!} class="button action-button {{ $classes }} {{ $button_class }} @isset ($button['icon']) flex items-center gap-3 @endif {{ $button['style'] }}" style="text-decoration:none !important;@if ('text' == $button_layout) padding: 0.75rem 0; @endif" @if ($button['is_blank']) target="_blank" @endif>
                                      {{ $button["name"]}}
                                      @if ($show_arrow)
                                      <span aria-hidden="true"> &rarr;</span>
                                      @endif

                                      @isset ($button['icon'])
                                      @if ($button['icon'])
                                        <img style="width:20px !important;height:20px !important;" class="h-8 w-8 @if ('button-hollow' == $button['style']) acf-icon-action @endif" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $button['icon'] }}.svg" alt="" />
                                      @endif
                                      @endisset
                                    </a>
                                  </div>
                                  <style>
                                    .{{ $button_class }} {
                                      {!! $button_styles !!}
                                    }
                                    .{{ $button_class }}:hover {
                                      {!! $button_hover_styles !!}
                                    }
                                  </style>

                              @endforeach
                            </div>
                          @endif


                        {{-- Check for the "icon_and_highlight" layout --}}
                        @elseif (get_row_layout() == 'icon_and_highlight')
                            <div {!! $section_id !!} class="icon-and-highlight bg-action text-white p-8 mt-8 mb-8 rounded-lg flex">
                              <div class="icon pr-4">
                                @php
                                    $icon = get_sub_field('icon'); // Fetch the icon name from the SVG picker
                                @endphp


                                @if ($icon)
                                  <span class="mb-5 bg-white w-10 h-10 p-2 flex justify-center items-center rounded-full">
                                    <img src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $icon }}.svg" alt="Icon" class="icon-image acf-icon-action lazy h-full w-full " />
                                  </span>
                                @endif
                            </div>


                                <div class="highlight-text text-lg">
                                    {!! get_sub_field('text') !!}
                                </div>
                            </div>

                        {{-- Check for the "key_takeaways" layout --}}
                        @elseif (get_row_layout() == 'key_takeaways' && get_sub_field('style') == 'plain')
                          <?php
                          $menu_label = get_sub_field('menu_label') ?: 'Key Takeaways'; // Get the 'menu_label' field or default to 'Key Takeaways'
                          ?>

                            <div {!! $section_id !!} class="wysiwyg-content-kt key-takeaways-menu" data-menu-label="<?php echo esc_attr($menu_label); ?>">
                              {!! get_sub_field('header') !!}
                            </div>
                        {{-- Check for the "key_takeaways" layout --}}
                        @elseif (get_row_layout() == 'key_takeaways' && get_sub_field('style') != 'plain')
                          <?php
                          $menu_label = get_sub_field('menu_label') ?: 'Key Takeaways'; // Get the 'menu_label' field or default to 'Key Takeaways'
                          ?>

                            <div {!! $section_id !!} class="key-takeaways key-takeaways-menu relative p-5 mt-8 mb-5 rounded-lg overflow-hidden" data-menu-label="<?php echo esc_attr($menu_label); ?>">
                              <div class="absolute inset-0 bg-brand opacity-75 bg-purple-overlay"></div>
                                  <div class="z-10 relative p-5">
                                    <div class="header">{!! get_sub_field('header') !!}</div>
                                    <div class="takeaways flex flex-col gap-2 md:grid grid-cols-2 mb-4">
                                        @if (have_rows('takeaways'))
                                            @while (have_rows('takeaways')) @php the_row(); @endphp
                                                @php
                                                  $icon = get_sub_field('icon');
                                                @endphp
                                                <div class="takeaway flex">
                                                  @if ($icon)
                                                      <span class="icon mb-5 mt-2 bg-light w-10 h-10 p-2 flex justify-center items-center rounded-full">
                                                        <img class="lazy h-full w-full acf-icon-action" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $icon }}.svg" alt="Icon" />
                                                      </span>
                                                  @endif
                                                  <div class="text-lg">{{ get_sub_field('text') }}</div>
                                                </div>
                                            @endwhile
                                        @endif
                                    </div>
                                    <div class="tiles-header">
                                        {!! get_sub_field('text') !!}
                                    </div>
                                    <div class="tiles flex flex-wrap mt-5">
                                      @if (have_rows('tiles'))
                                        @while (have_rows('tiles')) @php the_row(); @endphp
                                            <div class="tile p-5 mt-4 mb-4">
                                                <div class="text-3xl font-bold">{{ get_sub_field('header') }}</div>
                                                <p class="text-sm">{{ get_sub_field('text') }}</p>
                                            </div>
                                        @endwhile
                                      @endif
                                    </div>
                                </div>
                              </div>

                        {{-- Check for the "spotlight" layout --}}
                        @elseif (get_row_layout() == 'spotlight')
                          @php
                              $background_image = get_sub_field('background_image'); // Image array field
                              $pill_text = get_sub_field('pill_text'); // Pill text field
                              $button = get_sub_field('button'); // Button array field
                          @endphp
                          <div {!! $section_id !!} class="spotlight-container py-8 rounded overflow-hidden">
                            <div class="spotlight p-8 lg:p-16 relative border-electric-purple border rounded-lg"
                            <div class="spotlight p-8 lg:p-16 relative border-electric-purple border rounded-lg"
                                @if ($background_image && isset($background_image['url']))
                                    style="background-image: url('{{ $background_image['url'] }}'); background-size: cover;"
                                @endif>
                            <div class="card-overlay absolute inset-0 bg-white opacity-90 z-1 border border-transparent rounded-lg"></div>
                            <div class="z-10 relative">
                                @if ($pill_text)
                                    <div class="text-electric-purple border border-electric-purple  bg-transparent mix-blend-multiply   text-sm py-1 px-4 inline-block mb-6 rounded-full">
                                        {!! $pill_text !!}
                                    </div>
                                @endif


                                {!! get_sub_field('text') !!}


                                @if ($button && isset($button['url']))
                                    <a href="{{ $button['url'] }}" class="button action-button  button-id-0  flex items-center gap-3  button-solid-purple">
                                        {{ $button['title'] ?? 'Learn More' }}
                                    </a>
                                @endif
                              </div>
                            </div>
                          </div>


                        {{-- Check for the "table" layout --}}
                        @elseif (get_row_layout() == 'table')



                          @php
                              $table = get_sub_field('table_display'); // Fetch the table array from ACF
                          @endphp

                          @if ($table)
                            <div {!! $section_id !!} class="flex flex-col my-4">
                              <div class="overflow-x-auto">
                                <div class="block rounded-lg">
                                  <table class="acf-data-table w-full table-auto border-collapse border-2 border-action">


                                  {{-- Check if a caption exists and display it --}}
                                  @if (isset($table['caption']))
                                    <caption class="mb-4 ml-0.5 text-left">{!! $table['caption'] !!}</caption>
                                  @endif

                                  {{-- Display the table header if it exists --}}
                                  @if (isset($table['header']))
                                    <thead class="bg-action">
                                      <tr>
                                        @foreach ($table['header'] as $th)
                                          <th scope="col" class="px-6 py-4 text-left text-xs uppercase text-white">
                                            <span class="tracking-widest">{{ $th['c'] }}</span>
                                          </th>
                                        @endforeach
                                      </tr>
                                    </thead>
                                  @endif

                                  {{-- Display the table body if it exists --}}
                                  @if (isset($table['body']))
                                    <tbody class="bg-white">
                                      @foreach ($table['body'] as $index => $tr)
                                        <tr class="@if ($index % 2 == 0) bg-white @else bg-light @endif">
                                          @foreach ($tr as $i => $td)
                                            <td data-label="{{ $table['header'][$i]['c'] }}" class="align-top px-6 py-4 text-sm border border-light @if (!$loop->last) border-r border-light @endif">
                                              <div class="cell-wrap">
                                                {{-- Simply output the cell content --}}
                                                {!! $td['c'] !!}
                                              </div>
                                            </td>
                                          @endforeach
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  @endif
                                  </table>
                                </div>
                              </div>
                            </div>
                          @endif



                        {{-- Check for the "wysiwyg" layout --}}
                        @elseif (get_row_layout() == 'wysiwyg')
                            <div {!! $section_id !!} class="wysiwyg-content">
                                {!! get_sub_field('wysiwyg') !!}
                            </div>

                        @endif

                    @endwhile
                @endif

            @endwhile
            @endif


          </div>
        </div>
      </div>
      <div id="reportlightbox" class="lightbox">
          <span class="close">&times;</span>
          <div class="lightbox-content-scroller">
            <img class="lightbox-content" id="reportlightbox-image">
            <div id="reportcaption"></div>
          </div>
      </div>


      {{-- ABOUT UU --}}
      <div class="{{ get_field('display_menu') ? 'max-w-4xl' : 'max-w-5xl' }}  mb-10 mx-auto report-news-about">
          @isset($aboutUniteUs)
              <div id="newsAbout" class="bg-light sm:rounded-xl sm:mx-8 p-10 leading-loose">
                  {!! $aboutUniteUs !!}
                  <div class="my-6 border border-blue-300" style="width: 100px"></div>
                  @if ($postTopics)
                      <div class="flex flex-wrap items-center mb-3">
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

    </section>


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


<section class="component-section relative bg-white report demo">
    <div class="absolute bottom-0 border border-blue-900 -ml-4 w-full h-3/6 -mb-[1px] bg-blue-900"></div>

    <div class="component-inner-section relative">
        <div
            class="bg-light w-full rounded-2xl flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 lg:gap-20">

            <div class=" order-2  p-9 md:p-20 flex flex-col  justify-center  text-lg  md:order-1  lg:mb-0">
                <div class="subtitle n-case mb-3 text-2xl">
                    Ready to get started?
                </div>
                <h2 class="mb-0 text-4xl">Start building healthier communities today.</h2>

                <div
                    class="flex flex-wrap justify-center flex-col sm:flex-row gap-6  mt-6 sm:mt-10  button-layout-buttons flex md:justify-start">
                    <div class=" inline-flex ">
                        <a href="" class="button  flex items-center gap-3  button-solid"
                            style="text-decoration:none !important;">
                            Request Demo
                        </a>
                    </div>
                </div>
            </div>

            <div class="relative p-9 md:p-9  pb-0 md:p-0   flex flex-col  justify-center   md:order-2 ">
                <img class="lazy rounded-lg w-full max-w-sm mx-auto lg:max-w-md"
                    data-src="/wp-content/uploads/2022/09/building-communities.png" alt="building communities">
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>


document.addEventListener('DOMContentLoaded', function () {
  const desktopMenuWrapperOuter = document.querySelector('.report-menu-wrapper-outer');
  const desktopMenu = document.querySelector('.report-menu-wrapper');
  const innerContent = document.querySelector('.report-news-about'); // The content that wraps the WYSIWYG components
  const navHeight = 80; // The fixed height of the main nav at the top

  if (desktopMenuWrapperOuter) {
    let menuWrapperInitialTop = desktopMenuWrapperOuter.offsetTop; // Initial position of the menu wrapper

    // Handle sticky menu behavior
    const handleScroll = () => {
        const scrollPosition = window.scrollY;
        const innerContentBottom = innerContent.offsetTop + innerContent.offsetHeight; // Bottom of inner-content

        // Set width dynamically to match the outer wrapper width
        desktopMenu.style.width = `${desktopMenuWrapperOuter.offsetWidth}px`;

        // Check if the user has scrolled past the initial menu position
        if (scrollPosition + navHeight > menuWrapperInitialTop) {
            // Stick the menu as long as it hasn't reached the bottom of inner-content
            if (scrollPosition + navHeight + desktopMenu.offsetHeight < innerContentBottom) {
                desktopMenu.style.position = 'fixed';
                desktopMenu.style.top = `${navHeight}px`;
            } else {
                // When at the bottom of inner-content, switch to absolute positioning
                desktopMenu.style.position = 'absolute';
                // Calculate the top position based on the inner-content's bottom and menu height
                desktopMenu.style.top = `${innerContentBottom - desktopMenuWrapperOuter.offsetTop - desktopMenu.offsetHeight}px`;
            }
        } else {
            // If user is above the menu's initial position, reset to normal
            desktopMenu.style.position = 'relative';
            desktopMenu.style.top = 'unset';
        }
    };

    // Attach scroll event listener
    window.addEventListener('scroll', handleScroll);

    // On window resize, recalculate the width of the menu to match its container
    window.addEventListener('resize', function () {
        desktopMenu.style.width = `${desktopMenuWrapperOuter.offsetWidth}px`;
    });
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const mobileMenu = document.getElementById('reportMobileMenu');
  const menuToggle = document.getElementById('reportMobileMenuToggle');
  const menuCloseBtn = document.getElementById('reportMenuCloseBtn');
  const keyTakeawaysSection = document.querySelector('.key-takeaways-menu');
  const menu = document.getElementById('reportDynamicMenu');
  const sections = []; // Store sections and their corresponding menu links
  const offset = 80; // Main nav (80px)

  if (mobileMenu) {
    const scrollToSectionWithOffset = (element, offset) => {
        const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
        // Detect if it's desktop or mobile and apply the correct offset
        const isDesktop = window.innerWidth >= 1024; // 1024px breakpoint for desktop
        const offsetPosition = isDesktop
            ? elementPosition - offset - 10  // Offset for desktop (Main nav - 10px)
            : elementPosition - offset - 56; // Offset for mobile (Main nav + Mobile menu - 56px)

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth',
        });
    };

    // Toggle menu visibility on clicking the toggle button
    menuToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });

    // Close the menu when clicking the close button (X)
    menuCloseBtn.addEventListener('click', function () {
        mobileMenu.classList.add('hidden');
    });

    // Set menu height to viewport height minus 80px for nav and 56px for mobile nav
    const setMenuHeight = () => {
        const menuHeight = window.innerHeight - offset;
        mobileMenu.style.height = `${menuHeight}px`;
    };

    // Retrieve the user-defined menu label from the data attribute, defaulting to "Key Takeaways" if not set
  const menuLabel = keyTakeawaysSection.getAttribute('data-menu-label') || 'Key Takeaways';

  // Add Key Takeaways link to the menu if section exists
  if (keyTakeawaysSection && menu) {
      const listItem = document.createElement('li');
      const link = document.createElement('a');

      // Use menuLabel for the text in the menu
      link.href = '#key-takeaways';
      link.innerHTML = `<div class="text-gray-500 pr-4">A.</div> <div class="head text-blue-600">${menuLabel}</div>`;
      link.classList.add('px-8', 'pt-2', 'pb-2', 'text-sm', 'font-semibold', 'no-underline', 'flex');

      // Add click event to scroll smoothly to the key-takeaways section and close the menu
      link.addEventListener('click', function (e) {
          e.preventDefault();
          scrollToSectionWithOffset(keyTakeawaysSection, offset);
          mobileMenu.classList.add('hidden'); // Close the menu

          // Remove active class from all headings and subheadings
          document.querySelectorAll('li.heading, li.subheading, div.h3-wrapper').forEach((el) => {
              el.classList.remove('active');
          });

          // Add active class to Key Takeaways
          listItem.classList.add('active');
      });

      listItem.classList.add('heading'); // Add .heading class to the li
      listItem.appendChild(link);
      menu.appendChild(listItem);

      // Add the Key Takeaways section to the sections array for active detection
      sections.push({
          id: 'key-takeaways',
          element: keyTakeawaysSection
      });
    }
}


  // Scrape WYSIWYG components for h2 and h3 elements
  const wysiwygSections = document.querySelectorAll('.wysiwyg-content');
  let h2Counter = 1;
  let h3Counter = 0;
  let h3Wrapper = null; // Wrapper for H3 elements

  wysiwygSections.forEach(wysiwyg => {
      const headings = wysiwyg.querySelectorAll('h2, h3');
      const h3Elements = Array.from(headings).filter(heading => heading.tagName.toLowerCase() === 'h3');

      headings.forEach(heading => {
          const headingText = heading.textContent.trim(); // Get trimmed heading text
          const currentHeading = heading;

          // Only add to the menu if the heading has non-empty text
          if (headingText) {
              const listItem = document.createElement('li');
              const link = document.createElement('a');
              let counterText = '';

              // Set up the scroll behavior for H2 and H3
              link.addEventListener('click', function (e) {
                  e.preventDefault();
                  scrollToSectionWithOffset(heading, offset); // Scroll to the heading
                  mobileMenu.classList.add('hidden'); // Close the menu

                  // Add active class to clicked li.heading and remove from others only if it's a heading
                  if (listItem.classList.contains('heading')) {
                      document.querySelectorAll('li.heading, div.h3-wrapper').forEach((el) => {
                          el.classList.remove('active');
                      });

                      // Add active class to clicked heading
                      listItem.classList.add('active');

                      // If li.parent has a sibling h3-wrapper, also add active class to the h3-wrapper
                      const siblingH3Wrapper = listItem.nextElementSibling;
                      if (listItem.classList.contains('parent') && siblingH3Wrapper && siblingH3Wrapper.classList.contains('h3-wrapper')) {
                          siblingH3Wrapper.classList.add('active');
                      }
                  } else if (listItem.classList.contains('subheading')) {
                      // If a subheading is clicked, activate the closest heading and its h3-wrapper
                      scrollToSectionWithOffset(heading, offset);

                      const closestHeading = listItem.closest('.h3-wrapper').previousElementSibling;
                      const parentH3Wrapper = listItem.closest('.h3-wrapper');

                      // Ensure active class is only added to the correct li.parent and div.h3-wrapper
                      if (closestHeading && closestHeading.classList.contains('parent')) {
                          document.querySelectorAll('li.heading, div.h3-wrapper').forEach((el) => {
                              el.classList.remove('active');
                          });

                          // Add active class to closest li.parent
                          closestHeading.classList.add('active');
                          // Add active class to the parent div.h3-wrapper
                          parentH3Wrapper.classList.add('active');
                      }

                      mobileMenu.classList.add('hidden');
                  }
              });

              // Check if it's an H2 or H3 and adjust the numbering or styling
              if (heading.tagName.toLowerCase() === 'h2') {
                  // When encountering an H2, close any open H3 wrapper
                  if (h3Wrapper) {
                      menu.appendChild(h3Wrapper); // Append the H3 wrapper to the menu
                      h3Wrapper = null; // Reset the wrapper
                  }

                  counterText = `<div class="text-gray-500 pr-4">${h2Counter}.</div> `;
                  h2Counter++; // Increment H2 counter
                  h3Counter = 0; // Reset H3 counter after each H2
                  link.classList.add('px-8', 'pt-2', 'pb-2', 'text-sm', 'font-semibold', 'no-underline', 'flex', 'items-baseline'); // Regular styling for H2

                  // Append the link to the list item and directly to the menu for H2
                  link.href = `#${heading.id || 'h2-' + h2Counter}`;
                  // Add heading id attribute if it doesn't exist
                  // This ensures that the same heading doesn't get multiple ids
                  // and allows for smooth scrolling
                  // to the same heading

                  if (!heading.id) {
                     // add id attribute to currentHeading
                    currentHeading.id = heading.id || 'h2-' + h2Counter;
                  }

                  // Set the inner HTML for the link
                  link.innerHTML = `${counterText}<div class="head text-blue-600 no-underline pb-2 pt-2">${headingText}</div>`;
                  listItem.classList.add('heading'); // Add .heading class to li with H2
                  listItem.appendChild(link);
                  menu.appendChild(listItem);

                  // Add to sections array for scroll detection
                  sections.push({
                      id: heading.id || 'h2-' + h2Counter,
                      element: heading
                  });

              } else if (heading.tagName.toLowerCase() === 'h3') {
                  // Create a new wrapper if one doesn't exist
                  if (!h3Wrapper) {
                      h3Wrapper = document.createElement('div'); // Wrapper for all H3 elements under the current H2
                      h3Wrapper.classList.add('h3-wrapper', 'pt-2', 'pb-2'); // Add the vertical line style
                  }

                  h3Counter++;

                  // Create the H3 link without numbering (just the vertical bar and indentation)
                  link.classList.add('text-sm', 'font-medium', 'pl-6', 'pr-6', 'relative', 'flex', 'no-underline'); // Indent H3
                  link.href = `#${heading.id || 'h3-' + h3Counter}`;
                  link.innerHTML = `<div class="vertical-line"></div><div class="head text-blue-600 no-underline">${headingText}</div>`;
                  listItem.classList.add('subheading'); // Add .subheading class to li with H3

                  // Append padding only to middle elements
                  if (h3Elements.length > 1) {
                      if (h3Counter === 1) {
                          link.classList.add('pt-0'); // No padding-top for first element
                      } else if (h3Counter === h3Elements.length) {
                          link.classList.add('pb-0'); // No padding-bottom for last element
                      } else {
                          link.classList.add('pt-2', 'pb-2'); // Padding for middle elements
                      }
                  }

                  // Append the H3 link to the list item
                  listItem.appendChild(link);

                  // Append the list item to the H3 wrapper
                  h3Wrapper.appendChild(listItem);

                  // Add to sections array for scroll detection
                  sections.push({
                      id: heading.id || 'h3-' + h3Counter,
                      element: heading
                  });
              }
          }
      });

      // If there is an open H3 wrapper after processing all headings, append it to the menu
      if (h3Wrapper) {
          menu.appendChild(h3Wrapper);
      }

      // Check for H2 elements with an adjacent h3-wrapper and add the 'parent' class
      const listItems = menu.querySelectorAll('li.heading');
      listItems.forEach((li) => {
          const nextSibling = li.nextElementSibling;
          if (nextSibling && nextSibling.classList.contains('h3-wrapper')) {
              li.classList.add('parent'); // Add 'parent' class if h3-wrapper is next sibling
          }
      });
  });
});


document.addEventListener('DOMContentLoaded', function () {
  let offset = 100; // Offset for fixed navigation (80px)

  // Function to scroll smoothly to a section
  const smoothScrollToSection = (element) => {
      if (window.innerWidth <= 1024) {
          offset = 160; // Offset for desktop (80px + 100px for the menu)
      } else {
        offset = 100; // Offset for mobile (80px)
      }

      const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
      const offsetPosition = elementPosition - offset;

      window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth',
      });
  };

});

  // reports image lightbox
document.addEventListener('DOMContentLoaded', function () {
  const lightbox = document.getElementById('reportlightbox');
  const lightboxImage = document.getElementById('reportlightbox-image');
  const close = document.querySelector('.report .close');
  const wysiwygImages = document.querySelectorAll('.report .wysiwyg-content img');

  let isDragging = false;
  let startX, startY, scrollLeft, scrollTop;

  if (lightbox) {
    wysiwygImages.forEach(img => {
        img.addEventListener('click', function () {
            lightbox.style.display = 'block';
            lightboxImage.src = this.src;
        });
    });

    close.addEventListener('click', function () {
        lightbox.style.display = 'none';
    });

    // Zooming in/out by scrolling
    lightboxImage.addEventListener('wheel', function (e) {
        e.preventDefault();
        let scale = Number(this.getAttribute('data-scale')) || 1;
        scale += e.deltaY * -0.001;
        scale = Math.min(Math.max(1, scale), 4); // Limit scale between 1 and 4
        this.style.transform = `scale(${scale})`;
        this.setAttribute('data-scale', scale);
    });

    // Drag to pan
    lightboxImage.addEventListener('mousedown', function (e) {
        isDragging = true;
        lightboxImage.classList.add('grabbing');
        startX = e.pageX - lightboxImage.offsetLeft;
        startY = e.pageY - lightboxImage.offsetTop;
        scrollLeft = lightbox.scrollLeft;
        scrollTop = lightbox.scrollTop;
    });

    lightboxImage.addEventListener('mousemove', function (e) {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - startX;
        const y = e.pageY - startY;
        lightboxImage.style.transform = `translate(${x}px, ${y}px) scale(${lightboxImage.getAttribute('data-scale') || 1})`;
    });

    lightboxImage.addEventListener('mouseup', function () {
        isDragging = false;
        lightboxImage.classList.remove('grabbing');
    });

    lightboxImage.addEventListener('mouseleave', function () {
        isDragging = false;
        lightboxImage.classList.remove('grabbing');
    });
  }
});

document.addEventListener('DOMContentLoaded', function () {
    // Attach event listeners to all internal links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const targetId = this.getAttribute('href').substring(1); // Get the ID without the #
          const targetElement = document.getElementById(targetId);

          // Scroll to the section if the target exists
          if (targetElement) {
              smoothScrollToSection(targetElement);
              reportMenuCloseBtn.click(); // Close the mobile menu after scrolling
          }
      });
  });
});
</script>
@endpush