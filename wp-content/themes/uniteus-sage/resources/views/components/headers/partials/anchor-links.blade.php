<ul id="jump-links" class="flex gap-10 list-none font-semibold text-lg">
  <li><span style="color:#2C405A80">Jump to Features:</span> </li>
  @foreach($anchors as $anchor)
    <li>
      <a class="no-underline text-brand" href="#{{ $anchor['id'] }}">{{ $anchor['title'] }}</a>
    </li>
  @endforeach
</ul>
<style>
  #jump-links a {
    position: relative;
    padding-bottom: 2px;
    background: linear-gradient(90deg, #25c696 -3.11%, #216cff 35.56%, #9643ff 74.77%, #ff548b 104.31%), linear-gradient(0deg, #ffffff80, #ffffff80);
    background-clip: text;
    transition: all 0.25s linear;
  }
  #video-hero-link::after,
  #jump-links a:hover::after {
    background: linear-gradient(90deg, #25c696 -3.11%, #216cff 35.56%, #9643ff 74.77%, #ff548b 104.31%), linear-gradient(0deg, #ffffff80, #ffffff80);
  }
  #video-hero-link::after,
  #jump-links a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
  }
  #video-hero-link::after {
    height: 4px;
  }
  #jump-links a:hover {
    color: transparent;
  }
</style>
