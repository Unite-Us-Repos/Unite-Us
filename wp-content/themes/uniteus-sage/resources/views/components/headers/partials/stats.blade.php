@if ($stats)
<div class="component-inner-section mb-10">
  <div class="flex flex-col sm:grid grid-cols-{{ count($stats) }} px-4 gap-6">
    @foreach ($stats as $stat)
      <div class="flex flex-col justify-between px-4 gap-6">
        <div class="text-brand">{!! $stat['description'] !!}</div>
        @if ($stat['logo'])
          <img class="max-w-[120px] w-full h-auto mb-2" src="{{ $stat['logo']['sizes']['medium'] }}" alt="{{ $stat['logo']['alt'] }}" />
        @endif
      </div>
    @endforeach
  </div>
</div>
@endif
