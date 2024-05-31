<div class="bg-white py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
@if ($section['title'] || $section['description'])
  <div class="text-center max-w-4xl mx-auto">
    @if ($section['title'])
      <h2>{{ $section['title'] }}</h2>
    @endif
    @if ($section['description'])
    <div class="text-xl">
      {!! $section['description'] !!}
    </div>
    @endif
  </div>
@endif

{!! $code_editor !!}

</div>

<script src="https://unpkg.com/popper.js@1"></script>
<script src="https://unpkg.com/tippy.js@4"></script>

<style>
svg#us-map a:focus {
   outline: none;
}

svg#us-map path:hover,
svg#us-map path.tippy-active {
  stroke: #fff;
  stroke-width: 2px;
  stroke-linejoin: round;
  fill: #3B8BCA;
  cursor: pointer;
  outline: none !important;
}

svg#us-map path:focus {
  outline: none !important;
}

.tippy-tooltip.map-theme {
  color: #2C405A;
  background-color: #EAF0F7;
  border-radius: 8px;
  padding: 25px;
  font-family: arial;
  height: auto;
}

.tippy-tooltip.map-theme[data-animatefill] {
  background-color: transparent;
}

.tippy-tooltip.map-theme .tippy-backdrop {
  background-color: #EAF0F7;
}

.tippy-tooltip.map-theme[x-placement^='top'] .tippy-arrow {
  border-top-color: #EAF0F7;
}
.tippy-tooltip.map-theme[x-placement^='bottom'] .tippy-arrow {
  border-bottom-color: #EAF0F7;;
}
.tippy-tooltip.map-theme[x-placement^='left'] .tippy-arrow {
  border-left-color: #EAF0F7;;
}
.tippy-tooltip.map-theme[x-placement^='right'] .tippy-arrow {
  border-right-color: #EAF0F7;;
}
</style>
<script>
  document.addEventListener('DOMContentLoaded', function () {

const instance = tippy('#us-map path[data-info]', {
  content(reference) {
    const id = 'stateTemplate'
    const tipContent = reference.getAttribute('data-info')
    const container = document.createElement('div')
    const linkedTemplate = document.getElementById(id)
    const boxContent = linkedTemplate.querySelector('#info-box-content')
    boxContent.innerHTML = tipContent
    const node = document.importNode(linkedTemplate, true)
    container.appendChild(node)
    return node
  },
  theme: 'map',
  animateFill: false,
  animation: 'scale',
  interactive: true,
  followCursor: 'initial',
  delay: 250,
  arrow: false,
  trigger: 'click focus',
  hideOnClick: 'false',
  duration: 0,
  maxWidth: 250,
  onShown: function(instance) {
    // on enter, trigger click on popup button
    function goToLink() {
      const popper = document.querySelector('.tippy-popper');
      let urlRegex = /(href='https?:\/\/[^ ]*')/;
      let bubbleLink = instance.reference.dataset.info;
      bubbleLink = bubbleLink.match(urlRegex)[1];
      bubbleLink = bubbleLink.replace('href=', '');
      bubbleLink = bubbleLink.replace("'", "");
      window.location.href = bubbleLink;
    }

    function onKeyDown(event) {
      if (event.key === "Enter") {
        if (instance.state.isVisible) {
          goToLink();
        }
      }
    }

    document.addEventListener('keydown', onKeyDown);

    document.addEventListener('click', function (event) {
      if (!event.target.closest('.close-bubble')) return;
      event.preventDefault();
      instance.hide();
    });
  }
});

}, false);

</script>
<div style="display: none;position:relative;">
  <div id="stateTemplate"><a href="#" id="close-bubble" class="close-bubble"><svg xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6" fill="#4d95cf" viewBox="0 0 24 24" stroke="white" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg></a>
    <div id="info-box-content">Loading...</div>
  </div>
</div>
