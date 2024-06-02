<section class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div x-data="{ input: '{{ strip_tags($section['description']) }}' }"  class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
    <div class="flex flex-col gap-10 md:grid md:grid-cols-12">
      <div class="col-span-3">
        <h2 class="mb-6 max-w-[200px] text-2xl font-semibold font-syne icon-arrow-down-br">{!! $section['title'] !!}</h2>
        @if ($section['subtitle'])
          <div class="font-space text-base font-normal">
            {!! $section['subtitle'] !!}
          </div>
        @endif

        <button @click="copyRichText(document.getElementById('clipit{{ $index }}').innerHTML)"
          class="button button-hollow-redish gap-2 mt-6">
          <span class="text-sm">Copy to Clipboard</span>
          <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.99967 4.14119H4.66634C3.92996 4.14119 3.33301 4.73815 3.33301 5.47453V13.4745C3.33301 14.2109 3.92996 14.8079 4.66634 14.8079H11.333C12.0694 14.8079 12.6663 14.2109 12.6663 13.4745V5.47453C12.6663 4.73815 12.0694 4.14119 11.333 4.14119H9.99967M5.99967 4.14119C5.99967 4.87757 6.59663 5.47453 7.33301 5.47453H8.66634C9.40272 5.47453 9.99967 4.87757 9.99967 4.14119M5.99967 4.14119C5.99967 3.40482 6.59663 2.80786 7.33301 2.80786H8.66634C9.40272 2.80786 9.99967 3.40482 9.99967 4.14119" stroke="#FF4F4F" stroke-width="1.5" stroke-linecap="round"/>
          </svg>

        </button>
      </div>
      <div class="col-span-9 col-end-13 border-2 border-blue-200 rounded-xl p-12">
        <div class="font-space text-lg font-normal">
          <div id="clipit{{ $index }}">
            @if ($section['description'])
              {!! $section['description'] !!}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
