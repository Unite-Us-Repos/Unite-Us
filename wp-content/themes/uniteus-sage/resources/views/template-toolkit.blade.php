@php
/**
 * Template Name: Toolkit
 * Template Post Type: page
 */
@endphp
@extends('layouts.app')

@section('content')
@php
  $icons_uri = get_stylesheet_directory_uri() . '/resources/icons';   

  // Build the left menu from ACF → toolkit_page (first "hero" title per page)
  $pagesData = get_field('toolkit_page') ?: [];
  $menuItems = []; // index => ['id' => 'anchor', 'title' => '...']

  foreach ($pagesData as $idx => $p) {
    $pageId     = trim($p['page_id'] ?? '');
    $components = $p['components'] ?? [];
    $heroTitle  = '';

    foreach ($components as $comp) {
      if (($comp['acf_fc_layout'] ?? '') === 'hero') {
        $heroTitle = trim($comp['title'] ?? '');
        break;
      }
    }

    // Anchor preference: explicit page_id → slug(hero title) → numbered fallback
    if ($pageId !== '') {
      $anchor = $pageId;
    } elseif ($heroTitle !== '') {
      $anchor = 'toolkit-' . sanitize_title($heroTitle);
    } else {
      $anchor = 'toolkit-section-' . ($idx + 1);
    }

    $menuItems[$idx] = [
      'id'    => $anchor,
      'title' => $heroTitle !== '' ? $heroTitle : ('Section ' . ($idx + 1)),
    ];
  }
@endphp

