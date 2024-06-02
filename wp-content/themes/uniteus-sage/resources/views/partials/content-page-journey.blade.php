@php
$section = $acf['section'];
$background = $acf['background'];
$hide_breadcrumbs = true;
$buttons = false;
$cards = false;
$sections = $acf['sections'];
@endphp
<style>
html,
body {
	overflow: unset !important;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tocbot/4.18.2/tocbot.min.css" integrity="sha512-NbcJD2XMKvUk/QtduxC5P5KgNBhWbQPF3+JXhzZjoM8E9teoqJZb21bPu1dnAYLeJatNdgitYbBVz7byHKMH9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="header-hero bg-gray-800 relative component-section">
  <!-- Overlay -->

  <div class="absolute inset-0">
    @if ($background['image'])
      <img fetchpriority="high" class="w-full h-full object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif" src="{{ $background['image']['sizes']['medium'] }}"
        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
        sizes="(max-width: 600px) 300px, 1024px"
        alt="{{ $background['image']['alt'] }}">
    @endif
  </div>

  @if ($background['overlay'])
  <div class="absolute inset-0 bg-brand opacity-75"></div>
  @endif

  <div class="relative w-full @if ($cards) pb-32 @endif">

    <div class="component-inner-section">
      <div class="relative max-w-3xl">
        @if (!$hide_breadcrumbs)
          <div class="mb-9 sm:mb-10">
            @php
            $data = [
              'color' => 'white'
            ];
            @endphp
            @include('ui.breadcrumbs.simple-with-slashes', $data)
          </div>
        @endif

        @if ($section['subtitle'])
          <div class="text-white uppercase font-semibold text-xl mb-9 sm:mb-10">
            {!! $section['subtitle'] !!}
          </div>
        @endif
        <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl">
          {!! $section['title'] !!}
        </h1>
      </div>

      <div class="relative md:w-8/12 lg:w-6/12">
        @if ($section['description'])
          <div class="text-white text-xl">
            {!! $section['description'] !!}
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

<section class="component-section">
  <div class="component-inner-section">
    <div class="lg:grid lg:grid-cols-12 gap-8">
      <div class="lg:col-span-4">
        <div class="js-toc sticky top-0"></div>
      </div>
      <div class="js-toc-content lg:col-span-8">
        @if ($sections)
            @foreach ($sections as $index => $section)
              <div class="doc-section">
                <h2 id="section{{ $index }}" class="doc-heading">{{ $section['section_title'] }}</h2>
                @if ($section['section_description'])
                  <div class="section-description">
                    {!! $section['section_description'] !!}
                  </div>
                @endif

                @if ($section['sub_sections'])
                  @foreach ($section['sub_sections'] as $index_2 => $sub_section)
                    <div class="doc-sub-section border-b border-blue-100 mx-6 pb-3 mb-8">
                      <h3 id="section{{ $index }}_{{ $index_2 }}" class="doc-subheading">{{ $sub_section['sub_heading'] }}</h3>
                      @if ($sub_section['content'])
                        <div class="section-description">
                          {!! $sub_section['content'] !!}
                        </div>
                      @endif

                      @if ($sub_section['doc_widgets'])
                        @foreach ($sub_section['doc_widgets'] as $widget)
                          @isset ($widget["acf_fc_layout"])
                            @include('widgets.' . str_replace('_', '-', $widget["acf_fc_layout"]))
                         @endisset
                        @endforeach
                      @endif

                    </div>
                  @endforeach
                @endif
              </div>
            @endforeach
        @endif
      </div>
    </div>
  </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tocbot/4.18.2/tocbot.min.js" integrity="sha512-g3ESN5HI4E4N2ZsgXw6mcLgD6U8qs1vneuEhN8xq3fQcgiBz7MD1jIMBjf404FPu8NrEaJNUwwxholBy4NiIZg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  tocbot.init({
    // Where to render the table of contents.
    tocSelector: '.js-toc',
    // Where to grab the headings to build the table of contents.
    contentSelector: '.js-toc-content',
    // Which headings to grab inside of the contentSelector element.
    headingSelector: 'h2, h3',
    // For headings inside relative or absolute positioned containers within content.
    hasInnerContainers: false,
    scrollSmooth: false,
});
</script>
