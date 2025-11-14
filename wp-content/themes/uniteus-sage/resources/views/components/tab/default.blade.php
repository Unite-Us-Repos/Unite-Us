{{-- resources/views/components/tab-default.blade.php --}}

@php
  // ----------------------------
  // Safe defaults / settings
  // ----------------------------
  $s_settings = ['collapse_padding' => false, 'fullscreen' => ''];
  $section_settings = $acf['components'][$index]['layout_settings']['section_settings'] ?? $s_settings;

  // The ACF group is stored under "tab"
  $tab_group = $acf['components'][$index]['tab'] ?? [];

  // Info clone (same contract as other components)
  $section   = $section
    ?? ($acf['components'][$index]['info'] ?? [])
    ?? ($tab_group['info'] ?? []);

  // Global buttons (clone)
  $buttons   = $buttons
    ?? ($acf['components'][$index]['action_buttons']['buttons'] ?? [])
    ?? ($tab_group['action_buttons']['buttons'] ?? []);

  // Background (clone)
  $background = $background
    ?? ($acf['components'][$index]['background'] ?? [])
    ?? ($tab_group['background'] ?? []);

  // Tab nav + content repeaters
  $tab_nav     = $tab_group['tab_nav']     ?? [];
  $tab_content = $tab_group['tab_content'] ?? [];

  // If nav not provided, derive labels from content headings
  if (empty($tab_nav) && !empty($tab_content)) {
    $tab_nav = array_map(function($row, $i){
      return ['tab' => !empty($row['heading']) ? wp_strip_all_tags($row['heading']) : 'Tab '.($i+1)];
    }, $tab_content, array_keys($tab_content));
  }

  // Accessibility ids
  $uid = 'tabs-' . ($section['id'] ?? $index);
  $align = $section['alignment'] ?? 'center';
@endphp

@if (!empty($background['has_divider']))
  @includeIf('dividers.waves')
@endif

