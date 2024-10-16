@php
$global_alerts = get_field('alerts', 'options');
$global_alerts['section_classes'] = '!p-0 padding-collapse ';
@endphp
<!-- Schema.org Validation -->
<script type="application/ld+json">
  {!! json_encode([
      "@context" => "https://schema.org/",
      "@type" => "WebPage",
      "name" => get_the_title(),
      "speakable" => [
          "@type" => "SpeakableSpecification",
          "xpath" => [
              "/html/head/title",
              "/html/head/meta[@name='description']/@content"
          ]
      ],
      "url" => get_permalink()
  ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
<!-- End of Schema.org Validation -->

<div class="z-50" x-data="{ showSearchModal: false, showMobileMenu: false, isSticky: false, alertHeight: 0 }" x-init="
    alertHeight = $refs.alert ? $refs.alert.offsetHeight : 0;
    window.addEventListener('scroll', () => {
        isSticky = window.scrollY > alertHeight;
    });
    $watch('isSticky', value => {
        if (value) {
            $refs.nav.classList.add('fixed', 'top-0', 'left-0', 'w-full', 'z-50', 'shadow-md');
            $refs.placeholder.style.height = $refs.nav.offsetHeight + 'px';
        } else {
            $refs.nav.classList.remove('fixed', 'top-0', 'left-0', 'w-full', 'z-50', 'shadow-md');
            $refs.placeholder.style.height = '0px';
        }
    });
">
<script>
  document.addEventListener("DOMContentLoaded", function() {
      let iframes = document.querySelectorAll("iframe");
      let hasUniteusWidget = false;

      // Loop through iframes and check if src contains "widgets.uniteus.io"
      iframes.forEach(function(iframe) {
          if (iframe.src.includes("widgets.uniteus.io")) {
              hasUniteusWidget = true;
          }
      });

      // If iframe with "widgets.uniteus.io" exists, hide the global alerts
      if (hasUniteusWidget) {
          let alertElement = document.querySelector('[x-ref="alert"]');
          if (alertElement) {
              alertElement.style.display = 'none';
          }
      }
  });
</script>

@if (isset($global_alerts['description']) && !empty($global_alerts['description']))
  <div x-ref="alert">
      @includeIf('components.alerts.fullscreen', $global_alerts)
  </div>
@endif


  <!-- Placeholder to prevent content shift -->
  <div x-ref="placeholder" style="height: 0;"></div>

  <div id="nav" x-ref="nav" class="top-nav bg-white">
    <div class="mx-auto">
      <div class="flex relative justify-between items-center max-w-7xl mx-auto px-8 lg:justify-start">
        <div class="flex justify-start py-4 lg:w-0 lg:flex-1">
          <a href="/">
            <span class="sr-only">Main menu</span>
            <img fetchpriority="high" src="@asset('images/unite-us-logo.svg')" alt="Unite Us" width="192" height="48" />
          </a>
        </div>
        <div class="-mr-2 -my-2 flex items-center gap-3 lg:hidden">
          <!-- Trigger for Search Modal -->
          <button type="button" @click="showSearchModal = true" class="rounded-lg flex items-center justify-center">
            <span class="sr-only">Search site</span>
            <img src="@asset('images/nav-search.svg')" alt="" width="20" height="20" />
          </button>

          <!-- Trigger for Mobile Menu -->
          <button type="button"
            class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-action"
            @click="showMobileMenu = !showMobileMenu" aria-expanded="false"
            :aria-expanded="showMobileMenu.toString()">
            <span class="sr-only">Open menu</span>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
        <nav class="hidden lg:flex space-x-5 xl:space-x-10">
        @foreach ($mainMenuItems as $menu)
          @if ($menu['children'])
          <div class="relative group">
            <a href="{{ $menu['url'] }}"
              class="group bg-white rounded-md inline-flex items-center text-base font-medium py-4 hover:text-brand focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-action text-brand menu_click">
              <span>{{ $menu['title'] }}</span>
              <img class="ml-2" src="@asset('images/nav-chevron-down.svg')" alt="" width="20" height="20" />
            </a>
            <div class="absolute hidden group-focus:block group-hover:block z-50 left-1/2 transform -translate-x-1/2 mt-0 px-2 w-screen max-w-xs sm:px-0">
              <div class="rounded-lg !shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                  @foreach ($menu['children'] as $child)
                  <a href="{{ $child['url'] }}" class="-m-3 p-3 flex items-start rounded-lg hover:bg-light menu_click">
                    <span class="text-base font-medium text-brand">{{ $child['title'] }}</span>
                  </a>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          @else
          <a href="{{ $menu['url'] }}" class="text-base font-medium text-brand py-4 hover:text-brand"> {{ $menu['title'] }} </a>
          @endif
        @endforeach
        </nav>
        <div class="hidden lg:flex items-center justify-end lg:flex-1 lg:w-0">
          <a href="https://app.uniteus.io/" class="whitespace-nowrap text-base font-medium text-brand hover:text-brand"> Log In </a>
          <a href="/demo/" class="button button-solid-purple mx-6">Demo</a>
          <!-- Trigger for Search Modal -->
          <button type="button" @click="showSearchModal = true" class="rounded-lg flex items-center justify-center">
            <span class="sr-only">Search site</span>
            <img src="@asset('images/nav-search.svg')" alt="" width="20" height="20" />
          </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="showMobileMenu" class="absolute z-50 inset-x-0 p-2 transition transform origin-top-right lg:hidden" style="top:0; display: none;">
          <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
            <div class="pt-5 px-5">
              <div class="flex items-center justify-between">
                  <img fetchpriority="high" src="@asset('images/unite-us-logo.svg')" alt="Unite Us" width="192" height="48" />
                  <button type="button" class="bg-white rounded-md inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" @click="showMobileMenu = false">
                    <span class="sr-only">Close menu</span>
                    <img src="@asset('images/nav-close.svg')" alt="" width="24" height="24" />
                  </button>
              </div>
              <div class="mt-6">
                <ul class="list-none">
                  @foreach ($mainMenuItems as $menu)
                    @if ($menu['children'])
                    <li class="relative py-2" x-data="{ isOpen: false }">
                      <button type="button" class="text-left w-full" @click="isOpen = !isOpen">
                        <div class="flex items-center justify-between">
                          <span class="text-base font-medium text-brand">{{ $menu['title'] }}</span>
                          <img src="@asset('images/nav-chevron-down.svg')" alt="" width="20" height="20" />
                        </div>
                      </button>
                      <div class="relative overflow-hidden transition-all max-h-0 duration-700" x-ref="container" x-bind:style="isOpen ? 'max-height: ' + $refs.container.scrollHeight + 'px' : ''">
                        <div class="overflow-hidden">
                          <div class="relative grid gap-6 rounded-lg bg-light mb-2 mt-6 px-5 py-6 sm:gap-8 sm:p-8">
                          @foreach ($menu['children'] as $child)
                            <a href="{{ $child['url'] }}" class="-m-3 p-3 flex items-start rounded-lg hover:bg-light menu_click">
                              <span class="text-base font-medium text-brand">{{ $child['title'] }}</span>
                            </a>
                          @endforeach
                          </div>
                        </div>
                      </div>
                    </li>
                  @else
                    <li class="relative py-2">
                      <a href="{{ $menu['url'] }}" class="flex items-center rounded-md hover:bg-gray-50">
                        <span class="text-base font-medium text-brand"> {{ $menu['title'] }} </span>
                      </a>
                    </li>
                  @endif
                @endforeach
                </ul>
              </div>
            </div>
            <div class="py-6 px-5 space-y-6">
                <a href="/demo/" class="text-center button button-solid"> Demo </a>
                <p class="mt-6 text-center text-base font-medium">
                  Have an account already?
                  <a href="https://app.uniteus.io/"> Log in </a>
                </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('partials.content-search-modal')
  </div>
</div>
