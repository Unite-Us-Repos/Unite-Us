@php
    $recommended_press = App\View\Composers\Post::getPosts(4, '', '', [$post->ID]);
    if (!isset($layout)) {
        $layout = '';
    }
@endphp
<article class="webinar">
      <header>
          <section class="pt-12 pb-8 px-4">
              <div class="component-inner-section">
                <div class="gradient-border w-fit !rounded-2xl mb-4">
                  <div class="subheading flex gap-1 items-center px-4 py-1">
                    <img src="@asset('images/play-icon.svg')" alt="play icon" /> Webinar
                  </div>
                </div>
                  <h1 class="entry-title mb-8 sm:mb-10 text-4xl mr-8 font-bold">
                    {!! $title !!}
                  </h1>
                </div>
          </section>
      </header>
      <div class="webinar-inner-content component-section">
        <div class="component-inner-section flex flex-col lg:flex-row">
          <div class="w-full lg:w-2/3 space-y-6 padding-right">

            @php the_content(); @endphp

            {{-- ACF Flexible Content Loop --}}
            @if (have_rows('webinar_components'))
            @while (have_rows('webinar_components')) @php the_row(); @endphp

                @if (have_rows('components'))
                    @while (have_rows('components')) @php the_row(); @endphp
          
                        {{-- Check for the "blockquote" layout --}}
                        @if (get_row_layout() == 'blockquote')
                            <blockquote class="blockquote text-center bg-light !text-brand py-8 rounded-lg relative">
                                {!! get_sub_field('text') !!}
                            </blockquote>
                        {{-- Check for the "WYSIWYG" layout --}}
                        @elseif (get_row_layout() == 'wysiwyg')
                            <div class="wysiwyg-content">
                               <div class="mb-2 subheading capitalize gradient-text">{!! get_sub_field('subheading') !!}</div>
                               <div class="">{!! get_sub_field('wysiwyg') !!}</div>
                            </div>
                         {{-- Check for the "list items" layout --}}
                        @elseif (get_row_layout() == 'list_items')
                            <div class="list-content">
                              <hr class="mb-4 mt-8" />
                              <div class="mb-2 subheading capitalize gradient-text">{!! get_sub_field('subheading') !!}</div>
                              <h2 class="heading">{!! get_sub_field('heading') !!}</h2>
                               <div class="list">
                                @if (have_rows('list_item'))
                                  <ul class="space-y-2 list-disc list-inside">
                                    @while (have_rows('list_item')) @php the_row() @endphp
                                      <li class="text-gray-700 list-none py-1">{!! get_sub_field('item') !!}</li>
                                    @endwhile
                                  </ul>
                                @endif
                               </div>
                               <hr class="mb-4 mt-8" />
                            </div>
                        {{-- Check for the "webinar transcript" layout --}}
                        @elseif (get_row_layout() == 'webinar_transcript')
                          <div 
                          x-data="{ isOpen: false }" 
                          class="transcript-content border border-gray-300 rounded-lg overflow-hidden mb-6 !mt-16"
                        >
                          <button 
                            @click="isOpen = !isOpen" 
                            type="button" 
                            class="heading w-full flex items-center justify-between text-left px-4 py-3 font-semibold transition-colors duration-300"
                            :class="isOpen ? 'text-action' : 'text-gray-800'"
                          >
                            <span>{!! get_sub_field('heading') !!}</span>

                            <!-- Caret Icon -->
                            <svg 
                              class="w-5 h-5 transform transition-transform duration-300" 
                              :class="{ 'rotate-180': isOpen }" 
                              fill="none" 
                              stroke="currentColor" 
                              viewBox="0 0 24 24" 
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                          </button>

                          <div 
                            class="relative overflow-hidden transition-all duration-500 max-h-0" 
                            x-ref="container"
                            x-bind:style="isOpen ? 'max-height: ' + $refs.container.scrollHeight + 'px' : ''"
                          >
                            <div class="body-content px-4 py-4 bg-blue-50">
                              {!! get_sub_field('wysiwyg') !!}
                            </div>
                          </div>
                        </div>
                        {{-- Check for the "video" layout --}}
                        @elseif (get_row_layout() == 'video')
                          <div class="video-content aspect-w-16 aspect-h-9 mb-8">
                            {!! get_sub_field('embed') !!}
                          </div>
                        @endif

                    @endwhile
                @endif

            @endwhile
            @endif

          </div>
          @php
            $webinar_components = get_field('webinar_components');
            $speakers = $webinar_components['speakers'] ?? null;
            $organizations = $webinar_components['organizations'] ?? null;
          @endphp

          <div class="w-full lg:w-1/3 space-y-8">

            {{-- SPEAKERS --}}
            @if ($speakers)
              <div class="speakers-section border gradient-border rounded-xl p-4">
                <div class="p-8">
                @if (!empty($speakers['speaker_heading']))
                  <h3 class="text-2xl font-medium mb-4">{{ $speakers['speaker_heading'] }}</h3>
                @endif

                @if (!empty($speakers['all_speakers']))
                  <div class="space-y-4">
                    @foreach ($speakers['all_speakers'] as $speaker_row)
                      @php
                        $author = $speaker_row['author'];
                      @endphp
                      @if ($author)
                        <div class="flex items-center space-x-4 bg-light rounded-lg p-4">
                          @php
                            $author_id = $author->ID;
                            $author_name = get_the_title($author_id);
                            $author_desc = get_the_content(null, false, $author_id);
                            $author_image = get_the_post_thumbnail_url($author_id, 'thumbnail');
                          @endphp

                          @if ($author_image)
                            <img src="{{ $author_image }}" alt="{{ $author_name }}" class="w-14 h-14 rounded-full object-cover">
                          @endif

                          <div>
                            <h4 class="font-semibold text-gray-900 !mb-0">{{ $author_name }}</h4>
                            <p class=" text-gray-400 text-sm leading-tight">{!! $author_desc !!}</p>
                          </div>
                        </div>
                      @endif
                    @endforeach
                  </div>
                @endif
                </div>
              </div>
            @endif

            {{-- ORGANIZATIONS --}}
            @if ($organizations)
              <div class="organizations-section border gradient-border rounded-xl p-4">
                <div class="p-8">
                @if (!empty($organizations['organization_heading']))
                  <h3 class="text-2xl font-medium mb-4">{{ $organizations['organization_heading'] }}</h3>
                @endif

                @if (!empty($organizations['all_organizations']))
                  <div class="space-y-4">
                    @foreach ($organizations['all_organizations'] as $org_row)
                      @php $logo = $org_row['logo'] ?? null; @endphp
                      @if ($logo)
                        <div class="bg-light rounded-lg p-4 flex justify-center">
                          <img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] ?? '' }}" class="max-h-12 w-auto object-contain">
                        </div>
                      @endif
                    @endforeach
                  </div>
                @endif
              </div>
               </div>
            @endif

          </div>

        </div>
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


