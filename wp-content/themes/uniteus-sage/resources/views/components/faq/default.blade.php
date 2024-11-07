@php
$s_settings = [
    'collapse_padding' => false,
    'fullscreen' => '',
];
$section_settings = isset($acf["components"][$index]['layout_settings']['section_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : $s_settings;

$faqs = $acf["components"][$index]['faq']['faq_wrapper'] ?? [];
$faq_title = $acf["components"][$index]['faq']['title'] ?? 'Frequently Asked Questions';
@endphp

@if ($background['has_divider'])
@includeIf('dividers.waves')
@endif

<section @isset($acf["components"][$index]['id']) id="{{ $acf["components"][$index]['id'] }}" @endisset class="relative component-section {{ $section_classes }}">
  <div class="relative component-inner-section max-w-3xl mx-auto">
    <h2 class="text-4xl font-bold mb-8 text-center">{{ $faq_title }}</h2>

    @if (!empty($faqs))
      <div class="accordion accordion-vertical" x-data="{ selected: null }">
        <ul class="list-none">
          @foreach ($faqs as $index => $faq)
            <li class="relative faq-item py-6 px-9 lg:p-10 mb-6 bg-white rounded-lg shadow-lg" x-ref="container{{ $index }}" :class="{ 'open': selected === {{ $index }} }">

              <!-- Question button -->
              <button type="button" class="w-full text-left flex justify-between items-center" @click="selected !== {{ $index }} ? selected = {{ $index }} : selected = null">
                <h3 class="faq-question text-xl font-semibold mb-0">
                  {{ $faq['question'] ?? 'No question provided' }}
                </h3>
              
              </button>

              <!-- Answer with sliding effect -->
              <div class="relative overflow-hidden transition-all max-h-0 duration-700" 
                   x-ref="container{{ $index }}" 
                   x-bind:style="selected === {{ $index }} ? 'max-height: ' + $refs.container{{ $index }}.scrollHeight + 'px' : ''">
                <div class="faq-answer text-lg border-t border-blue-300 mt-6 pt-6">
                  {!! $faq['answer'] ?? 'No answer provided' !!}
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    @else
      <p class="text-lg text-red-500">No FAQ items found.</p>
    @endif
  </div>
</section>

@if ($background['divider_bottom'])
@includeIf('dividers.waves-bottom')
@endif

<style>
.rotate-180 {
  transform: rotate(180deg);
  transition: transform 0.3s ease;
}
</style>