<section
  @isset($section['id']) id="{{ $section['id'] }}" @endisset
  class="tab-default relative component-section {{ $section_classes ?? '' }}
         @if (($background['color'] ?? '') === 'dark') text-white @endif
         @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] ?? '' }} @endif">

  {{-- Optional background image --}}
  @if (!empty($background['image']))
    <div class="absolute inset-0">
      <img
        fetchpriority="high"
        class="w-full h-full object-cover
               @if (($background['position'] ?? '') === 'top') object-top @endif
               @if (($background['position'] ?? '') === 'bottom') object-bottom @endif"
        src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    </div>
  @endif

  {{-- Header / Info --}}
  <div class="component-inner-section relative z-10">
    @if ($align === 'center')
      <div class="text-center max-w-4xl mx-auto mb-8">
        @if (!empty($section['subtitle']))
          @php $is_hollow = !empty($section['gradient_hollow_pill']); @endphp
          @if (!empty($section['subtitle_display_as_pill']) || $is_hollow)
            <span class="@if($is_hollow) pill-outline-gradient @else text-action @if (($background['color'] ?? '') === 'light-gradient') bg-white @else bg-light mix-blend-multiply @endif @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
              {{ $section['subtitle'] }}
            </span>
          @else
            <span class="block text-base mb-6 font-semibold uppercase tracking-wider text-action">
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
    @elseif ($align === 'left')
      <div class="mb-8">
        @if (!empty($section['subtitle']))
          @php $is_hollow = !empty($section['gradient_hollow_pill']); @endphp
          @if (!empty($section['subtitle_display_as_pill']) || $is_hollow)
            <span class="@if($is_hollow) pill-outline-gradient @else text-action @if (($background['color'] ?? '') === 'light-gradient') bg-white @else bg-light mix-blend-multiply @endif @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
              {{ $section['subtitle'] }}
            </span>
          @else
            <span class="block text-base mb-6 font-semibold uppercase tracking-wider text-action">
              {{ $section['subtitle'] }}
            </span>
          @endif
        @endif

        @if (!empty($section['title'])) <h2 class="mb-6">{!! $section['title'] !!}</h2> @endif
        @if (!empty($section['description'])) <div class="text-lg">{!! $section['description'] !!}</div> @endif
        @if (!empty($buttons)) @include('components.action-buttons', ['justify' => 'justify-start', 'mt' => 'mt-6']) @endif
      </div>
    @else
      <div class="flex flex-col md:grid md:grid-cols-12 gap-6 mb-8">
        <div class="md:col-span-5">
          @if (!empty($section['subtitle']))
            <span class="block text-base mb-6 font-semibold uppercase tracking-wider text-action">
              {{ $section['subtitle'] }}
            </span>
          @endif
          @if (!empty($section['title'])) <h2 class="mb-0">{!! $section['title'] !!}</h2> @endif
        </div>
        <div class="md:col-span-7 text-lg">
          {!! $section['description'] ?? '' !!}
          @if (!empty($buttons)) @include('components.action-buttons', ['justify' => 'justify-start', 'mt' => 'mt-6']) @endif
        </div>
      </div>
    @endif

    {{-- Tabs --}}
    @if (!empty($tab_nav) && !empty($tab_content))
      <div x-data="{ active: 0 }" class="tabs-wrapper">
        {{-- Tab Nav --}}
        <div class="tabs-nav mx-auto max-w-5xl mb-10">
          <div class="pill-rail" role="tablist" aria-label="Tabs {{ $uid }}">
            @foreach ($tab_nav as $i => $item)
              @php
                $label = trim($item['tab'] ?? ('Tab '.($i+1)));
                $tabId = $uid . '-tab-' . $i;
                $panelId = $uid . '-panel-' . $i;
              @endphp
              <button
                type="button"
                :class="active === {{ $i }} ? 'pill active' : 'pill'"
                role="tab"
                :aria-selected="(active === {{ $i }}) ? 'true' : 'false'"
                aria-controls="{{ $panelId }}"
                id="{{ $tabId }}"
                @click="active = {{ $i }}"
              >
                <span class="label">{{ $label }}</span>
              </button>
            @endforeach
          </div>
        </div>

        {{-- Panels --}}
        <div class="space-y-12">
          @foreach ($tab_content as $i => $row)
            @php
              $heading     = $row['heading']     ?? '';
              $desc        = $row['description']  ?? '';
              $leftButtons = $row['buttons']['buttons'] ?? [];

              $image       = $row['image']        ?? [];
              $code        = $row['code_editor']  ?? '';
              $wysiwyg     = $row['wysiwyg']      ?? '';
              $accordion   = $row['accordion']    ?? [];
              $panelId     = $uid . '-panel-' . $i;
              $tabId       = $uid . '-tab-' . $i;
            @endphp

            <div
              x-show="active === {{ $i }}"
              role="tabpanel"
              :aria-labelledby="'{{ $tabId }}'"
              id="{{ $panelId }}"
              class="panel grid grid-cols-1 lg:grid-cols-12 gap-10 items-center"
            >
              {{-- Left column --}}
              <div class="lg:col-span-6">
                @if (!empty($heading))
                  <h3 class="mb-4 text-2xl font-semibold">{!! $heading !!}</h3>
                @endif

                @if (!empty($desc))
                  <div class="prose max-w-none text-lg">{!! $desc !!}</div>
                @endif

                @if (!empty($leftButtons))
                  <div class="mt-6">
                    @include('components.action-buttons', ['buttons' => $leftButtons, 'justify' => 'justify-start'])
                  </div>
                @endif
              </div>

              {{-- Right column (image / code / wysiwyg / accordion) --}}
              <div class="lg:col-span-6">
                @if (!empty($code))
                  <div class="rounded-lg overflow-hidden responsive-embed">{!! $code !!}</div>
                @elseif (!empty($image['sizes']))
                  <img
                    class="rounded-lg w-full h-auto object-cover"
                    src="{{ $image['sizes']['medium_large'] }}"
                    alt="{{ $image['alt'] ?? '' }}">
                @elseif (!empty($wysiwyg))
                  <div class="wysiwyg-content text-lg">{!! $wysiwyg !!}</div>
                @elseif (!empty($accordion) && is_iterable($accordion))
                  <div class="accordion accordion-vertical" x-data="{ open: -1 }">
                    <ul class="list-none m-0 p-0">
                      @foreach ($accordion as $ai => $a)
                        <li class="relative py-5 px-6 mb-4 bg-white/5 rounded-lg border border-action @if(($background['color'] ?? '')==='dark') text-white @endif"
                            :class="{ 'open': open === {{ $ai }} }">
                          <button type="button" class="w-full text-left font-semibold"
                                  @click="open !== {{ $ai }} ? open = {{ $ai }} : open = -1">
                            {{ $a['heading'] ?? '' }}
                          </button>
                          <div class="overflow-hidden transition-all max-h-0"
                               x-ref="acc{{ $i }}{{ $ai }}"
                               x-bind:style="open === {{ $ai }} ? 'max-height: ' + $refs.acc{{ $i }}{{ $ai }}.scrollHeight + 'px' : ''">
                            <div class="mt-4 pt-4 border-top text-base">
                              {!! wpautop($a['description'] ?? '') !!}
                            </div>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                @else
                  <div class="rounded-lg bg-white/5 border border-white/10 p-8 text-sm opacity-80">
                    No media provided for this tab.
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>

