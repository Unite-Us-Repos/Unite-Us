@if ($buttons)
@php
    $layout = 'flex';
    $margin = 'ml-3';
    $show_arrow = false;
    $click_action = '';
    $button_layout = '';

    if (!isset($justify)) {
      $justify = 'justify-center';
    }

    if (!isset($style)) {
      $style = 'simple-justified';
    }

    if (isset($button_layout) && ('text' == $button_layout)) {
      $layout = 'grid grid-cols-2 gap-x-6';
      $margin = '';
      $show_arrow = true;
    }

    if (isset($isAlert) && $isAlert) {
      $click_action = ' @click="localStorage.setItem(\'hideUuGlobalAlert\', \'' . $unique_id . '\'); hideAlert = true" ';
    }

    if (!isset($mt)) {
     $mt = false;
    }

  @endphp
  <div class="flex flex-wrap flex-col w-full sm:flex-row gap-6 @if ('text' == $button_layout) mt-5 @elseif ('simple-justified' == $style && !$mt) mt-9 sm:mt-10 @elseif ($mt) {{ $mt }} @else mt-9 sm:mt-10 @endif button-layout-{{ $button_layout }} {{ $layout }} md:{{ $justify }}">
    @foreach ($buttons as $index => $button)
      @php
        if ('internal' == $button['link_type']) {
          $link = $button['page_link'];
        } else {
          $link = $button['link'];
        }

        if (isset($button_layout) && ('text' == $button_layout)) {
          $button['style'] = 'button-text';
        }

        if (!isset($classes)) {
          $classes = '';
        }

        if (!isset($styles)) {
          $styles = '';
        }

        if (isset($button['background_color']['color'])) {
          $styles .= ' background-color: ' . $button['background_color']['color'] . '; ';

          if ('button-hollow' == $button['style']) {
            $styles .= ' border-color: ' . $button['text_color']['color'] . '; ';
          } else {
            $styles .= ' border-color: ' . $button['background_color']['color'] . '; ';
          }
        }

        if (isset($button['text_color']['color'])) {
          $styles .= ' color: ' . $button['text_color']['color'] . '!important; ';
        }

      @endphp
        <div class="@if ('text' != $button_layout) inline-flex @endif">
          <a href="{{ $link }}" {!! $click_action !!} class="button action-button {{ $classes }} @isset ($button['icon']) flex items-center gap-3 @endif {{ $button['style'] }}" style="text-decoration:none !important;@if ('text' == $button_layout) padding: 0.75rem 0; @endif {{ $styles }} " @if ($button['is_blank']) target=="_blank" @endif>
            {{ $button["name"]}}
            @if ($show_arrow)
            <span aria-hidden="true"> &rarr;</span>
            @endif

            @isset ($button['icon'])
            @if ($button['icon'])
              <img style="width:20px !important;height:20px !important;" class="h-8 w-8 @if ('button-hollow' == $button['style']) acf-icon-action @endif" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $button['icon'] }}.svg" alt="" />
            @endif
            @endisset
          </a>
        </div>

    @endforeach
  </div>
@endif
