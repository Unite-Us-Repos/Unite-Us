<div class="overflow-hidden {{ $section_classes }}">
  <ul class="marquee {{ $settings['direction'] == 'ltr' ? 'marquee-ltr' : '' }} list-none py-6 mb-0 inline-flex text-4xl space-x-6 whitespace-nowrap max-w-full"
      x-data="Marquee({ speed: 0.8, spaceX: 4 })">
    @foreach ($scrolling_items as $item)
      @php
        $img      = $item['image'] ?? null;   // ACF image array
        $img_url  = '';
        $img_alt  = '';
        if (is_array($img)) {
          $img_url = $img['sizes']['medium'] ?? ($img['url'] ?? '');
          $img_alt = $img['alt'] ?? ($img['title'] ?? strip_tags($item['title'] ?? ''));
        }
      @endphp

      <li class="inline-flex items-center gap-3">
        @if (!empty($item['link']))
          <a class="text-brand inline-flex items-center gap-3" href="{{ $item['link'] }}" target="_blank" rel="noopener">
            @if ($img_url)
              <img src="{{ $img_url }}" alt="{{ $img_alt }}" class="inline-block align-middle" />
            @endif
            {!! $item['title'] !!}
          </a>
        @else
          <span class="inline-flex items-center gap-3">
            @if ($img_url)
              <div class="w-24">
                <img src="{{ $img_url }}" alt="{{ $img_alt }}" class="inline-block align-middle" />
              </div>
            @endif
            {!! $item['title'] !!}
          </span>
        @endif
      </li>
    @endforeach
  </ul>
</div>