@if (!empty($background['divider_bottom']))
  @includeIf('dividers.waves-bottom')
@endif

<style>
  /* =========================
     Subtitle hollow pill (scoped)
     ========================= */
  .tab-default .pill-outline-gradient{
    background:transparent;
    color:currentColor;
    border-radius:9999px;
    padding:.25rem .9rem;
    position:relative;
    display:inline-block;
  }
  .tab-default .pill-outline-gradient::before{
    content:'';
    position:absolute; inset:0;
    border-radius:9999px;
    padding:1.5px;
    background:linear-gradient(90deg,#2F71F4 0%,#9643FF 100%);
    -webkit-mask:linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite:xor;
            mask:linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite:exclude;
    pointer-events:none;
  }

  /* =========================
     TAB NAV – Figma style (scoped)
     ========================= */
  .tab-default .tabs-nav{ display:flex; justify-content:center; }
  .tab-default .tabs-nav .pill-rail{
    display:flex; gap:28px; align-items:center; justify-content:center;
    padding:12px 18px; border-radius:9999px;
    background:#EAF0F7; border:1px solid #D7E2EF;
    box-shadow:
      inset 0 1px 0 rgba(255,255,255,.65),
      inset 0 -6px 14px rgba(35,48,74,.06),
      0 2px 8px rgba(16,24,40,.06);
  }
  .tab-default .tabs-nav .pill{
    position:relative; appearance:none; border:0; background:transparent; cursor:pointer;
    border-radius:9999px; padding:12px 24px;
    transition: background-color .15s ease, box-shadow .15s ease, transform .02s ease;
  }
  .tab-default .tabs-nav .pill .label{
    font-weight:700; font-size:20px; line-height:1;
    color:#23304A; transition: color .12s ease, background .12s ease;
  }
  .tab-default .tabs-nav .pill:hover .label,
  .tab-default .tabs-nav .pill:focus-visible .label{
    background-image:linear-gradient(90deg,#2F71F4 0%, #9643FF 100%);
    -webkit-background-clip:text; background-clip:text;
    -webkit-text-fill-color:transparent; color:transparent;
  }
  .tab-default .tabs-nav .pill.active{
    background:#fff;
    box-shadow:
      0 10px 30px rgba(47,113,244,.08),
      0 4px 12px rgba(16,24,40,.08);
  }
  .tab-default .tabs-nav .pill.active .label{
    background-image:linear-gradient(90deg,#2F71F4 0%, #9643FF 100%);
    -webkit-background-clip:text; background-clip:text;
    -webkit-text-fill-color:transparent; color:transparent;
  }
  .tab-default .tabs-nav .pill:focus-visible{
    outline:2px solid rgba(47,113,244,.45);
    outline-offset:2px;
  }
  .tab-default .tabs-nav .pill:hover{ transform:translateY(-1px); }
  .tab-default .tabs-nav .pill:active{ transform:translateY(0); }

  @media (max-width: 640px){
    .tab-default .tabs-nav .pill-rail{ gap:12px; padding:10px 12px; }
    .tab-default .tabs-nav .pill{ padding:10px 16px; }
    .tab-default .tabs-nav .pill .label{ font-size:16px; }
  }

  /* =========================
     Panels – instant swap
     ========================= */
  .tab-default .panel{ transition:none !important; }

  /* =========================
     Embeds
     ========================= */
  .tab-default .responsive-embed iframe,
  .tab-default .responsive-embed video{
    width:100%; height:100%;
    aspect-ratio:16/9; display:block;
  }

  /* minor border alias used in accordion */
  .tab-default .border-top{ border-top:1px solid rgba(255,255,255,.10); }
</style>
