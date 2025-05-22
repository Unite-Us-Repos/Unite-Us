@if ($stats)
<div class="component-inner-section mb-10">
  <div class="horizontal-dividers md:vertical-dividers flex flex-col md:grid grid-cols-{{ count($stats) }}">
    @foreach ($stats as $stat)
    @php
      $logo_link_properties = get_field('image_link_properties', $stat['logo']['id']);
      $logo_link = $logo_link_properties['external_link'] ?? '';
      $logo_link_internal = $logo_link_properties['internal_link'] ?? '';
      $logo_link = $logo_link ? $logo_link : $logo_link_internal;
      $logo_link_target = $logo_link_properties['target_new'] ?? '';
      $logo_link_target = $logo_link_target ? '_blank' : '_self';
    @endphp
      <div class="flex md:flex-col justify-between mx-4 py-8 md:py-0 md:m-0 px-9 gap-6">
        <div class="text-brand text-lg">{!! $stat['description'] !!}</div>
        @if ($stat['logo'])
          <span class="image-filter brand">
            @if ($logo_link)
              <a href="{{ $logo_link }}" target="{{ $logo_link_target }}">
            @endif
            <img class="w-32 h-12 object-contain object-right-bottom md:object-left-bottom mb-2" src="{{ $stat['logo']['sizes']['medium'] }}" alt="{{ $stat['logo']['alt'] }}" />
            @if ($logo_link)
              </a>
            @endif
          </span>
        @endif
      </div>
    @endforeach
  </div>
</div>
@endif
