@isset ($widget['video_embed'])
  @if (!empty($widget['video_embed']))
    <div class="responsive-embed">
      {!! $widget['video_embed'] !!}
    </div>
  @endif
@endisset
