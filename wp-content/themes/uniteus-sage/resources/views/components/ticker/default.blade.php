<div class="overflow-hidden">
  <ul class="ticker mb-0 inline-flex space-x-10 whitespace-nowrap max-w-full" x-data="Ticker({speed: 0.5, spaceX: 4})">
  @foreach ($ticker_items as $item)
    <li>
      <a href="{{ $item['link'] }}" target="_blank">
        {!! $item['title'] !!}
      </a>
    </li>
  @endforeach
  </ul>
</div>
