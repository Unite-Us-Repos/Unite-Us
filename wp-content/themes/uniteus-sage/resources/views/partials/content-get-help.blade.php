@php
$taxonomy = 'states';
$args = array(
    'hide_empty' => false
);
$items = [];
$states = [];
array_push($networkActiveStates, 'all');
$state_taxonomy = get_terms($taxonomy, $args);
foreach ($state_taxonomy as $index => $state) {
  if (in_array($state->slug, $networkActiveStates)) {
    $states[] = $state;
  }
}

foreach ($states as $index => $state) {
  if (in_array($state->slug, $networkActiveStates)) {
    $items[] = '{&quot;id&quot;:' . $index . ',&quot;name&quot;:&quot;' . htmlentities(str_replace('- All -', 'Select a State', $state->name)) . '&quot;}';
  }
}
$items = array_merge($items);
$states = array_merge($states);
@endphp
<script>
  function redirectNetwork(selectedIndex) {
    let url = document.getElementById('listbox-option-' + selectedIndex).getAttribute('data-url');
    let link = url;
    if ('/networks/all/get-help/' == link) {
      alert('Please select a state.');
      return false;
    }
    window.location=link;
  }
</script>
<section class="component-section bg-brand" style="background: linear-gradient(180deg, #182A44 0%, #2C405A 100%), linear-gradient(0deg, rgba(24, 42, 68, 0.75) 0%, rgba(24, 42, 68, 0.75) 100%), lightgray 50% / cover no-repeat;">
  <div class="component-inner-section py-14 lg:py-40">
      <h1 class="mb-3 text-center text-white">
        Get Help
      </h1>
      <div class="text-xl text-white font-semibold text-center mb-6">
        <p>Looking for housing, food, or other resources in your community?</p>
      </div>
    <div
      x-data="Components.listbox({ modelName: 'selected', open: false, selectedIndex: 0, activeIndex: 0, items: [{!! implode(',', $items) !!}] })"
      x-init="init()">
      <label
        id="listbox-label"
        class="sr-only block text-base font-medium leading-[1.5] text-brand"
        @click="$refs.button.focus()">
        Select your state
      </label>
      <div class="relative mt-2 flex flex-col gap-6 sm:gap-0 sm:flex-row justify-center max-w-2xl mx-auto">
        <button type="button"
          class="relative w-full cursor-default rounded-md sm:rounded-tr-none sm:rounded-br-none bg-white py-4 pl-6 pr-10 text-left text-brand font-bold shadow-sm ring-1 ring-inset ring-light focus:outline-none focus:ring-2 focus:ring-brand"
          x-ref="button" @keydown.arrow-up.stop.prevent="onButtonClick()"
          @keydown.arrow-down.stop.prevent="onButtonClick()" @click="onButtonClick()" aria-haspopup="listbox"
          :aria-expanded="open" aria-labelledby="listbox-label">
          <span x-text="selected.name" class="block truncate">Tanya Fox</span>
          <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3C10.2652 3 10.5196 3.10536 10.7071 3.29289L13.7071 6.29289C14.0976 6.68342 14.0976 7.31658 13.7071 7.70711C13.3166 8.09763 12.6834 8.09763 12.2929 7.70711L10 5.41421L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711C5.90237 7.31658 5.90237 6.68342 6.29289 6.29289L9.29289 3.29289C9.48043 3.10536 9.73478 3 10 3ZM6.29289 12.2929C6.68342 11.9024 7.31658 11.9024 7.70711 12.2929L10 14.5858L12.2929 12.2929C12.6834 11.9024 13.3166 11.9024 13.7071 12.2929C14.0976 12.6834 14.0976 13.3166 13.7071 13.7071L10.7071 16.7071C10.3166 17.0976 9.68342 17.0976 9.29289 16.7071L6.29289 13.7071C5.90237 13.3166 5.90237 12.6834 6.29289 12.2929Z" fill="#216CFF"/>
            </svg>
          </span>
        </button>


        <ul x-show="open" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
          class="absolute list-none z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-base"
          x-max="1" @click.away="open = false" x-description="Select popover, show/hide based on select state."
          @keydown.enter.stop.prevent="onOptionSelect()" @keydown.space.stop.prevent="onOptionSelect()"
          @keydown.escape="onEscape()" @keydown.arrow-up.prevent="onArrowUp()"
          @keydown.arrow-down.prevent="onArrowDown()" x-ref="listbox" tabindex="-1" role="listbox"
          aria-labelledby="listbox-label" :aria-activedescendant="activeDescendant"
          aria-activedescendant="listbox-option-4" style="display: none;">

          @foreach ($states as $index => $state)
          <li x-state:on="Highlighted" x-state:off="Not Highlighted"
            class="relative cursor-default select-none py-2 pl-8 pr-4 text-brand"
            x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
            id="listbox-option-{{ $index }}" role="option" @click="choose({{ $index }})" data-url="/networks/{{ $state->slug }}/get-help/"