<article class="report bg-light">
  <div class="flex flex-col lg:flex-row content-width">

    {{-- LEFT MENU --}}
    <section class="report-menu-wrapper-outer w-full lg:w-1/4 lg:mt-8 lg:relative lg:ml-6 z-50 lg:z-10">
      <div class="report-menu-wrapper">
        <!-- Mobile menu toggle -->
        <div
          class="report-mobile-menu-wrap flex w-full justify-between items-center hidden p-4 px-8 fixed lg:relative top-[80px] left-0 right-0 z-40 bg-white shadow-md"
          id="reportMobileMenuToggle">
          <span class="text-white">Jump To</span>
          <span>
            <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M4 0C4.26522 5.96046e-08 4.51957 0.105357 4.70711 0.292893L7.70711 3.29289C8.09763 3.68342 8.09763 4.31658 7.70711 4.70711C7.31658 5.09763 6.68342 5.09763 6.29289 4.70711L4 2.41421L1.70711 4.70711C1.31658 5.09763 0.683417 5.09763 0.292893 4.70711C-0.0976311 4.31658 -0.097631 3.68342 0.292893 3.29289L3.29289 0.292893C3.48043 0.105357 3.73478 0 4 0ZM0.292893 9.29289C0.683417 8.90237 1.31658 8.90237 1.70711 9.29289L4 11.5858L6.29289 9.29289C6.68342 8.90237 7.31658 8.90237 7.70711 9.29289C8.09763 9.68342 8.09763 10.3166 7.70711 10.7071L4.70711 13.7071C4.31658 14.0976 3.68342 14.0976 3.29289 13.7071L0.292893 10.7071C-0.0976311 10.3166 -0.0976311 9.68342 0.292893 9.29289Z"
                fill="white" />
            </svg>
          </span>
        </div>

        <!-- Menu panel -->
        <div id="reportMobileMenu"
          class="report-menu bg-white fixed top-[130px] rounded-2xl left-0 lg:static lg:block lg:w-auto lg:rounded-lg lg:shadow-lg z-50 lg:z-10 shadow-md hidden overflow-auto lg:overflow-visible">

          <!-- Close (X) -->
          <div class="flex justify-end mb-4 absolute right-0 lg:hidden">
            <button id="reportMenuCloseBtn" class="pt-4 pr-4 text-gray-500 hover:text-action">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="mb-4 px-8 pt-8 hidden lg:block">
            <a href="/toolkit-home/" class="text-action text-sm uppercase font-bold no-underline flex items-center">
              <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.17871 0.821289L1 4M1 4L4.17871 7.17871M1 4L9.47656 4" stroke="#2F71F4"
                  stroke-width="1.54119" stroke-linecap="round" stroke-linejoin="round" />
              </svg>&nbsp;MAIN
            </a>
          </div>

          <div class="pt-2 px-8 hidden lg:block">
            <h2 class="text-md font-semibold leading-tight mb-6">
              Unite Us<br/>Customer Toolkit
            </h2>
          </div>

          <div class="hidden lg:block border-t border-gray-300"></div>

          <div>
            <nav>
              <ul id="reportDynamicMenu" class="space-y-2 list-none">
                @foreach ($menuItems as $i => $item)
                  <li class="report-menu-item">
                    <a href="#{{ $item['id'] }}" class="flex no-underline px-8 py-4 hover:bg-gray-50 text-brand">
                      <span class="block mr-3 text-gray-500 font-semibold">{{ sprintf('%02d.', $loop->iteration) }}</span>
                      <span class="block text-sm font-semibold leading-tight">{{ $item['title'] }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </section>

    {{-- RIGHT CONTENT --}}
    <section class="content w-full lg:w-3/4">
      <div class="report-inner-content component-section !pt-1 lg:!px-0">
        <div class="component-inner-section relative z-10">
          <div class="max-w-5xl pt-6 mx-auto">

            {{-- ACF Loop --}}
            @if (have_rows('toolkit_page'))
              @php $page_index = -1; @endphp
              @while (have_rows('toolkit_page')) @php the_row(); $page_index++; @endphp
                @php
                  $explicit_page_id = trim((string) get_sub_field('page_id'));
                  $computed_id = $explicit_page_id ?: ($menuItems[$page_index]['id'] ?? ('toolkit-section-' . ($page_index + 1)));
                @endphp

                <div class="page bg-white rounded-lg" id="{{ $computed_id }}">
                  @if (have_rows('components'))
                    @while (have_rows('components')) @php the_row(); @endphp
                      @php $section_id = get_sub_field('id') ? 'id="' . esc_attr(get_sub_field('id')) . '"' : ''; @endphp

                      {{-- CHECKLIST --}}
                      @if (get_row_layout() === 'checklist')
                        @php $title = get_sub_field('title'); @endphp
                        <section {!! $section_id !!} class="toolkit-checklist px-12">
                          <hr class="my-4 border-gray-200">
                          @if ($title)
                            <h2 class="text-2xl font-normal leading-tight mb-4">{{ $title }}</h2>
                          @endif
                          @if (have_rows('checklist_group'))
                            <div class="divide-y divide-gray-200">
                              @while (have_rows('checklist_group')) @php the_row(); @endphp
                                @php
                                  $heading      = get_sub_field('heading');
                                  $instructions = get_sub_field('instructions');
                                @endphp

                                <div class="py-6 grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-6">
                                  <div class="md:col-span-4">
                                    @if ($heading)
                                      <div class="w-40 text-md font-semibold leading-6">{{ $heading }}</div>
                                    @endif
                                  </div>
                                  <div class="md:col-span-8 space-y-4">
                                    @if ($instructions)
                                      <div class="text-sm text-gray-500 leading-6">{{ $instructions }}</div>
                                    @endif

                                    @if (have_rows('list'))
                                      @while (have_rows('list')) @php the_row(); @endphp
                                      
                                        @php 
                                        $item_raw  = get_sub_field('list_item');  
                                        $item_html = is_string($item_raw) ? trim($item_raw) : '';

                                        if ($item_html !== '') {
                                          $item_html = preg_replace('/^\s*<p>(.*?)<\/p>\s*$/si', '$1', $item_html);
                                        }
                                        @endphp
                                        @if ($item)
                                          <label class="flex items-start gap-3">
                                            <input type="checkbox" class="mt-1.5 h-4 w-4 shrink-0 rounded border-gray-300 align-top toolkit-checkbox">
                                            <span class="text-sm leading-6">{!! $item_html !!}</span>
                                          </label>
                                        @endif
                                      @endwhile
                                    @endif
                                  </div>
                                </div>
                              @endwhile
                            </div>
                          @endif
                        </section>

                      {{-- HERO --}}
                      @elseif (get_row_layout() === 'hero')
                        @php
                          $image = get_sub_field('image'); // array
                          $title = get_sub_field('title'); // text
                          $description = get_sub_field('description'); // text
                        @endphp
                        <section {!! $section_id !!} class="toolkit-hero mb-8">
                          @if ($image)
                            <figure class="overflow-hidden mb-6">
                              {!! wp_get_attachment_image(
                                $image['ID'] ?? 0,
                                'full',
                                false,
                                [
                                  'class'    => 'w-full h-auto object-cover',
                                  'alt'      => ($image['alt'] ?? '') ?: ($title ?: 'Hero image'),
                                  'loading'  => 'eager',
                                  'decoding' => 'async',
                                ]
                              ) !!}
                            </figure>
                          @endif
                          <div class="px-12">
                            @if ($title)
                              <h2 class="font-semibold leading-tight tracking-tight mb-4">{{ $title }}</h2>
                            @endif
                            @if ($description)
                              <p>{{ $description }}</p>
                            @endif
                          </div>
                        </section>

                      {{-- LINKED TILES V1 --}}
                      @elseif (get_row_layout() === 'linked_tiles_v1')
                        @php $tiles = get_sub_field('tiles') ?: []; @endphp
                        @if ($tiles)
                        <section {!! $section_id !!} class="toolkit-tiles-v1 px-12 pt-8 pb-8">
                          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-4">
                            @foreach ($tiles as $tile)
                              @php
                                $title = trim($tile['title'] ?? '');
                                $desc  = trim($tile['description'] ?? '');
                                $btn   = $tile['button'] ?? null;
                                $slug  = sanitize_title($title) ?: 'tile-'.$loop->index;

                                if (is_array($btn)) { $url = $btn['url'] ?? ''; $label = $btn['title'] ?? ''; $target = $btn['target'] ?? '_self'; }
                                else { $url = $btn ?: ''; $label = ''; $target = '_self'; }

                                $labelOrHost = $label ?: (parse_url($url, PHP_URL_HOST) ?: 'Learn more');
                              @endphp

                              <article id="tile-{{ $slug }}" class="relative bg-white p-4 pt-0">
                                <div class="absolute left-0 right-0 -top-[1px] h-2 gradient-border !rounded-none"></div>

                                <div class="pt-8 flex items-start justify-between gap-3">
                                  @if ($title)
                                    <h3 class="text-xl font-semibold mb-4 tracking-tight">{{ $title }}</h3>
                                  @endif

                                  <img src="{{ $icons_uri }}/arrow-top-right.svg" alt="" class="w-4 h-4" loading="lazy" decoding="async" />

                                </div>
                                
                                @if ($desc)
                                  <div class="mt-3 text-sm leading-6 text-gray-700"> {!! $desc !!}</div>
                                @endif

                                @if ($url)
                                  <div class="mt-5">
                                    <a href="{{ esc_url($url) }}" target="{{ esc_attr($target) }}" rel="noopener"
                                      class="inline-flex items-center gap-2 rounded-md border border-action p-2 text-sm font-normal text-action no-underline">
                                      {{ $labelOrHost }}
                                      {{-- tiny chain link (inline) --}}
                                      <img src="{{ $icons_uri }}/lock.svg" alt="" class="w-4 h-4" loading="lazy" decoding="async" />
                                    </a>
                                  </div>
                                @endif
                              </article>
                            @endforeach
                          </div>
                        <hr class="my-4 border-gray-200">
                        </section>
                        @endif

                      {{-- LINKED TILES V2 --}}
                      @elseif (get_row_layout() === 'linked_tiles_v2')
                        @php $tiles = get_sub_field('tiles') ?: []; @endphp
                        @if ($tiles)
                        <section {!! $section_id !!} class="toolkit-tiles-v2 px-12">
                          <div class="space-y-8">
                            @foreach ($tiles as $row)
                              @php
                                $title       = trim($row['title'] ?? '');
                                $subheading  = $row['subheading'] ?? '';
                                $wys         = $row['description'] ?? '';
                                // ACF true/false named "button" (1/0, "1"/"0", or bool)
                                $rawFlag     = $row['button'] ?? false;
                                // If an old link field named "button" still exists as an array, do NOT show the copy button.
                                $showButton  = is_array($rawFlag) ? false : (bool) $rawFlag;
                                $slug  = sanitize_title($title) ?: 'tile-'.$loop->index;
                                $label       = 'Copy to Clipboard';
                                $copyId      = 'tilev2-copy-' . $computed_id . '-' . $loop->index;
                              @endphp

                              <div id="tile-{{ $slug }}" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                                {{-- Left column: title + (optional) COPY button --}}
                                <div class="lg:col-span-3 mt-8">
                                  <div class="flex items-start justify-between gap-3">
                                    <div>
                                      @if ($title)
                                        <h3 class="text-xl font-semibold mb-4 tracking-tight">{{ $title }}</h3>
                                      @endif
                                      @if ($subheading)
                                        <p>{{ $subheading }}</p>
                                      @endif
                                    </div>
                                    <img src="{{ $icons_uri }}/arrow-top-right.svg" alt="" class="w-4 h-4" loading="lazy" decoding="async" />
                                  </div>

                                  @if ($showButton)
                                    <div class="mt-4">
                                      <button type="button"
                                              class="js-copy-v2 inline-flex items-center gap-2 rounded-md border border-action p-2 text-sm font-normal text-action no-underline"
                                              data-copy-target="#{{ $copyId }}">
                                        <span class="btn-text">{{ $label }}</span>
                                        <img src="{{ $icons_uri }}/clipboard.svg" alt="" class="w-4 h-4" loading="lazy" decoding="async" />
                                      </button>
                                    </div>
                                  @endif
                                </div>

                                {{-- Right column: bordered WYSIWYG box (source for copying) --}}
                                <div class="lg:col-span-9">
                                  <div id="{{ $copyId }}" class="rounded-2xl border border-blue-200 bg-white p-6 shadow-sm break-words">
                                      {!! $wys !!}
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </div>
                        </section>
                        @endif
                      {{-- POPOUT --}}
                      @elseif (get_row_layout() === 'popout')
                        @php
                          $text   = get_sub_field('text'); // left column WYSIWYG
                          $ptitle = trim((string) get_sub_field('popout_title'));
                          $pdesc  = trim((string) get_sub_field('popout_description'));
                          $pbtn   = get_sub_field('popout_button'); // array: url, title, target
                          $href   = $pbtn['url']    ?? '';
                          $label  = $pbtn['title']  ?? '';
                          $target = $pbtn['target'] ?? '_self';
                          $labelOrHost = $label ?: (parse_url($href, PHP_URL_HOST) ?: '');
                            $icons_uri = get_stylesheet_directory_uri() . '/resources/icons';

                        @endphp

                        <section {!! $section_id !!} class="toolkit-popout px-12">
                          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                            {{-- Left: body copy --}}
                            <div class="lg:col-span-8">
                              {!! $text !!}
                            </div>

                            {{-- Right: example card --}}
                            <aside class="lg:col-span-4">
                              <div class="relative rounded-2xl border border-gray-200 bg-white shadow-sm p-8 pt-0">
                                <div class="absolute left-0 right-0 h-2 gradient-border !rounded-bl-none !rounded-br-none"></div>

                                <div class="pt-8 flex items-start justify-between gap-3">
                                  @if($ptitle)
                                    <h3 class="text-xl font-semibold mb-4 tracking-tight">{{ $ptitle }}</h3>
                                  @endif
                                   <img src="{{ $icons_uri }}/arrow-top-right.svg" alt="" class="w-5 h-5" loading="lazy" decoding="async" />
                                </div>

                                @if($pdesc)
                                  <p class="mt-4 text-[17px] leading-8 text-gray-700">
                                    {{ $pdesc }}
                                  </p>
                                @endif

                                @if($href)
                                  <div class="mt-5">
                                    <a
                                      href="{{ esc_url($href) }}" target="{{ esc_attr($target) }}" rel="noopener"
                                      class="inline-flex items-center gap-2 rounded-md border border-action p-2 text-sm font-normal text-action no-underline">
                                      {{ $labelOrHost }}
                                      <img src="{{ $icons_uri }}/lock.svg" alt="" class="w-4 h-4" loading="lazy" decoding="async" />
                                    </a>
                                  </div>
                                @endif
                              </div>
                            </aside>
                          </div>
                        </section>


                      {{-- WYSIWYG --}}
                      @elseif (get_row_layout() === 'wysiwyg')
                        <div {!! $section_id !!} class="px-12">
                          {!! get_sub_field('wysiwyg') !!}
                        </div>
                      @endif
                    @endwhile
                  @endif
                  @php
                    $prevItem = $menuItems[$page_index - 1] ?? null;
                    $nextItem = $menuItems[$page_index + 1] ?? null;
                  @endphp
                  <section class="px-8">
                    <hr class="my-4 border-gray-200">
                    <nav class="toolkit-pager px-0 py-4 pb-8 flex justify-between items-center">
                      <a
                        href="{{ $prevItem ? '#'.$prevItem['id'] : '#' }}"
                        class="pager-prev flex items-center gap-2 text-sm no-underline {{ $prevItem ? 'text-brand hover:text-action' : 'opacity-50 pointer-events-none text-gray-400' }}"
                        data-target="{{ $prevItem['id'] ?? '' }}"
                      >
                        <img src="{{ $icons_uri }}/arrow-left.svg" alt="" class="w-4 h-4" loading="lazy" decoding="async" /> Previous
                      </a>

                      <a
                        href="{{ $nextItem ? '#'.$nextItem['id'] : '#' }}"
                        class="pager-next flex items-center gap-2 text-sm no-underline {{ $nextItem ? 'text-action' : 'opacity-50 pointer-events-none text-action' }}"
                        data-target="{{ $nextItem['id'] ?? '' }}"
                      >
                        Next <img src="{{ $icons_uri }}/arrow-right.svg" alt="" class="w-4 h-4" loading="lazy" decoding="async" />
                      </a>
                    </nav>
                  </section>    
                </div>
              @endwhile
            @endif
          </div>
        </div>
      </div>
    </section>
  </div>
</article>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const outer       = document.querySelector('.report-menu-wrapper-outer');
  const menuWrap    = document.querySelector('.report-menu-wrapper');
  const inner       = document.querySelector('.component-inner-section'); // bounds stop
  const navHeight   = 80; // height of main fixed nav

  if (!outer || !menuWrap || !inner) return;

  const getDocTop = (el) => el.getBoundingClientRect().top + window.pageYOffset;

  const handle = () => {
    const isDesktop = window.innerWidth >= 1024;
    // Reset when switching breakpoints
    if (!isDesktop) {
      menuWrap.style.position = 'relative';
      menuWrap.style.top = 'unset';
      menuWrap.style.width = '';
      return;
    }

    const wrapperTop   = getDocTop(outer);
    const scrollY      = window.scrollY;
    const innerBottom  = getDocTop(inner) + inner.offsetHeight;

    // lock width to its column so it doesn't jump when fixed
    menuWrap.style.width = outer.offsetWidth + 'px';

    if (scrollY + navHeight > wrapperTop) {
      if (scrollY + navHeight + menuWrap.offsetHeight < innerBottom) {
        menuWrap.style.position = 'fixed';
        menuWrap.style.top = navHeight + 'px';
      } else {
        menuWrap.style.position = 'absolute';
        menuWrap.style.top = (innerBottom - wrapperTop - menuWrap.offsetHeight) + 'px';
      }
    } else {
      menuWrap.style.position = 'relative';
      menuWrap.style.top = 'unset';
    }
  };

  window.addEventListener('scroll', handle, { passive: true });
  window.addEventListener('resize', handle);
  handle();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const mobileMenu  = document.getElementById('reportMobileMenu');
  const toggleBtn   = document.getElementById('reportMobileMenuToggle');
  const closeBtn    = document.getElementById('reportMenuCloseBtn');
  const menuList    = document.getElementById('reportDynamicMenu');
  const navHeight   = 80;

  // Toggle mobile panel
  const toggleMobile = () => { if (mobileMenu) mobileMenu.classList.toggle('hidden'); };
  if (toggleBtn) toggleBtn.addEventListener('click', toggleMobile);
  if (closeBtn)  closeBtn.addEventListener('click', () => mobileMenu && mobileMenu.classList.add('hidden'));

  // Fit panel to viewport
  const navHeight = 80;
  const isDesktop = () => window.innerWidth >= 1024;

  const setMenuHeight = () => {
    if (!mobileMenu) return;
    if (isDesktop()) {
      // desktop: let the card size itself
      mobileMenu.style.height = '';
      mobileMenu.style.overflowY = 'visible';
    } else {
      // mobile: fit to viewport and scroll
      mobileMenu.style.height = (window.innerHeight - navHeight) + 'px';
      mobileMenu.style.overflowY = 'auto';
    }
  };

  setMenuHeight();
  window.addEventListener('resize', setMenuHeight);


  // Smooth scroll with offset for anchors inside the menu
  const scrollToWithOffset = (el) => {
    const isDesktop = window.innerWidth >= 1024;
    const extra = isDesktop ? 10 : 56; // small breathing room; extra for mobile UI
    const y = el.getBoundingClientRect().top + window.pageYOffset - navHeight - extra;
    window.scrollTo({ top: y, behavior: 'smooth' });
  };

  if (menuList) {
    menuList.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener('click', (e) => {
        const id = a.getAttribute('href').slice(1);
        const target = document.getElementById(id);
        if (!target) return;
        e.preventDefault();
        scrollToWithOffset(target);
        if (mobileMenu && window.innerWidth < 1024) mobileMenu.classList.add('hidden');
      });
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const links = Array.from(document.querySelectorAll('#reportDynamicMenu a'));
  if (!links.length) return;

  const pairs = links
    .map(a => ({ a, el: document.getElementById(a.getAttribute('href').slice(1)) }))
    .filter(p => p.el);

  const setActive = (a, on) => {
    a.parentElement.classList.toggle('active', on);
    const label = a.querySelector('span:last-child');
    if (label) label.classList.toggle('text-action', on); // your blue text class
  };

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        pairs.forEach(p => setActive(p.a, p.el === entry.target));
      }
    });
  }, { rootMargin: '-35% 0px -55% 0px' });

  pairs.forEach(p => io.observe(p.el));
});

