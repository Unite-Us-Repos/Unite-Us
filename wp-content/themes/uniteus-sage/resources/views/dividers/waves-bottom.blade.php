@php
$divider_color = $background['color'];
if (isset($bg_color)) {
  if ($bg_color) {
    $divider_color = $bg_color;
  }
}
@endphp
<div class="section-divider relative h-5 sm:h-10 md:h-14 xl:h-20 text-{{ $divider_color }}">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" width="1358" height="80" preserveAspectRatio="none" viewBox="0 0 1358 80" fill="none">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 70.1429L56.625 64.2977C113.25 58.4525 226.5 46.762 339.75 52.6072C453 58.4525 566.25 81.8334 679.5 79.885C792.75 77.9366 906 50.6588 1019.25 44.8135C1132.5 38.9683 1245.75 54.5556 1302.37 62.3493L1359 70.1429V0H1302.37C1245.75 0 1132.5 0 1019.25 0C906 0 792.75 0 679.5 0C566.25 0 453 0 339.75 0C226.5 0 113.25 0 56.625 0H0V70.1429Z" fill="currentColor"/>
  </svg>
</div>
