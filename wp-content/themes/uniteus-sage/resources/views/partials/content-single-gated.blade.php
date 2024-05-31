@php
$acf = $acf['gated_page'];
@endphp
<section id="gated-page" class="component-section bg-dark-gradient">
  <div class="component-inner-section">

    <div class="flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 gap-10">
      <div class="text-lg text-white lg:pr-12 xl:pr-20">
        <h1 class="form-page-title">{!! $acf['title'] !!}</h1>
        @if ($acf['featured_image'])
          <div class="featured-image my-6">
            <img class="w-full" src="{{ $acf['featured_image']['sizes']['large'] }}" alt="$acf['featured_image']['alt']" />
          </div>
        @endif
        <div class="text-lg description">
          {!! $acf['description'] !!}
        </div>
      </div>

      <div class="relative lg:row-start-1 lg:col-start-2">
        @isset ($acf['code_editor'])
          @if (!empty($acf['code_editor']))
            <div id="request-form" class="rounded-lg shadow-lg bg-white p-10 embed-form">
              @if ($acf['form_title'])
                <h3 class="text-2xl">{{ $acf['form_title'] }}</h3>
              @endif
              {!! $acf['code_editor'] !!}
            </div>
          @endif
        @endisset
      </div>
    </div>
  </div>
</section>


@if ($acf['title_2'] OR $acf['description_2'])
  <div class="section-divider" style="calc(100% + 2px); margin: -1px">
    <svg style="width:100%" width="1358" height="80" preserveAspectRatio="none" viewBox="0 0 1358 80" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 71.0853L57.125 65.2401C113.75 59.3948 227 47.7043 340.25 53.5496C453.5 59.3948 566.75 82.7758 680 80.8274C793.25 78.879 906.5 51.6012 1019.75 45.7559C1133 39.9107 1246.25 55.498 1302.87 63.2917L1359.5 71.0853V0.942383H1302.87C1246.25 0.942383 1133 0.942383 1019.75 0.942383C906.5 0.942383 793.25 0.942383 680 0.942383C566.75 0.942383 453.5 0.942383 340.25 0.942383C227 0.942383 113.75 0.942383 57.125 0.942383H0.5V71.0853Z" fill="#2C405A"/>
    </svg>
  </div>


  <section class="component-section gated-section-2">
    <div class="component-inner-section">

      <div class="flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 gap-10 lg:gap-28">
        <div class="text-lg">
          @if ($acf['title_2'])
            <h2 class="form-page-title-2">{!! $acf['title_2'] !!}</h2>
          @endif

          @if ($acf['description_2'])
            <div class="text-lg">
              {!! $acf['description_2'] !!}
            </div>
          @endif

          @if ($acf['display_cta_button'])
            <div class="inline-flex mt-6">
              <a href="#request-form" class="button button-solid">
              {!! $acf['button_text'] !!}
              </a>
            </div>
          @endif
        </div>

        <div class="relative lg:row-start-1 lg:col-start-2">
          @isset ($acf['embeds'])
            @if (!empty($acf['embeds']))
              <div class="rounded-lg responsive-embed">
                {!! $acf['embeds'] !!}
              </div>
            @endif
          @endisset
        </div>
      </div>
    </div>
  </section>
@endif
