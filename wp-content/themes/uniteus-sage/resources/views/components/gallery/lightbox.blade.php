<section class="component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section relative @if ($section_settings['fullscreen']) fullscreen !px-0 @endif">
    <div class="text-center">
      @if ($section['title'] || $section['description'])
        @if ($section['title'])
          <h2>{{ $section['title'] }}</h2>
        @endif
        @if ($section['description'])
        <div class="text-lg">
          {!! $section['description'] !!}
        </div>
        @endif
      @endif
    </div>

    @if ($images)
      <div id="gallery" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
        @foreach ($images as $index => $image)
        @php
          $url = $image['sizes']['large'];
          $video = get_field('video_url', $image['ID']);
          if ($video) {
            $url = $video;
          }
          $hidden_class = '';
          if ($index > 11) {
            $hidden_class = 'hiddenStyle';
          }
        @endphp
        <a href="{{ $url }}" class="glightbox">
          <img src="{{ $image['sizes']['medium_large'] }}" alt="{{ $image['alt'] }}" class="gallery-item {{ $hidden_class }} w-full h-full aspect-video object-cover" />
        </a>
        @endforeach
      </div>
      @if (count($images) > 12)
      <div class="mt-14 text-center">
          <button id="loadMore" type="button" class="inline-flex button button-solid">
            <span class="mr-4 inline-block">Load More</span> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"></path></svg>
          </button>
        </div>
        @endif
    @endif
  </div>
</section>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script type="text/javascript">
  const lightbox = GLightbox();


  console.clear();
var work = document.querySelector("#gallery");
var items = Array.from(work.querySelectorAll(".gallery-item"));
var loadMore = document.getElementById("loadMore");
maxItems = 12;
loadItems = 8;
hiddenClass = "hiddenStyle";
hiddenItems = Array.from(document.querySelectorAll(".hiddenStyle"));

items.forEach(function (item, index) {
  if (index > maxItems - 1) {
    item.classList.add(hiddenClass);
  }
});

loadMore.addEventListener("click", function () {
  [].forEach.call(document.querySelectorAll("." + hiddenClass), function (
    item,
    index
  ) {
    if (index < loadItems) {
      item.classList.remove(hiddenClass);
    }

    if (document.querySelectorAll("." + hiddenClass).length === 0) {
      loadMore.style.display = "none";
    }
  });
});

</script>
<style>

.hiddenStyle {
  position: absolute;
  overflow: hidden;
  clip: rect(0 0 0 0);
  height: 1px;
  width: 1px;
  margin: -1px;
  padding: 0;
  border: 0;
}

</style>
