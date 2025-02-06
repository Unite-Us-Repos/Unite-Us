<section  @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
    <div class="col-wrapper md:flex md:gap-10">
        <div class="col md:basis-1/3">
            @if ($section['subtitle'])
            @if ($section['subtitle_display_as_pill'])
              <div class="@if($section['purple_text']) text-electric-purple @elseif (str_contains($section_classes, 'bg-dark')) text-white @else text-action @endif text-sm py-1 px-4 inline-block mb-6 rounded-full border border-electric-purple">
            @else
              <div class="subtitle mb-6">
            @endif
              {{ $section['subtitle'] }}
              </div>
            @endif

            @if ($section['title'] || $section['description'])
            <div class="text-left md:mx-auto pb-4 @if (str_contains($section_classes, 'bg-dark')) text-white @endif">
                @if ($section['title'])
                    <h2 class="text-4xl">{!! $section['title'] !!}</h2>
                @endif
                @if ($section['description'])
                    {!! $section['description'] !!}
                @endif
            </div>
            @endif
        </div>
        <div class="col md:basis-2/3 md:mt-16">
            <div class="testimonial-wrapper md:flex md:gap-20">
              @foreach ($testimonials as $index => $testimonial)
              <div class="testimonial">
                <blockquote class="testimonial-quote mb-2">
                    <div class="text-left @if (str_contains($section_classes, 'bg-dark')) text-white @endif">
                        {!! $testimonial['quote'] !!}
                    </div>
                    <div class="flex gap-4 mt-4 mb-12">
                      @if ($testimonial['image'])
                        <div class="">
                          <img class="mx-auto h-10 w-10 md:mr-4 rounded-full" src="{{ $testimonial['image']['sizes']['thumbnail'] }}" alt="" />
                        </div>
                      @endif
                      <div class="">
                        <div class="text-sm sm:text-base font-semibold @if (str_contains($section_classes, 'bg-dark')) text-white @endif">{{ $testimonial['name'] }}</div>
                        @if ($testimonial['title_position'])
                          <div class="text-sm sm:text-base font-semibold md:text-left sm:max-w-sm lg:max-w-none @if (str_contains($section_classes, 'bg-dark')) text-gray-500 @endif">{{ $testimonial['title_position'] }}</div>
                        @endif
                      </div>
                    </div>
                </blockquote>
              </div>
              @endforeach
            </div>
        </div>
    </div>
    <div class="logo-wrapper">
        @if ($logos)
            <div class="flex flex-wrap md:flex-nowrap justify-center md:justify-between">
                @foreach ($logos as $logo)
                    <img class="basis-1/2 sm:basis-auto md:flex-none p-4 w-20 h-auto md:w-48"
                         src="{{ $logo['logo']['sizes']['medium'] }}" 
                         alt="{{ $logo['logo']['alt'] }}" />
                @endforeach
            </div>
        @endif
    </div>
    
  </div>
</section>


