<style>
  .lined-list {
  border-bottom-width: 1px;
    border-color: #E5E7EB;
    padding: 22px 0;
  }
  .lined-list:last-child {
    border:none;
  }
</style>
@php
$cards = $widget['features']['cards'];
$columns = $widget['features']['columns'];
$display_h = isset($widget['display_horizontal']) ? $widget['display_horizontal'] : false;
$display_badges = (isset($widget['display_as']) && ($widget['display_as'] == 'badges')) ? true : false;
$display_list = false;
$display_line_list = false;
if ($widget['display_as'] == 'list') {
  $display_h = true;
  $display_list = true;
}
if ($widget['display_as'] == 'lined-list') {
  $display_h = true;
  $display_list = true;
  $display_line_list = true;
}
if (!isset($widget['background_color'])) {
        $widget['background_color'] = '';
}
@endphp
<div class="grid grid-cols-1 @if ($display_list && !$display_line_list) gap-7 @else @if ($columns >= 3) gap-6 @else @if (!$display_line_list) gap-y-7 gap-x-10 @endif @endif @endif @if (!$display_line_list) mb-6 @endif @if ($columns > 1) sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-{{ $columns }} @endif">
  @foreach ($cards as $index => $card)
  <div class="@if ($display_line_list) lined-list @endif">
    <div class="@if ($display_h) flex items-center @if ($display_badges) px-6 py-4 @endif @else @if ($display_badges OR $display_list) py-3 @else flow-root @endif text-center @endif @if (!$display_line_list) h-full rounded-lg @endif @if ($widget['background_color'] == 'white') bg-white @endif @if ($widget['background_color'] == 'dark') bg-brand text-white @endif @if ($widget['background_color'] == 'light') bg-light @endif @if (!$display_list) @if ($columns > 3) px-2 @else px-6 @endif @endif">

        <div class="flex @if ($display_h) items-center @else justify-center @endif">
          @isset ($card["icon"])
            @if (!empty($card["icon"]))
              @if ('lined-list' == $widget['display_as'])
              <span class="inline-flex @if ($display_h) mr-4 @else -mt-6 @endif @if ($display_list) w-12 h-12 @else w-16 h-16 @endif items-center justify-center rounded-full border-4 border-action bg-action p-3 shadow-lg">
              @else
              <span class="inline-flex @if ($display_h) mr-4 @else -mt-6 @endif @if ($display_list) w-12 h-12 @else w-16 h-16 @endif items-center justify-center rounded-full border-4 border-action bg-action p-2 shadow-lg">
              @endif
                <img class="h-8 w-8" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $card['icon'] }}.svg" alt="" />
              </span>
            @endif
          @endisset
        </div>

        <div>
        @if ($card['title'])
          <h4 class="@if ($display_badges OR $display_list) mb-0 @endif @if ($display_h && !$display_badges) mt-2 @else @if (!$display_badges) mt-6 @endif @endif text-lg tracking-tight @if ($display_list) font-medium @else font-semibold @endif">{!! $card['title'] !!}</h4>
        @endif

        @if ($card['description'])
          <div class="mt-6">
            {!! $card['description'] !!}
          </div>
        @endif
        </div>

        @isset ($card['button_link'])
          <a href="{{ $card['button_link'] }}" class="button button-hollow inline-block" @if ($card['is_blank']) target=="_blank" @endif>
            Learn More
          </a>
        @endisset
      </div>
  </div>
  @endforeach
</div>
