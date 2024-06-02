@php
$job_id = 0;
$job_title = '';
$title_override = false;
if ($section['title']) {
  $job_title = $section['title'];
}
@endphp
<style>
@media (max-width: 768px) {
  .hero-v3 {
    padding-top: 0 !important;
  }
}
</style>
<section class="relative hero-v3 component-section md:!py-24 {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <!-- Overlay -->

  <div class="absolute flex justify-end top-0 bottom-0 right-0 z-20" style="width: 52%">
    <img class="absolute hidden lg:block lazy" data-src="@asset('/images/herov3-purple-bar.png')" alt="" style="right: 8%;
      width: 208px;
      top: 7%" />
    <img class="absolute lazy" data-src="@asset('/images/herov3-heart-home.png')" alt="" style="right: 0;
      width: 230px;
      bottom: 0" />
  </div>
  <div class="absolute bg-homev3 inset-0 bg-brand z-10 hidden md:block" style="width: 56%;border-top-right-radius: 250px;">
  <img class="absolute lazy" data-src="@asset('/images/herov3-food.png')" alt="" style="right: -130px;
    width: 230px;
    top: 0" />
  <img class="absolute lazy" data-src="@asset('/images/herov3-profile-chart.png')" alt="" style="right: -80px;
    width: 140px;
    bottom: 33%;" />
  <img class="absolute hidden lg:block lazy" data-src="@asset('/images/herov3-grad-bar.png')" alt="" style="right: -225px;
    width: 160px;
    bottom: 13%;" />
  </div>
  <div class="absolute inset-0">
    @if ($background['image'])
      <img fetchPriority="high" class="hidden md:block w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
        src="{{ $background['image']['sizes']['2048x2048'] }}"
        alt="{{ $background['image']['alt'] }}">


        <img class="md:hidden w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
        src="{{ $background['logo']['sizes']['medium'] }}"
        alt="{{ $background['logo']['alt'] }}">
    @endif
  </div>

  @if ($background['overlay'])
  <div class="absolute inset-0 bg-brand opacity-75"></div>
  @endif

  <div class="relative w-full z-20">

    <div class="component-inner-section">
    <div class="relative flex flex-col md:grid md:grid-cols-2">

      <div class="relative order-2 md:order-1">
      <div class="absolute bg-homev3 inset-0 bg-brand z-10 md:hidden" style="border-top-right-radius: 120px;margin: -7rem -3rem -5rem -3rem"></div>

        @if (!$hide_breadcrumbs)
          <div class="mb-6">
            @php
            $data = [
              'color' => 'white'
            ];
            @endphp
            @include('ui.breadcrumbs.simple-with-slashes', $data)
          </div>
        @endif

            <div class="relative z-10 -mt-12 md:mt-0">
              <div class="py-12" style="max-width: 500px">
        @if ($section['subtitle'])
          <div class="text-action-light-blue uppercase font-semibold text-base mb-3">
            {!! $section['subtitle'] !!}
          </div>
        @endif
        <h1 class="mb-0 text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight @if ($background['color'] == 'light') text-brand @else text-white @endif">
          {!! $job_title !!}
        </h1>

        @if ($section['description'])
          <div class="mt-6 @if ($background['color'] == 'light') text-brand @else text-white @endif text-xl">
            {!! $section['description'] !!}
          </div>
        @endif
        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-start',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif
          </div>
          </div>
      </div>

      <div class="relative order-1 md:order-2 -mx-12">
        <img class="absolute md:hidden lazy" data-src="@asset('/images/herov3-food.png')" alt=""
          style="
            transform: scaleX(-1);
            right: 2rem;
            width: 190px;
            top: 0" />
        <img class="absolute md:hidden lazy" data-src="@asset('/images/herov3-purple-bar.png')" alt=""
          style="
            left: 3rem;
            width: 112px;
            top: 2rem" />
        <img class="absolute md:hidden lazy" data-src="@asset('/images/herov3-profile-chart.png')" alt=""
          style="
            bottom: 13rem;
            width: 117px;
            right: 3rem" />
        <img class="absolute md:hidden lazy" data-src="@asset('/images/herov3-heart-home.png')" alt=""
          style="
            transform: scaleX(-1);
            left: 1rem;
            width: 170px;
            bottom: 6.5rem;" />
        @isset ($section['logo']['sizes'])
          <img class="w-full h-auto md:hidden" src="{{ $section['logo']['sizes']['medium'] }}" alt="{{ $section['logo']['alt'] }}" />
        @endisset</div>
          </div>
    </div>
  </div>
</section>
