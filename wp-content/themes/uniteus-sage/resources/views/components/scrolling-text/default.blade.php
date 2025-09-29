<div class="overflow-hidden {{ $section_classes }}">
  <ul
    class="marquee {{ $settings['direction'] === 'ltr' ? 'marquee-ltr' : '' }} list-none py-6 mb-0 inline-flex text-4xl space-x-6 whitespace-nowrap max-w-full"
    x-data="Marquee({ speed: 0.8, spaceX: 4, dynamicWidthElements: true })"
  >
    @foreach ($scrolling_items as $item)
      <li
        class="relative inline-flex items-center gap-4
              [&>p]:m-0 [&>figure]:m-0
              [&_p]:inline-flex [&_p]:items-center [&_p]:gap-3
              [&_img]:inline-block [&_img]:h-[1.25em] [&_img]:w-auto [&_img]:align-middle
              [&>*]:shrink-0"
      >
        {!! $item['title'] !!}
        @if (!empty($item['link']))
          <button type="button" class="absolute inset-0 z-10"
                  @click="if(!$event.target.closest('a')) window.open('{{ $item['link'] }}','_blank')"
                  aria-label="Open item"></button>
        @endif
      </li>
    @endforeach
  </ul>
</div>
