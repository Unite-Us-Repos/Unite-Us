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
$section_settings = isset($acf["components"][$index]['layout_settings']['section_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : $s_settings;
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">

    <div class="md:relative flex flex-col lg:grid lg:grid-cols-2 gap-20">

      <div class="flex flex-col lg:col-span-1 @if ('center' == $vertical_alignment) justify-center @endif order-2 text-lg @if ('text_image' == $layout) lg:order-1 @else lg:order-2 @endif">
        @if ($section['subtitle'])
          <div class="text-purple uppercase font-semibold mb-6">
            {!! $section['subtitle'] !!}
          </div>
        @endif
        @isset ($section['logo']['sizes'])
          <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
        @endisset
        @if ($section['title'])
       
        @if ($section['is_header'])
        <div class="mb-6 h2">{!! $section['title'] !!}</div>
        @else
        <h1 class="mb-6 h2">{!! $section['title'] !!}</h1>
        @endif

        @endif

        @if ($section['description'])
        <div class="description">
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
              'classes' => '!py-2 !px-6',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
      <div class="flex flex-col lg:col-span-1 @if ('center' == $vertical_alignment) justify-center @endif relative @if ('text_image' == $layout) lg:order-2 @else  lg:order-1 @endif">

        @if ($mask_image)
        <div class="relative max-w-lg mx-auto" @if ($featured_image) style="background: url({{ $featured_image['sizes']['medium_large'] }}) no-repeat center center;background-size: 60%;" @endif>
          <img class="lazy" data-src="@asset('/images/network-mask-1.png')" alt="" />
        </div>
        @else
          @isset ($featured_image['sizes'])
            @if ($stylized_image && $image_style == 'lg-curve-squared-dots')
              <img style="top: -40px; @if ('image_text' == $layout) right: 30%; @else left: 30%; @endif width: 114px; height: auto;" class="lazy absolute" @if ('image_text' == $layout) data-src="@asset('/images/square-dots-blue.png')" @else data-src="@asset('/images/square-dots-purple.png')" @endif />
              <img class="lazy z-10 @if ('image_text' == $layout) rounded-tr-[50%] lg:-ml-28 @else rounded-tl-[50%] lg:-mr-28 @endif object-cover h-full w-full lg:w-[120%] @if ($set_max_width_height) h-full aspect-square object-contain max-h-96 max-w-sm mx-auto @else max-w-md mx-auto lg:max-w-3xl @endif" data-src="@if (strpos($featured_image['url'], '.gif')) {{ $featured_image['url'] }} @else {{ $featured_image['sizes']['large'] }} @endif" alt="{{ $featured_image['alt'] }}" />
            @else
              <img class="lazy rounded-lg w-full @if ($set_max_width_height) h-full aspect-square object-contain max-h-96 max-w-sm mx-auto @else max-w-md mx-auto lg:max-w-3xl @endif" data-src="@if (strpos($featured_image['url'], '.gif')) {{ $featured_image['url'] }} @else {{ $featured_image['sizes']['medium_large'] }} @endif" alt="{{ $featured_image['alt'] }}" />
            @endif
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
            <div>
              {!! $code_editor !!}
            </div>
          @endif
        @endisset


      </div>
    </div>
  </div>
</section>
