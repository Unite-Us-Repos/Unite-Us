@if ($key_points)
<div class="component-inner-section mb-10">
  <div class="flex flex-col gap-8 @if (count($key_points) > 1) md:grid md:grid-cols-2 lg:grid-cols-{{ count($key_points) }} @endif">
    @foreach ($key_points as $point)
      <div class="flex top-gradient-line flex-col justify-between gap- p-8 lg:p-0">
        <div class="text-brand text-lg">{!! $point['description'] !!}</div>
        @isset ($point['logo'])
          <span class="image-filter brand">
            <img class="w-32 h-12 object-contain object-left-bottom mb-2" src="{{ $stat['logo']['sizes']['medium'] }}" alt="{{ $stat['logo']['alt'] }}" />
          </span>
        @endisset
      </div>
    @endforeach
  </div>
</div>
@endif
