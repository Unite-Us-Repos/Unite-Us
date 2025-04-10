<div class="overflow-hidden {{ $section_classes }}">
  <ul class="marquee {{ $settings['direction'] ==  'ltr' ? 'marquee-ltr' : ''  }} list-none py-6 mb-0 inline-flex text-4xl space-x-6 whitespace-nowrap max-w-full" x-data="Marquee({speed: 0.8, spaceX: 4})">
  @foreach ($scrolling_items as $item)
    <li>
      @if ($item['link'])
        <a class="text-brand" href="{{ $item['link'] }}" target="_blank">
        {!! $item['title'] !!}
        </a>
      @else
        {!! $item['title'] !!}
      @endif
    </li>
  @endforeach
  </ul>
</div>
