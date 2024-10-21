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
@php
    // ALL REPORTS FIELDS
    $selected_author = get_field('select_author'); // Fetch the author post object from ACF

    if ($selected_author) {
        $author_name = get_the_title($selected_author); // Get the post title, which could be the author's name
    $author_image_url = get_the_post_thumbnail_url($selected_author, 'small'); // Get the featured image URL (small size)
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


@if (has_category('report'))
<article class="report bg-light-gradient-short">
  <div class="flex flex-col lg:flex-row">
      @if (get_field('display_menu'))


      <section class="report-menu-wrapper-outer w-full lg:w-1/4 lg:mt-4 lg:relative lg:ml-6 z-50 lg:z-10">
        <section class="report-menu-wrapper">
          <!-- Mobile menu wrapper - visible on mobile only -->
          <div class="report-mobile-menu-wrap flex w-full justify-between items-center lg:hidden p-4 px-8 fixed lg:relative top-[80px] left-0 right-0 z-40 bg-white shadow-md" id="reportMobileMenuToggle">
            <span class="text-white">Jump To</span>
            <span>
              <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4 0C4.26522 5.96046e-08 4.51957 0.105357 4.70711 0.292893L7.70711 3.29289C8.09763 3.68342 8.09763 4.31658 7.70711 4.70711C7.31658 5.09763 6.68342 5.09763 6.29289 4.70711L4 2.41421L1.70711 4.70711C1.31658 5.09763 0.683417 5.09763 0.292893 4.70711C-0.0976311 4.31658 -0.097631 3.68342 0.292893 3.29289L3.29289 0.292893C3.48043 0.105357 3.73478 0 4 0ZM0.292893 9.29289C0.683417 8.90237 1.31658 8.90237 1.70711 9.29289L4 11.5858L6.29289 9.29289C6.68342 8.90237 7.31658 8.90237 7.70711 9.29289C8.09763 9.68342 8.09763 10.3166 7.70711 10.7071L4.70711 13.7071C4.31658 14.0976 3.68342 14.0976 3.29289 13.7071L0.292893 10.7071C-0.0976311 10.3166 -0.0976311 9.68342 0.292893 9.29289Z" fill="white"/>
              </svg>
            </span>
          </div>

          <!-- Mobile menu with close (X) button -->
          <div id="reportMobileMenu" class="report-menu bg-white fixed top-[130px] rounded-2xl left-0 lg:static lg:block lg:w-auto lg:rounded-lg lg:shadow-lg z-50 lg:z-10 shadow-md hidden overflow-scroll">
            
            <!-- Close button (X) -->
            <div class="flex justify-end mb-4 lg:hidden">
              <button id="reportMenuCloseBtn" class="pt-4 pr-4 text-gray-500 hover:text-action">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <div class="mb-4 px-8 pt-6">
              <a href="/knowledge-hub/" class="text-action text-sm uppercase font-bold no-underline flex items-center">
                <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M4.17871 0.821289L1 4M1 4L4.17871 7.17871M1 4L9.47656 4" stroke="#2F71F4" stroke-width="1.54119" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>&nbsp;Knowledge Hub
              </a>
            </div>

            <div class="pt-4 px-8">
              <h2 class="text-md font-semibold leading-tight">
                {!! get_the_title() !!} {{-- Post title --}}
              </h2>
            </div>

            <div class="border-t border-gray-300 pt-4"></div>

            <div class="pt-4">
              <nav>
                <ul id="reportDynamicMenu" class="space-y-2 list-none">
                  <!-- Menu items will be inserted here -->
                </ul>
              </nav>
            </div>
          </div>
        </section>
      </section>

          
      @endif
    <section class="content w-full {{ get_field('display_menu') ? 'lg:w-3/4' : 'lg:w-full' }}">
      <header>
          <section class="relative component-section !pt-0 !pb-0">
              <div class="component-inner-section relative">
                  @if ($desktop_featured_image || $mobile_featured_image)
                      {{-- Desktop and tablet image (visible on screen sizes above 640px) --}}
                      @if ($desktop_featured_image)
                          <img fetchpriority="high" class="w-full h-full object-cover hidden sm:block mt-5"
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

                  @if ($author_name)
                      <div
                          class="author absolute text-left p-2 bg-white flex flex-row align-items-center justify-center b-4">
                          @if ($author_image_url)
                              <img class="mx-auto rounded-full" src="{{ $author_image_url }}"
                                  alt="{{ $author_name }}">
                          @endif
                          <span class="d-block text-lg px-4"><span
                                  class="font-bold">{{ $author_name }}</span><br /><span
                                  class="text-medium-gray">{{ the_date() }} &bull; 10 min read</span></span>

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
                  <div class="categories flex flex-wrap px-6 max-w-5xl pt-6 px-4 mt-4 mx-auto">
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

                        {{-- Check for the "blockquote" layout --}}
                        @if (get_row_layout() == 'blockquote')
                            <blockquote class="blockquote text-center text-blue-600 bg-light p-8 rounded-lg relative">
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
                            <div class="icon-and-highlight bg-action text-white p-8 mt-8 mb-8 rounded-lg flex">
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
                        @elseif (get_row_layout() == 'key_takeaways')
                            <div class="key-takeaways relative p-5 mt-8 mb-5 rounded-lg overflow-hidden">
                              <div class="absolute inset-0 bg-brand opacity-75 bg-purple-overlay"></div>
                                  <div class="z-10 relative p-5">
                                    <div class="header">{!! get_sub_field('header') !!}</div>
                                    <div class="takeaways flex flex-wrap mb-4">
                                        @if (have_rows('takeaways'))
                                            @while (have_rows('takeaways')) @php the_row(); @endphp
                                                @php
                                                  $icon = get_sub_field('icon');
                                                @endphp
                                                <div class="takeaway flex mb-8">
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
                          <div class="spotlight-container py-8 rounded overflow-hidden">
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
                            <div class="flex flex-col my-4">
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
                            <div class="wysiwyg-content">
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
           
      {{-- ABOUT UU --}}
      <div class="{{ get_field('display_menu') ? 'max-w-4xl' : 'max-w-5xl' }}  mb-10 mx-auto">
          @isset($aboutUniteUs)
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

    </section>
    
  </div>
</article>

@else

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

@endif 

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


@if (has_category('report'))
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
@endif


{{-- Output the user-provided schema markup if it exists --}}
@if ($schema_markup)
  <script type="application/ld+json">
    {!! $schema_markup !!}
  </script>
@endif