@mouseenter="onMouseEnter($event)" @mousemove="onMouseMove($event, {{ $index }})" @mouseleave="onMouseLeave($event)"
            :class="{ 'bg-light text-brand font-bold': activeIndex === {{ $index }}, 'text-brand': !(activeIndex === {{ $index }}) }">
            <span x-state:on="Selected" x-state:off="Not Selected" class="font-normal block truncate"
              :class="{ 'font-semibold': selectedIndex === {{ $index }}, 'font-normal': !(selectedIndex === {{ $index }}) }">
              {{ str_replace('- All -', 'Select a State', $state->name) }}
            </span>

            <span x-description="Checkmark, only display for selected option." x-state:on="Highlighted"
              x-state:off="Not Highlighted" class="absolute inset-y-0 left-0 flex items-center pl-1.5 text-brand"
              :class="{ 'text-white': activeIndex === {{ $index }}, 'text-brand': !(activeIndex === {{ $index }}) }"
              x-show="selectedIndex === {{ $index }}" style="display: none;">
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                  d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                  clip-rule="evenodd"></path>
              </svg>
            </span>
          </li>
          @endforeach
        </ul>
        <button @click="redirectNetwork(selectedIndex)" class="button button-solid sm:!rounded-tl-none !font-semibold sm:!rounded-bl-none !px-12 items-center">Submit</button>
      </div>
    </div>

  </div>
</section>






<section class="component-section hidden relative bg-white padding-collapse-t" style="background:#2C4059;">
  <div class="absolute bottom-0 border border-blue-900 -ml-4 w-full h-3/6 -mb-[1px] bg-blue-900"></div>

  <div class="component-inner-section relative ">
    <div class="bg-light w-full rounded-2xl flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 lg:gap-20">

      <div class=" order-2  p-9 md:p-20 flex flex-col  justify-center  text-lg  md:order-1  lg:mb-0">
                  <div class="subtitle n-case mb-3">
            Ready to get started?
          </div>
                <h2 class="mb-0">Start building healthier communities today. </h2>

                            <div class="flex flex-wrap justify-center flex-col sm:flex-row gap-6  mt-9 sm:mt-10  button-layout-buttons flex md:justify-start">
                        <div class=" inline-flex ">
          <a href="" class="button  flex items-center gap-3  button-solid" style="text-decoration:none !important;">
            Request Demo

                                              </a>
        </div>
            </div>
              </div>

      <div class="relative pt-0 p-9 md:p-9  pb-0 md:p-0   flex flex-col  justify-center   md:order-2 ">
                  <img class="lazy rounded-lg w-full max-w-sm mx-auto lg:max-w-md" data-src="/wp-content/uploads/2022/09/building-communities.png" alt="building communities">


                                </div>
    </div>
  </div>
</section>
