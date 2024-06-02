@php
$cta = isset($widget['cta']) ? $widget['cta'] : false;
@endphp
@if ($cta)
<div class="text-center h-full rounded-xl bg-light p-14">
    @if ($cta['title'])
      <h3 class="mb-6 text-3xl">
        {!! $cta['title'] !!}
      </h3>
    @endif
    @if ($cta['description'])
      <div class="cta-description text-lg max-w-3xl mx-auto">
        {!! $cta['description'] !!}
      </div>
    @endif
    @if ($cta['buttons'])
      <div>
      @php
          $mt = '';
          $buttons = $cta['buttons'];
          if (!$cta['description'] OR (!$cta['title'] && !$cta['description'])) {
            $mt = 'mt-0';
          }
          @endphp
          @include('components.action-buttons', ['mt' => $mt, 'button_layout' => ''])
      </div>
    @endif
  </div>
  @endif
