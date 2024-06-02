@php
$flex_index = $index;
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div x-data="{ showSlide{{ $flex_index }}: 0 }" class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

    <div class="text-center mb-6">
      @if ($section['subtitle'])
        @if ($section['subtitle_display_as_pill'])
          <span class="@if ($background['color'] == 'dark') bg-brand text-action-light-blue @else text-action bg-light  mix-blend-multiply @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
        @else
          <span class="block text-base mb-3 font-semibold uppercase tracking-wider @if ('dark' == $background['color']) text-action-light-blue @else text-action @endif">
        @endif
          {{ $section['subtitle'] }}
        </span>
      @endif
      <h2 class="mb-3 @if ('dark' == $background['color']) text-white @endif">{!! $section['title'] !!}</h2>
      <div class="text-lg @if ('dark' == $background['color']) text-white @endif">
        {!! $section['description'] !!}

      </div>
    </div>
    @if ($slides)
      <div class="flex flex-col lg:flex-row mt-10 gap-10 lg:gap-24">
        <div class="sticky top-0 basis-3/6 self-start hidden lg:flex flex-col justify-center">
          @foreach ($slides as $index => $slide)
            <div
              x-data=""
              :class="showSlide{{ $flex_index }} == {{ $flex_index.$index }} ? 'opacity-100 sticky z-20' : 'opacity-0 absolute z-10'"
              class="flex mt-10 inset-0 transition-opacity"
              style="transition-duration: 700ms;"
              @if ($slide['video'])
              x-init="$watch('showSlide{{ $flex_index }}', (value) => {
                if (value === {{ $flex_index.$index }}) {
                      $refs.video{{ $flex_index.$index }}.load()
                      $refs.video{{ $flex_index.$index }}.play()
                } else {
                  $refs.video{{ $flex_index.$index }}.pause()
                }
              })"
              @endif
              >
              <div class="w-full">
                @if ($slide['video'])
                  <video x-ref="video{{ $flex_index.$index }}" muted loop playsinline disableRemotePlayback poster="{{ $slide['image']['url'] }}" class="lazy object-cover mx-auto">
                    <source data-src="{{ $slide['video'] }}" type="video/mp4" />Your browser does not support the video tag.
                  </video>
                @else
                  @if ($slide['image']['url'])
                    <img class="lazy w-full h-auto max-w-md mx-auto object-contain" data-src="{{ $slide['image']['url'] }}" alt="{{ $slide['image']['alt'] }}" />
                  @endif
                @endif
              </div>
            </div>
          @endforeach
        </div>

        <div class="basis-3/6 mt-10 flex flex-col gap-40 lg:gap-60 @if ('dark' == $background['color']) text-white @endif">
          @foreach ($slides as $index => $slide)
            <div
              x-intersect.margin.0.0.-50%.0="showSlide{{ $flex_index }} = {{ $flex_index.$index }}"
              class="@if (count($slides) == $index+1) mb-10 pb-6 @endif"
              >
              <img class="mb-10 w-full max-w-md mx-auto lg:hidden" src="{{ $slide['image']['url'] }}" alt="{{ $slide['image']['alt'] }}" />
              <h2 class="font-semibold text-4xl mb-6">{!! $slide['title'] !!}</h2>
              <div class="text-lg">{!! $slide['description'] !!}</div>


              @isset ($slide['blog_card'])
                @if (is_array($slide['blog_card']))
                <div class="flex flex-col gap-6 mt-6">
                  @foreach ($slide['blog_card'] as $card)
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
                    <div x-data="">
                    <div
                      @click.prevent="window.location.href='{{ get_permalink($card->ID) }}'"
                      class="group @if ($slide['blog_card_style'] == 'light') bg-light @else bg-brand @endif flex flex-col sm:grid sm:grid-cols-12 rounded-xl overflow-hidden border-b border-action cursor-pointer" style="border-bottom-width: 12px;">
                      <div class="sm:col-span-4">
                        @if ($thumb)
                          <img class="h-full w-auto object-cover lazy" data-src="{{ $thumb }}" alt="" />
                        @endif
                      </div>
                      <div class="sm:col-span-8 p-6">
                        @if ($category)
                          <span class="mb-6 inline-block px-3 py-0.5 bg-action text-white rounded-xl text-sm">{{ $category }}</span>
                        @endif
                        <h3 class="@if ($slide['blog_card_style'] == 'light') text-brand @else text-white @endif mb-3 font-medium">{!! $card->post_title !!}</h3>
                        @if ($card->post_excerpt)
                        <div class="mb-6 @if ($slide['blog_card_style'] == 'dark') text-white @endif">{!! $card->post_excerpt !!}</div>
                        @endif
                        <a class="card-link @if ($slide['blog_card_style'] == 'light') text-action group-hover:text-action-light-blue @else text-action-light-blue group-hover:text-action @endif  font-semibold no-underline flex flex-row items-center gap-3" href="{{ get_permalink($card->ID) }}">
                            <span>Learn More</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="11" viewBox="0 0 14 11" fill="none">
                              <path d="M8.66016 1.09241L12.7852 5.21741M12.7852 5.21741L8.66016 9.34241M12.7852 5.21741L1.78516 5.21741" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                      </div>
                    </div>
                    </div>
                  @endforeach
                  </div>
                @endif
              @endisset
            </div>
          @endforeach
        </div>
      </div>
    @endif
</section>
@if ($background['divider_bottom'])
  @includeIf('dividers.waves-bottom')
@endif
