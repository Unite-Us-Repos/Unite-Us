{{-- <style>
.gh-hide {
  display: none !important;
}
</style>
<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="gh-filter-bar relative component-section bg-light-gradient  padding-collapse-y ">
  <div class="component-inner-section">
    <div id="greenhouse-filters" class="ajax-filters greenhouse-filters relative z-20">
            <ul>
                <li class="sf-field-taxonomy-industry" data-sf-field-name="_sft_industry" data-sf-field-type="taxonomy"
                    data-sf-field-input-type="checkbox">
                    <div class="relative w-full" x-data="Components.popover({ open: false, focus: false })"
                        x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
                        <button type="button" x-state:on="Item active" x-state:off="Item inactive"
                            class="group w-full top-10 justify-between inline-flex items-center rounded-md bg-white text-base font-medium focus:outline-none focus:ring-2 focus:ring-action focus:ring-offset-2 text-sm text-brand"
                            :class="{ 'text-brand': open, 'text-brand': !(open) }" @click="toggle"
                            @mousedown="if (open) $event.preventDefault()" aria-expanded="false"
                            :aria-expanded="open.toString()">
                            <span>All Departments</span>
                            <svg x-state:on="Item active" x-state:off="Item inactive" class="ml-2 h-5 w-5 text-brand"
                                :class="{ 'text-gray-600': open, 'text-brand': !(open) }"
                                x-description="Heroicon name: mini/chevron-down" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            x-description="Flyout menu, show/hide based on flyout menu state."
                            class="absolute filter-drop-menu inset-x-0 z-10 transform bg-white ring-1 ring-black ring-opacity-5 shadow-lg rounded"
                            x-ref="panel" @click.away="open = false" style="display: none;">

                            <ul data-operator="or" class="">
                              @foreach ($departments as $index => $department)

                                @if ($department['jobs'])
                                <li class="sf-level-0">
                                  <input
                                    class="sf-input-checkbox" type="checkbox" data-filter-type="department" value="gh-filter-{!! $department['id'] !!}" name="gh-department[]"
                                    id="gh-filter-{!! $department['id'] !!}">
                                    <label class="sf-label-checkbox w-full"
                                    for="gh-filter-{!! $department['id'] !!}">{!! $department['name'] !!}</label>
                                  </li>
                                @endif
                              @endforeach
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="sf-field-category" data-sf-field-name="_sft_category" data-sf-field-type="category"
                    data-sf-field-input-type="text">
                    <div class="relative w-full" x-data="Components.popover({ open: false, focus: false })"
                        x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
                        <button type="button" x-state:on="Item active" x-state:off="Item inactive"
                            class="group w-full top-10 justify-between inline-flex items-center rounded-md bg-white text-base font-medium focus:outline-none focus:ring-2 focus:ring-action focus:ring-offset-2 text-sm text-brand"
                            :class="{ 'text-brand': open, 'text-brand': !(open) }" @click="toggle"
                            @mousedown="if (open) $event.preventDefault()" aria-expanded="false"
                            :aria-expanded="open.toString()">
                            <span>All Offices</span>
                            <svg x-state:on="Item active" x-state:off="Item inactive" class="ml-2 h-5 w-5 text-brand"
                                :class="{ 'text-gray-600': open, 'text-brand': !(open) }"
                                x-description="Heroicon name: mini/chevron-down" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            x-description="Flyout menu, show/hide based on flyout menu state."
                            class="absolute filter-drop-menu inset-x-0 z-10 transform bg-white ring-1 ring-black ring-opacity-5 shadow-lg rounded"
                            x-ref="panel" @click.away="open = false" style="display: none;">

                            <ul class="">
                              @foreach ($active_offices as $office_name => $office_id)
                                <li class="sf-level-0">
                                  <input
                                    class="sf-input-checkbox filter-office" type="checkbox" data-filter-type="office" value="gh-filter-{{ $office_id }}" name="gh-offices[]"
                                    id="gh-filter-{{ $office_id }}">
                                    <label class="sf-label-checkbox w-full"
                                    for="gh-filter-{{ $office_id }}">{!! $office_name !!}
                                  </label>
                                </li>
                              @endforeach
                            </ul>
                        </div>
                    </div>
                </li>


                <li class="sf-field-search" data-sf-field-name="search" data-sf-field-type="search" data-sf-field-input-type="">
                  <label class="w-full">
                    <input id="gh-search" placeholder="Search" name="_sf_search[]" class="w-full sf-input-text" type="text" value="" title="">
                  </label>
                </li>

            </ul>
    </div>
    <div id="filterBadges" class="relative flex flex-wrap items-center gap-y-4 py-10 z-10"></div>

</div>
</div>
</section> --}}
