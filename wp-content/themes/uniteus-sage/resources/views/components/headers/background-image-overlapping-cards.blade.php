@php
$job_id = 0;
$job_title = '';
$title_override = false;
if ($section['title']) {
  $job_title = $section['title'];
}

if (isset($_GET['gh_jid'])) {
  $job_id = $_GET['gh_jid'];
  $job  = App\View\Composers\Greenhouse::getJob($job_id);
  $job_title = $job['title'];
  $title_override = true;
} else {
  if (is_page('job')) {
    wp_redirect('/our-careers/job-openings/');
    exit;
  }
}
$small_font = $section['small_font'] ?? false;

@endphp

<section class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }}  @endif @if ($small_font) extra-pt-pb @else  lg:!py-24 @endif">
  <!-- Overlay -->

  <div class="absolute inset-0">
    @if ($background['image'])
      <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    @endif
  </div>

  @if ($background['overlay'])
    <div class="absolute inset-0 opacity-75 bg-electric-purple-overlay"></div>
  @endif

  <div class="relative w-full">
    <div class="component-inner-section">
      <div class="relative max-w-3xl">
        @if (!$hide_breadcrumbs)
          <div class="mb-6">
            @php
            $data = [
              'color' => 'white'
            ];
            @endphp
            @include('ui.breadcrumbs.simple-with-slashes', $data)
          </div>
        @endif
        @isset ($section['logo']['sizes'])
          <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
        @endisset

        @if ($section['subtitle'])
          <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
            {!! $section['subtitle'] !!}
          </div>
        @endif
        <h1 class="mb-0 text-4xl tracking-tight @if ($background['color'] == 'light') text-brand @else text-white @endif
        @if ($small_font) width-35 text-5xl font-semibold small-font @else font-extrabold md:text-5xl lg:text-6xl @endif">
          {!! $job_title !!}
        </h1>
      </div>

      <div class="relative md:w-8/12 lg:w-6/12">
        @if ($section['description'])
          <div class="mt-6 @if ($background['color'] == 'light') text-brand @else text-white @endif text-xl">
            {!! $section['description'] !!}
          </div>
        @endif
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-start',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
    </div>
  </div>
</section>
@if ($background['has_divider'])
<div class="hero-divider">@includeIf('dividers.waves')</div>
@endif
