<style>
.submitted-message {
color: #2C405A;
}
</style>
@php
$section_settings = $acf["components"][$index]['layout_settings']['section_settings'];
@endphp
@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section relative {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="absolute bottom-0 border border-blue-900 -ml-4 w-full h-4/6 -mb-[1px] bg-blue-900"></div>

    <div class="component-inner-section relative @if ($section_settings['fullscreen']) fullscreen @endif">
        <div class="px-9 lg:px-20 py-16 bg-light w-full rounded-2xl flex flex-col relative lg:flex-none lg:grid lg:grid-cols-12 gap-10">

            <div class="lg:col-span-8 @if ($featured_image) order-2 @endif flex flex-col @if ('center' == $vertical_alignment) justify-center @endif text-lg @if ('text_image' == $layout) md:order-1 @else md:order-2 @endif lg:mb-0">
                @if ($section['subtitle'])
                <div class="subtitle n-case mb-3">
                    {{ $section['subtitle'] }}
                </div>
                @endif
                
                @if ($section['is_header'])
                <div class="mb-6 h2">{!! $section['title'] !!}</div>
                @else
                <h1 class="mb-6 h2">{!! $section['title'] !!}</h1>
                @endif

                {!! $section['description'] !!}
                @if ($buttons)
                @php
                    $data = [
                    'justify' => 'justify-start',
                    ];
                @endphp
                @include('components.action-buttons', $data)
                @endif
            </div>

            <div class="lg:col-span-4 relative flex flex-col @if ('center' == $vertical_alignment) justify-center @endif @if ('text_image' == $layout) lg:order-2 @else  lg:order-1 @endif">
                @if ($featured_image)
                    <img class="lazy rounded-lg w-full max-w-[200px] sm:max-w-md mx-auto" data-src="{{ $featured_image['sizes']['large'] }}" alt="{{ $featured_image['alt'] }}" />
                @endif

                @isset ($embeds)
                    @if (!empty($embeds))
                        <div class="rounded-lg responsive-embed">
                            {!! $embeds !!}
                        </div>
                    @endif
                @endisset

                @isset ($code_editor)
                    @if (!empty($code_editor))
                        <div class="">
                            {!! $code_editor !!}
                        </div>
                    @endif
                @endisset
            </div>
        </div>
        <p class="text-white mt-20">All opinions expressed by podcast guests are solely those of the guest and do not reflect the opinions of Unite Us.</p>
    </div>
</section>
