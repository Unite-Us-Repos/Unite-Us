@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
@endphp
<section class="header-hero relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
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
  <div class="absolute inset-0 bg-brand opacity-75"></div>
  @endif

  <div class="relative w-full text-center">

    <div class="component-inner-section">
      <div class="relative max-w-4xl mx-auto">
        @if (!$hide_breadcrumbs)
          <div class="mb-9 sm:mb-10">
            @php
            $bread_text = 'dark';
            if ($background['color'])
            $data = [
              'color' => $bread_text,
              'align' => 'center'
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
       
        @if ($section['is_header'] === 'h1')
        <h1 class="h1 mb-0 font-extrabold @if (($background['color'] == 'light') || $background['color'] == 'light-gradient') text-brand @else text-white @endif text-5xl lg:text-6xl">
          {!! $section['title'] !!}
        </h1>
        @elseif ($section['is_header'] === 'h2')
            <h2 class="h1 mb-0 font-extrabold @if (($background['color'] == 'light') || $background['color'] == 'light-gradient') text-brand @else text-white @endif text-5xl lg:text-6xl">
              {!! $section['title'] !!}
            </h2>
        @else
            <div class="h1 mb-0 font-extrabold @if (($background['color'] == 'light') || $background['color'] == 'light-gradient') text-brand @else text-white @endif text-5xl lg:text-6xl">
              {!! $section['title'] !!}
            </div>
        @endif
        
        
      </div>

      <div class="relative max-w-4xl mx-auto mt-10">
        @if ($section['description'])
          <div class="@if (($background['color'] == 'light') OR $background['color'] == 'light-gradient') text-brand @else text-white @endif text-xl">
            {!! $section['description'] !!}
          </div>
        @endif
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-center',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
      </div>
    </div>
    <div class="p-8"></div>
  </div>
</section>
<section class="relative component-section padding-collapse-t  -mt-16">
<div class="component-inner-section">
  <div class="mx-auto flex flex-col lg:grid gap-8 lg:grid-cols-12">
    <div class="col-span-8 relative h-full flex flex-col bg-light rounded-lg shadow-lg overflow-hidden">
      <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>
      <div class="text-center flex-1 flex flex-col justify-between pt-4">
        <div class="flex-1 px-6 py-10">

          <h3 class="mb-6 text-2xl sm:text-3xl">Join the Unite Us Platform</h3>
          <div class="text-lg sm:text-xl">
            <p>All users are invited to migrate to the Unite Us platform to continue positively serving their communities. <a href="/how-it-works">Learn more about how it works.</a></p>
            <p>Reach out to your organization’s NowPow administrator or contact Unite Us to discuss next steps.</p>
            <p><a href="/contact" class="button  flex items-center gap-3 button-hollow" style="font-weight:400 !important;text-decoration:none !important;">
              Contact Unite Us
            </a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-span-4 relative h-full flex flex-col bg-brand rounded-lg shadow-lg overflow-hidden">
      <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>
      <div class="text-center text-white flex-1 flex flex-col justify-between pt-4">
        <div class="flex-1 px-6 py-10">

          <h3 class="mb-6 text-2xl">Have Questions?</h3>
          <div class="text-base">
            <p>Please email <a class="text-action-light-blue" href="mailto:support@nowpow.com">support@nowpow.com</a> with any remaining support needs and a team member will be in touch.</p>
          </div>
        </div>

      </div>
    </div>

    {{-- <div class="col-span-8 pt-6 flex items-center justify-center text-center sm:justify-start sm:text-left">
      <div class="text-xl">
        <p>Interested in learning more about Unite Us or how to get started?</p>
      </div>
    </div>

    <div class="col-span-4 pt-6 flex items-center justify-center text-center sm:justify-start sm:text-left">
      <div class="text-lg">
        <p><span class="block sm:inline">You can connect with the </span>Unite Us team <a href="https://uniteus.com/contact/" title="Go to contact page">here</a>.</p>
      </div>
    </div> --}}

  </div>
</div>
</section>
