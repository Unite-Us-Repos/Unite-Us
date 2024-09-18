

<footer class="footer-section component-section bg-blue-900" aria-labelledby="footer-heading">
  <h2 id="footer-heading" class="sr-only">Footer</h2>
  <div class="component-inner-section">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 lg:gap-8">
      <div class="mb-16 lg:mb-0">
        <h3 class="text-sm font-semibold text-blue-400 tracking-wider uppercase">Solutions</h3>
        @if (has_nav_menu('footer_solutions'))
          {!!
            wp_nav_menu([
              'theme_location'  => 'footer_solutions',
              'menu_class'      => 'space-y-4 list-none',
              'echo'            => false,
              'link_class'      => 'text-white hover:text-white'
            ])
          !!}
        @endif
      </div>

      <div class="mb-16 lg:mb-0">
        <h3 class="text-sm font-semibold text-blue-400 tracking-wider uppercase">Products</h3>
        @if (has_nav_menu('footer_products'))
          {!!
            wp_nav_menu([
              'theme_location'  => 'footer_products',
              'menu_class'      => 'space-y-4 list-none',
              'echo'            => false,
              'link_class'      => 'text-white hover:text-white'
            ])
          !!}
        @endif
      </div>

      <div class="mb-16 lg:mb-0">
        <h3 class="text-sm font-semibold text-blue-400 tracking-wider uppercase">Support</h3>
        @if (has_nav_menu('footer_support'))
          {!!
            wp_nav_menu([
              'theme_location'  => 'footer_support',
              'menu_class'      => 'space-y-4 list-none',
              'echo'            => false,
              'link_class'      => 'text-white hover:text-white'
            ])
          !!}
        @endif
      </div>

      <div class="mb-16 lg:mb-0">
        <h3 class="text-sm font-semibold text-blue-400 tracking-wider uppercase">Company</h3>
        @if (has_nav_menu('footer_company'))
          {!!
            wp_nav_menu([
              'theme_location'  => 'footer_company',
              'menu_class'      => 'space-y-4 list-none',
              'echo'            => false,
              'link_class'      => 'text-white hover:text-white'
            ])
          !!}
        @endif
      </div>

      <div class="mb-16 lg:mb-0">
        <h3 class="text-sm font-semibold text-blue-400 tracking-wider uppercase">Legal</h3>
        @if (has_nav_menu('footer_legal'))
          {!!
            wp_nav_menu([
              'theme_location'  => 'footer_legal',
              'menu_class'      => 'space-y-4 list-none',
              'echo'            => false,
              'link_class'      => 'text-white hover:text-white'
            ])
          !!}
        @endif
      </div>

      <div class="">
        <h3 class="text-sm font-semibold text-blue-400 tracking-wider uppercase">Language</h3>
        <div class="styled-select">
          {!! do_shortcode('[gtranslate]') !!}
        </div>
      </div>
    </div>
    <div class="border-y border-gray-700 py-10 lg:flex lg:items-center lg:justify-between my-10 lg:my-20 lg:mb-14">
      <div>
        <h3 class="text-sm font-semibold text-blue-400 tracking-wider uppercase">Join our newsletter</h3>
        <p class="text-base text-white">The latest news, articles, and resources, sent right to your inbox.</p>
      </div>
      <div class="newsletter">
        <iframe src="https://marketing.uniteus.com/l/1001871/2022-12-15/31f9" width="100%" type="text/html" frameborder="0" allowTransparency="true" style="border: 0" title="Join our Newsletter"></iframe>
      </div>
    </div>
    <div class="md:flex md:items-center md:justify-between">
      <div class="flex space-x-6 md:order-2">

        @if ($socialMediaIcons)
          @foreach ($socialMediaIcons as $social)
            <a href="{{ $social['url'] }}" target="_blank" class="text-white hover:text-blue-400">
              <span class="sr-only">{{ $social['label'] }}</span>
              <img class="h-5 w-auto" src="{{ $social['icon'] }}" alt="{{ $social['label'] }} logo" />
            </a>

            @endforeach
        @endif

      </div>
      <p class="text-base text-white my-6 lg:my-0 md:order-1">&copy; {{ $currentYear }} Unite Us. All rights reserved.
      </p>
    </div>
  </div>
</footer>

@if (!is_singular('network'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/4.3.2/iframeResizer.min.js" integrity="sha512-dnvR4Aebv5bAtJxDunq3eE8puKAJrY9GBJYl9GC6lTOEC76s1dbDfJFcL9GyzpaDW4vlI/UjR8sKbc1j6Ynx6w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  iFrameResize({ log: false, crossOrigin: false, heightCalculationMethod:'lowestElement' }, '#formIframe iframe');
  setTimeout(function() {
    iFrameResize({ 
        log: false, 
        crossOrigin: false, 
        heightCalculationMethod: 'lowestElement' 
    }, '#formIframe #iframe-container iframe');
}, 1000); // 1000 milliseconds = 1 second

</script>
@endif

@if (!is_page('thank-you'))
<script>
  function hasJsonStructure(str) {
    if (typeof str !== 'string') return false;
    try {
        const result = JSON.parse(str);
        const type = Object.prototype.toString.call(result);
        return type === '[object Object]'
            || type === '[object Array]';
    } catch (err) {
        return false;
    }
}
window.addEventListener('message', function(event) {
  try {
    if (typeof event === 'object' && hasJsonStructure(event.data)) {

      const data = JSON.parse(event.data);
      if ('success' == data.pardot) {
        const download = data.download;
        const waiting = '<div class="fixed inset-0 z-50 items-center justify-center overflow-auto bg-brand bg-opacity-80 flex"><div class="flex items-center h-screen"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"> <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle> <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3647z"></path></svg><p class="text-2xl text-white mr-4 mb-0">Please wait...</p></div></div>';
        document.body.classList.add('relative');
        document.body.insertAdjacentHTML('beforeend', waiting);
        window.location.href = '/thank-you/{{ $postSlug }}/?doc=' + download;
      }
    }
  } catch (err) {
    console.error(err);
  }
});
</script>
@endif

