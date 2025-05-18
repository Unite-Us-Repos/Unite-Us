@if ($stats)
<div class="component-inner-section mb-10">
  <div class="horizontal-dividers md:vertical-dividers flex flex-col md:grid grid-cols-{{ count($stats) }}">
    @foreach ($stats as $stat)
      <div class="flex md:flex-col justify-between mx-4 py-8 md:py-0 md:m-0 px-9 gap-6">
        <div class="text-brand text-lg">{!! $stat['description'] !!}</div>
        @if ($stat['logo'])
          <span class="image-filter brand">
            <img class="w-32 h-12 object-contain object-right-bottom md:object-left-bottom mb-2" src="{{ $stat['logo']['sizes']['medium'] }}" alt="{{ $stat['logo']['alt'] }}" />
          </span>
        @endif
      </div>
    @endforeach
  </div>
</div>
@endif
