@if ($widget['group_title'])
<h2 class="mb-6 text-xlg lg:text-2xl font-semibold">
  {!! $widget['group_title'] !!}
</h2>
@endif
<div class="accordion accordion-vertical" x-data="{selected:9999}">
  <ul class="list-none">
    @isset ($widget['cards'])
      @foreach ($widget['cards'] as $index => $card)
        <li class="relative social-card py-6 px-9 lg:p-10 mb-6 bg-white rounded-lg shadow-lg" x-ref="container{{ $index }}" :class="{ 'open':  selected == {{ $index }} }">

          <button type="button" class="w-full" @click="selected !== {{ $index }} ? selected = {{ $index }} : selected = null">
            <h3 class="heading mb-0 text-xl font-bold">
                {!! $card['title'] !!}
            </h3>
          </button>

          <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container{{ $index }}" x-bind:style="selected == {{ $index }} ? 'max-height: ' + $refs.container{{ $index }}.scrollHeight + 'px' : ''">
            <div class="text-lg border-t border-blue-300 mt-6 pt-6">
              {!! $card['description'] !!}
            </div>
          </div>

        </li>
      @endforeach
    @endisset
  </ul>
</div>
