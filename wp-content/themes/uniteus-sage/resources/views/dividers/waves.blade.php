@php
$divider_color = $background['color'];
if (isset($bg_color)) {
  if ($bg_color) {
    $divider_color = $bg_color;
  }
}
@endphp
<div class="section-divider relative h-5 sm:h-10 md:h-14 xl:h-20 -mb-2 -sm:mb-3 md:-mb-7 xl:-mb-10 text-{{ $divider_color }}">
  <svg class="w-full h-full" width="1358" height="80" preserveAspectRatio="none" viewBox="0 0 1358 80" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 9.85705L56.625 15.7023C113.25 21.5475 226.5 33.238 339.75 27.3928C453 21.5475 566.25 -1.83344 679.5 0.114975C792.75 2.06339 906 29.3412 1019.25 35.1865C1132.5 41.0317 1245.75 25.4444 1302.37 17.6507L1359 9.85705V80H1302.37C1245.75 80 1132.5 80 1019.25 80C906 80 792.75 80 679.5 80C566.25 80 453 80 339.75 80C226.5 80 113.25 80 56.625 80H0V9.85705Z" fill="currentColor"></path>
  <defs>
  <linearGradient x1="679.5" y1="0" x2="679.5" y2="80" gradientUnits="userSpaceOnUse">
  <stop stop-color="#EEF5FC"></stop>
  <stop offset="1" stop-color="#EEF5FC"></stop>
  </linearGradient>
  </defs>
  </svg>
</div>
