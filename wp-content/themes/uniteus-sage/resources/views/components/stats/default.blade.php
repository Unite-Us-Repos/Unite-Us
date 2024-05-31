<section class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">
    <dl class="text-center sm:mx-auto grid grid-cols-2 gap-10 @if (count($stats) === 2) sm:grid-cols-2 @endif @if (count($stats) === 3) sm:grid-cols-3 @endif @if (count($stats) >= 4) sm:grid-cols-2 lg:grid-cols-4 @endif">
      @foreach ($stats as $stat)
      <div class="flex flex-col">
        <dt class="order-2 mt-2 text-lg md:text-xl font-medium leading-[1.5] text-action-light-blue">{!! $stat["description"] !!}</dt>
        <dd class="order-1 text-3xl md:text-5xl font-extrabold tracking-tight text-white">{!! $stat["label"] !!}</dd>
      </div>
      @endforeach
    </dl>
  </div>
</section>
@if ($background['has_divider'])
  <div class="section-divider -mx-1 relative mb-5 -mt-2 -sm:mb-3 md:-mt-7 md:-mt-7 xl:-mt-10">
    <svg class="w-full h-auto" width="1358" height="80" preserveAspectRatio="none" viewBox="0 0 1358 80" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 71.0853L57.125 65.2401C113.75 59.3948 227 47.7043 340.25 53.5496C453.5 59.3948 566.75 82.7758 680 80.8274C793.25 78.879 906.5 51.6012 1019.75 45.7559C1133 39.9107 1246.25 55.498 1302.87 63.2917L1359.5 71.0853V0.942383H1302.87C1246.25 0.942383 1133 0.942383 1019.75 0.942383C906.5 0.942383 793.25 0.942383 680 0.942383C566.75 0.942383 453.5 0.942383 340.25 0.942383C227 0.942383 113.75 0.942383 57.125 0.942383H0.5V71.0853Z" fill="#172A44"></path>
    </svg>
  </div>
@endif
