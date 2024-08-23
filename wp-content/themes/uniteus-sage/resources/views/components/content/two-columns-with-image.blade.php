<style>
.mini-card-grad {
  background: rgb(227,235,243);
  background: linear-gradient(180deg, rgba(227,235,243,1) 0%, rgba(255,255,255,1) 50%);
}
</style>
@php
if (!isset($acf)) {
        $acf = [];
}
if (!isset($index)) {
        $index = 0;
}
$s_settings = [
        'collapse_padding' => false,
        'fullscreen' => '',
];

$columns = '6_6';
if ($grid_layout) {
  $columns = $grid_layout;
}
$columns = explode('_', $columns);

$image_overaly = @asset('/images/network-mask-1.png');
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

    <div class="md:relative flex flex-col lg:grid lg:grid-cols-12 lg:gap-10">

      <div class="flex flex-col items-start @if ('accordion' == $type) lg:col-span-4 @else lg:col-span-{{ $columns[0] }} @endif @if ('center' == $vertical_alignment) justify-center @endif @if (('image' == $type) OR ('embed' == $type)) order-2 @endif text-lg @if ('image' == $type) @if ('text_image' == $layout) lg:order-1 @else lg:order-2 @endif @endif">
        @if ($section['subtitle'])
        @if ($section['subtitle_display_as_pill'])
          <div class="@if($section['purple_text']) text-electric-purple @else text-action @endif bg-light mix-blend-multiply text-sm py-1 px-4 inline-block mb-6 rounded-full">
        @else
          <div class="subtitle mb-6">
        @endif
          {{ $section['subtitle'] }}
          </div>
        @endif

          @isset ($section['logo']['sizes'])
            <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
          @endisset
          @if ($section['title'])
          <h2 class="mb-6">{!! $section['title'] !!}</h2>
          @endif

          @if ($section['description'])
          <div class="description">
            {!! $section['description'] !!}
          </div>
          @endif

          @if ($buttons && ('title_area' == $button_placement))
          <div class="mb-6 lg:m-0 w-full">
            @php
              $data = [
                'justify' => 'justify-start',
              ];
            @endphp
            @include('components.action-buttons', $data)
            </div>
          @endif

        @isset ($extra_content)
          @if ('testimonial' == $extra_content)
            @if ($testimonial['quote'])
              @if ($testimonial['style'] == 'inline')
                <blockquote class="!p-0 !border-none !not-italic">
                  <div class="text-lg text-brand pl-7 border-l-2 border-action">
                    {!! $testimonial['quote'] !!}
                  </div>
                  <div class="flex items-center mt-6 gap-3">
                    @isset ($testimonial['image']['sizes'])
                      <img class="w-16 h-16 object-contain rounded-full" src="{{ $testimonial['image']['sizes']['thumbnail'] }}" alt="{{ $testimonial['image']['alt'] }}" />
                    @endisset


                    <p class="text-brand text-base"><span class="font-bold">{!! $testimonial['name'] !!}</span>@if ($testimonial['title']), {!! $testimonial['title'] !!} @endif</p>
                  </div>
                </blockquote>
              @else
                <blockquote class="!p-0 !border-none">
                  <div class="text-2xl text-brand text-center italic p-3 mt-6">
                    {!! $testimonial['quote'] !!}
                  </div>
                  <p class="text-brand font-semibold text-base text-center not-italic mt-3">{!! $testimonial['name'] !!}@if ($testimonial['title']), {!! $testimonial['title'] !!} @endif</p>
                </blockquote>
              @endif
            @endif
          @endif

          @if ('mini-cards' == $extra_content)
            @if ($mini_cards)
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-10 gap-3">
                @foreach ($mini_cards as $card)
                  <div class="relative text-center sm:text-left border border-blue-200 rounded-xl p-6 group">
                    <div class="relative z-10">
                    <h2 class="font-extrabold text-3xl text-action mb-0 leading-10">{!! $card['title'] !!}</h2>
                    <div class="text-base">{!! $card['description'] !!}</div>
                    </div>
                    <div class="absolute inset-0 mini-card-grad z-0 rounded-xl opacity-0 group-hover:opacity-100">

                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          @endif

          @if ('results' == $extra_content)
            @isset ($results)
              @foreach ($results as $index => $card)
              <div class="stat-item">
                <h3 class="heading mb-2 text-2xl font-bold">{!! $card['title'] !!}</h3>
                <div class="description text-lg">
                  {!! $card['description'] !!}
                </div>
              </div>
              @endforeach
            @endisset
          @endif

          @if ('icons' == $extra_content)
            @isset ($results)
              @foreach ($results as $index => $card)

              <div class="icon-item flex flex-col gap-10 mt-10">
                <div class="flex gap-5">
                  <div class="shrink-0">
                    @if ($card['icon'])
                      <span class="bg-action inline-block h-12 w-12 p-3 rounded-md">
                        <img class="acf-icon-white w-6 h-6" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg?v=1" alt="" />
                      </span>
                    @endif
                  </div>
                  <div>
                    <h3 class="heading mb-0 text-lg font-bold">{!! $card['title'] !!}</h3>
                    <div class="description text-base">
                      {!! $card['description'] !!}
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            @endisset
          @endif

          @if ('blog-card' == $extra_content)
                @if (is_array($blog_card))
                <div class="flex flex-col gap-6 mt-6">
                  @foreach ($blog_card as $card)
                    @php
                      $category = '';
                      $catSlug = '';
                      $thumb = get_the_post_thumbnail_url($card->ID, 'medium_large');
                      $category = get_the_category($card->ID);
                      foreach ($category as $cat) {
                        $category = $cat->cat_name;
                        $catSlug = $cat->category_nicename;
                      }
                    @endphp
                    <div x-data="" class="relative group rounded-xl overflow-hidden">
                    <div class="absolute p-7 flex justify-end inset-0 z-10 rounded-xl group-hover:opacity-0">
                <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up.svg')" alt="" />
              </div>
              <div class="absolute p-7 flex justify-end inset-0 z-10 rounded-xl opacity-0 group-hover:opacity-100">
                <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up-active.svg')" alt="" />
              </div>

              <div class="absolute inset-0 z-0  @if ($blog_card_style == 'light') bg-light @else bg-brand @endif"></div>
                    <div
                      @click.prevent="window.location.href='{{ get_permalink($card->ID) }}'"
                      class="relative z-10 flex flex-col group sm:grid sm:grid-cols-12 rounded-xl overflow-hidden border-b border-electric-purple cursor-pointer" style="border-bottom-width: 12px;">
                      <div class="relative sm:col-span-4">
                        @if ($thumb)
                          <img class="h-full w-auto object-cover lazy" data-src="{{ $thumb }}" alt="" />
                        @endif
                        <div class="absolute inset-0 bg-dark-blue opacity-50"></div>
                      </div>
                      <div class="sm:col-span-8 p-6">
                        @if ($category)
                          <span class="mb-6 inline-block px-3 py-0.5 bg-electric-purple text-white rounded-xl text-sm">{{ $category }}</span>
                        @endif
                        <h3 class="@if ($blog_card_style == 'light') text-brand @else text-white @endif mb-3 font-semibold">{!! $card->post_title !!}</h3>

                        @if ($blog_card_content == 'excerpt_arrow')
                          <div class="text-[15px] leading-snug">
                            {!! get_the_excerpt($card) !!}
                          </div>
                        @endif

                        @if ($blog_card_content == 'title_more')
                        <a class="card-link @if ($blog_card_style == 'light') text-electric-purple group-hover:text-action-light @else text-action-light-blue group-hover:text-action @endif font-semibold no-underline flex flex-row items-center gap-3" href="{{ get_permalink($card->ID) }}">
                            <span>Learn More</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="11" viewBox="0 0 14 11" fill="none">
                              <path d="M8.66016 1.09241L12.7852 5.21741M12.7852 5.21741L8.66016 9.34241M12.7852 5.21741L1.78516 5.21741" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                        @endif
                      </div>
                    </div>
                    </div>
                  @endforeach
                  </div>
                @endif
              @endif





        @endisset

        </div>
        <div class="flex flex-col lg:max-h-[600px] @if ('accordion' == $type) lg:col-span-7 lg:col-end-13 @else lg:col-span-{{ $columns[1] }} @endif @if ('center' == $vertical_alignment) justify-center @endif relative @if ('image' == $type) @if ('text_image' == $layout) lg:order-2 @else  lg:order-1 @endif @endif">

          @if ('image' == $type)
            @if ($mask_image)
              @if ($featured_image)
                @if ($image_mask)
                  @php
                    $image_overaly = $image_mask;
                    @endphp
                @endif
                <div class="relative max-w-lg mx-auto mb-6 lg:mb-0">
                  <img class="lazy relative z-10" data-src="{{ $image_overaly }}?v=1" alt="" />
                  <div class="absolute inset-0 flex justify-center items-center"
                    style="
                    margin:10px;
                    width: 60%;
                    height: 70%;
                    margin-top: 17%;
                    margin-left: 20%;
                    @if (!$video) background: url({{ $featured_image['sizes']['medium_large'] }}) no-repeat center center;background-size: cover;
                    @endif
                    ">
                @if ($video)
                  <video autoplay loop muted playsinline poster="{{ $featured_image['sizes']['medium_large'] }}" class="lazy object-cover mx-auto" style="aspect-ratio: 1/1.3;">
                    <source data-src="{{ $video }}" type="video/mp4" />Your browser does not support the video tag.
                  </video>
                @endif
              </div>
                </div>
              @endif
            @else
              @isset ($featured_image['sizes'])
                <img class="lazy mb-6 lg:mb-0 rounded-lg w-full @if ($set_max_width_height) h-full object-contain max-w-lg mx-auto @else max-w-md mx-auto lg:max-w-3xl @endif" data-src="@if (strpos($featured_image['url'], '.gif')) {{ $featured_image['url'] }} @else {{ $featured_image['sizes']['medium_large'] }} @endif" alt="{{ $featured_image['alt'] }}" />
              @endisset
            @endif
          @endif

          @if ('video' == $type)
          @if ($video)
            <video autoplay loop muted playsinline poster="{{ $featured_image['sizes']['medium_large'] }}" class="lazy object-cover mx-auto">
              <source data-src="{{ $video }}" type="video/mp4" />Your browser does not support the video tag.
            </video>
            @endif
          @endif

          @if ('embed' == $type)
            @isset ($embeds)
              @if (!empty($embeds))
                <div class="rounded-lg responsive-embed">
                  {!! $embeds !!}
                </div>
              @endif
            @endisset
          @endif

          @if ('code_editor' == $type)
            @isset ($code_editor)
              @if (!empty($code_editor))
                <div>
                  {!! $code_editor !!}
                </div>
              @endif
            @endisset
          @endif

          @if ('wysiwyg' == $type)
            @isset ($wysiwyg)
              @if (!empty($wysiwyg))
                <div class="text-lg">
                  {!! $wysiwyg !!}
                </div>
              @endif
            @endisset
          @endif

          @if ('accordion' == $type)
            <div class="accordion accordion-vertical" x-data="{selected:9999}">
              <ul class="list-none">
                @isset ($accordion)
                  @foreach ($accordion as $index => $card)
                    <li class="relative social-card py-6 px-9 lg:p-10 mb-6 bg-white rounded-lg shadow-lg" x-ref="container{{ $index }}" :class="{ 'open':  selected == {{ $index }} }">

                      <button type="button" class="w-full" @click="selected !== {{ $index }} ? selected = {{ $index }} : selected = null">
                        @if ($card['pill'])
                          <div class="rounded-full inline-block mb-4 px-3 py-1 bg-light text-action text-sm">
                            {!! $card['pill'] !!}
                          </div>
                        @endif
                        <h3 class="heading mb-0 text-xl font-semibold pr-6">
                            {!! $card['title'] !!}
                        </h3>
                      </button>

                      <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container{{ $index }}" x-bind:style="selected == {{ $index }} ? 'max-height: ' + $refs.container{{ $index }}.scrollHeight + 'px' : ''">
                        <div class="text-lg border-t border-blue-300 mt-6 pt-6">
                          {!! $card['description'] !!}
                        </div>
                      </div>

                    </li>
                  @endforeach
                @endisset
              </ul>
            </div>
          @endif
          
          @if ('list' == $type)
          
          @if (!empty($list_items))
            <div class="list-items-with-icons flex flex-wrap mt-5 mb-3">
                @foreach ($list_items as $item)
                    <div class="item basis-full lg:basis-1/2 flex gap-2 p-2 lg:p-4 items-center">
                        
                        @if (isset($item['svg_picker_or_custom_icon_upload']))
                        <div class="basis-1/5 flex justify-start lg:justify-end align-middle">
                            @if ($item['svg_picker_or_custom_icon_upload'] == 'SVG Icon Picker' && !empty($item['icon']))
                                <span class="icon w-10 h-10 p-2 flex justify-center items-center rounded-full mb-5 bg-light ">
                                  <img class="lazy h-full w-full" data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $item['icon'] }}.svg" alt="" />
                                </span>
                            @elseif ($item['svg_picker_or_custom_icon_upload'] == 'Custom' && !empty($item['icon_custom_upload']))
                              <span class="icon w-10 h-10 flex justify-center items-center rounded-full bg-light ">
                                <img src="{{ $item['icon_custom_upload']['url'] }}" alt="{{ $item['icon_custom_upload']['alt'] }}" class="custom-icon w-10 h-10">
                              </span>
                            @endif
                        </div>
                        @endif

                        <span class="text basis-4/5 font-semibold">
                            {{ $item['list_item'] }}
                        </span>
                    </div>
                @endforeach
            </div>
          @endif
    
          @endif

          @if ($buttons && ('widget_area' == $button_placement))
          <div class="mb-6 lg:m-0 w-full">
            @php
              $data = [
                'justify' => 'justify-start',
              ];
            @endphp
            @include('components.action-buttons', $data)
            </div>
          @endif

        </div>
      </div>

  </div>
