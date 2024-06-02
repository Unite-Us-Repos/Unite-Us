@if (isset($display))
@php
if (!is_array($display)) {
  $display = [];
}
@endphp
@if (in_array($post->ID, $display) or empty($display))
<style>
.alert .action-button {
  padding: 8px 17px;
  font-weight: 500;
  width: 100%;
}
.alert .button-hollow-white:hover {
  background: #fff;
  color: #2c405a !important;
  border: solid 1px #fff !important;
}
</style>
<section x-data="{hideAlert: localStorage.getItem('hideUuGlobalAlert') === '{{ $unique_id }}' }" x-bind:class="{'hidden' : hideAlert == true }" class="relative component-section alert !p-0" style="@isset ($text_color) color: {{ $text_color }}; @endisset @isset($background_color) background: {{ $background_color }}; @endisset">
  <div class="component-inner-section !p-0">
    <div type="{{ $style }}" class="py-4 px-6 md:px-8">
      <div class="flex flex-col sm:flex-row gap-3">
        <div class="w-full flex md:items-center gap-4">
          <div class="flex flex-shrink-0 pt-1">

            @if ('custom' == $style)
              @isset ($icon)
                <img class="h-6 w-6" src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $icon }}.svg" alt="" />
              @endif
            @endif

            @if ('error' == $style)
              <!-- Heroicon name: mini/x-circle -->
              <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
              </svg>
            @endif

            @if ('info' == $style)
              <!-- Heroicon name: mini/information-circle -->
              <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
              </svg>
            @endif

            @if ('success' == $style)
              <!-- Heroicon name: mini/check-circle -->
              <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
              </svg>
            @endif

            @if ('warning' == $style)
              <!-- Heroicon name: mini/exclamation-triangle -->
              <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
              </svg>
            @endif

          </div>
          <div class="flex gap-4 flex-col sm:flex-row items-center justify-between w-full">

            @if ($title)
            <h3 class="mb-0 text-lg font-bold">{!! $title !!}</h3>
            @endif

            @if ($description)
            <div class="flex-1 pr-6 sm:p-0 leading-tight">
              {!! $description !!}
            </div>
            @endif
            </div>
            </div>

            <div class="flex-shrink-0">
              @include('components.action-buttons', ['isAlert' => true, 'buttons' => $buttons, 'style' => 'simple-justified', 'mt' => 'mt-0'])
            </div>

            <div class="flex-shrink-0 flex items-center absolute top-0 right-0 mt-4 mr-4 sm:m-0 sm:relative">
              <svg @click="localStorage.setItem('hideUuGlobalAlert', '{{ $unique_id }}'); hideAlert = true" xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                <path d="M6.5 18L18.5 6M6.5 6L18.5 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>

      </div>
    </div>
  </div>
</section>
@endif
@endif
