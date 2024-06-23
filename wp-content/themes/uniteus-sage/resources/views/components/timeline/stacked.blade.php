@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div
    class="relative z-20 component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif"
  >
  <div class="text-center mb-7">
    @if ($section['subtitle'])
      @if ($section['subtitle_display_as_pill'])
        <span class="@if ($background['color'] == 'dark') bg-brand text-action-light-blue @else text-action @if ($background['color'] == 'light-gradient') bg-white @else bg-light mix-blend-multiply @endif @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
      @else
        <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
      @endif
        {{ $section['subtitle'] }}
        </span>
    @endif
    <h2 class="mb-6">{!! $section['title'] !!}</h2>
    <div class="text-lg">
      <div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div>
    </div>
    @isset ($buttons)
      @php
        $data = [
          'justify' => 'justify-center',
          'mt' => 'mt-6',
        ];
      @endphp
      @include('components.action-buttons', $data)
    @endisset
  </div>

<div x-data id="timeline"
 class="relative sm:px-10 pt-[18px] sm:p-0 overflow-hidden flex flex-col gap-20 sm:gap-14 mx-auto max-w-5xl">
 @foreach ($timeline as $index => $card)


<div
    x-data data-scene data-scene-duration="20" id="number{{ $card['order'] }}Alt" data-scene-hook="onCenter" x-intersect.margin.50%.0="startTimeline()"
      class="text-xl sm:text-2xl hidden sm:flex items-center justify-center absolute z-50 inset-0 w-9 h-9 sm:w-12 sm:h-12 shadow-md text-action bg-white rounded-full left-1/2 sm:top-1/2 transform -translate-x-1/2 -translate-y-1/2"
      >
      <div
     data-animate data-animate-from-alpha="0" data-animate-to-alpha="1"
      class="opacity-0 text-xl sm:text-2xl flex items-center justify-center absolute z-50 inset-0 w-9 h-9 sm:w-12 sm:h-12 shadow-md text-white bg-action rounded-full left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2"
      >{{ $card['order'] }}</div>

      <span>{{ $card['order'] }}</span>
    </div>
 @endforeach
 <div id="vertical-divider" class="absolute h-full sm:z-40 top-0  w-2 left-1/2 transform -translate-x-1/2" style="background: url(@asset('/images/timeline-vdashes-new-blue.png')) repeat-y top center; height:0;"></div>
@foreach ($timeline as $index => $card)
  <div
    class="relative z-10 bg-white grid sm:grid-cols-2 gap-10 sm:gap-20 p-9 sm:py-10 sm:px-0 w-full"
    >
    <div
    data-scene data-scene-duration="2" data-alt-number="number{{ $card['order'] }}Alt" id="number{{ $card['order'] }}" data-scene-hook="onCenter"
      class="og-number text-xl sm:text-2xl flex items-center justify-center absolute z-20 inset-0 w-9 h-9 sm:w-12 sm:h-12 shadow-md text-action bg-white rounded-full left-1/2 sm:top-1/2 transform -translate-x-1/2 -translate-y-1/2"
      >
      <div
    data-animate data-animate-from-alpha="0" data-animate-to-alpha="1" data-animate-duration="2"
      class="opacity-0 text-xl sm:text-2xl flex items-center justify-center absolute z-20 inset-0 w-9 h-9 sm:w-12 sm:h-12 shadow-md text-white bg-action rounded-full left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2"
      >{{ $card['order'] }}</div>

      <span>{{ $card['order'] }}</span>
    </div>
    <div class="relative z-10 flex items-center justify-center @if ($loop->odd) sm:order-2 sm:justify-end @else sm:justify-start @endif">
      @if ($card['image'])
        <div class="@if ($card['mobile_image']) hidden sm:block @endif timeline-img-wrap relative @if ($loop->odd) -mr-8 @else -ml-8 @endif">
            <img class="rounded-md sm:rounded-xl w-full max-h-[430px]"
              src="{{ $card['image']['sizes']['medium_large'] }}"
              alt="" />
        </div>
      @endif

      @if ($card['mobile_image'])
        <div class="sm:hidden timeline-img-wrap relative">
            <img class="rounded-md mx-auto sm:rounded-xl w-full max-h-[430px]"
              src="{{ $card['mobile_image']['sizes']['medium_large'] }}"
              alt="" />
        </div>
      @endif
    </div>
    <div class="relative z-10 flex flex-col justify-center @if ($loop->even) sm:items-end @endif">
      <div class="w-full max-w-[390px]">
        <h2 class="mb-3 text-3xl md:text-4xl">{!! $card['title'] !!}</h2>
        <div class="text-lg">
          {!! $card['description'] !!}
        </div>
      </div>
    </div>

    <div class="hidden absolute z-10 @if ($loop->first) h-1/2 bottom-0 @else @if ($loop->last) h-1/2 top-0 @else inset-0 @endif @endif w-2 left-1/2 transform -translate-x-1/2" style="background: url(@asset('/images/timeline-vdashes-new-blue.png')) repeat-y top center;"></div>

    <div class="absolute h-full sm:max-h-[376px] left-0 right-0 sm:left-10 sm:right-10 lg:left-20 lg:right-20 bg-light rounded-xl top-1/2 transofrm -translate-y-1/2" @isset ($card['background']['image']['sizes']) style="background: url({{ $card['background']['image']['sizes']['medium_large'] }}?v=2) no-repeat center center; background-size: cover;" @endisset></div>
  </div>
