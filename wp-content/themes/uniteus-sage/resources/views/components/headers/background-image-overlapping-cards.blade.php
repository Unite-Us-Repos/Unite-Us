@php
    $title = $section['title'] ?? '';
    $small_font = $section['small_font'] ?? false;
    $stack_on_mobile = $section['stack_on_mobile'] ?? false; // ACF true/false toggle
    $mobile_image = $section['mobile_image'] ?? null; // ACF image field

    $enable_smile = $enable_smile ?? false; // safe default if not set

@endphp

@if ($stack_on_mobile && $mobile_image)
    <!-- Mobile Image -->
    <div class="block md:hidden">
        <img src="{{ $mobile_image['url'] }}" alt="{{ $mobile_image['alt'] }}" class="w-full h-auto mb-4">
    </div>
@endif

<section @isset($section['id']) id="{{ $section['id'] }}" @endisset
    class="relative component-section {{ $section_classes }}
    @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif
    @if ($small_font) extra-pt-pb @else lg:!py-24 @endif
    @if ($stack_on_mobile && $mobile_image) padding-collapse-t md:!pt-20 @endif">

    <!-- Background image (hidden on mobile if stacking with a mobile image) -->
    <div class="absolute inset-0 @if ($stack_on_mobile && $mobile_image) hidden md:block @endif">
        @if (!empty($background['image']))
            <img fetchPriority="high"
                class="hero-desktop w-full h-full object-cover
          @if (!empty($background['position']) && $background['position'] == 'top') object-top @endif
          @if (!empty($background['position']) && $background['position'] == 'bottom') object-bottom @endif"
                src="{{ $background['image']['sizes']['medium'] }}"
                srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
                sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
        @endif
    </div>

    @if (!empty($background['overlay']) && !$stack_on_mobile && !$mobile_image)
        <div class="absolute inset-0 bg-brand opacity-75 bg-electric-purple-overlay"></div>
    @endif


    <div class="relative w-full">
        <div class="component-inner-section">

            <div class="relative max-w-3xl">
                @if (empty($hide_breadcrumbs))
                    <div class="mb-6">
                        @php $data = ['color' => 'white']; @endphp
                        @include('ui.breadcrumbs.simple-with-slashes', $data)
                    </div>
                @endif

                @isset($section['logo']['sizes'])
                    <img class="mb-6 max-w-[224px] h-auto" src="{{ $section['logo']['sizes']['medium'] }}"
                        alt="{{ $section['logo']['alt'] }}" />
                @endisset

                @if (!empty($section['subtitle']))
  @php
    $isPill   = !empty($section['subtitle_display_as_pill']);
    $pillIcon = $section['pill_icon']['url'] ?? '';
    $wrap     = ($stack_on_mobile && $mobile_image)
                ? 'mx-auto md:ml-0 block md:inline-block w-fit'
                : 'inline-block';

    // Optional text casing support (keeps your existing behavior)
    $case = match ($section['case_type'] ?? '') {
      'Uppercase' => 'uppercase',
      'Lowercase' => 'lowercase',
      'Camelcase' => 'capitalize',
      default     => '',
    };
  @endphp

  @if ($isPill)
    <div class="{{ $wrap }} mb-6">
      @if (!empty($section['gradient_hollow_pill']))
        {{-- Gradient hollow pill with icon (purple gradient border + light inner) --}}
        <span class="inline-flex items-center !rounded-full gradient-border bg-transparent">
          <span class="inline-flex items-center gap-2 !rounded-full bg-transparent px-4 py-1">
            @if ($pillIcon)
              <img src="{{ esc_url($pillIcon) }}" alt="" aria-hidden="true" class="h-5 w-5">
            @endif
            <span class="text-slate-700 text-sm font-medium {{ $case }}">
              {!! $section['subtitle'] !!}
            </span>
          </span>
        </span>
      @else
        {{-- Regular filled pill (previous style) --}}
        <span class="inline-flex items-center gap-2 rounded-full bg-light bg-opacity-10 text-action-light-blue text-sm py-1 px-4 {{ $case }}">
          @if ($pillIcon)
            <img src="{{ esc_url($pillIcon) }}" alt="" aria-hidden="true" class="h-5 w-5">
          @endif
          {!! $section['subtitle'] !!}
        </span>
      @endif
    </div>
  @else
    {{-- Non-pill subtitle with optional icon --}}
    <div class="{{ $wrap }} font-semibold text-base mb-3 {{ !empty($section['purple_text']) ? 'text-electric-purple' : 'text-action-light-blue' }} {{ $case }}">
      @if ($pillIcon)
        <img src="{{ esc_url($pillIcon) }}" alt="" aria-hidden="true" class="h-5 w-5 inline align-[-2px] mr-2">
      @endif
      {!! $section['subtitle'] !!}
    </div>
  @endif
@endif


                @if (($section['is_header'] ?? '') === 'h1')
                    <h1
                        class="h1 mb-0 text-4xl tracking-tight
            @if ($stack_on_mobile && $mobile_image) text-brand text-center md:text-left
            @elseif (($background['color'] ?? '') === 'light') text-brand
            @else text-white @endif
            @if ($small_font) width-35 text-5xl !font-semibold small-font
            @else font-extrabold md:text-5xl lg:text-6xl @endif">
                        {!! $title !!}
                    </h1>
                @elseif (($section['is_header'] ?? '') === 'h2')
                    <h2
                        class="h1 mb-0 text-4xl tracking-tight
            @if ($stack_on_mobile && $mobile_image) text-brand text-center md:text-left
            @elseif (($background['color'] ?? '') === 'light') text-brand
            @else text-white @endif
            @if ($small_font) width-35 text-5xl font-semibold small-font
            @else font-extrabold md:text-5xl lg:text-6xl @endif">
                        {!! $title !!}
                    </h2>
                @else
                    <div
                        class="h1 mb-0 text-4xl tracking-tight
            @if ($stack_on_mobile && $mobile_image) text-brand text-center md:text-left
            @elseif (($background['color'] ?? '') === 'light') text-brand
            @else text-white @endif
            @if ($small_font) width-35 text-5xl font-semibold small-font
            @else font-extrabold md:text-5xl lg:text-6xl @endif">
                        {!! $title !!}
                    </div>
                @endif
            </div>

            <div class="relative md:w-8/12 lg:w-6/12">
                @if (!empty($section['description']))
                    <div
                        class="mt-6
            @if ($stack_on_mobile && $mobile_image) text-brand text-center md:text-left
            @elseif (($background['color'] ?? '') === 'light') text-brand
            @else text-white @endif
            text-xl">
                        {!! $section['description'] !!}
                    </div>
                @endif

                @if (!empty($buttons))
                    @php $data = ['justify' => 'justify-start']; @endphp
                    @include('components.action-buttons', $data)
                @endif
            </div>


            @if (!empty($widgets))
                <div class="relative z-10 overflow-hidden pt-12">
                    @foreach ($widgets as $widget)
                        @isset($widget['acf_fc_layout'])
                            @includeIf('widgets.' . str_replace('_', '-', $widget['acf_fc_layout']))
                        @endisset
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

@if (!empty($background['has_divider']))
    <div class="hero-divider">@includeIf('dividers.waves')</div>
@endif
