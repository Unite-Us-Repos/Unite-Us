@php
  // Ensure a stable, unique component scope id
  if (!isset($component_index)) {
    $component_index = isset($index) ? $index : (function_exists('wp_unique_id') ? wp_unique_id('cmp_') : uniqid('cmp_'));
  }
@endphp

{{-- resources/views/components/logo-downloader/default.blade.php --}}
@php
  $rows = $downloader_row ?? [];
  $section_settings = $section_settings ?? ['collapse_padding' => false, 'padding_class' => '', 'fullscreen' => ''];
  $section_classes  = $section_classes  ?? '';

  // Label helper (handles .zip -> "EPS (ZIP)")
  $formatLabel = function (array $file) {
    $mime = strtolower($file['mime_type'] ?? '');
    $url  = $file['url'] ?? '';
    $name = $file['filename'] ?? basename(parse_url($url, PHP_URL_PATH) ?? '');
    $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if ($ext === 'zip') {
      $base = strtolower(pathinfo($name, PATHINFO_FILENAME));
      if (str_contains($base, 'eps')) return 'EPS (ZIP)';
      if (str_contains($base, 'svg')) return 'SVG (ZIP)';
      if (str_contains($base, 'pdf')) return 'PDF (ZIP)';
      if (str_contains($base, 'png')) return 'PNG (ZIP)';
      if (str_contains($base, 'jpg') || str_contains($base, 'jpeg')) return 'JPEG (ZIP)';
      return 'ZIP';
    }
    if (str_contains($mime, 'png') || $ext === 'png')   return 'PNG';
    if (str_contains($mime, 'jpeg') || in_array($ext, ['jpg','jpeg'])) return 'JPEG';
    if (str_contains($mime, 'svg') || $ext === 'svg')   return 'SVG';
    if (str_contains($mime, 'pdf') || $ext === 'pdf')   return 'PDF';
    if (str_contains($mime, 'eps') || $ext === 'eps')   return 'EPS';
    return strtoupper($ext ?: 'FILE');
  };

  // Keep downloads same-origin
  $toRelative = function ($absUrl) {
    if (function_exists('wp_make_link_relative')) {
      return wp_make_link_relative($absUrl) ?: $absUrl;
    }
    return wp_parse_url($absUrl, PHP_URL_PATH) ?: $absUrl;
  };
@endphp

@if (!empty($background['has_divider'])) @includeIf('dividers.waves') @endif

