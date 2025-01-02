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

<div class="z-50" x-data="{ showSearchModal: false, showMobileMenu: false, isSticky: false, alertHeight: 0 }" x-init="alertHeight = $refs.alert ? $refs.alert.offsetHeight : 0;
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
});">
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
                <div class="flex justify-start py-4 lg:py-0 lg:w-0 lg:flex-1">
                    <a href="/">
                        <span class="sr-only">Main menu</span>
                        <img fetchpriority="high" src="@asset('images/unite-us-logo.svg')" alt="Unite Us" width="192"
                            height="48" />
                    </a>
                </div>
                <div class="lg:hidden -mr-2 -my-2 flex items-center gap-3">
                    <!-- Trigger for Search Modal -->
                    <button type="button" @click="showSearchModal = true"
                        class="rounded-lg flex items-center justify-center">
                        <span class="sr-only">Search site</span>
                        <img src="@asset('images/nav-search.svg')" alt="" width="20" height="20" />
                    </button>

                    <!-- Trigger for Mobile Menu -->
                    <button type="button"
                        class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-action"
                        @click="showMobileMenu = !showMobileMenu" aria-expanded="false"
                        :aria-expanded="showMobileMenu.toString()">
                        <span class="sr-only">Open menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <!-- Desktop Menu -->
                <nav class="hidden lg:flex items-center space-x-5 xl:space-x-10 desktop-nav">
                    @foreach ($mainMenuItems as $menu)
                        @if ($menu['children'])
                            <div
                                class="relative group flex {{ isset($menu['classes']) ? implode(' ', $menu['classes']) : '' }} ">
                                <a href="{{ $menu['url'] }}"
                                    class="group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-brand focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-action text-brand menu_click">
                                    <span>{{ $menu['title'] }}</span>
                                    <svg width="21" height="20" viewBox="0 0 21 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="transition-colors duration-300 fill-gray-500 group-hover:fill-action">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M6.2177 7.29289C6.60822 6.90237 7.24139 6.90237 7.63191 7.29289L10.9248 10.5858L14.2177 7.29289C14.6082 6.90237 15.2414 6.90237 15.6319 7.29289C16.0224 7.68342 16.0224 8.31658 15.6319 8.70711L11.6319 12.7071C11.2414 13.0976 10.6082 13.0976 10.2177 12.7071L6.2177 8.70711C5.82717 8.31658 5.82717 7.68342 6.2177 7.29289Z" />
                                    </svg>
                                </a>
                                <div
                                class="menu-wrapper absolute hidden group-focus:block group-hover:block z-50 left-1/2 transform -translate-x-1/2 mt-0 w-screen px-0 bg-gray-100">
                                    <div class="menu-wrapper-inner overflow-hidden">
                                        <div class="menu-item-wrapper relative grid gap-8 p-12 @if (isset($menu['classes']) && in_array('solutions', $menu['classes'])) solutions-menu-item-wrapper @endif">
                                            @foreach ($menu['children'] as $child)
                                                <div class="menu-item relative group @if (isset($menu['classes']) && in_array('solutions', $menu['classes'])) solutions-menu-item @endif">
                                                    <a href="{{ $child['url'] }}"
                                                        class="flex -m-3 p-3 menu_click {{ isset($child['classes']) ? implode(' ', $child['classes']) : '' }}">
                                                        @if (!empty($child['icon']))
                                                            <img src="{{ $child['icon'] }}" alt="{{ $child['title'] }} icon" class="w-8 h-8 mr-2" />
                                                        @endif
                                                        <span class="text-base font-semibold text-brand">{{ $child['title'] }}</span>
                                                        @if (isset($menu['classes']) && in_array('resources', $menu['classes']) && !empty($child['description']))
                                                            <div class="description text-sm text-gray-500 mt-2">
                                                                {{ $child['description'] }}
                                                            </div>
                                                        @endif
                                                    </a>
                                                    @if (!empty($child['children']))
                                                        <div class="sub-sub-menu-wrapper absolute hidden group-focus:block group-hover:block z-50 left-0 top-8 mt-0 sm:px-0">
                                                            <div class="overflow-hidden">
                                                                <div class="sub-sub-menu relative flex flex-col gap-6 px-8 py-8">
                                                                    @foreach ($child['children'] as $subChild)
                                                                        <a href="{{ $subChild['url'] }}"
                                                                            class="-m-3 p-3 flex items-start menu_click {{ isset($subChild['classes']) ? implode(' ', $subChild['classes']) : '' }}">

                                                                            @if (!empty($subChild['icon']))
                                                                                <div class="sub-sub-icon">
                                                                                  <img src="{{ $subChild['icon'] }}" alt="{{ $subChild['title'] }} icon"
                                                                                    class="w-5 h-5 mr-2" />
                                                                                </div>
                                                                            @endif
                                                                            <div class="sub-sub-item">
                                                                            <span class="text-base font-bold text-brand">{{ $subChild['title'] }}</span>
                                                                            @if (!empty($subChild['description']))
                                                                              <div class="description text-xs text-dark mt-2">
                                                                                  {{ $subChild['description'] }}
                                                                              </div>
                                                                            @endif
                                                                            </div>
                                                                        </a>
                                                                       
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- Add "Have questions? Let’s talk." only for the "company" menu --}}
                                          @if (isset($menu['classes']) && in_array('company', $menu['classes']))
                                          <div class="bg-gray-200 px-5 pt-4 pb-4 pl-12">
                                              <p class="text-base font-semibold text-gray-700 flex">
                                                  Have questions?&nbsp;
                                                  <a href="/contact" class="text-action flex items-center !underline gap-1">Let's talk.
                                                    <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.26562 1.19189L14.0739 7.00013L8.26562 12.8084" stroke="#216CFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M14.0744 6.99951L1.71777 6.99951" stroke="#216CFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                  </a>
                                              </p>
                                          </div>
                                          @endif
                                          {{-- Add "View All Resources" only for the "resources" menu --}}
                                          @if (isset($menu['classes']) && in_array('resources', $menu['classes']))
                                          <div class="bg-gray-200 px-5 pt-4 pb-4 pl-12 view-all">
                                              <p class="text-base flex">
                                                  <a href="/contact" class="text-gray-700 flex items-center gap-4 font-semibold ">View All Resources
                                                    <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.26562 1.19189L14.0739 7.00013L8.26562 12.8084" stroke="#216CFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M14.0744 6.99951L1.71777 6.99951" stroke="#216CFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                  </a>
                                              </p>
                                          </div>
                                          @endif
                                    </div>
                                    @php
                                    // Check if this menu item is "Resources"
                                    $is_resources_menu = isset($menu['classes']) && in_array('resources', $menu['classes']);
                                    if ($is_resources_menu) {
                                        // Fetch fields
                                        $featured_image = get_field('resources_featured_image', 'option');
                                        $featured_pill = get_field('resources_featured_pill', 'option');
                                        $featured_pill_subtext = get_field('resources_featured_pill_subtext', 'option');
                                        $featured_button = get_field('resources_featured_button', 'option');
                                    }
                                    @endphp

                                    @if ($is_resources_menu && $featured_image)
                                        <div class="featured-block relative bg-cover bg-center p-4 px-8" style="background-image: url('{{ $featured_image }}');">
                                            <div class="wrapper relative z-10 flex flex-col items-start">
                                                @if ($featured_pill)
                                                    <div class="pill p-1 rounded-full flex items-center gap-2">
                                                        <span class=" bg-dark text-white px-2 py-1 rounded-full uppercase font-semibold">{{ $featured_pill }}</span>
                                                        @if ($featured_pill_subtext)
                                                            <span class="text-white flex items-center pr-4 gap-2">{{ $featured_pill_subtext }} <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                              <path d="M8.8331 1.04004L13.6695 5.87642M13.6695 5.87642L8.8331 10.7128M13.6695 5.87642L0.772461 5.87642" stroke="white" stroke-width="0.905178" stroke-linecap="round" stroke-linejoin="round"/>
                                                              </svg>
                                                              </span>
                                                        @endif
                                                    </div>
                                                @endif
                                                @if ($featured_button && isset($featured_button['url']) && isset($featured_button['title']))
                                                    <a href="{{ $featured_button['url'] }}" class="btn bg-white text-dark font-semibold">
                                                        {{ $featured_button['title'] }} <svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                          <path d="M7.43219 0.887695L11.0747 4.53021M11.0747 4.53021L7.43219 8.17273M11.0747 4.53021L1.36133 4.53021" stroke="#2C405A" stroke-opacity="0.5" stroke-width="1.25793" stroke-linecap="round" stroke-linejoin="round"/>
                                                          </svg> 
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @else
                          <a href="{{ $menu['url'] }}"
                              class="text-base font-medium text-brand py-4 hover:text-brand"> {{ $menu['title'] }}
                          </a>
                        @endif
                    @endforeach
                </nav>
                <div class="hidden lg:flex items-center justify-end lg:flex-1 lg:w-0">
                    <a href="https://app.uniteus.io/"
                        class="whitespace-nowrap text-base font-medium text-brand hover:text-brand"> Log In </a>
                    <a href="/demo/" class="button button-solid-purple mx-6">Demo</a>
                    <!-- Trigger for Search Modal -->
                    <button type="button" @click="showSearchModal = true"
                        class="rounded-lg flex items-center justify-center">
                        <span class="sr-only">Search site</span>
                        <img src="@asset('images/nav-search.svg')" alt="" width="20" height="20" />
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div x-show="showMobileMenu"
                    class="lg:hidden absolute z-50 inset-x-0 p-2 transition transform origin-top-right"
                    style="top:0; display: none;">
                    <div
                        class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                        <div class="pt-5 pb-16 px-5">
                            <div class="flex items-center justify-between">
                                <img fetchpriority="high" src="@asset('images/unite-us-logo.svg')" alt="Unite Us" width="192"
                                    height="48" />
                                <button type="button"
                                    class="bg-white rounded-md inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                                    @click="showMobileMenu = false">
                                    <span class="sr-only">Close menu</span>
                                    <img src="@asset('images/nav-close.svg')" alt="" width="24" height="24" />
                                </button>
                            </div>
                            <div class="mt-6">
                                <ul class="list-none">
                                    @foreach ($mainMenuItems as $menu)
                                        @if ($menu['children'])
                                            <li class="relative py-2 {{ isset($menu['classes']) ? implode(' ', $menu['classes']) : '' }}"
                                                x-data="{ isOpen: false }">
                                                <button type="button" class="text-left w-full"
                                                    @click="isOpen = !isOpen">
                                                    <div class="flex items-center justify-between">
                                                        <span
                                                            class="text-base font-medium text-brand">{{ $menu['title'] }}</span>
                                                        <svg width="21" height="20" viewBox="0 0 21 20"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="transition-transform duration-300"
                                                            :class="isOpen ? 'rotate-180 text-blue-500' :
                                                                'rotate-0 text-gray-500'">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M6.2177 7.29289C6.60822 6.90237 7.24139 6.90237 7.63191 7.29289L10.9248 10.5858L14.2177 7.29289C14.6082 6.90237 15.2414 6.90237 15.6319 7.29289C16.0224 7.68342 16.0224 8.31658 15.6319 8.70711L11.6319 12.7071C11.2414 13.0976 10.6082 13.0976 10.2177 12.7071L6.2177 8.70711C5.82717 8.31658 5.82717 7.68342 6.2177 7.29289Z"
                                                                :fill="isOpen ? '#2563EB' : '#9CA3AF'" />
                                                        </svg>
                                                    </div>
                                                </button>
                                                <div class="relative overflow-hidden transition-all max-h-0 duration-700"
                                                    x-ref="container"
                                                    x-bind:style="isOpen ? 'max-height: ' + $refs.container.scrollHeight + 'px' : ''">
                                                    <div class="overflow-hidden">
                                                        <div
                                                            class="relative grid gap-6 rounded-lg bg-light mb-2 mt-6 px-5 py-6 sm:gap-8 sm:p-8">
                                                            @foreach ($menu['children'] as $child)
                                                                <a href="{{ $child['url'] }}"
                                                                    class="-m-3 p-3 flex items-start rounded-lg hover:bg-light menu_click {{ isset($child['class']) ? implode(' ', $child['class']) : '' }}">
                                                                    <span
                                                                        class="text-base font-medium text-brand">{{ $child['title'] }}</span>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @else
                                            <li class="relative py-2">
                                                <a href="{{ $menu['url'] }}"
                                                    class="flex items-center rounded-md hover:bg-gray-50 {{ isset($menu['classes']) ? implode(' ', $menu['classes']) : '' }}">
                                                    <span
                                                        class="text-base font-medium text-brand">{{ $menu['title'] }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="py-6 px-5 space-y-6">
                            <a href="/demo/" class="text-center button button-solid-purple"> Demo </a>
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
