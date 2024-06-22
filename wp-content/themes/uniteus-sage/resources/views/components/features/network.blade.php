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

    <div class="flex flex-wrap justify-center gap-14 sm:gap-0">
      @foreach ($cards as $index => $card)
        @php
          $link = $card['button_link'];
          if ('internal' == $card['link_type']) {
            $link = $card['page_link'];
          }
        @endphp

        <div class="
          basis-full
          max-auto max-w-md
          @if ($columns != 'full' && $card['title']) md:basis-1/2 @endif
          lg:basis-{{ $columns }} rounded-lg
          p-3
          ">
          @if ($card['image'])
            <img class="w-full rounded-xl mb-6" src="{{ $card['image']['sizes']['medium_large'] }}" alt="{{ $card['image']['alt'] }}" />
          @endif
          @if ($card['title'])
            <h3 class="text-2xl font-bold mb-6">{!! $card['title'] !!}</h3>
          @endif
          <div class="text-lg">{!! wpautop($card['description']) !!}</div>

          @if ($link)
                      <a class="button button-solid mt-6 text-whit font-semibold block" href="{{ $link }}" @if ($card['is_blank'])
                        style="background: #712F79 !important;border-color: #712F79 !important;"
                        target=="_blank" @endif>
                        @if ($card['button_text']) {{ $card['button_text'] }} @else Read More @endif<span aria-hidden="true" class="ml-1">
                            </span></a>
                    @endif
        </div>

      @endforeach
    </div>
  </div>
</section>
