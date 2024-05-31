<article @php (post_class()) @endphp="@php (post_class()) @endphp">
  <header>
    <section class="component-section  bg-brand">
      <div class="component-inner-section">
        <div class="max-w-4xl px-10 mx-auto leading-loose">
            <div class="flex justify-center mb-8 sm:mb-10">
              @php
              $data = [
                'color' => 'white',
                'linkable' => false,
              ];
              @endphp
              @include('ui.breadcrumbs.simple-with-slashes', $data)
            </div>
            <h1 class="entry-title text-center leading-none mb-8 sm:mb-10 text-white text-4xl lg:text-5xl">
              {!! $title !!}
            </h1>
        </div>
        @include('partials.entry-meta', $data)
      </div>
    </section>
  </header>

  <div class="component-section">
    <div class="max-w-4xl px-5 sm:px-16 mx-auto leading-loose">
      @php(the_content())
    </div>
  </div>

  <div class="max-w-4xl mb-10 mx-auto">
    @isset ($press_about)
    <div id="newsAbout" class="bg-light sm:rounded-xl sm:mx-8 p-10 leading-loose">
      {!! $press_about !!}
    </div>
    @endisset
  </div>
</article>
