

<footer class="footer-section component-section bg-blue-900" aria-labelledby="footer-heading">
  <h2 id="footer-heading" class="sr-only">Footer</h2>
  <div class="component-inner-section">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 lg:gap-8">
      <div class="mb-16 lg:mb-0">
        <h3 class="text-sm font-semibold text-blue-400 tracking-wider uppercase">Industries</h3>
        @if (has_nav_menu('footer_solutions'))
          {!!
            wp_nav_menu([
              'theme_location'  => 'footer_solutions',
              'menu_class'      => 'space-y-4 list-none',
              'echo'            => false,
              'link_class'      => 'text-white hover:text-white footer_click'
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
              'link_class'      => 'text-white hover:text-white footer_click'
            ])
          !!}
        @endif
      </div>

      <div class="mb-16 lg:mb-0">
        <h3 class="text-sm font-semibold text-blue-400 tracking-wider uppercase">Resources</h3>
        @if (has_nav_menu('footer_support'))
          {!!
            wp_nav_menu([
              'theme_location'  => 'footer_support',
              'menu_class'      => 'space-y-4 list-none',
              'echo'            => false,
              'link_class'      => 'text-white hover:text-white footer_click'
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
              'link_class'      => 'text-white hover:text-white footer_click'
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
      <div class="md:flex">
        <div class="pr-4">
          <p class="text-base text-white my-6 lg:my-0 md:order-1">&copy; {{ $currentYear }} Unite Us. All rights reserved.</p>
        </div>

          @if (has_nav_menu('footer_legal'))
            {!!
              wp_nav_menu([
                'theme_location'  => 'footer_legal',
                'menu_class'      => 'space-y-4 list-none flex items-center gap-4 footer-legal',
                'echo'            => false,
                'link_class'      => 'text-white hover:text-white footer_click'
              ])
            !!}
          @endif

    </div>
    </div>
  </div>
</footer>

@if (!is_singular('network'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/4.3.2/iframeResizer.min.js" integrity="sha512-dnvR4Aebv5bAtJxDunq3eE8puKAJrY9GBJYl9GC6lTOEC76s1dbDfJFcL9GyzpaDW4vlI/UjR8sKbc1j6Ynx6w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Run iframeResizer when the DOM is fully loaded
    iFrameResize({ log: false, crossOrigin: false, heightCalculationMethod:'lowestElement' }, '#formIframe iframe');
    setTimeout(function() {
      iFrameResize({
          log: false,
          crossOrigin: false,
          heightCalculationMethod: 'lowestElement'
      }, '#formIframe #iframe-container iframe');
    }, 1000); // 1000 milliseconds = 1 second
  });
</script>
@endif

