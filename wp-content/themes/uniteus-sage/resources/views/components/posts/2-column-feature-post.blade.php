<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        @php
            $press_post = new WP_Query([
                'post_type' => 'press',
                'posts_per_page' => 1,
                'post_status' => 'publish',
            ]);
        @endphp

        @if ($press_post->have_posts())
            @while ($press_post->have_posts())
                @php $press_post->the_post(); @endphp

                <article class="flex flex-col lg:flex-row-reverse items-start gap-8 p-6 shadow-sm">
                    <div class="w-full lg:w-1/2">
                        <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'large') }}" alt="{{ get_the_title() }}"
                            class="rounded-lg object-cover w-full h-64 lg:h-full" />
                    </div>

                    <div class="w-full lg:w-1/2 flex flex-col justify-between">
                        <div class="flex bg-light rounded-full p-1 items-center gap-4 w-fit pe-8 mb-8">
                            <div class="text-white bg-action text-sm py-1 px-4 inline-block rounded-full uppercase">
                                @php
                                    $categories = get_the_terms(get_the_ID(), 'category');
                                    $categoryName =
                                        !empty($categories) && !is_wp_error($categories)
                                            ? $categories[0]->name
                                            : 'Press Release';
                                @endphp

                                {{ $categoryName }} </div>
                            <div class="pr-4 flex items-center gap-2 text-sm text-gray-800">
                                <span>Latest News</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>

                        <h2 class="mb-6 text-3xl">
                            {!! get_the_title() !!}
                        </h2>

                        <p class="text-xl text-action">
                            {{ get_the_date('F j, Y') }}
                        </p>

                        <a href="{{ get_permalink() }}" class="inline-flex button button-solid !w-fit">
                            <span class="mr-4 inline-block">Read More</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                viewBox="0 0 24 24" stroke="#FFFFFF" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7m0 0l-7 7m7-7H4" />
                            </svg>
                        </a>

                    </div>
                </article>
            @endwhile
            @php wp_reset_postdata(); @endphp
        @else
            <p>No press release found.</p>
        @endif
    </div>
</section>
