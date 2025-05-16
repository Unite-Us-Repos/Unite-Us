<div x-data="Components.menu({ open: true, timeout: null })" x-init="init(); width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                    if (width < 640) {
                     open = false
                    } else {
                     open = true
                    }" @keydown.escape.stop="open = false; focusButton()" @click.away=" width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                    if (width < 640) { onClickAway($event) }" @resize.window="
                    width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                    if (width < 640) {
                     open = false
                    } else {
                     open = true
                    }" class="relative w-full sm:mb-10 flex flex-col items-center">
  <div class="w-full sm:hidden">
    <button id="menu-button" type="button" class="flex w-full justify-between items-center gap-x-1.5  bg-light p-6 px-8 text-base font-medium text-brand hover:bg-gray-50" x-ref="button" @click="onButtonClick()" @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()" aria-expanded="true" aria-haspopup="true" x-bind:aria-expanded="open.toString()" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()">
      {{ $anchor_links_title ? $anchor_links_title : 'Jump To' }}
      <svg width="9" height="14" viewbox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.56152 0C4.82674 5.96046e-08 5.08109 0.105357 5.26863 0.292893L8.26863 3.29289C8.65915 3.68342 8.65915 4.31658 8.26863 4.70711C7.87811 5.09763 7.24494 5.09763 6.85442 4.70711L4.56152 2.41421L2.26863 4.70711C1.87811 5.09763 1.24494 5.09763 0.854417 4.70711C0.463892 4.31658 0.463892 3.68342 0.854417 3.29289L3.85442 0.292893C4.04195 0.105357 4.29631 0 4.56152 0ZM0.854417 9.29289C1.24494 8.90237 1.87811 8.90237 2.26863 9.29289L4.56152 11.5858L6.85442 9.29289C7.24494 8.90237 7.87811 8.90237 8.26863 9.29289C8.65915 9.68342 8.65915 10.3166 8.26863 10.7071L5.26863 13.7071C4.87811 14.0976 4.24494 14.0976 3.85442 13.7071L0.854417 10.7071C0.463892 10.3166 0.463892 9.68342 0.854417 9.29289Z" fill="#2C405A"/>
      </svg>

    </button>
  </div>

  <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
  class="relative right-0 left-0 z-10 w-full origin-top-right origin divide-y divide-gray-100 rounded-md focus:outline-none" x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state." x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()">

    <div class="jump-menu-wrap w-full md:relative">
      <ul id="jump-links" class="absolute sm:relative flex flex-col justify-center sm:flex-row  w-full flex-wrap gap-4 sm:gap-5 md:gap-x-10 list-none font-medium text-lg">
        <li class="hidden sm:block w-full text-center  lg:w-auto">
          <span style="color:#2C405A">{{ $anchor_links_title ? $anchor_links_title . ':'  : ''  }}</span>
        </li>
        @foreach($anchorLinksData as $hash => $anchor_name)
        <li>
          <a class="no-underline text-brand block" href="#{{ $hash }}">{{ $anchor_name }}</a>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>

<style>
#jump-links a {
  position: relative;
  padding-bottom: 2px;
  background: linear-gradient(90deg, #25c696 -3.11%, #216cff 35.56%, #9643ff 74.77%, #ff548b 104.31%), linear-gradient(0deg, #ffffff80, #ffffff80);
  background-clip: text;
  transition: all 0.25s linear;
}

#jump-links a:hover::after,
#video-hero-link::after {
  background: linear-gradient(90deg, #25c696 -3.11%, #216cff 35.56%, #9643ff 74.77%, #ff548b 104.31%), linear-gradient(0deg, #ffffff80, #ffffff80);
}

#jump-links a::after,
#video-hero-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 2px;
}

#video-hero-link::after {
  height: 2px;
  box-shadow: 1px 1px 30px #fff, 1px 1px 30px #0048ff
}

#jump-links a:hover {
  color: transparent;
}

.text-glow{
  text-shadow: 1px 1px 30px #fff, 1px 1px 30px #0048ff;
}
</style>
