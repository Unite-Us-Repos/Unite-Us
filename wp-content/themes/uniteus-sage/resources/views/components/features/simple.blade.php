@php
$isCenter = ('center' == $section["alignment"]) ? true : false;
$columns = $columns['value'];
@endphp
<style>
.text-action.svg path {
  fill: #216CFF !important;
}
.text-action.svg svg {
  width: 24px !important;
  height: 24px !important;
}
</style>
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">

    <div @class([
      'max-w-3xl mx-auto text-center' => $isCenter,
      'flex flex-col gap-3 mb-5' => !$isCenter,
      ])>

      <div class="@if (!$isCenter) md:col-span-4 @endif">
        @if ($section['subtitle'])
          <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
            {{ $section['subtitle'] }}
          </span>
        @endif

        @if ($section['title'])
          <h2 class="mb-6 font-bold">
            {!! $section['title'] !!}
          </h2>
        @endif
      </div>

      @if ($section['description'])
        <div class="@if (!$isCenter) md:col-span-8 @endif mb-10 text-lg font-normal max-w-4xl mx-auto">
          {!! $section['description'] !!}
        </div>
      @endif
    </div>

    <div class="flex flex-col flex-wrap lg:justify-center sm:flex-row @if ('round-flat' == $icon_style) -mx-5 @else -mx-3 @endif">
      @foreach ($cards as $index => $card)
        @php
          $link = $card['button_link'];
          if ('internal' == $card['link_type']) {
            $link = $card['page_link'];
          }
        @endphp

        <div class="
        basis-full
        @if ($columns != 'full' && $card['title']) md:basis-1/2 @endif
        lg:basis-{{ $columns }} rounded-md
        @if ('custom' != $card['icon_type'] && 'round-flat' != $icon_style) hover:bg-light-gray/50 hover:shadow-lg @endif
        @if ('round-flat' == $icon_style) p-6 @else p-8 @endif
        @if (!$card['title']) pt-0 -mt-6 lg:pt-6 lg:mt-0 @endif
        ">


          <div class="
            @if (!$card['title']) hidden lg:flex @endif
            w-12 h-12 mb-6 @if ('round' == $card['icon_type']) bg-blue-300/25 border border-blue-300/25 @endif rounded-md flex justify-center items-center">
            <span class="text-redish">
              @isset ($card["icon"])
                @if (!empty($card["icon"]))
                  @if ('round' == $card['icon_type'])
                    <span class="inline-flex w-12 h-12 items-center justify-center rounded-full border-4 border-action bg-brand p-2 shadow-lg">
                  @elseif ('round-flat' == $icon_style)
                    <span class="inline-flex items-center justify-center rounded-full bg-blue-200 w-12 h-12">
                  @endif

                    @isset ($card['icon'])
                      @if ('round-flat' == $icon_style)
                      <span class="text-action svg h-8 w-8 inline-flex items-center justify-center">
                      {!! file_get_contents(get_template_directory() . '/resources/icons/acf/' . $card['icon'] . '.svg') !!}
                      </span>
                      @elseif ('custom' == $card['icon_type'])
                      <img style="width:48px !important;height:48px !important;" class="custom h-8 w-8" src="{{ $card['custom_icon']['url'] }}" alt="" />
                      @else
                      <img style="width:20px !important;height:20px !important;" class="h-8 w-8" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
                      @endif
                    @endisset
                    </span>
                @endif
              @endisset
            </span>
          </div>
          @if ($card['title'])
            <h3 class="text-lg mb-3">{!! $card['title'] !!}</h3>
          @endif
          <div class="@if ('round-flat' == $icon_style) text-base @else text-sm @endif">{!! wpautop($card['description']) !!}</div>
        </div>

      @endforeach
    </div>
  </div>
</section>
