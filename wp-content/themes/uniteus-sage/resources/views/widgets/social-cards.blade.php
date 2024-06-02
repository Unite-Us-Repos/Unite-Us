@isset ($widget['cards'])
  @foreach ($widget['cards'] as $index => $card)
    @php
      $text = App\View\Composers\Post::urlEncode($card['description'])
    @endphp
    @if ($card['title'])
      <h3 class="mb-6 text-2xl font-normal @if ($index > 0) mt-14 @endif">{!! $card['title'] !!}</h3>
    @endif
    <div class="social-card p-10 mb-6 bg-white rounded-lg shadow-lg">
      {!! $card['description'] !!}
      @if ($card['social_post'])
      <div class="mt-6 flex gap-6">
        @foreach (($card['social_post']) as $social)
        <div class="inline-flex rounded-md shadow">
          <a href="{{ $socialPosts[$social]['url'] }}?text={{ $text }}" class="inline-flex button button-solid share" target="_blank">
            <img class="mr-3" src="{{ $socialPosts[$social]['icon'] }}" alt="" /> {{ $socialPosts[$social]['label'] }}
          </a>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  @endforeach
@endisset