</section>
@if ('testimonials' == $extra_content)
  <section class="component-section padding-collapse-t -mb-4" style="background: url(/wp-content/uploads/2024/01/spider-webs.png) no-repeat center center;
      background-size: cover;">
    <div class="component-inner-section">
        @if (count($testimonials['testimonials']))
        <div class="flex flex-col lg:grid lg:grid-cols-2 gap-10 lg:gap-20">
          @foreach ($testimonials['testimonials'] as $testimonial)

                        <blockquote class="!p-0 !border-none !not-italic @if ($loop->index == 0) lg:mt-44 @endif">
                        <div class="flex items-start mt-6 gap-6">
                            @isset ($testimonial['image']['sizes'])
                              <img class="w-16 h-16 object-contain rounded-full" src="{{ $testimonial['image']['sizes']['thumbnail'] }}" alt="{{ $testimonial['image']['alt'] }}" />
                            @endisset

                            <div>
                              <div class="text-lg text-brand mb-6">
                                {!! $testimonial['quote'] !!}
                              </div>



                            <div class="text-brand text-base"><span class="font-bold">{!! $testimonial['name'] !!}</span>@if ($testimonial['title']), <div class="text-action text-base font-semibold">{!! $testimonial['title'] !!}</div> @endif</div>
                      </div>
                          </div>
                        </blockquote>

          @endforeach
          </div>
        @endif
    </div>
  </section>
@endif
@if ($background['divider_bottom'])
  @includeIf('dividers.waves-bottom')
@endif