@endforeach

<div id="vertical-divider2" class="absolute opacity-50  sm:block sm:z-20   inset-0  w-2 left-1/2 transform -translate-x-1/2" style="background: url(@asset('/images/timeline-vdashes-new-blue.png')) repeat-y top center;"></div>

      </div>

</div>
</section>
<script>
  window.console = window.console || function(t) {};
</script>

<script src="https://unpkg.com/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://unpkg.com/scrollxp@2.1.2/dist/scrollxp.min.js"></script>
<script>
  new ScrollXP({
    container: document.body,
  });

  let timelineGrow = function() {
    const verticalLine = document.getElementById("vertical-divider")
    document.addEventListener('scroll', function(e) {
      scrollPosition = window.scrollY / 2 ;
      verticalLine.style.height = `${scrollPosition}px`
    });
  }


  var showDivider = function(element) {
    var timeline = document.getElementById("timeline");

        var isVisible = false;
        var windowHeight = window.innerHeight;
        var dimensions = timeline.getBoundingClientRect();
        var top = dimensions.top;
        var difference;
        var timeline = document.getElementById("timeline");
        var tdimensions = timeline.getBoundingClientRect();
        var numbers = document.querySelectorAll('.og-number');

        var firstNumber = numbers[0];
        var lastNumber = numbers[numbers.length-1];

        var firstNumberTop = firstNumber.getBoundingClientRect().top;
        var lastNumberTop = lastNumber.getBoundingClientRect().top;
        var lastNumberBottom = lastNumber.getBoundingClientRect().bottom;
        var maxDividerHeight = (tdimensions.height-(firstNumberTop-tdimensions.top)-(tdimensions.bottom-lastNumberBottom));

        var newTop = firstNumberTop - dimensions.top;

        if (top === 0) {
            isVisible = true;
            difference = windowHeight/2;
        } else if (top < 0) {
            isVisible = true;
            difference = -top + windowHeight/2;
        } else if (top < windowHeight/2) {
            isVisible = true;
            difference = windowHeight/2 - top;
        }

        difference = difference - newTop;

        if (difference < maxDividerHeight-30) {
          paintDivider(element, difference);
        }
    };

    //function to paint the divider
    var paintDivider = function(divider, length) {
        if (divider) {
          if (typeof length !== 'undefined') {
            divider.style.height = length + "px";
          }
        }
    };

    function startTimeline() {

    //get the divider element that needs to be painted
    var divider = document.getElementById("vertical-divider");


    //bind to the 'scorll' event and 'resize' event, to decide whether to
    //paint the divider or not
    document.addEventListener("scroll", function() {

        showDivider(divider);
    });
    window.addEventListener("resize", function() {
        showDivider(divider);
    });
  }

  function positionNumber() {
      var timeline = document.getElementById("timeline");
      var tdimensions = timeline.getBoundingClientRect();
      var divider = document.getElementById("vertical-divider");
      var divider2 = document.getElementById("vertical-divider2");

      var numbers = document.querySelectorAll('.og-number');

      numbers.forEach(function(number, index) {

        // Now do something with my button
        var dimensions = number.getBoundingClientRect();

        var newTop = dimensions.top - tdimensions.top + 24;

        var newBottom = tdimensions.bottom - dimensions.bottom;
        var altNumber = number.getAttribute('id');
        let newNumber = document.getElementById(altNumber + 'Alt');
        newNumber.style.top = newTop + "px";
        // offset vertical line

        if (index === 0) {
          divider.style.marginTop = newTop-12 + "px";
          divider2.style.marginTop = newTop-12 + "px";
        }

        if (index === (numbers.length-1)) {
          divider.style.marginBottom = newBottom + "px";
          divider2.style.marginBottom = newBottom + "px";
        }


      });
    }

  document.addEventListener('DOMContentLoaded', function () {
    positionNumber();
  }, false);


  window.addEventListener("resize", function() {
        positionNumber();
    });
</script>
<style>
  @media (min-width: 640px) {
    div#vertical-divider::before {
      content: '';
      width: 16px;
      height: 16px;
      background: red;
      position: absolute;
      bottom: 0;
      left: 0;
      margin-left: -4px;
      margin-bottom: -16px;
      border-radius: 50%;
      background: #226cff;
    }
  }

  .timeline-img-wrap div {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: transparent;
    background-size: contain;
    margin: -2.5rem;
  }
  @media (max-width: 639px) {
  #vertical-divider,
  #vertical-divider2 {
    background-size: 3px !important;
  }
  .timeline-img-wrap div {
    margin: -1.5rem;
  }
  }
  </style>
