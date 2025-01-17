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
$stack_on_mobile = $section['stack_on_mobile'] ?? false; // ACF true/false toggle
$mobile_image = $section['mobile_image'] ?? null; // ACF image field
@endphp

@if ($stack_on_mobile && $mobile_image)
<!-- Mobile Image -->
<div class="block md:hidden">
    <img src="{{ $mobile_image['url'] }}" alt="{{ $mobile_image['alt'] }}" class="w-full h-auto mb-4">
</div>
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }}  @endif @if ($small_font) extra-pt-pb @else  lg:!py-24 @endif
@if ($stack_on_mobile && $mobile_image) padding-collapse-t md:!pt-20 @endif">
  <!-- Overlay -->

  <div class="absolute inset-0 @if ($stack_on_mobile && $mobile_image) hidden md:block @endif">
    @if ($background['image'])
      <img fetchPriority="high" class="hero-desktop w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" 
        src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    @endif
</div>

  @if ($background['overlay'] && !$stack_on_mobile && !$mobile_image)
    <div class="absolute inset-0 bg-brand opacity-75 bg-electric-purple-overlay"></div>
  @endif


  <div class="relative w-full">
    <div class="component-inner-section">
     
      <div class="relative max-w-3xl ">
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
            <div class="
                {{ $section['purple_text'] ? 'text-electric-purple' : 'text-action-light-blue' }} 
                {{ $section['case_type'] == 'Uppercase' ? 'uppercase' : '' }} 
                {{ $section['case_type'] == 'Lowercase' ? 'lowercase' : '' }} 
                {{ $section['case_type'] == 'Camelcase' ? 'capitalize' : '' }} 
                {{ $section['case_type'] == 'Typed' ? 'none' : '' }} 
                @if ($section['subtitle_display_as_pill']) 
                    bg-light bg-opacity-10 text-action-light-blue text-sm py-1 px-4 mb-6 rounded-full
                    {{ $section['gradient_pill'] ? 'gradient-pill' : '' }}
                @else 
                    font-semibold text-base mb-3
                @endif
                @if ($stack_on_mobile && $mobile_image) mx-auto md:ml-0 block md:inline-block w-fit @else inline-block @endif

            ">
                {!! $section['subtitle'] !!}
            </div>
        @endif
    

        @if ($section['is_header'] === 'h1')
            <h1 class="h1 mb-0 text-4xl tracking-tight 
                @if ($stack_on_mobile && $mobile_image) text-brand text-center md:text-left
                @elseif ($background['color'] == 'light') text-brand 
                @else text-white @endif
                @if ($small_font) width-35 text-5xl !font-semibold small-font 
                @else font-extrabold md:text-5xl lg:text-6xl @endif">
                {!! $job_title !!}
            </h1>
        @elseif ($section['is_header'] === 'h2')
            <h2 class="h1 mb-0 text-4xl tracking-tight 
                @if ($stack_on_mobile && $mobile_image) text-brand text-center md:text-left
                @elseif ($background['color'] == 'light') text-brand 
                @else text-white @endif
                @if ($small_font) width-35 text-5xl font-semibold small-font 
                @else font-extrabold md:text-5xl lg:text-6xl @endif">
                {!! $job_title !!}
            </h2>
        @else
            <div class="h1 mb-0 text-4xl tracking-tight 
                @if ($stack_on_mobile && $mobile_image) text-brand text-center md:text-left
                @elseif ($background['color'] == 'light') text-brand 
                @else text-white @endif
                @if ($small_font) width-35 text-5xl font-semibold small-font 
                @else font-extrabold md:text-5xl lg:text-6xl @endif">
                {!! $job_title !!}
            </div>
        @endif
    
       
      </div>

      <div class="relative md:w-8/12 lg:w-6/12">
        @if ($section['description'])
            <div class="mt-6 
                @if ($stack_on_mobile && $mobile_image) text-brand text-center md:text-left
                @elseif ($background['color'] == 'light') text-brand 
                @else text-white @endif 
                text-xl">
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
      <div class="relative z-10 overflow-hidden pt-12">
        @if ($widgets)
          @foreach ($widgets as $widget)
            @isset ($widget["acf_fc_layout"])
              @includeIf('widgets.' . str_replace('_', '-', $widget["acf_fc_layout"]))
            @endisset
          @endforeach
        @endif
      </div>
    </div>
  </div>
</section>
@if ($background['has_divider'])
<div class="hero-divider">@includeIf('dividers.waves')</div>
@endif
