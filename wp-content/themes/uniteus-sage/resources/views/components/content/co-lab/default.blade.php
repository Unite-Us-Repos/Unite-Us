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
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset  class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @else relative @endif">

    @isset ($featured_image['sizes'])
    <div class="absolute right-0 top-0 -mt-16 -mr-10 lg:-mt-32 lg:-mr-20 z-10 simple-parallax">
      <img class="h-32 w-32 lg:h-64 lg:w-64" src="/wp-content/themes/uniteus-sage/resources/images/big-triangle.svg" alt="" />
    </div>
    @endisset

    <div class="md:relative flex flex-col md:grid md:grid-cols-2 gap-10">

      <div class="flex flex-col sm:col-span-1 @if ('center' == $vertical_alignment) justify-center @endif order-2 text-lg @if ('text_image' == $layout) md:order-1 @else md:order-2 @endif">
        @if ($section['subtitle'])
          <div class="subtitle">
            {{ $section['subtitle'] }}
          </div>
        @endif
        @isset ($section['logo']['sizes'])
          <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
        @endisset
        @if ($section['title'])
        <h2 class="mb-6 font-bold font-syne">{!! $section['title'] !!}</h2>
        @endif

        @if ($section['description'])
        <div class="description font-space text-lg font-normal">
          {!! $section['description'] !!}
        </div>
        @endif

        @isset ($extra_content)
          @if ('testimonial' == $extra_content)
            @if ($testimonial['quote'])
              <blockquote style="border: none;padding: 0;">
                <div class="text-2xl text-brand text-center italic p-3 mt-6">
                  {!! $testimonial['quote'] !!}
                </div>
                <p class="text-brand font-semibold text-base text-center not-italic mt-3">{!! $testimonial['name'] !!} @if ($testimonial['title']), {!! $testimonial['title'] !!} @endif</p>
              </blockquote>
            @endif
          @endif

          @if ('mini-cards' == $extra_content)
            @if ($mini_cards)
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-10 gap-3">
                @foreach ($mini_cards as $card)
                  <div class="relative text-center sm:text-left border border-blue-200 rounded-xl p-6 group">
                    <div class="relative z-10">
                    <h2 class="font-extrabold text-3xl text-action mb-0 leading-10">{!! $card['title'] !!}</h2>
                    <div>{!! $card['description'] !!}</div>
                    </div>
                    <div class="absolute inset-0 mini-card-grad z-0 rounded-xl opacity-0 group-hover:opacity-100">

                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          @endif
        @endisset

        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-start',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
      <div class="flex flex-col sm:col-span-1 @if ('center' == $vertical_alignment) justify-center @endif relative @if ('text_image' == $layout) md:order-2 @else  md:order-1 @endif">

        @if ($mask_image)
        <div class="relative max-w-lg mx-auto" @if ($featured_image) style="background: url({{ $featured_image['sizes']['medium_large'] }}) no-repeat center center;background-size: 60%;" @endif>
          <img class="lazy" data-src="@asset('/images/network-mask-1.png')" alt="" />
        </div>
        @else
          @isset ($featured_image['sizes'])
            <img class="lazy rounded-lg w-full @if ($set_max_width_height) h-full aspect-square object-contain max-h-96 max-w-sm mx-auto @else max-w-2xl mx-auto lg:max-w-3xl @endif" data-src="@if ('image/gif' == wp_get_image_mime($featured_image['url'])) {{ $featured_image['url'] }} @else {{ $featured_image['sizes']['medium_large'] }} @endif" alt="{{ $featured_image['alt'] }}" />
          @endisset
        @endif

        @isset ($embeds)
          @if (!empty($embeds))
            <div class="rounded-lg responsive-embed">
              {!! $embeds !!}
            </div>
          @endif
        @endisset

        @isset ($code_editor)
          @if (!empty($code_editor))
            <div id="form" class="bg-gray-50 rounded-lg drop-shadow-lg bg-white p-10 embed-form">
              {!! $code_editor !!}
            </div>
          @endif
        @endisset


      </div>
    </div>
  </div>
</section>