<section class="component-section {{ $section_classes }} @if (!empty($section_settings['collapse_padding'])) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section @if (!empty($section_settings['fullscreen'])) fullscreen @endif">
    <div class="space-y-12">
      @foreach ($rows as $i => $row)
        @php
          $heading    = $row['heading'] ?? '';
          $subheading = $row['subheading'] ?? '';
          $icon       = $row['icon']['url'] ?? '';
          $logo       = $row['logo']['url'] ?? '';
          $isDark     = !empty($row['logo_dark_background']);

          // Build dropdown options from repeater
          $options = []; // label => ['url'=>..., 'download'=>...]
          foreach (($row['image_format'] ?? []) as $fmt) {
            $file = $fmt['logo_file'] ?? null;
            if (!is_array($file) || empty($file['url'])) continue;
            $label = $formatLabel($file);
            $url   = $toRelative($file['url']);
            $dl    = $file['filename'] ?? basename(parse_url($file['url'], PHP_URL_PATH) ?: 'asset');
            $base = $label; $n = 2;
            while (isset($options[$label])) { $label = $base.' #'.$n++; }
            $options[$label] = ['url'=>$url, 'download'=>$dl];
          }

          $cardId = 'logo-dl-'.($component_index ?? 0).'-'.$i;
        @endphp

        <div id="{{ $cardId }}" class="grid grid-cols-1 lg:grid-cols-12 gap-6" data-logo-dl>
          {{-- LEFT: title + controls --}}
          <div class="lg:col-span-3">
            <div class="mb-1 flex items-baseline gap-8">
              <div class="mb-4">
                @if ($heading)<h3 class="font-semibold mb-0">{{ $heading }}</h3>@endif
                @if ($subheading)<p class="text-md mb-3">{{ $subheading }}</p>@endif
              </div>
              @if ($icon)<img src="{{ esc_url($icon) }}" alt="" class="h-4 w-4 object-contain">@endif
            </div>

            <div class="flex flex-col gap-3">
              <label for="{{ $cardId }}-select" class="sr-only">Select a format</label>
              <div class="relative">
                <select id="{{ $cardId }}-select"
                        class="appearance-none w-full h-11 rounded-lg border border-slate-300 bg-white px-3 pr-10 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        data-dl-select @disabled(empty($options))>
                  <option value="" selected disabled>{{ empty($options) ? 'No files available' : 'Select an Option' }}</option>
                  @foreach ($options as $label => $meta)
                    <option value="{{ esc_url($meta['url']) }}" data-download="{{ esc_attr($meta['download']) }}">
                      {{ $label }} Format
                    </option>
                  @endforeach
                </select>
                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                <img
                    src="{{ esc_url( get_theme_file_uri('resources/icons/select-icon.svg') ) }}"
                    alt=""
                    aria-hidden="true"
                    class="h-2 w-2"
                >
                </span>
              </div>

              {{-- Start fully disabled --}}
              <a href="#"
                 class="button button-solid w-full lg:w-40 h-11 inline-flex items-center justify-center gap-2 opacity-50 pointer-events-none cursor-not-allowed"
                 disabled aria-disabled="true"
                 data-dl-btn>
                <span>Download</span>
                <img src="{{ esc_url( get_theme_file_uri('resources/icons/download.svg') ) }}" alt="" aria-hidden="true" class="h-4 w-4">
              </a>
            </div>
          </div>

          {{-- RIGHT: preview --}}
          <div class="lg:col-span-9">
            <div class="flex items-center justify-center rounded-2xl p-6 border h-64 @if($isDark) bg-black @else bg-white @endif">
              @if ($logo)
                <div class="h-24 w-full flex items-center justify-center">
                  <img src="{{ esc_url($logo) }}" alt="{{ esc_attr($heading) }}" class="max-h-full w-auto object-contain">
                </div>
              @else
                <div class="h-24 flex items-center justify-center text-slate-400"><span>No preview set</span></div>
              @endif
            </div>
          </div>
        </div>

        {{-- Scoped behavior --}}
        <script type="module">
          (() => {
            const root   = document.getElementById(@json($cardId));
            if (!root) return;
            const select = root.querySelector('[data-dl-select]');
            const btn    = root.querySelector('[data-dl-btn]');
            if (!select || !btn) return;

            const enable = (url, filename) => {
              btn.href = url;
              if (filename) btn.setAttribute('download', filename);
              btn.removeAttribute('disabled');
              btn.removeAttribute('aria-disabled');
              btn.classList.remove('opacity-50','pointer-events-none','cursor-not-allowed');
            };
            const disable = () => {
              btn.href = '#';
              btn.removeAttribute('download');
              btn.setAttribute('disabled','');
              btn.setAttribute('aria-disabled','true');
              btn.classList.add('opacity-50','pointer-events-none','cursor-not-allowed');
            };

            const setState = () => {
              const opt = select.options[select.selectedIndex];
              if (opt && opt.value) {
                enable(opt.value, opt.getAttribute('data-download') || 'download');
              } else {
                disable();
              }
            };

            select.addEventListener('change', setState);
            setState(); // stay disabled until a real option is chosen
          })();
        </script>
      @endforeach
    </div>
  </div>
</section>

{{-- single-caret fix --}}
<style>select{-webkit-appearance:none;-moz-appearance:none;appearance:none}</style>
