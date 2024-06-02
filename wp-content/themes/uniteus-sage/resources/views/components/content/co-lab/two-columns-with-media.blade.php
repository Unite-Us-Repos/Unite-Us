<section class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
    <div class="flex flex-col gap-10 md:grid md:grid-cols-12">
      <div class="col-span-4">
        <h2 class="mb-6 font-bold font-syne">{!! $section['title'] !!}</h2>
      </div>
      <div class="col-span-7 col-end-13">
        <div class="font-space text-lg font-normal">
          <div class="mb-10">
            <img class="h-auto w-20" src="@asset('images/four-arrows-down.svg')" alt="">
          </div>
          @if ($section['description'])
            {!! $section['description'] !!}
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
