
<div class="fixed inset-0 z-50 hidden items-center justify-center overflow-auto bg-brand bg-opacity-80" :class="{ 'hidden': ! showSearchModal, 'flex': showSearchModal }" x-show="showSearchModal">
  <div class="w-full max-w-4xl sm:p-10 mx-auto" @click.away="showSearchModal = false" x-transition:enter="motion-safe:ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
    <div class="flex items-center justify-end mb-10">
      <button type="button" class="z-10 rounded-full text-white p-1 border border-white cursor-pointer" @click="showSearchModal = false">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
    <div id="site-filters" class="ajax-filters search-filters relative z-20 mb-10">
      {!! do_shortcode('[searchandfilter slug="site-search"]') !!}
    </div>
  </div>
</div>
