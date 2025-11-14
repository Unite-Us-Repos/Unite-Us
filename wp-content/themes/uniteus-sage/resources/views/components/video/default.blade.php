{{-- resources/views/components/default.blade.php --}}
@php
    // pull only the video fields from ACF if not already provided
    $video = $video ?? ($acf['components'][$index]['video'] ?? []);
    $embed = $embed ?? ($video['embed'] ?? '');
    $code_editor = $code_editor ?? ($video['code_editor'] ?? '');
    $side_text = $side_text ?? ($video['text'] ?? ''); // <-- THIS is the WYSIWYG in your JSON
    $video_link = $video_link ?? ($video['link'] ?? null);
@endphp

@php
// Match other comps: only resolve section_settings
  $s_settings = ['collapse_padding' => false, 'fullscreen' => ''];
  $section_settings = isset($acf['components'][$index]['layout_settings']['section_settings'])
    ? $acf['components'][$index]['layout_settings']['section_settings']
    : $s_settings; @endphp

@if (!empty($background['has_divider'])) @includeIf('dividers.waves') @endif

<section @isset($section['id']) id="{{ $section['id'] }}" @endisset
    class="video-default relative @if (($background['color'] ?? '') === 'dark') text-white @endif component-section {{ $section_classes ?? '' }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] }} @endif">

    {{-- Optional background image (same style as other comps) --}}
    @if (!empty($background['image']))
        <div class="absolute inset-0">
            <img fetchpriority="high"
                class="w-full h-full object-cover
               @if (($background['position'] ?? '') === 'top') object-top @endif
               @if (($background['position'] ?? '') === 'bottom') object-bottom @endif"
                src="{{ $background['image']['sizes']['medium'] }}"
                srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] ?? ($background['image']['sizes']['large'] ?? $background['image']['sizes']['medium']) }} 1024w"
                sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
        </div>
    @endif

    {{-- Heading / copy (mirrors service-icon-cards) --}}
    @if (($section['alignment'] ?? '') === 'center')
        <div class="component-inner-section relative z-10">
            <div class="text-center mb-7">
                @if (!empty($section['subtitle']))
                    @php
                        $isPill = !empty($section['subtitle_display_as_pill']);
                        $isHollow = !empty($section['gradient_hollow_pill']);
                        $onDark = ($background['color'] ?? '') === 'dark';
                        $onLightG = ($background['color'] ?? '') === 'light-gradient';
                    @endphp

                    @if ($isPill)
                        <span
                            class="{{ $isHollow
                                ? 'pill-outline-gradient'
                                : ($onDark
                                    ? 'bg-brand text-action-light-blue'
                                    : 'text-action ' . ($onLightG ? 'bg-white' : 'bg-light mix-blend-multiply')) }}
             text-sm py-1 px-4 inline-block mb-6 rounded-full">
                            {{ $section['subtitle'] }}
                        </span>
                    @else
                        <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
                            {{ $section['subtitle'] }}
                        </span>
                    @endif
                @endif


                @if (!empty($section['title']))
                    <h2 class="mb-6">{!! $section['title'] !!}</h2>
                @endif

                @if (!empty($section['description']))
                    <div class="text-lg">{!! $section['description'] !!}</div>
                @endif

                @if (!empty($buttons))
                    @include('components.action-buttons', ['justify' => 'justify-center', 'mt' => 'mt-6'])
                @endif
            </div>
        </div>
    @elseif (($section['alignment'] ?? '') === 'left')
        <div class="component-inner-section">
            <div class="mb-8">
                @if (!empty($section['subtitle']))
                    <span class="block text-base mb-6 font-semibold uppercase tracking-wider text-action">
                        {{ $section['subtitle'] }}
                    </span>
                @endif
                @if (!empty($section['title']))
                    <h2 class="mb-6">{!! $section['title'] !!}</h2>
                @endif
                @if (!empty($section['description']))
                    <div class="text-lg">{!! $section['description'] !!}</div>
                @endif
                @if (!empty($buttons))
                    @include('components.action-buttons', ['justify' => 'justify-start', 'mt' => 'mt-6'])
                @endif
            </div>
        </div>
    @else
        <div class="component-inner-section">
            <div class="flex flex-col md:grid md:grid-cols-12 gap-6 mb-8">
                <div class="md:col-span-5">
                    @if (!empty($section['subtitle']))
                        <span class="block text-base mb-6 font-semibold uppercase tracking-wider text-action">
                            {{ $section['subtitle'] }}
                        </span>
                    @endif
                    @if (!empty($section['title']))
                        <h2 class="mb-0">{!! $section['title'] !!}</h2>
                    @endif
                </div>
                <div class="md:col-span-7 text-lg">
                    {!! $section['description'] ?? '' !!}
                    @if (!empty($buttons))
                        @include('components.action-buttons', [
                            'justify' => 'justify-start',
                            'mt' => 'mt-6',
                        ])
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Video + Side Text (expects $embed, $code_editor, $side_text, $video_link passed in) --}}
    <div class="component-inner-section relative z-10">
        <div class="grid lg:grid-cols-12 lg:gap-10 items-start">
            {{-- Video card --}}
            <div class="lg:col-span-8  order-2 lg:order-1">
                <div class="video-card relative rounded-2xl overflow-hidden shadow-2xl ring-1 ring-white/10 bg-white/5">

                    {{-- Video / Embed --}}
                    @if (!empty($embed))
                        <div class="responsive-embed {{ !empty($video_link) ? 'video-clickthrough' : '' }}">
                            {!! $embed !!}
                        </div>
                    @elseif (!empty($code_editor))
                        <div class="responsive-embed {{ !empty($video_link) ? 'video-clickthrough' : '' }}">
                            {!! $code_editor !!}
                        </div>
                    @else
                        <div class="aspect-video flex items-center justify-center text-sm opacity-70 p-8">
                            <span>No video embed provided.</span>
                        </div>
                    @endif

                    {{-- Always-visible centered play badge (visual only) --}}
                    <div class="play-badge absolute inset-0 z-40 pointer-events-none flex items-center justify-center">
                        <img src="@asset('/images/play-button-icon.svg')" alt="" aria-hidden="true"
                            class="h-16 w-16 md:h-20 md:w-20 drop-shadow-xl" />
                    </div>

                    {{-- If a link is provided, make the WHOLE card clickable --}}
                    @if (!empty($video_link['url']))
                        <a class="video-overlay absolute inset-0 z-30 block focus:outline-none"
                            href="{{ $video_link['url'] }}" target="{{ $video_link['target'] ?? '_self' }}"
                            rel="{{ isset($video_link['target']) && $video_link['target'] === '_blank' ? 'noopener noreferrer' : '' }}"
                            @if (!empty($video_link['title'])) aria-label="{{ e($video_link['title']) }}" @else aria-label="Open video" @endif>
                            <span class="sr-only">{{ $video_link['title'] ?? 'Open video' }}</span>
                        </a>
                    @endif
                </div>

            </div>

            {{-- Side text --}}
            @if (!empty($side_text))
                <div class="lg:col-span-4 mb-8 lg:mb-0 order-1 lg:order-2">
                    <div class="video-aside prose max-w-none @if (($background['color'] ?? '') === 'dark') prose-invert @endif">
                        {!! $side_text !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@if (!empty($background['divider_bottom']))
    @includeIf('dividers.waves-bottom')
@endif

<style>
  /* --- Stronger, wider glow for the video card --- */
  .video-default .video-card {
    /* optional slight card glow */
    box-shadow: 0 20px 70px rgb(255 255 255), 0 0 120px rgb(255 255 255);
    background: rgba(255, 255, 255, .06);
  }

  /* Play badge centered, never blocks clicks */
  .video-default .play-badge {
    pointer-events: none;
  }

  /* When an overlay link exists, stop the iframe/video from stealing clicks */
  .video-default .video-clickthrough iframe,
  .video-default .video-clickthrough video {
    pointer-events: none !important;
    height: auto;
    width: 100%;
  }

  /* Full-card overlay anchor */
  .video-default .video-overlay {
    cursor: pointer;
  }
  .video-default .video-overlay * {
    pointer-events: none;
  }

  /* Gradient hollow pill */
  .video-default .pill-outline-gradient {
    position: relative;
    display: inline-block;
    border-radius: 9999px;
    padding: .35rem 1rem; /* match your pill size */
    line-height: 1;
    color: #fff;          /* white text on dark header */
    background: transparent; /* hollow */
    filter: drop-shadow(0 2px 10px rgba(47, 113, 244, .25)); /* subtle glow */
  }
  .video-default .pill-outline-gradient::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    padding: 2px; /* border thickness */
    background: linear-gradient(90deg, #2F71F4 0%, #9643FF 100%);
    /* “hole” in the middle */
    -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
    -webkit-mask-composite: xor;
            mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            mask-composite: exclude;
    pointer-events: none;
  }
</style>