</script>
<script>
/**
 * Toolkit "slider" – show one .page at a time.
 * - Prev/Next buttons
 * - Left menu clicks jump between slides
 * - Updates URL hash, active state, and closes mobile menu on small screens
 * This script is fully scoped to <article.report>.
 */
(function () {
  const NAV = 80;
  const isDesktop = () => window.innerWidth >= 1024;

  document.addEventListener('DOMContentLoaded', function () {
    const report    = document.querySelector('article.report');
    if (!report) return;

    const panel     = report.querySelector('#reportMobileMenu');
    const pages     = Array.from(report.querySelectorAll('.page'));
    const menuLinks = Array.from(report.querySelectorAll('#reportDynamicMenu a'));

    if (!pages.length) return;

    // Helpers
    const idxOf = (id) => pages.findIndex(p => p.id === id);
    const setActiveMenu = (i) => {
      menuLinks.forEach((a, ix) => a.parentElement.classList.toggle('active', ix === i));
    };
    const scrollTopOf = (el) => {
      const extra = isDesktop() ? 10 : 56;
      const y = el.getBoundingClientRect().top + window.pageYOffset - NAV - extra;
      window.scrollTo({ top: y, behavior: 'smooth' });
    };
    const updatePagerForAll = () => {
      pages.forEach((page, i) => {
        const prev = page.querySelector('.pager-prev');
        const next = page.querySelector('.pager-next');
        if (prev) {
          const pi = i - 1;
          if (pi >= 0) {
            prev.classList.remove('opacity-50','pointer-events-none','text-gray-400');
            prev.href = '#'+pages[pi].id;
            prev.dataset.target = pages[pi].id;
          } else {
            prev.classList.add('opacity-50','pointer-events-none','text-gray-400');
            prev.removeAttribute('data-target');
            prev.href = '#';
          }
        }
        if (next) {
          const ni = i + 1;
          if (ni < pages.length) {
            next.classList.remove('opacity-50','pointer-events-none');
            next.href = '#'+pages[ni].id;
            next.dataset.target = pages[ni].id;
          } else {
            next.classList.add('opacity-50','pointer-events-none');
            next.removeAttribute('data-target');
            next.href = '#';
          }
        }
      });
    };

    // Core: show only the target page
    let current = 0;
    const show = (i, {pushHash=true, scroll=true} = {}) => {
      if (i < 0 || i >= pages.length) return;
      pages.forEach((p, ix) => { p.style.display = (ix === i) ? '' : 'none'; });
      current = i;
      setActiveMenu(i);
      if (pushHash) history.replaceState(null, '', '#'+pages[i].id);
      if (scroll)   scrollTopOf(pages[i]);
    };

    // Wire left-menu clicks
    menuLinks.forEach((a, i) => {
      a.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();
        show(i);
        // close mobile panel if needed
        if (panel && !isDesktop()) panel.classList.add('hidden');
      });
    });

    // Wire pager clicks
    report.querySelectorAll('.pager-prev, .pager-next').forEach(a => {
      a.addEventListener('click', (e) => {
        const target = a.dataset.target;
        if (!target) return; // disabled edge
        e.preventDefault();
        const i = idxOf(target);
        if (i >= 0) show(i);
      });
    });

    // Init: decide which page to show
    updatePagerForAll();
    const startId  = (location.hash || '').slice(1);
    const startIdx = startId ? idxOf(decodeURIComponent(startId)) : 0;

    // Hide all first to avoid flash
    pages.forEach(p => p.style.display = 'none');
    show(startIdx >= 0 ? startIdx : 0, {pushHash:false, scroll:false});
  });
})();
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const root = document.querySelector('article.report');
  if (!root) return;

  // Turn a node's HTML into nice plain text (show URLs for <a> links)
  function toPlainText(node) {
    const clone = node.cloneNode(true);
    clone.querySelectorAll('a').forEach(a => {
      const url = a.getAttribute('href') || '';
      if (url && !/^https?:\/\//i.test(a.textContent.trim())) {
        a.textContent = url; // show the real URL if anchor text isn't a URL
      }
    });
    return clone.innerText.replace(/\u00A0/g, ' ').trim(); // normalize &nbsp;
  }

  async function copy(text) {
    try {
      await navigator.clipboard.writeText(text);
      return true;
    } catch (e) {
      // Fallback
      const ta = document.createElement('textarea');
      ta.value = text;
      ta.style.position = 'fixed';
      ta.style.left = '-9999px';
      document.body.appendChild(ta);
      ta.select();
      const ok = document.execCommand('copy');
      ta.remove();
      return ok;
    }
  }

  root.addEventListener('click', async (e) => {
    const btn = e.target.closest('.js-copy-v2');
    if (!btn) return;

    const sel = btn.getAttribute('data-copy-target');
    const target = sel ? root.querySelector(sel) : null;
    if (!target) return;

    const text = toPlainText(target);
    if (!text) return;

    const labelEl = btn.querySelector('.btn-text');
    const oldLabel = labelEl ? labelEl.textContent : '';

    const ok = await copy(text);
    if (ok && labelEl) {
      labelEl.textContent = 'Copied!';
      setTimeout(() => { labelEl.textContent = oldLabel; }, 1600);
    }
  });
});
</script>
<script>
(function () {
  const NAV = 80;
  const isDesktop = () => window.innerWidth >= 1024;

  function parseHash(h) {
    const raw = (h || location.hash || '').replace(/^#/, '');
    if (!raw) return { page:null, sub:null };
    const [page, sub] = raw.split(/[:|]/); // allow : or |
    return { page: page || null, sub: sub || null };
  }

  document.addEventListener('DOMContentLoaded', function () {
    const report    = document.querySelector('article.report');
    if (!report) return;

    const panel     = report.querySelector('#reportMobileMenu');
    const pages     = Array.from(report.querySelectorAll('.page'));
    const menuLinks = Array.from(report.querySelectorAll('#reportDynamicMenu a'));
    if (!pages.length) return;

    const idxOf = (id) => pages.findIndex(p => p.id === id);
    const setActiveMenu = (i) => {
      menuLinks.forEach((a, ix) => a.parentElement.classList.toggle('active', ix === i));
    };
    const scrollToEl = (el) => {
      if (!el) return;
      const extra = isDesktop() ? 10 : 56;
      const y = el.getBoundingClientRect().top + window.pageYOffset - NAV - extra;
      window.scrollTo({ top: y, behavior: 'smooth' });

      // brief highlight
      el.classList.add('ring-2','ring-action');
      setTimeout(() => el.classList.remove('ring-2','ring-action'), 1200);
    };

    let current = 0;
    const show = (i, { pushHash=true, scroll=true } = {}) => {
      if (i < 0 || i >= pages.length) return;
      pages.forEach((p, ix) => { p.style.display = (ix === i) ? '' : 'none'; });
      current = i;
      setActiveMenu(i);
      if (pushHash) history.replaceState(null, '', '#'+pages[i].id);
      if (scroll)   scrollToEl(pages[i]);
    };

    // Menu clicks (page only)
    menuLinks.forEach((a, i) => {
      a.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();
        show(i);
        if (panel && !isDesktop()) panel.classList.add('hidden');
      });
    });

    // Pager links (already rendered in each page)
    report.querySelectorAll('.pager-prev, .pager-next').forEach(a => {
      a.addEventListener('click', (e) => {
        const target = a.dataset.target;
        if (!target) return;
        e.preventDefault();
        const i = idxOf(target);
        if (i >= 0) show(i);
      });
    });

    // Delegate ANY in-content link like #page:sub to the slider
    report.addEventListener('click', (e) => {
      const a = e.target.closest('a[href^="#"]');
      if (!a) return;
      const { page, sub } = parseHash(a.getAttribute('href'));
      if (!page) return;
      const i = idxOf(decodeURIComponent(page));
      if (i === -1) return;
      e.preventDefault();
      show(i);
      if (sub) {
        // prefer id="tile-<slug>", fallback to plain id
        const targetEl =
          report.querySelector('#tile-' + CSS.escape(sub)) ||
          report.querySelector('#' + CSS.escape(sub));
        if (targetEl) setTimeout(() => scrollToEl(targetEl), 200);
      }
    });

    // Init from URL (supports #page and #page:sub)
    const { page, sub } = parseHash();
    const startIdx = page ? idxOf(decodeURIComponent(page)) : 0;
    pages.forEach(p => p.style.display = 'none');
    show(startIdx >= 0 ? startIdx : 0, { pushHash:false, scroll:false });
    if (sub) {
      const targetEl =
        report.querySelector('#tile-' + CSS.escape(sub)) ||
        report.querySelector('#' + CSS.escape(sub));
      if (targetEl) setTimeout(() => scrollToEl(targetEl), 200);
    }

    // Keep behavior if hash is changed manually
    window.addEventListener('hashchange', () => {
      const { page:hp, sub:hs } = parseHash();
      if (!hp) return;
      const i = idxOf(decodeURIComponent(hp));
      if (i === -1) return;
      show(i, { pushHash:false });
      if (hs) {
        const el =
          report.querySelector('#tile-' + CSS.escape(hs)) ||
          report.querySelector('#' + CSS.escape(hs));
        if (el) setTimeout(() => scrollToEl(el), 200);
      }
    });
  });
})();
</script>

@endsection
<style>
  /* Left menu active look */
#reportDynamicMenu li.active > a { background-color: #EFF3FF; } /* similar to bg-blue-50 */
#reportDynamicMenu li.active > a span:nth-child(2) { color: #2F71F4; }
.toolkit-pager a[disabled],
.toolkit-pager .pointer-events-none {
  cursor: not-allowed;
}
/* Popout: match the pill/disabled cursor & keep spacing consistent */
.toolkit-popout .rounded-2xl { border-radius: 16px; }
.toolkit-popout .pager a[disabled],
.toolkit-popout .pointer-events-none { cursor: not-allowed; }

</style> 