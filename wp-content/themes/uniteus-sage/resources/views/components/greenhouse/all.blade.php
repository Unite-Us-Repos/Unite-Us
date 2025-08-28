@php
$ppp = 3;
$state = isset($_GET['state']) ? $_GET['state'] : '';
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];

$h_level = '2';

$departments = $greenHouseDepartments['departments'];
//$offices = $greenHouseOffices['offices'];
$jobs = $greenHouseJobs['jobs'];

$active_offices = [];
// build array of offices with jobs
if (count($jobs)) {
foreach ($jobs as $index=> $job) {
if (count($job['offices'])) {
foreach ($job['offices'] as $index=> $office) {
$active_offices[$office['name']] = $office['id'];
}
}
}
}
// alphabetize by key name DESC
ksort($active_offices);
@endphp
@if ($background['has_divider'])
@includeIf('dividers.waves')
@endif
@includeIf('components.greenhouse.partials.filters')

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset id="greenhouse-job-board"
  class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif"
  @if ($h_level==='1' ) style="padding-top:0 !important;" @endif>
  <div class="component-inner-section">

    @if ($h_level === '1')

    <div class="relative">
      <div class="absolute inset-0 -mb-24 -mx-4 {{ $section_classes }}"></div>
      <div class="relative pt-20 lg:pt-32 pb-10 z-10">
        @if ($section['title'] || $section['description'])
        <div class="text-center max-w-5xl mx-auto">
          @if ($section['title'])
          <h{{ $h_level }} class="mb-10>{!! $section['title'] !!}</h{{ $h_level }}>
              @endif
              @isset ($section['description'])
                <div class=" section-description max-w-5xl mx-auto text-xl">
            {!! $section['description'] !!}
        </div>
        @endisset
      </div>
      @endif
    </div>
  </div>

  @else
  @if (isset($section['title']) || isset($section['description']))
  <div>
    <div class="flex flex-col text-{{ $section['alignment'] }}">
      @if ($section['title'])
      <h2>{{ $section['title'] }}</h2>
      @endif
      @if ($section['description'])
      {!! $section['description'] !!}
      @endif
    </div>
  </div>
  @endif

  <div>

    <div class="lg:grid-cols-2 flex justify-between">
      <div>
        @if ($section['subtitle'])
        <h2 class="mb-6">{{ $section['subtitle'] }}</h2>
        @endif
      </div>
    </div>

    @foreach ($departments as $index => $department)
    @if (!$department['jobs'])
    @continue
    @endif
    <div
      class="flex flex-col sm:grid sm:grid-cols-12 border-t border-b border-light py-10 gap-6 gh-result-row gh-filter-{{ $department['id'] }}">
      <div class="col-span-4">
        @if ($department['jobs'])
        <h2 class="text-xl mb-4">{!! $department['name'] !!}</h2>
        <p class="text-lg md:max-w-[234px]">Open positions on the {!! $department['name'] !!} team.</p>
        @endif
      </div>

      <div class="col-span-8 flex flex-col gap-6">
        @foreach ($department['jobs'] as $index => $job)
          @includeIf('components.greenhouse.partials.job-card')
        @endforeach
      </div>
    </div>
    @endforeach



  </div>
  @endif
</section>
