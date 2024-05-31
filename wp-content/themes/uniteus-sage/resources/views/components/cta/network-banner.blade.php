@php
$background['color'] = 'light';
$section_classes = 'bg-light';
$section = [
  'title' => '<strong>Keep Community at the Heart of Collaboration.</strong>
  <span class="text-action md:block">Attend the One Continuum Community Event.</span>',
  'description' => '',

  ];

  $buttons = [
    ];
@endphp

<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section" style="padding-top: 40px; padding-bottom:40px;">
  <div class="component-inner-section  @if ('dark' == $background['color']) is-dark-bg text-white @endif">
    <div class="network-banner flex rounded-xl px-11 p-9 bg-light flex-col lg:flex-row lg:items-center lg:justify-between gap-10">
      <div class="">
      @if ($section['title'])
        <h2 class="text-2xl font-normal mb-0">
          {!! $section['title'] !!}
        </h2>
      @endif

      <div class="font-semibold w-full flex flex-col sm:flex-row flex-wrap gap-5 mt-6 sm:mt-3">
<span class="flex gap-4 items-center">
<span class="w-6 h-6 flex justify-center items-center text-marketing-2">
  <svg class="w-full h-full" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M6.56153 0.5C5.7331 0.5 5.06153 1.17157 5.06153 2V3.5H3.56153C1.90467 3.5 0.561523 4.84315 0.561523 6.50001V21.5C0.561523 23.1569 1.90467 24.5 3.56153 24.5H21.5616C23.2184 24.5 24.5616 23.1569 24.5616 21.5V6.50001C24.5616 4.84315 23.2184 3.5 21.5616 3.5H20.0616V2C20.0616 1.17157 19.39 0.5 18.5616 0.5C17.7331 0.5 17.0616 1.17157 17.0616 2V3.5H8.06154V2C8.06154 1.17157 7.38996 0.5 6.56153 0.5ZM6.56153 8.00001C5.7331 8.00001 5.06153 8.67159 5.06153 9.50001C5.06153 10.3284 5.7331 11 6.56153 11H18.5616C19.39 11 20.0616 10.3284 20.0616 9.50001C20.0616 8.67159 19.39 8.00001 18.5616 8.00001H6.56153Z" fill="currentColor"></path>
</svg>
</span>
<span>
 <span class="mec-start-date-label">Nov 9</span></span></span>
 <span class="flex gap-4 items-center">
 <span class="w-7 h-7 flex justify-center items-center text-marketing-2">
  <svg class="w-6 h-6" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M12.5615 24.5C19.1889 24.5 24.5615 19.1274 24.5615 12.5C24.5615 5.87259 19.1889 0.5 12.5615 0.5C5.9341 0.5 0.561523 5.87259 0.561523 12.5C0.561523 19.1274 5.9341 24.5 12.5615 24.5ZM14.0615 6.50001C14.0615 5.67158 13.3899 5.00001 12.5615 5.00001C11.7331 5.00001 11.0615 5.67158 11.0615 6.50001V12.5C11.0615 12.8978 11.2196 13.2794 11.5009 13.5607L15.7435 17.8033C16.3293 18.3891 17.279 18.3891 17.8648 17.8033C18.4506 17.2175 18.4506 16.2678 17.8648 15.682L14.0615 11.8787V6.50001Z" fill="currentColor"></path>
</svg>
</span>
2:00 pm EST</span>
</div>
      </div>
      <div class="text-lg flex-shrink-0 justify-end">
        {!! $section['description'] !!}
        @if ($buttons)
          @php
          $mt = '';
          if (!$section['description'] OR (!$section['title'] && !$section['description'])) {
            $mt = 'mt-0';
          }
          if (!$section['description']) {
            $justify = 'justify-end';
          } else {
            $justify = 'justify-start';
          }
          @endphp
          @include('components.action-buttons', ['style', 'simple-justified', 'justify' => $justify, 'mt' => $mt])
        @endif


        <div class="flex flex-wrap justify-center flex-col sm:flex-row gap-6 button-layout-buttons sm:justify-start">
                        <div class=" inline-flex ">
          <a href="https://events.zoom.us/ev/AqveSEAhWHnJgOVl_2b-_adHPJc4QqF0EthwsP_uwnMLk8wyfNY4~AitwM4qRuuMtqrQpHcGBGUYbhvyqsQeHGlFtKavQejxMcXDvzdPYFjkURTVDGGPilLlnmfufpqPXKD_dxqcyNQk9dQ" class="button !py-2 !px-6 flex items-center gap-3  button-solid" style="text-decoration:none !important;  " target="=&quot;_blank&quot;">
            Register Today

                                              </a>
        </div>
            </div>
      </div>
    </div>
  </div>
</section>
