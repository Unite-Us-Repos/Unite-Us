@if ($stats)
<div class="component-inner-section mb-10">
  <div class="vertical-dividers flex flex-col sm:grid grid-cols-{{ count($stats) }}">
    @foreach ($stats as $stat)
      <div class="flex flex-col justify-between px-9 gap-6">
        <div class="text-brand text-lg">{!! $stat['description'] !!}</div>
        @if ($stat['logo'])
          <img class="max-w-[120px] w-full h-auto mb-2" src="{{ $stat['logo']['sizes']['medium'] }}" alt="{{ $stat['logo']['alt'] }}" />
        @endif
      </div>
    @endforeach
  </div>
</div>
@endif
<style>
  /* Add vertical dividers between items (except first and last) */
    .vertical-dividers div:not(:first-child)::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 1px;
      background-color: rgba(44, 64, 90, 0.2);
    }
    .vertical-dividers div {
      position: relative;
    }
    </style>
