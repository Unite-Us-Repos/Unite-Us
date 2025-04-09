@php
$s_settings = [
    'collapse_padding' => false,
    'fullscreen' => '',
];
$section_settings = isset($acf["components"][$index]['layout_settings']['section_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : $s_settings;

$faqs = $acf["components"][$index]['faq']['faq_wrapper'] ?? [];
$faq_title = $acf["components"][$index]['faq']['title'] ?? 'Frequently Asked Questions';

$faq_schema_json = ''; // Initialize as empty

if (!empty($faqs)) {
    $faq_schema = [
        "@context" => "https://schema.org",
        "@type" => "FAQPage",
        "mainEntity" => []
    ];

    foreach ($faqs as $faq) {
        $question = $faq['question'] ?? 'No question provided';
        $answer = $faq['answer'] ?? 'No answer provided';

        // Strip all HTML tags and trim whitespace & newlines
        $clean_answer = strip_tags($answer);
        $clean_answer = preg_replace('/\s+/', ' ', $clean_answer); // Replace multiple spaces/newlines with a single space
        $clean_answer = trim($clean_answer); // Trim leading/trailing spaces

        $faq_schema['mainEntity'][] = [
            "@type" => "Question",
            "name" => trim($question), // Trim question to remove leading/trailing spaces
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => $clean_answer
            ]
        ];
    }

    // Convert array to JSON
    $faq_schema_json = json_encode($faq_schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
@endphp

@if (!empty($faq_schema_json))
  <script type="application/ld+json">
  {!! $faq_schema_json !!}
  </script>
@endif


@if ($background['has_divider'])
@includeIf('dividers.waves')
@endif

<section
  @isset($acf["components"][$index]['id']) id="{{ $acf["components"][$index]['id'] }}" @endisset
  class="relative component-section {{ $section_classes }}
  @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif"
  @if ($section_settings['padding_class'] == 'padding-collapse') style="padding: 0;" @endif
>
  <div
    class="relative component-inner-section
    @if ($section_settings['fullscreen']) fullscreen @endif"
    @if ($section_settings['padding_class'] == 'padding-collapse') style="padding: 0;" @endif
  >


  <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-14">
    <div class="col-span-6">
      @if ($section['title'] || $section['description'])
        <div class="text-left text-lg max-w-4xl mx-auto mb-10">
          @if ($section['title'])

            <h2> <span id="rotating-title-text" class="block text-action" x-data="rotatingText({ words: ['Screenings', 'Resources', 'Referrals', 'Reimbursements'], delay: 2000, capitalize: true, addPeriod: true })" x-text="currentText" >Screenings.</span> All Made Simpler! </h2>

          @endif
          @if ($section['description'])
            {!! $section['description'] !!}
          @endif
        </div>
      @endif

      @if (!empty($faqs))
      <div class="accordion accordion-vertical" x-data="{
      selected: null,
      updateSwiper(index) {
        // Always update the swiper regardless of screen size
        if (window.swiperInstance) {
          window.swiperInstance.slideTo(index);
        }
      }
    }">
          <ul class="special-accordion list-none">
            @foreach ($faqs as $index => $faq)
              <li class="relative faq-item py-6 px-9 lg:p-10 mb-6 bg-white rounded-lg shadow-lg" x-ref="container{{ $index }}" :class="{ 'open': selected === {{ $index }} }">

                <!-- Question button -->
                <button type="button" class="w-full text-left flex justify-between items-center"
                  @click="
                    if(selected !== {{ $index }}) {
                      selected = {{ $index }};
                      updateSwiper({{ $index }});
                    } else {
                      selected = null;
                    }
                  ">
                  <h3 class="faq-question text-xl font-semibold mb-0 pr-10"
                  :class="{ 'text-action title-text-clip': selected === {{ $index }} }">
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
          <p class="text-lg text-red-500">No items found.</p>
        @endif
      </div>

      <div class="col-span-6">
        <div class="sticky top-20">
          @include('components.faq.partials.swiper', $faqs)
        </div>
      </div>
    </div>
  </div>
</section>

@if ($background['divider_bottom'])
@includeIf('dividers.waves-bottom')
@endif
<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('rotatingText', (config = {}) => ({
      words: config.words || [],
      wordIndex: 0,
      delay: config.delay || 2000,
      capitalize: config.capitalize !== undefined ? config.capitalize : true,
      addPeriod: config.addPeriod !== undefined ? config.addPeriod : true,

      init() {
        setInterval(() => {
          this.wordIndex = (this.wordIndex + 1) % this.words.length;
        }, this.delay);
      },

      get currentText() {
        let text = this.words[this.wordIndex];

        if (this.capitalize) {
          text = text.charAt(0).toUpperCase() + text.slice(1);
        }

        if (this.addPeriod) {
          text += '.';
        }

        return text;
      }
    }));
  });
</script>

<style>
#rotating-title-text,
.special-accordion .faq-question {
  background: linear-gradient(0deg, #216CFF, #216CFF),
  linear-gradient(90deg, rgba(150, 67, 255, 0) 0%, #9643FF 100%);
  background-clip: text;
  transition: all 0.25s linear;
}
#rotating-title-text,
.special-accordion .faq-question.title-text-clip {
  color: transparent;
}

.special-accordion .faq-item {
  background: linear-gradient(0deg, rgba(33, 108, 255, 0.05), rgba(33, 108, 255, 0.05)),
  linear-gradient(90deg, rgba(150, 67, 255, 0) 0%, rgba(150, 67, 255, 0.05) 100%);
}
</style>
