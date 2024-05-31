@php
  $form_content = '';
  $help_page = (get_query_var('get-help') != '') ? get_query_var('get-help') : 1;
  if (is_numeric($help_page)) {
    $help_page = $help_page-1;
  }
  $title = 'Get Help';
  $network_forms = get_field('network_forms', $networkFormId);
  $new_network_forms = [];

  if ($network_forms && is_array($network_forms)) {
    foreach ($network_forms as $index => $form) {
      if ($form['network_form_slug']) {
          $index = $form['network_form_slug'];
      }
      $new_network_forms[$index] = $form;
    }
  }

  if ($networkFormSelect && ('' == get_query_var('get-help'))) {
    // show dropmenu
    $form_content .= $networkFormSelect;
  } else {
    // show form

    if ($network_forms) {
      foreach ($new_network_forms as $index => $form) {
        if ($index == ($help_page)) {
          $form_content .= $form['network_form_embed'];

          if ($form['form_page_title']) {
            $title = $form['form_page_title'];
          }
        }
      }
    }
  }
@endphp
<article @php (post_class('default-page')) @endphp="@php (post_class()) @endphp">
  <header>
    <section class="component-section  bg-brand">
      <div class="component-inner-section">
        <div class="max-w-4xl mx-auto leading-loose">
            <div class="mb-9 sm:mb-10">
              @php
              $data = [
                'color' => 'white'
              ];
              @endphp
              @include('ui.breadcrumbs.simple-with-slashes', $data)
            </div>
            <h1 class="entry-title leading-none mb-0 text-white text-4xl lg:text-5xl">
              {!! $title !!}
            </h1>
        </div>
      </div>
    </section>
  </header>

  <div class="component-section">
    <div class="max-w-4xl mx-auto leading-loose">
      <div class="text-lg">
        {!! $networkHeaderText !!}
      </div>

      <div class="my-8">
        {!! $form_content !!}
      </div>

      <div class="text-lg">
        {!! $networkFooterText !!}
      </div>
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
<script>
 document.addEventListener("DOMContentLoaded", () => {
  // Selecting the iframe element
  var uucontainer = document.getElementById("uu-container");
  var iframe = uucontainer.getElementsByTagName("iframe")[0];
  // Adjusting the iframe height onload event
  setTimeout(function() {
    iframe.setAttribute("scrolling", "yes");
  }, 500);
});
</script>
<style>
  #uu-container iframe {
    height: 1000px;
  }
  </style>
