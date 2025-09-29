<div class="overflow-hidden {{ $section_classes }}">
  <ul
    class="marquee {{ $settings['direction'] === 'ltr' ? 'marquee-ltr' : '' }} list-none py-6 mb-0 inline-flex text-4xl space-x-6 whitespace-nowrap max-w-full"
    x-data="Marquee({ speed: 0.8, spaceX: 4, dynamicWidthElements: true })"
  >
    @foreach ($scrolling_items as $item)
      <li
        class="relative inline-flex items-center gap-4
               [&>p]:m-0 [&>figure]:m-0
               [&_p]:inline-block [&_figure]:inline-block [&_img]:inline-block
               [&>*]:shrink-0"
      >
        {{-- Render WYSIWYG exactly as entered --}}
        {!! $item['title'] !!}

        @if (!empty($item['link']))
          {{-- If you want the whole item clickable WITHOUT breaking inner links: --}}
          <button
            type="button"
            class="absolute inset-0 z-10"
            aria-label="Open item"
            @click="if(!$event.target.closest('a')) window.open('{{ $item['link'] }}','_blank')"
          ></button>
        @endif
      </li>
    @endforeach
  </ul>
</div>
