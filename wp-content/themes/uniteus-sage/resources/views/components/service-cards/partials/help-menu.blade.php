<div x-data="{
      locations: {{ $helpMenuDataJson }},
      selectedIndex: 1,
      get selectedLocation() {
        return this.locations[this.selectedIndex];
      },
      get displayTitle() {
        return this.selectedIndex > 0 ? this.selectedLocation.title : this.locations[1].title;
      },
      get displayDescription() {
        return this.selectedIndex > 0 ? this.selectedLocation.description : this.locations[1].description;
      },
      handleKeyDown(event) {
        if (event.key === 'Enter' || event.key === ' ') {
          document.getElementById('location-description{{ $component_index }}').focus();
        }
      }
    }" class="px-1 mt-3">
    <div class="w-full flex md:grid grid-cols-12 border border-light bg-white shadow-lg rounded-lg gap-6 p-9">
      <div class="col-span-12">
        <h3 class="mb-2 sm:text-2xl">{{ $help_menu['settings']['section_title'] }}</h3>
        {!! $help_menu['settings']['section_description'] !!}
      </div>

      <div class="col-span-6">
        <label for="location" class="sr-only" id="location-label{{ $component_index }}">{{ $help_menu['settings']['select_text_prompt'] }}</label>
        <div class="mt-2 grid grid-cols-1 max-w-xs">
          <select
            id="location{{ $component_index }}"
            name="location"
            x-model="selectedIndex"
            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
            aria-labelledby="location-label{{ $component_index }}"
            aria-describedby="location-description{{ $component_index }}"
            aria-controls="location-results{{ $component_index }}"
            @keydown="handleKeyDown"
            @change="$nextTick(() => document.getElementById('location-description{{ $component_index }}').focus())"
          >
            <template x-for="(location, index) in locations" :key="index">
              <option :value="index" x-text="location.title"></option>
            </template>
          </select>
          <svg class="pointer-events-none col-start-1 row-start-1 mr-2 self-center justify-self-end text-gray-500 w-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"></path>
          </svg>
        </div>
    </div>

    <div
      id="location-results{{ $component_index }}"
      class="col-span-6"
      role="region"
      aria-live="polite"
      aria-atomic="true"
    >
      <h3 class="mb-2 sm:text-2xl" x-text="displayTitle"></h3>
      <div
        id="location-description{{ $component_index }}"
        x-html="displayDescription"
        tabindex="0"
      ></div>
    </div>
  </div>
