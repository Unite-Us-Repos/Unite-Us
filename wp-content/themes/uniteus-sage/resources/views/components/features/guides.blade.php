<style>
.svg-icon svg {
  width: 20px;
  height: 20px;
}
</style>
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">
      @if ($section['title'])
        <h2 class="mb-3">{!! $section['title'] !!}</h2>
      @endif
      @if ($section['description'])
        {!! wpautop($section['description']) !!}
      @endif
        <div class="flex flex-col sm:grid grid-cols-2 border border-gray-200 shadow-lg rounded-lg overflow-hidden mt-8 mb-12 sm:mb-16">
        @foreach ($cards as $index => $card)
          @php
            $link = $card['button_link'];
            if ('internal' == $card['link_type']) {
              $link = $card['page_link'];
            }
          @endphp
            <div class="relative hover:bg-light group @if(($loop->last) && ($loop->odd)) col-span-2 @endif p-7 border-b border-gray-200 sm:border-b @if($loop->odd) sm:border-r @endif @if(($loop->last) OR (($loop->iteration === $loop->count-1) && ($loop->count % 2 == 0))) sm:border-b-0 @endif">
              <div class="w-12 h-12 mb-9 bg-white border border-pale-blue-light shadow-md rounded-md flex justify-center items-center">
                @if (isset($card['icon']) && !empty($card['icon']))
                  @php
                    $icon = '';
                    $icon = file_get_contents(get_template_directory() . '/resources/icons/acf/' . $card['icon'] . '.svg');
                    $icon = str_replace('fill="white"', 'fill="currentColor"', $icon);
                  @endphp
                  <span class="text-action svg-icon">
                      {!! $icon !!}
                  </span>
                  @else
                  <span class="text-action svg-icon">
                  <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10.2943 13.6619H17.0002M10.2943 18.1324H17.0002M19.2355 23.7207H8.05902C6.82451 23.7207 5.82373 22.7199 5.82373 21.4854V5.83832C5.82373 4.6038 6.82451 3.60303 8.05902 3.60303H14.302C14.5984 3.60303 14.8827 3.72078 15.0923 3.93038L21.1434 9.98156C21.353 10.1912 21.4708 10.4754 21.4708 10.7719V21.4854C21.4708 22.7199 20.47 23.7207 19.2355 23.7207Z" stroke="#216cff" stroke-width="2.23529" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

                  </span>
                @endif
              </div>
              <h3 class="mb-3 text-lg font-medium">
                @if ($link)
                  <a
                    href="{{ $link }}"
                    class="text-brand no-underline group-hover:text-action group-hover:font-bold"
                    @if ($card['is_blank']) target="_blank" @endif
                    >
                @endif
                  {{ $card['title'] }}
                @if ($link)
                  </a>
                @endif
              </h3>
              {!! wpautop($card['description']) !!}

              <div class="absolute p-7 flex justify-end inset-0 z-0 rounded-xl  @if ($link) group-hover:opacity-0 @endif">
                <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up.svg')" alt="" />
              </div>
              @if ($link)
              <div class="absolute p-7 flex justify-end inset-0 z-0 rounded-xl opacity-0 group-hover:opacity-100">
                <a
                  class="absolute inset-0 z-20 text-brand no-underline" href="{{ $link }}"
                  @if ($card['is_blank']) target="_blank" @endif>
                  <span class="sr-only">{{ $card['title'] }}</span>
                </a>
                <img class="w-5 h-5" src="@asset('/images/arrow-diagonal-up-active.svg')" alt="" />
              </div>
              @endif
            </div>
          @endforeach
        </div>
  </div>
</section>
