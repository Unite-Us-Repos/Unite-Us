@php
  $link = $card['link'];
  $external_link = $card['external_link'];

  if ($external_link) {
    $link = $external_link;
  }
  if ($card['link_type'] == 'none') {
    $link = false;
  }
@endphp
<div class="service-icon-cards h-full group">
  <div class="bg-white text-brand transition-all hover:shadow-lg relative flex items-start rounded-lg overflow-hidden group h-full
  @if ($background['color'] != 'light-gradient') shadow-lg @endif
  @if ($card['bg_image']) group-hover:bg-action-dark
  @else
  group-hover:bg-electric-purple gradient-purple group-hover:text-white
  @endif
  @if (!empty($card['custom_icon'])) gradient-border @endif">

    @if ($card['bg_image'])
      <div style="z-index: 1;" class="absolute inset-0">
        @if ($link)
        <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
        @endif
          <img class="lazy w-full h-full object-cover opacity-0 group-hover:opacity-20" data-src="{{ $card['bg_image']['sizes']['large'] }}" alt="{{ $card['bg_image']['alt'] }}" />
        @if ($link)
        </a>
        @endif
      </div>
    @endif

    @if ($card['thumbnail'])
      <div style="z-index: 1;" class="top-10 left-0 right-0 px-3 absolute h-1/2">
        @if ($link)
        <a class="no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif alt="{{ strip_tags($card['title']) }}">
        @endif
          <img class="lazy w-full h-full object-contain" data-src="{{ $card['thumbnail']['sizes']['medium_large'] }}" alt="{{ $card['thumbnail']['alt'] }}" />
        @if ($link)
        </a>
        @endif
      </div>
    @endif

    <div class="relative z-10 w-full h-full p-9 text-lg lg:text-4xl">
      <div classs="absolute inset-0 z-10 border-b-[15px] border-action-dark transition ease-in-out delay-250 group-hover:opacity-0 group-hover:z-0"></div>
      @if ($link)
      <a class="absolute inset-0 p-9 text-brand group-hover:text-white no-underline" href="{{ $link }}" @if ($card['is_blank']) target="_blank" @endif>
      @endif
      <div class="relative">
        @isset($card["icon"])
        {{-- Check for custom_icon and render in a separate wrapper --}}
        @if (!empty($card["custom_icon"]))
          <span class="w-14 h-14 p-2 flex justify-center items-center rounded-full">
            <img class="lazy h-full w-full custom-icon service-icon"
              data-src="{{ $card['custom_icon']['url'] }}"
              alt="{{ $card['custom_icon']['alt'] ?? 'Custom Icon' }}" />
          </span>
        @elseif (!empty($card["icon"]))
          {{-- Render default icon inside styled span --}}
          <span class="mb-5 block bg-light
          @if ($alternate) bg-{{ $icon_color_class }} @else bg-light @endif
          @if ($icon_color_class == 'electric-purple')
              group-hover:bg-white
            @elseif ($icon_color_class == 'white')
              group-hover:bg-white
            @else
              group-hover:bg-action
            @endif
          w-10 h-10 p-2 flex justify-center items-center rounded-full">
            <img class="lazy h-full w-full acf-icon-{{ $icon_color_class}} service-icon" data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
          </span>
        @endif
      @endisset
        {{-- @isset ($card["icon"])
          @if (!empty($card["icon"]))
            <span class="mb-5 block bg-light
              @if ($alternate) bg-{{ $icon_color_class }} @else bg-light @endif
              @if ($icon_color_class == 'electric-purple')
                group-hover:bg-white
              @elseif ($icon_color_class == 'white')
                group-hover:bg-white
              @else
                group-hover:bg-action
              @endif
            w-10 h-10 p-2 flex justify-center items-center rounded-full">
              <img class="lazy h-full w-full acf-icon-{{ $icon_color_class}} service-icon" data-src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
            </span>
          @endif
        @endisset --}}
        @if ($card['title'])
        <h3 class="text-xl font-semibold mb-4">{!! $card['title'] !!}</h3>
        @endif
        @if ($card['description'])
          <div class="text-lg w-full">
              {!! $card['description'] !!}
          </div>
        @endif
      </div>
      @if ($link)
      </a>
      @endif
    </div>
  </div>
</div>
<style>
.gradient-purple:hover {
  background-color: #9643FF;
  background-image: linear-gradient(317.09deg, #216CFF 0%, rgba(33, 108, 255, 0) 100%);
  color: white;
}
</style>
