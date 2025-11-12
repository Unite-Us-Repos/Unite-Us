<style>
    .mini-card-grad {
        background-color: #E3EBF3;
        /* fallback */
        background-image: linear-gradient(90deg, #216bff02 15%, #216bff05 35%, #9543ff10 60%);
        background-repeat: no-repeat
    }
</style>

@php
    // Safe defaults
    $acf = $acf ?? [];
    $index = $index ?? 0;
    $type = $type ?? '';
    $layout = $layout ?? '';
    $vertical_alignment = $vertical_alignment ?? '';
    $button_placement = $button_placement ?? '';
    $extra_content = $extra_content ?? '';
    $blog_card_style = $blog_card_style ?? 'light';
    $blog_card_content = $blog_card_content ?? 'excerpt_arrow';

    $s_settings = [
        'collapse_padding' => false,
        'fullscreen' => '',
    ];
    // Section settings (prevents undefined index)
    $section_settings = $acf['components'][$index]['layout_settings']['section_settings'] ?? $s_settings;

    // Grid columns (e.g., "6_6")
    $grid_layout = $grid_layout ?? '6_6';
    $columns_pair = explode('_', $grid_layout);
    // Ensure we have two integers
    $columns_pair = array_pad($columns_pair, 2, '6');
    [$colA, $colB] = $columns_pair;

    // Mask overlay asset
    $image_overlay = @asset('/images/network-mask-1.png');
@endphp

@if (!empty($background['has_divider']))
    @includeIf('dividers.waves')
@endif

<section @isset($section['id']) id="{{ $section['id'] }}" @endisset
    class="relative component-section {{ $section_classes ?? '' }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] ?? '' }} @endif">

    <div class="absolute inset-0">
        @if (!empty($background['image']))
            <img fetchPriority="high"
                class="w-full h-full @if (($background['position'] ?? '') === 'top') object-top @endif @if (($background['position'] ?? '') === 'bottom') object-bottom @endif"
                src="{{ $background['image']['sizes']['medium'] }}"
                srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
                sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
        @endif
    </div>

    <div class="relative z-10 component-inner-section @if (!empty($section_settings['fullscreen'])) fullscreen @endif">
        <div class="md:relative flex flex-col lg:grid lg:grid-cols-12 lg:gap-14">

            {{-- Left/Text column --}}
            <div
                class="flex flex-col items-start
                  @if ($vertical_alignment === 'center') justify-center @endif
                  @if ($type === 'image' || $type === 'embed') order-2 @endif
                  text-lg
                  @if ($type === 'image') @if ($layout === 'text_image') lg:order-1 @else lg:order-2 @endif
                  @endif">

                @if (!empty($section['subtitle']))
                    @if (!empty($section['subtitle_display_as_pill']))
                        <div
                            class="
              @if (!empty($section['purple_text'])) text-electric-purple @else text-action @endif
              @if (($background['color'] ?? '') === 'light-gradient') bg-none border border-action @else bg-light mix-blend-multiply @endif
              text-sm py-1 px-4 inline-block mb-6 rounded-full">
                        @else
                            <div class="subtitle mb-6 @if (($background['color'] ?? '') === 'dark') text-white @endif">
                    @endif
                    {{ $section['subtitle'] }}
            </div>
            @endif

            @isset($section['logo'])
                <x-image-link :image="$section['logo']" image-size="medium" :lazy="true" classes="mb-6 max-w-[224px] h-auto"
                    link-classes="" />
            @endisset

            @if (!empty($section['title']))
                @if (($section['is_header'] ?? '') === 'h1')
                    <h1 class="mb-6 h2 @if (($background['color'] ?? '') === 'dark') text-white @endif">{!! $section['title'] !!}
                    </h1>
                @elseif (($section['is_header'] ?? '') === 'h2')
                    <h2 class="mb-6 h2 @if (($background['color'] ?? '') === 'dark') text-white @endif">{!! $section['title'] !!}
                    </h2>
                @else
                    {{-- If "h" is not a utility in your theme, consider "h2" here --}}
                    <div class="mb-6 h @if (($background['color'] ?? '') === 'dark') text-white @endif">{!! $section['title'] !!}
                    </div>
                @endif
            @endif

            @if (!empty($section['description']))
                <div class="description @if (($background['color'] ?? '') === 'dark') text-white @endif">
                    {!! $section['description'] !!}
                </div>
            @endif

            @isset($extra_content)
                @if ($extra_content === 'testimonial' && !empty($testimonial['quote']))
                    @if (($testimonial['style'] ?? 'inline') === 'inline')
                        <blockquote class="!p-0 !border-none !not-italic">
                            <div class="text-lg text-brand pl-7 border-l-2 border-action">{!! $testimonial['quote'] !!}</div>
                            <div class="flex items-center mt-6 gap-3">
                                @isset($testimonial['image']['sizes'])
                                    <img class="w-16 h-16 object-contain rounded-full"
                                        src="{{ $testimonial['image']['sizes']['thumbnail'] }}"
                                        alt="{{ $testimonial['image']['alt'] }}" />
                                @endisset
                                <p class="text-brand text-base">
                                    <span class="font-bold">{!! $testimonial['name'] !!}</span>
                                    @if (!empty($testimonial['title']))
                                        , <span class="text-action font-semibold">{!! $testimonial['title'] !!}</span>
                                    @endif
                                </p>
                            </div>
                        </blockquote>
                    @else
                        <blockquote class="!p-0 !border-none">
                            <div class="text-2xl text-brand text-center italic p-3 mt-6">{!! $testimonial['quote'] !!}</div>
                            <p class="text-brand font-semibold text-base text-center not-italic mt-3">
                                {!! $testimonial['name'] !!}
                                @if (!empty($testimonial['title']))
                                    , <span class="text-action">{!! $testimonial['title'] !!}</span>
                                @endif
                            </p>
                        </blockquote>
                    @endif
                @endif

                @if ($extra_content === 'mini-cards' && !empty($mini_cards))
                    @php $count = is_countable($mini_cards) ? count($mini_cards) : 0; @endphp
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 {{ $count > 4 ? 'lg:grid-cols-3' : 'lg:grid-cols-2' }} gap-3 mt-4">
                        @foreach ($mini_cards as $card)
                            <div
                                class="relative text-center sm:text-left border border-blue-200 rounded-xl p-6 group overflow-hidden">
                                <div class="relative z-10">
                                    <h2 class="font-extrabold text-3xl gradient-text mb-0 leading-10 w-fit">
                                        {!! $card['title'] !!}</h2>
                                    <div class="text-base">{!! $card['description'] !!}</div>
                                </div>
                                <div
                                    class="absolute inset-0 rounded-xl mini-card-grad z-0 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($extra_content === 'results' && !empty($results))
                    @foreach ($results as $idx => $card)
                        <div class="stat-item">
                            <h3 class="heading mb-2 text-2xl font-bold">{!! $card['title'] !!}</h3>
                            <div class="description text-lg">{!! $card['description'] !!}</div>
                        </div>
                    @endforeach
                @endif

                @if ($extra_content === 'icons' && !empty($results))
                    @foreach ($results as $idx => $card)
                        <div class="icon-item flex flex-col gap-10 mt-10">
                            <div class="flex gap-5">
                                <div class="shrink-0">
                                    @if (!empty($card['icon']))
                                        <span class="bg-action inline-block h-12 w-12 p-3 rounded-md">
                                            <img class="acf-icon-white w-6 h-6"
                                                src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg?v=1"
                                                alt="" />
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="heading mb-0 text-lg font-bold">{!! $card['title'] !!}</h3>
                                    <div class="description text-base">{!! $card['description'] !!}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if ($extra_content === 'blog-card' && !empty($blog_card) && is_iterable($blog_card))
                    <div class="flex flex-col gap-6 mt-6">
                        @foreach ($blog_card as $card)
                            @php
                                $thumb = get_the_post_thumbnail_url($card->ID, 'medium_large');
                                $categoryObjs = get_the_category($card->ID);
                                $category = '';
                                if (!empty($categoryObjs)) {
                                    $category = $categoryObjs[0]->cat_name ?? '';
                                }
                            @endphp
                            <div x-data class="relative group rounded-xl overflow-hidden">
                                <div class="absolute p-7 flex justify-end inset-0 z-10 rounded-xl group-hover:opacity-0">
                                    <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up.svg')" alt="" />
                                </div>
                                <div
                                    class="absolute p-7 flex justify-end inset-0 z-10 rounded-xl opacity-0 group-hover:opacity-100">
                                    <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up-active.svg')" alt="" />
                                </div>

                                <div
                                    class="absolute inset-0 z-0 @if ($blog_card_style === 'light') bg-light @else bg-brand @endif">
                                </div>

                                <div @click.prevent="window.location.href='{{ get_permalink($card->ID) }}'"
                                    class="relative z-10 flex flex-col group sm:grid sm:grid-cols-12 rounded-xl overflow-hidden border-b border-electric-purple cursor-pointer"
                                    style="border-bottom-width:12px;">
                                    <div class="relative sm:col-span-4">
                                        @if ($thumb)
                                            <img class="h-full w-auto object-cover lazy" data-src="{{ $thumb }}"
                                                alt="" />
                                        @endif
                                        <div class="absolute inset-0 bg-dark-blue opacity-50"></div>
                                    </div>
                                    <div class="sm:col-span-8 p-6">
                                        @if (!empty($category))
                                            <span
                                                class="mb-6 inline-block px-3 py-0.5 bg-electric-purple text-white rounded-xl text-sm">{{ $category }}</span>
                                        @endif

                                        <h3
                                            class="@if ($blog_card_style === 'light') text-brand @else text-white @endif mb-3 font-semibold">
                                            {!! $card->post_title !!}
                                        </h3>

                                        @if ($blog_card_content === 'excerpt_arrow')
                                            <div class="text-[15px] leading-snug">{!! get_the_excerpt($card) !!}</div>
                                        @endif

                                        @if ($blog_card_content === 'title_more')
                                            <a class="card-link @if ($blog_card_style === 'light') text-electric-purple group-hover:text-action-light @else text-action-light-blue group-hover:text-action @endif font-semibold no-underline flex flex-row items-center gap-3"
                                                href="{{ get_permalink($card->ID) }}">
                                                <span>Learn More</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="11"
                                                    viewBox="0 0 14 11" fill="none">
                                                    <path
                                                        d="M8.66016 1.09241L12.7852 5.21741M12.7852 5.21741L8.66016 9.34241M12.7852 5.21741L1.78516 5.21741"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endisset

            @if (!empty($buttons) && $button_placement === 'title_area')
                <div class="mb-6 lg:m-0 w-full">
                    @include('components.action-buttons', ['justify' => 'justify-start'])
                </div>
            @endif

        </div>

        {{-- Right/Media column --}}
        <div
            class="flex flex-col lg:max-h-[600px]
                  @if ($vertical_alignment === 'center') justify-center @endif
                  relative
                  @if ($type === 'image') @if ($layout === 'text_image') lg:order-2 @else lg:order-1 @endif
                  @endif">

            @if ($type === 'image')
                @if (!empty($mask_image))
                    @if (!empty($featured_image))
                        @php
                            if (!empty($image_mask)) {
                                $image_overlay = $image_mask;
                            }
                        @endphp
                        <div class="relative max-w-lg mx-auto mb-6 lg:mb-0">
                            <img class="lazy relative z-10" data-src="{{ $image_overlay }}?v=1" alt="" />
                            <div class="absolute inset-0 flex justify-center items-center"
                                style="margin:10px;width:60%;height:70%;margin-top:17%;margin-left:20%;
                            @if (empty($video)) background:url({{ $featured_image['sizes']['medium_large'] }}) no-repeat center center;background-size:cover; @endif">
                                @if (!empty($video))
                                    <video autoplay loop muted playsinline
                                        poster="{{ $featured_image['sizes']['medium_large'] }}"
                                        class="lazy object-cover mx-auto" style="aspect-ratio:1/1.3;">
                                        <source data-src="{{ $video }}" type="video/mp4" />Your browser does not
                                        support the video tag.
                                    </video>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    @isset($featured_image['sizes'])
                        <img class="lazy mb-6 lg:mb-0 rounded-lg w-full
                         @if (!empty($set_max_width_height)) h-full object-contain max-w-lg mx-auto @else max-w-md mx-auto lg:max-w-3xl @endif"
                            data-src="@if (strpos($featured_image['url'] ?? '', '.gif')) {{ $featured_image['url'] }} @else {{ $featured_image['sizes']['medium_large'] }} @endif"
                            alt="{{ $featured_image['alt'] ?? '' }}" />
                    @endisset
                @endif
            @endif

            @if ($type === 'video' && !empty($video))
                <video autoplay loop muted playsinline poster="{{ $featured_image['sizes']['medium_large'] ?? '' }}"
                    class="lazy object-cover mx-auto">
                    <source data-src="{{ $video }}" type="video/mp4" />Your browser does not support the video
                    tag.
                </video>
            @endif

            @if ($type === 'embed' && !empty($embeds))
                <div class="rounded-lg responsive-embed">{!! $embeds !!}</div>
            @endif

            @if ($type === 'code_editor' && !empty($code_editor))
                <div>{!! $code_editor !!}</div>
            @endif

            @if ($type === 'wysiwyg' && !empty($wysiwyg))
                <div class="text-lg">{!! $wysiwyg !!}</div>
            @endif

            @if ($type === 'accordion')
                <div class="accordion accordion-vertical" x-data="{ selected: 9999 }">
                    <ul class="list-none">
                        @isset($accordion)
                            @foreach ($accordion as $i => $card)
                                <li class="relative social-card py-6 px-9 lg:p-10 mb-6 bg-white rounded-lg shadow-lg"
                                    x-ref="container{{ $i }}"
                                    :class="{ 'open': selected == {{ $i }} }">
                                    <button type="button" class="w-full"
                                        @click="selected !== {{ $i }} ? selected = {{ $i }} : selected = null">
                                        @if (!empty($card['pill']))
                                            <div
                                                class="rounded-full inline-block mb-4 px-3 py-1 bg-light text-action text-sm">
                                                {!! $card['pill'] !!}</div>
                                        @endif
                                        <h3 class="heading mb-0 text-xl font-semibold pr-6">{!! $card['title'] !!}</h3>
                                    </button>

                                    <div class="relative overflow-hidden transition-all max-h-0 duration-700"
                                        x-ref="container{{ $i }}"
                                        x-bind:style="selected == {{ $i }} ? 'max-height: ' + $refs
                                            .container{{ $i }}.scrollHeight + 'px' : ''">
                                        <div class="text-lg border-t border-blue-300 mt-6 pt-6">{!! $card['description'] !!}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endisset
                    </ul>
                </div>
            @endif

            @if (!empty($buttons) && $button_placement === 'widget_area')
                <div class="mb-6 lg:m-0 w-full">
                    @include('components.action-buttons', ['justify' => 'justify-start'])
                </div>
            @endif

        </div>
    </div>
    </div>
</section>

@if ($extra_content === 'testimonials')
    <section class="component-section padding-collapse-t -mb-4"
        style="background:url(/wp-content/uploads/2024/01/spider-webs.png) no-repeat center center;background-size:cover;">
        <div class="component-inner-section">
            @if (!empty($testimonials['testimonials']) && count($testimonials['testimonials']))
                <div class="flex flex-col lg:grid lg:grid-cols-2 gap-10 lg:gap-20">
                    @foreach ($testimonials['testimonials'] as $t)
                        <blockquote
                            class="!p-0 !border-none !not-italic @if ($loop->index == 0) lg:mt-44 @endif">
                            <div class="flex items-start mt-6 gap-6">
                                @isset($t['image']['sizes'])
                                    <img class="w-16 h-16 object-contain rounded-full"
                                        src="{{ $t['image']['sizes']['thumbnail'] }}" alt="{{ $t['image']['alt'] }}" />
                                @endisset
                                <div>
                                    <div class="text-lg text-brand mb-6">{!! $t['quote'] !!}</div>
                                    <p class="text-brand text-base">
                                        <span class="font-bold">{!! $t['name'] !!}</span>
                                        @if (!empty($t['title']))
                                            ,
                                            <span
                                                class="text-action text-base font-semibold">{!! $t['title'] !!}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </blockquote>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif

@if (!empty($background['divider_bottom']))
    @includeIf('dividers.waves-bottom')
@endif
