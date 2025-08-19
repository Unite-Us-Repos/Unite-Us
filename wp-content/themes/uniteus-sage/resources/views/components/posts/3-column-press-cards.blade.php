@php
    $ppp = 3;
    $press = [];
    $total_press = [];
    $total_press = App\View\Composers\Post::getPress($category);
    if ('by_category' == $selection) {
        $press = App\View\Composers\Post::getPress($category, $ppp);
    } else {
        $press = App\View\Composers\Post::getPress('', $ppp, $posts);
    }
@endphp

@if ($background['has_divider'])
    @includeIf('dividers.waves')
@endif

<section id="{{ $section['id'] }}"
    class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
    <div class="absolute inset-0">
        @if ($background['image'])
            <img fetchPriority="high"
                class="w-full h-full @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                src="{{ $background['image']['sizes']['medium'] }}"
                srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
                sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
        @endif
    </div>
    <div class="relative component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

        <div>
            @if ($section['title'] || $section['description'])
                <div class="text-center mx-auto">
                    @if ($section['title'])
                        <div
                            class="flex justify-between items-center mb-6 flex-col lg:flex-row gap-4 lg:gap-0 text-center lg:text-left">
                            <h2
                                class="mb-0 text-3xl font-semibold w-full lg:w-auto @if ($section_classes === 'bg-dark') text-white @endif">
                                {{ $section['title'] }}
                            </h2>
                            @php
                                $viewAll = $section['view_all_link'];
                            @endphp

                            @if ($viewAll && !empty($viewAll['url']))
                                <div class="flex justify-between items-center mb-6">
                                    <a href="{{ $viewAll['url'] }}" target="{{ $viewAll['target'] ?: '_self' }}"
                                        class="inline-flex items-center font-semibold text-sm no-underline @if ($section_classes === 'bg-dark') text-white @else text-action @endif">
                                        {{ $viewAll['title'] }}
                                        <span class="ml-1">&rarr;</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($section['description'])
                        {!! $section['description'] !!}
                    @endif
                </div>
            @endif
        </div>


        @if ($press)
            <div>
                <div id="ajax-spotlight"
                    class="mt-10 max-w-lg mx-auto grid gap-8 lg:grid-cols-3 lg:max-w-none">
                    @foreach ($press as $index => $post)
                        @if (str_contains($section_classes, 'bg-dark'))
                            {{-- DARK CARD --}}
                            <div class="relative flex flex-col rounded-lg shadow-lg overflow-hidden bg-transparent">

                                <div class="flex-1 flex flex-col justify-between">
                                    <div class="flex-1 pt-7 pb-4">
                                        @php
                                            $postID = $post['ID'];
                                            $pressCats = get_the_terms($postID, 'press_cat');
                                            $states = get_the_terms($postID, 'states');
                                            $companyNews = get_the_terms($postID, 'company-news');
                                            $inTheNews = get_the_terms($postID, 'in-the-news');
                                        @endphp

                                        @if (!empty($pressCats) && !is_wp_error($pressCats))
                                            @php $firstCat = $pressCats[0]; @endphp

                                            @if ($firstCat->slug === 'partnership' && !empty($states) && !is_wp_error($states))
                                                <p class="leading-normal text-sm font-medium text-white my-4">
                                                    <span
                                                        class="inline-block bg-action font-medium rounded-full px-[15px] py-1 pill-span">
                                                        {{ $states[0]->name }}
                                                    </span>
                                                </p>
                                            @elseif ($firstCat->slug === 'company-news' && !empty($companyNews) && !is_wp_error($companyNews))
                                                <p class="leading-normal text-sm font-medium text-white my-4">
                                                    <span
                                                        class="inline-block bg-action font-medium rounded-full px-[15px] py-1 pill-span">
                                                        {{ $companyNews[0]->name }}
                                                    </span>
                                                </p>
                                            @elseif ($firstCat->slug === 'in-the-news' && !empty($inTheNews) && !is_wp_error($inTheNews))
                                                <p class="leading-normal text-sm font-medium text-white my-4">
                                                    <span
                                                        class="inline-block bg-action font-medium rounded-full px-[15px] py-1 pill-span">
                                                        {{ $inTheNews[0]->name }}
                                                    </span>
                                                </p>
                                            @else
                                                <p class="leading-normal text-sm font-medium text-white my-4">
                                                    <span
                                                        class="inline-block bg-action font-medium rounded-full px-[15px] py-1 pill-span">
                                                        {{ $firstCat->name }}
                                                    </span>
                                                </p>
                                            @endif
                                        @endif


                                        <h3 class="mb-4">
                                            @if ($post['permalink'])
                                                <a class="no-underline text-white" href="{{ $post['permalink'] }}"
                                                    @if ($post['is_external']) target="_blank" @endif>
                                            @endif
                                            {!! $post['post_title'] !!}
                                            @if ($post['permalink'])
                                                </a>
                                            @endif
                                        </h3>

                                        <span class="text-white">{{ $post['date'] }}</span>

                                        @isset($post['excerpt'])
                                            {!! $post['excerpt'] !!}
                                        @endisset
                                    </div>

                                    <div>
                                        @if ($post['permalink'])
                                            <a class="no-underline light-blue font-semibold p-6 pt-4 pl-0 block"
                                                href="{{ $post['permalink'] }}"
                                                @if ($post['is_external']) target="_blank" @endif>
                                                Read More <span aria-hidden="true" class="ml-1"> &rarr;</span>
                                            </a>
                                        @else
                                            <span class="p-6 block">&nbsp;</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- LIGHT CARD --}}
                            <div class="relative flex flex-col rounded-lg shadow-lg overflow-hidden bg-white">
                                <div class="">
                                    @if (has_post_thumbnail($post['ID']))
                                        <img src="{{ get_the_post_thumbnail_url($post['ID'], 'large') }}"
                                            alt="{{ $post['post_title'] }}"
                                            class="lazy aspect-video w-full object-cover entered loaded" />
                                    @else
                                        <img src="{{ asset('images/Press-thumb.png') }}" alt="Fallback Image"
                                            class="lazy aspect-video w-full object-cover entered loaded" />
                                    @endif
                                </div>
                                <div class="absolute w-full top-0 p-2 gradient-background rounded-t-lg"></div>
                                <div class="flex-1 flex flex-col justify-between">
                                    <div class="flex-1 px-6 pt-7 pb-10">
                                        @php
                                            $postID = $post['ID'];
                                            $pressCats = get_the_terms($postID, 'press_cat');
                                            $states = get_the_terms($postID, 'states');
                                            $companyNews = get_the_terms($postID, 'company-news');
                                            $inTheNews = get_the_terms($postID, 'in-the-news');
                                        @endphp

                                        @if (!empty($pressCats) && !is_wp_error($pressCats))
                                            @php $firstCat = $pressCats[0]; @endphp

                                            @if ($firstCat->slug === 'partnership' && !empty($states) && !is_wp_error($states))
                                                <p class="leading-normal text-sm font-medium text-white my-4">
                                                    <span
                                                        class="inline-block bg-action font-medium rounded-full px-[15px] py-1 pill-span">
                                                        {{ $states[0]->name }}
                                                    </span>
                                                </p>
                                            @elseif ($firstCat->slug === 'company-news' && !empty($companyNews) && !is_wp_error($companyNews))
                                                <p class="leading-normal text-sm font-medium text-white my-4">
                                                    <span
                                                        class="inline-block bg-action font-medium rounded-full px-[15px] py-1 pill-span">
                                                        {{ $companyNews[0]->name }}
                                                    </span>
                                                </p>
                                            @elseif ($firstCat->slug === 'in-the-news' && !empty($inTheNews) && !is_wp_error($inTheNews))
                                                <p class="leading-normal text-sm font-medium text-white my-4">
                                                    <span
                                                        class="inline-block bg-action font-medium rounded-full px-[15px] py-1 pill-span">
                                                        {{ $inTheNews[0]->name }}
                                                    </span>
                                                </p>
                                            @else
                                                <p class="leading-normal text-sm font-medium text-white my-4">
                                                    <span
                                                        class="inline-block bg-action font-medium rounded-full px-[15px] py-1 pill-span">
                                                        {{ $firstCat->name }}
                                                    </span>
                                                </p>
                                            @endif
                                        @endif


                                        <h3 class="mb-1">
                                            @if ($post['permalink'])
                                                <a class="no-underline text-brand" href="{{ $post['permalink'] }}"
                                                    @if ($post['is_external']) target="_blank" @endif>
                                            @endif
                                            {!! $post['post_title'] !!}
                                            @if ($post['permalink'])
                                                </a>
                                            @endif
                                        </h3>

                                        <span class="text-action">{{ $post['date'] }}</span>

                                        @isset($post['excerpt'])
                                            {!! $post['excerpt'] !!}
                                        @endisset
                                    </div>

                                    <div class="bg-light hover:bg-blue-200">
                                        @if ($post['permalink'])
                                            <a class="no-underline text-action font-semibold p-6 block"
                                                href="{{ $post['permalink'] }}"
                                                @if ($post['is_external']) target="_blank" @endif>
                                                Read More <span aria-hidden="true" class="ml-1"> &rarr;</span>
                                            </a>
                                        @else
                                            <span class="p-6 block">&nbsp;</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
    </div>
    @endif
</section>
