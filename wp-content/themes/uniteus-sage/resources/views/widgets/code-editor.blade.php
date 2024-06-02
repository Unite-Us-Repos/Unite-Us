@php
$code = $widget['code_editor'];
$has_caption = $widget['has_caption'];
// remove css from hubspt forms
$code = str_replace("hbspt.forms.create({", "hbspt.forms.create({\ncss: \"\",", $code);
@endphp
@if ($has_caption)
  <div class="bg-shadow @if ($widget['caption']) rounded-md overflow-hidden @endif">
    {!! do_shortcode($code) !!}
    @if ($widget['caption'])
    <div class="bg-brand text-white px-10 pt-6 pb-10">
      {!! $widget['caption'] !!}
    </div>
    @endif
  </div>
@else
  {!! do_shortcode($code) !!}
@endif
