@php
$info = $acf['event_info'];

if (!$info['timezone']) {
  $info['timezone'] = 'America/New_York';
}
date_default_timezone_set($info['timezone']);

$signup = isset($acf['sign_up']) ? $acf['sign_up'] : [];
$featured_speakers[] = (isset($acf['featured_speaker']) && !empty($acf['featured_speaker']['first_name'])) ? $acf['featured_speaker'] : [];
$style = isset($acf['event_style']) ? $acf['event_style'] : false;
$show_social = true;
function formatDateRange($d1, $d2, $format = '') {

    if ($d1->format('Y-m-d') === $d2->format('Y-m-d')) {
	# Same day
	if (!$format) {
		$format = 'd. F';
	}
        return $d1->format($format);
    } elseif ($d1->format('Y-m') === $d2->format('Y-m')) {
        # Same calendar month
        return $d1->format('F j') . ' and ' . $d2->format('j, Y');
    } elseif ($d1->format('Y') === $d2->format('Y')) {
        # Same calendar year
        return $d1->format('d. F') . $d2->format('d. F');
    } else {
        # General case (spans calendar years)
        return $d1->format('d. F Y') . $d2->format('d. F Y');
    }
}



$utc = new DateTimeZone('UTC');
$dt = new DateTime('now', $utc);
$current_tz = new \DateTimeZone($info['timezone']);
$transition = $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
$abbr = $transition[0]['abbr'];

$d1 = new \DateTime($info['event_dates']['start']);
$d2 = new \DateTime($info['event_dates']['end']);
$dates = formatDateRange($d1, $d2, 'l, F d, Y');
$title_date = formatDateRange($d1, $d2);

if ($info['start_time'] AND $info['end_time']) {
  $start_time = str_replace(' pm', '', $info['start_time']);
  $start_time = str_replace(' am', '', $start_time);
$times = $start_time . '&mdash;' . $info['end_time'] . ' ' . $abbr;
  $title_date .= '<br />' . 'from ' . $start_time . '&mdash;' . $info['end_time'] . ' ' . $abbr;
} elseif ($info['start_time']) {
  $title_date .= '<br />' . 'starting at ' . $info['start_time'];
	$times = $start_time . ' ' . $abbr;
}

if ('manual' == $info['title_display']) {
  $title_date = $info['subtitle'];
}

$alt_content = $acf['side_byside_content'];
$cta = isset($acf['cta']) ? $acf['cta'] : [];
$additional_information = $acf['additional_information']['additional_information'];
$agendas = $acf['agenda']['agenda'];
$tabs = [];
$sessions = [];
if (is_array($agendas)) {
  foreach ($agendas as $index=> $item) {
    $tabs[] = [
      'title' => date('l', strtotime($item['date'])),
      'summary' => $item['summary'],
      'sessions' => $item['sessions'],
      ];
  }
}
$background = [
  'has_divider' => true,
  'color' => 'light',
  ];

$zones = [
    'PST' => 'America/Los_Angeles',
    'EST' => 'America/New_York',
  ];

$gmdate_str = gmdate('Y-m-d H:i:s', strtotime($info['start_date_time']));
$countdown = $gmdate_str;
$today_time_stamp = strtotime(date('Ymd H:i:s'));
$event_end_time_stamp = strtotime($info['event_dates']['end'] . ' ' . $info['end_time']);
$registration_open = 1;
if ($event_end_time_stamp < $today_time_stamp) {
  $registration_open = 0;
}
$show_additinal_information = false;
@endphp
@if ($style == 'oc2')
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400;1,700&family=Syne:wght@400;700&display=swap" rel="stylesheet">
@endif


<style>
@media (min-width: 1024px) {
.large-extra-padding {
padding: 5rem 0;
}
}
.mobile-margin-offset {
margin-left: -5rem;
margin-right: -5rem;
}


@if ($style == 'oc2')
  h1 {
    font-weight: 700 !important;
    font-family: 'Syne', sans-serif !important;
    font-size: 38px !important;
  }
  h2 {
    font-size: 38px;
    font-family: 'Syne', sans-serif;
  }
@endif
  span.scribble-bottom {
      background: url(/wp-content/uploads/2023/05/heading-oc2-bottom-scribble.png) no-repeat center bottom;
      background-size: 184px;
      min-width: 184px;
      display: inline-block;
      padding-bottom: 40px;
  }

  h1 span.scribble-bottom {
    min-width: 240px;
    background-size:240px;
    padding-bottom: 45px;
  }
@media only screen and (min-width: 1024px) {
  h1 {
  font-size: 4.25rem !important;
  }

  h1 span.scribble-bottom {
    background-position:bottom left;
  }
}
</style>


<style>
.basic-button {
	font-weight: 600;
	font-size: 18px;
	padding: 0.5rem 1.5rem;
}
@media only screen and (max-width: 1023px) {
.countdown {
  background-image: linear-gradient(#C7D8E8, #C7D8E8), linear-gradient(#C7D8E8, #C7D8E8);
  background-size: calc(100% - 32px) 1px, 1px calc(100% - 32px);
  background-repeat: no-repeat, no-repeat;
  background-position: center center, center center;
}
}
</style>

<section class="relative component-section padding-collapse bg-dark">
@if ($info['hero_bg_image'])
<div class="absolute inset-0 hidden lg:block">
        <img class="w-auto h-full" src="{{ $info['hero_bg_image']['sizes']['large'] }}"  alt="{{ $info['hero_bg_image']['alt'] }}" />
      </div>
      @endif


      @if ($style == 'oc2')



<div class="absolute right-0 left-0 top-0 flex justify-center z-40 hidden lg:block">
<img src="/wp-content/uploads/2023/05/oc2-hero-tc-overlay.png" alt="" class="mx-auto" style="width: auto;height: 120px" />
</div>

<div class="absolute top-0 right-0 z-40">
<img src="/wp-content/uploads/2023/05/oc2-hero-tr-overlay.png" alt="" style="width: auto;height: 190px" />
</div>

@endif

      @if ($style == 'oc2')
<div class="absolute hidden lg:block right-0 z-10 bg-white h-full" style="left:50%">
        <img class="w-full h-full object-cover" src="{{ $info['hero_image']['sizes']['large'] }}"  alt="{{ $info['hero_image']['alt'] }}" />

        </div>
      @endif
 <div class="component-inner-section relative z-10">

 @if ($style == 'oc2')

 <div class="absolute bottom-0 right-0 left-0 flex justify-start lg:hidden" style="z-index: -1;margin-left: -1rem;">
<img src="/wp-content/uploads/2023/05/oc2-hero-bg-ball-mobile.png" alt="" />
</div>

<div class="absolute bottom-0 right-0 left-0 flex justify-center z-10 hidden lg:flex">
<img src="/wp-content/uploads/2023/05/oc2-overlay-ball.png" alt="" style="width: auto;height: 290px" />
</div>

@endif
    <div class="flex flex-col gap-10 lg:grid lg:grid-cols-12">
      <div class="@if ($style == 'oc2') large-extra-padding @endif lg:col-span-6 mb-14 lg:mb-0 flex flex-col py-20 items-center lg:items-start justify-center gap-10 order-2 lg:order-1">
        @if ($info['logo'])
          <img class="w-48 h-auto mx-auto lg:mx-0" src="{{ $info['logo']['sizes']['medium_large'] }}" alt="" />
	  @endif

	  @if ($info['secondary_logo'])
          <img class="w-full h-auto mx-auto lg:mx-0" style="max-width: 396px" src="{{ $info['secondary_logo']['sizes']['large'] }}" alt="" />
        @endif
        <h1 class="text-white px-6 lg:px-0 font-normal text-center lg:text-left mb-0"><span @if($style == 'oc2') class="scribble-bottom" @endif>{!! $info['title'] !!}</span></h1>

        @if ($registration_open)
        <div style="max-width:550px" class="relative z-20 countdown-container w-full mx-auto lg:mx-0 lg:mb-0 text-center flex flex-col lg:flex-row items-center justify-between overflow-hidden rounded-2xl lg:rounded-full">
          <div class="bg-white w-4 h-full">
          </div>

          <div class="countdown w-full lg:h-full grid grid-cols-2 gap-6 lg:flex lg:items-center py-4 lg:py-0 px-6 justify-between bg-white" data-date="{{ $countdown }}" data-timezone="{{ $info['timezone'] }}">
            <div class="counter">
              <span id="days" class="value block text-3xl font-extrabold text-brand" data-days>00</span>
              <span class="suffix block uppercase text-sm text-action">Days</span>
            </div>

            <div class="counter">
              <span id="hours" class="value block text-3xl font-extrabold text-brand" data-hours>00</span>
              <span class="suffix block uppercase text-sm text-action">Hours</span>
            </div>

            <div class="counter">
              <span id="minutes" class="value block text-3xl font-extrabold text-brand" data-minutes>00</span>
              <span class="suffix block uppercase text-sm text-action">Mins</span>
            </div>

            <div class="counter">
              <span id="seconds" class="value block text-3xl font-extrabold text-brand" data-seconds>00</span>
              <span class="suffix block uppercase text-sm text-action">Secs</span>
            </div>
          </div>
          <a class="bg-action w-full lg:w-auto px-6 no-underline shrink-0 text-white hover:text-white text-base font-normal p-6" href="{{ $info['registration_link'] }}">Register Now</a>
        </div>
        @else
        @isset ($info['hero_button_link'])
          <a href="{!! $info['hero_button_link'] !!}" class="button button-solid flex-grow-0 z-20">
            {!! $info['hero_button_text'] !!}
          </a>
        @endif
        @endisset

      </div>

      <div class="relative @if ($style == 'oc2') mobile-margin-offset lg:hidden  @endif lg:col-span-6 order-1 lg:order-2">
     @if ($style == 'oc2')


       <div class="absolute left-0 bottom-0 top-0 flex items-end z-40 lg:hidden" style="margin-bottom: -5rem;">
<img src="/wp-content/uploads/2023/05/oc2-hero-mobile-dot.png" alt="" />
</div>

      <div class="absolute right-0 bottom-0 to:hidden" style="margin-bottom: -16rem;">
<img src="/wp-content/uploads/2023/05/oc2-hero-mobile-cr-blur.png" alt="" />
</div>
@endif
      @if ($info['hero_image'])

	<img class="w-full h-full object-cover" src="{{ $info['hero_image']['sizes']['large'] }}"  alt="{{ $info['hero_image']['alt'] }}" />

	@endif

      </div>
    </div>
  </div>
</section>
@if ($style == 'default')
<img class="w-full h-3" src="/wp-content/uploads/2022/10/rectangle-animated.gif" alt="" />
@endif


@if ($info['about_layout'] == 'default')
<section class="component-section">
  <div class="component-inner-section">
    <div class="flex flex-col gap-10 lg:grid lg:grid-cols-12">
      <div class="lg:col-span-5">
        @if ('dynamic' == $info['title_display'])
          <div class="text-purple uppercase font-semibold mb-3">
            About the Event
          </div>
	  @endif
	   @if ('address' == $info['title_display'])

<div class="text-purple uppercase font-semibold mb-3">
            About the Event
          </div>
<div class="mt-6 flex">
      <div class="mr-4 flex-shrink-0">
      <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7422 2.92334C16.8859 6.06706 16.8859 11.164 13.7422 14.3078L8.04999 20L2.35779 14.3078C-0.785929 11.164 -0.785929 6.06706 2.35779 2.92334C5.5015 -0.220378 10.5985 -0.220379 13.7422 2.92334ZM8.05024 10.9155C9.32049 10.9155 10.3502 9.88574 10.3502 8.61549C10.3502 7.34523 9.32049 6.31549 8.05024 6.31549C6.77998 6.31549 5.75024 7.34523 5.75024 8.61549C5.75024 9.88574 6.77998 10.9155 8.05024 10.9155Z" fill="#2874AF"/>
</svg>

	</div>
      <div class="text-brand text-2xl">
      		{!! $info['address'] !!}
	</div>
    </div>

<div class="mt-6 flex">
<div class="mr-4 flex-shrink-0">
<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M3.88251 0.469971C3.34644 0.469971 2.91188 0.904535 2.91188 1.4406V2.41122H1.94125C0.869129 2.41122 0 3.28035 0 4.35248V14.0587C0 15.1309 0.869129 16 1.94125 16H13.5888C14.6609 16 15.53 15.1309 15.53 14.0587V4.35248C15.53 3.28035 14.6609 2.41122 13.5888 2.41122H12.6181V1.4406C12.6181 0.904535 12.1836 0.469971 11.6475 0.469971C11.1115 0.469971 10.6769 0.904535 10.6769 1.4406V2.41122H4.85313V1.4406C4.85313 0.904535 4.41857 0.469971 3.88251 0.469971ZM3.88251 5.3231C3.34644 5.3231 2.91188 5.75767 2.91188 6.29373C2.91188 6.82979 3.34644 7.26436 3.88251 7.26436H11.6475C12.1836 7.26436 12.6181 6.82979 12.6181 6.29373C12.6181 5.75767 12.1836 5.3231 11.6475 5.3231H3.88251Z" fill="#2874AF"/>
</svg>

</div>
      <div class="text-brand text-2xl">

{!! $dates !!}
</div>
</div>

<div class="mt-6 flex">
<div class="mr-4 flex-shrink-0">

<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M7.76499 16C12.0535 16 15.53 12.5235 15.53 8.23498C15.53 3.94649 12.0535 0.469971 7.76499 0.469971C3.47651 0.469971 0 3.94649 0 8.23498C0 12.5235 3.47651 16 7.76499 16ZM8.73562 4.35248C8.73562 3.81641 8.30106 3.38185 7.76499 3.38185C7.22893 3.38185 6.79437 3.81641 6.79437 4.35248V8.23498C6.79437 8.49241 6.89663 8.73929 7.07866 8.92132L9.824 11.6667C10.2031 12.0457 10.8176 12.0457 11.1967 11.6667C11.5757 11.2876 11.5757 10.673 11.1967 10.294L8.73562 7.83294V4.35248Z" fill="#2874AF"/>
</svg>

</div>
      <div class="text-brand text-2xl">

{!! $times !!}
</div>
</div>

	   @else
	<h2>{!! $title_date !!}</h2>
@endif
      </div>
      <div class="lg:col-span-7 pt-">
        <div class="event-description text-lg">
        @if ('manual' != $info['title_display'])
        <div class="hidden lg:block uppercase font-semibold mb-3">
          &nbsp;
        </div>
        @endif
          {!! $info['description'] !!}
        </div>
        @if ($registration_open)

	@isset ($info['about_button_link'])
	<div class="mt-10 inline-flex rounded-md shadow">
          <a href="{{ $info['about_button_link'] }}" class="button button-solid" style="border-color: {{ $info['about_button_color'] }}; background-color: {{ $info['about_button_color'] }}">
            {{ $info['about_button_text'] }}
          </a>
        </div>
	@else
	<div class="mt-10 inline-flex rounded-md shadow">
      <a href="{{ $info['registration_link'] }}" class="basic-button text-white" style="background:#712f79">
      Register Now
          </a>
	</div>
	@endisset
        @endif
      </div>
    </div>
  </div>
</section>
@endif
@if ($info['about_layout'] == 'two-column-text-media')
<section class="component-section">
  <div class="component-inner-section">

      <div class="flex flex-col lg:grid lg:grid-cols-2 gap-10 lg:gap-20">
        <div>
          @if ($info['about_title'])
            <h2 class="text-3xl mb-6">{!! $info['about_title'] !!}</h2>
            <div class="description text-lg">
              {!! $info['description'] !!}
            </div>
          @endif
        </div>
        <div class="flex flex-col justify-center">
          @foreach ($info['about_media'] as $media)
            @if ($media['acf_fc_layout'] == 'video_embed')
            <div class="rounded-lg responsive-embed">
              {!! $media['video_embed'] !!}
            </div>

            @endif
          @endforeach
        </div>
      </div>

  </div>
</section>
@endif




@if ($featured_speakers)
  @if (isset($featured_speakers[0]['first_name']))
  @includeIf('dividers.waves', ['bg_color' => 'action-dark'])
  <section class="component-section bg-dark-gradient-oc -mb-10">
    <div class="component-inner-section">


    <div class="flex flex-col text-center">
        @isset ($acf['featured_speaker_section_title'])
        <h2 @if ($style == 'oc2') class="font-syne text-white" @endif>
          {{ $acf['featured_speaker_section_title'] }}
        </h2>
        @endisset
      </div>

      <ul role="list" class="list-none mb-0 mx-auto max-w-lg flex gap-x-6 gap-y-9">
        @foreach ($featured_speakers as $featured_speaker)
          @php
            $fit = 'object-cover';
            if (!isset($featured_speaker['thumbnail'])) {
              $featured_speaker['thumbnail_url'] = get_template_directory_uri() . '/resources/icons/acf/person.svg';
              $featured_speaker['thumbnail_alt'] = '';
              $fit = 'object-contain';
            } else {
              $featured_speaker['thumbnail_url'] = $featured_speaker['thumbnail']['sizes']['medium'];
              $featured_speaker['thumbnail_alt'] = $featured_speaker['thumbnail']['alt'];
            }

            $link = true;

            $full_name = isset($featured_speaker['full_name']) ? $featured_speaker['full_name'] : '';
            if (!$full_name) {
              $full_name = $featured_speaker['first_name'] . ' ' . $featured_speaker['last_name'];
            }

            @endphp
          <li class="mb-0">
            @isset ($featured_speaker['link'])
            <a href="{{ $featured_speaker['permalink'] }}" class="no-underline">
              @endisset
              <div>
                @isset ($featured_speaker['thumbnail_url'])
                <img class="lazy mx-auto h-36 w-36 object-cover rounded-full lg:w-44 lg:h-44" data-src="{{ $featured_speaker['thumbnail_url'] }}" alt="{{ $featured_speaker['thumbnail_alt'] }}">
                @endisset
                <div class="text-center mt-6">
                  <div class="mb-0">
                    <h3 class="font-bold text-white text-lg sm:text-xl mb-0">{{ $full_name }}</h3>
                    <p class="text-action-light-blue text-sm sm:text-base">{{ $featured_speaker['job_title'] }}</p>
                  </div>
                </div>
              </div>
              @isset ($featured_speaker['link'])
            </a>
            @endisset

            @if ($featured_speaker['social_media_link'])
            <div class="social-media-links mt-6 flex items-center justify-center">
                @foreach ($featured_speaker['social_media_link'] as $link)

                  <a href="{{ $link['url'] }}" target="_blank" class="inline-block">
                    @isset ($link["icon"])
                      @if (!empty($link["icon"]))
                        <span class="inline-flex items-center justify-center rounded-md text-gray-400 mx-2 shadow-lg">
                          <img class="lazy h-4 w-4" data-src="/wp-content/themes/uniteus-sage/resources/icons/social/{{ $link['icon'] }}.svg" alt="" />
                        </span>
                      @endif
                    @endisset
                  </a>
                @endforeach
              </div>
            @endif

          </li>
        @endforeach
      </ul>




    </div>
  </section>

  @includeIf('dividers.waves', ['bg_color' => 'dark'])

@endif



@if ($background['has_divider'])
  @includeIf('dividers.waves')
@endif
<section class="component-section bg-light-gradient">
  <div class="component-inner-section">

    <h2 class="text-brand text-center mb-6">{{ $acf['agenda']['title'] }}</h2>


    <div class="flex items-center justify-center mx-auto">
    <div class="container mx-auto h-full flex flex-col justify-center items-stretch" x-data="{tab: 0}">

        <!-- TABS -->
	<div class="flex flex-col items-center md:items-start md:flex-row text-xl justify-center md:gap-10 mb-4 z-10">
@if (count($tabs) > 1)
            <span class="text-brand font-medium md:py-4 no-underline font-medium inline-block align-middle">Explore each day: </span>
          <div class="flex gap-10">
            @foreach ($tabs as $tab_index => $tab)
              <a href="!#0" @click.prevent="tab = {{ $tab_index }}" :class="{'cursor-default border-b-2 border-action text-xl font-bold': tab === {{ $tab_index }}, 'focus:outline-none focus:shadow-outline': tab !== {{ $tab_index }}}" class="py-4 no-underline font-medium inline-block align-middle">
                {{ $tab['title'] }}
              </a>
            @endforeach
          </div>
	</div>
@endif
@endif

        <!-- Tabs Contains -->
        @foreach ($tabs as $tab_index => $tab)
          <div x-show="tab === {{ $tab_index }}" class="z-0">
            <div class="text-lg text-center max-w-4xl mx-auto">
              {!! $tab['summary'] !!}
            </div>
            <div class="accordion accordion-vertical mt-10" x-data="{selected:{{ $tab_index.'999' }}}">
              @if ($tab['sessions'])
                @foreach ($tab['sessions'] as $s_index => $session)
                  @if ($session)
                    @php
                    $start_time = $session['start_time'];
                      $end_time = $session['end_time'];
                      $session_time = $start_time;
                      if ($end_time) {
                        $session_time = str_replace('pm', '', $session_time);
                        $session_time = str_replace('am', '', $session_time);
                        $session_time = $session_time . ' &mdash; ' . $end_time;
                      }
                      @endphp
                    <div class="relative social-card py-6 px-9 lg:p-10 mb-6 bg-white rounded-lg shadow-lg" x-ref="container{{ $index.$s_index }}" :class="{ 'open':  selected == {{ $index.$s_index }} }">

                      <button type="button" class="w-full" @if ($session['description']) @click="selected !== {{ $index.$s_index }} ? selected = {{ $index.$s_index }} : selected = null" @else style="background: none;cursor: default" @endif>
                        <div class="flex flex-col gap-8 md:grid lg:grid-cols-12">
                          <div class="lg:col-span-3 order-2 lg:order-1">
                            <div class="flex gap-6">
                              @if ($session['video'])
                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8808 23.1899C18.573 23.1899 23.1875 18.5755 23.1875 12.8833C23.1875 7.19108 18.573 2.57664 12.8808 2.57664C7.18865 2.57664 2.57422 7.19108 2.57422 12.8833C2.57422 18.5755 7.18865 23.1899 12.8808 23.1899ZM12.3072 9.23467C11.9118 8.97111 11.4035 8.94654 10.9846 9.17073C10.5657 9.39493 10.3042 9.83149 10.3042 10.3066V15.4599C10.3042 15.9351 10.5657 16.3716 10.9846 16.5958C11.4035 16.82 11.9118 16.7954 12.3072 16.5319L16.1721 13.9552C16.5306 13.7163 16.7458 13.314 16.7458 12.8833C16.7458 12.4525 16.5306 12.0503 16.1721 11.8113L12.3072 9.23467Z" fill="#2874AF"/>
                                </svg>
                              @else
                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M12.8832 8.70556V13L16.104 16.2208M22.5456 13C22.5456 18.3364 18.2196 22.6625 12.8832 22.6625C7.54674 22.6625 3.2207 18.3364 3.2207 13C3.2207 7.66356 7.54674 3.33752 12.8832 3.33752C18.2196 3.33752 22.5456 7.66356 22.5456 13Z" stroke="#2874AF" stroke-width="2.14721" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                              @endif
                              <span class="text-action text-base font-semibold">
                                @if ($session['video'])
                                  Watch On-Demand
                                @else
                                  {!! $session_time !!}  {{ $abbr }}
                                @endif
                              </span>
                            </div>
                          </div>

                          <div class="lg:col-span-9 order-1 lg:order-2">
                            <div class="flex flex-col items-start lg:flex-row gap-6">
                              <div class="">
                                @if ($session['label'])
                                  <div class="min-w-[140px] text-base text-center inline-block shrink-0 px-4 py-1 bg-action rounded-full text-white"@if ($session['label_color']) style="background: {{ $session['label_color'] }}" @endif>
                                    {{ $session['label'] }}
                                  </div>
                                @endif
                              </div>
                              <div class="">
                                <h3 class="heading mb-0 text-xl font-normal lg:pr-12">
                                  {!! $session['title'] !!}
                                </h3>
                              </div>
                            </div>
                          </div>

                        </div>
                      </button>

                      <div class="relative overflow-hidden transition-all max-h-0 duration-700" style="" x-ref="container{{ $index.$s_index }}" x-bind:style="selected == {{ $index.$s_index }} ? 'max-height: ' + $refs.container{{ $index.$s_index }}.scrollHeight + 'px' : ''">

                        <div class="flex flex-col gap-8 lg:grid lg:grid-cols-12">

                          <div class="lg:col-span-3">
                            @isset ($session['featured_image']['sizes'])
                              <img class="mt-10 mx-auto" src="{{ $session['featured_image']['sizes']['medium'] }}" alt="" />
                            @endisset

                            @if ($session['presenters'])
                              @foreach ($session['presenters'] as $group)
                                <h3 class="mb-4 @if ($loop->index === 0) mt-5  @else mt-10 @endif uppercase font-bold text-action text-sm">{{ $group['group_title'] }}</h3>
                                @if ($group['members'])
                                  @foreach ($group['members'] as $m)
                                    <div class="flex gap-3 mb-2">
				      @if ($m['image'])
					<div class="shrink-0">
					  <img class="rounded-full w-9 h-9 object-cover" src="{{ $m['image']['sizes']['thumbnail'] }}" alt="" />
					</div>
					  @else
						 @if ($m['name'])
							<div class="shrink-0">
							 <img class="rounded-full w-9 h-9 object-cover" src="@asset('/images/person-head.svg')" />
							</div>
							 @endif
                                        @endif
                                      <div class="mb-4 text-sm">
                                        <span class="font-bold">{!! $m['name'] !!}</span>@if ($m['title'] && $m['name']), @endif
                                        <div class="text-sm">
                                        {!! $m['title'] !!}
                                        </div>

                                        @if ($m['social_media_link'] && $show_social)
                                          <div class="social-media-links mt-2 flex items-center gap-2">
                                            @foreach ($m['social_media_link'] as $link)

                                              <a href="{{ $link['url'] }}" target="_blank" class="inline-block">
                                                @isset ($link["icon"])
                                                  @if (!empty($link["icon"]))
                                                    <span class="inline-flex items-center justify-center rounded-md text-gray-400 shadow-lg">
                                                      <img class="lazy h-4 w-4" data-src="/wp-content/themes/uniteus-sage/resources/icons/social/{{ $link['icon'] }}.svg" alt="" />
                                                    </span>
                                                  @endif
                                                @endisset
                                              </a>
                                            @endforeach
                                          </div>
                                        @endif



                                      </div>
                                    </div>
                                  @endforeach
                                @endif
                              @endforeach
                            @endif

                          </div>

                          <div class="lg:col-span-9 text-lg border-t border-blue-300 lg:mr-16 lg:mt-6 pt-6">
                            @if ($session['video'])
                            <div class="max-w-2xl mx-auto mb-6">
                              <div class="responsive-embed">
                                {!! $session['video'] !!}
                              </div>
                            </div>
                            @endif
                            {!! $session['description'] !!}
                          </div>

                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>


@includeIf('partials.content-page-event-speakers')
@includeIf('partials.content-page-event-speakers-mobile')


@if ($alt_content)
<section class="component-section padding-collapse-t">
  <div class="component-inner-section">

      <div class="grid grid-cols-1 gap-7 lg:gap-[120px]">
      @foreach ($alt_content['content_row'] as $row)
      @php
        $layout = $alt_content['layout'];
        $alt_layout = $layout;
        $alternating_rows = $alt_content['alternating_rows'];
        $vertical_alignment = $alt_content['vertical_alignment'];

        if ($alternating_rows) {
          if ($loop->index-1 % 2 == 0) {
            if ($layout == 'image_text') {
              $alt_layout = 'text_image';
            }
            if ($layout == 'text_image') {
              $alt_layout = 'image_text';
            }
          }
        }
      @endphp
      <div class="md:relative flex flex-col md:flex-none md:grid md:grid-cols-5 gap-10 lg:grid-cols-2 lg:gap-20">

        <div class="flex flex-col md:col-span-2 lg:col-span-1 @if ('center' == $vertical_alignment) justify-center @endif relative @if ('text_image' == $alt_layout) md:order-2 @else  md:order-1 @endif">
          @if ('image' == $row['media_type'])
            <img class="rounded-lg w-full max-w-sm mx-auto lg:max-w-md" src="{{ $row['image']['sizes']['large'] }}" alt="{{ $row['image']['alt'] }}" />
          @endif

          @isset ($embeds)
            @if (!empty($embeds))
              <div class="rounded-lg responsive-embed">
                {!! $embeds !!}
              </div>
            @endif
          @endisset
        </div>

        <div class="flex flex-col md:col-span-3 lg:col-span-1 @if ('center' == $vertical_alignment) justify-center @endif order-2 mb-10 @if ('text_image' == $alt_layout) md:order-1 @else md:order-2 @endif lg:mb-0">
        @if ($row['subtitle'])
          <div class="text-md subtitle mb-6" @if ($row['color']) style="color: {{ $row['color']['color'] }}" @endif>
            {{ $row['subtitle'] }}
          </div>
        @endif
        <h2 class="mb-6 lg:w-10/12">{!! $row['title'] !!}</h2>
        @if ($row['description'])
        <div class="description text-lg">
          {!! $row['description'] !!}
        </div>
        @endif
        @if ($row['button_link'])
          <a href="{!! $row['button_link'] !!}" class="basic-button mt-6 self-start text-white hover:text-white border-white bg-orange" @if ($row['color']) style="background: {{ $row['color']['color'] }}" @endif>
            {!! $row['button_text'] !!}
          </a>
        @endif
        </div>
        </div>
      @endforeach
          </div>


  </div>
</section>
@endif


@if ($show_additinal_information)
  @includeIf('dividers.waves')
  <section class="component-section bg-light-gradient">
    <div class="component-inner-section">

      <h2 class="text-center">{!! $additional_information['section']['title'] !!}</h2>
      <div class="mt-12">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

          @foreach ($additional_information['cards'] as $index => $card)
            <div>
              @if ($card['image'])
              <img class="mb-6 object-cover aspect-video rounded-md"
                src="{{ $card['image']['sizes']['medium_large'] }}" alt="">
              @endif



              <h3 class="mb-4 text-2xl font-bold">
                  {!! $card['title'] !!}
              </h3>
              {!! $card['description'] !!}

              @if ($card['button_link'])
              <a href="{!! $card['button_link'] !!}" class="basic-button text-white hover:text-white border-white bg-orange">
                {!! $card['button_text'] !!}
              </a>
              @endif
            </div>
          @endforeach

        </div>
      </div>
    </div>
  </section>
@endif


@if ($registration_open)
<div class="section-divider relative h-5 sm:h-10 md:h-14 xl:h-20 -mb-2 -sm:mb-3 md:-mb-7 xl:-mb-10 text-light">
  <svg class="w-full h-full" width="1358" height="80" preserveAspectRatio="none" viewBox="0 0 1358 80" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 9.85705L56.625 15.7023C113.25 21.5475 226.5 33.238 339.75 27.3928C453 21.5475 566.25 -1.83344 679.5 0.114975C792.75 2.06339 906 29.3412 1019.25 35.1865C1132.5 41.0317 1245.75 25.4444 1302.37 17.6507L1359 9.85705V80H1302.37C1245.75 80 1132.5 80 1019.25 80C906 80 792.75 80 679.5 80C566.25 80 453 80 339.75 80C226.5 80 113.25 80 56.625 80H0V9.85705Z" fill="currentColor"></path>
  <defs>
  <linearGradient x1="679.5" y1="0" x2="679.5" y2="80" gradientUnits="userSpaceOnUse">
  <stop stop-color="#EEF5FC"></stop>
  <stop offset="1" stop-color="#EEF5FC"></stop>
  </linearGradient>
  </defs>
  </svg>
</div>
<section class="relative z-20 mb-10 component-section bg-light-gradient gated-section-2">
  <div class="component-inner-section">

    <div class="flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 gap-10 lg:gap-28">
    <div class="text-lg">
    <h2 class="">
	@isset ($signup['title'])
	{!! $signup['title'] !!}
	@endisset

	</h2>

	@if ($signup['logo'])
		<img src="{{ $signup['logo']['sizes']['large'] }}" class="w-full h-auto mb-10" style="max-width:186px;" alt="{{ $signup['logo']['alt'] }}" />

	@endif
        <div class="text-lg">
          {!! $signup['description'] !!}
        </div>

        @isset ($acf['button_text'])
          <div class="inline-flex mt-6">
            <a href="#request-form" class="button button-solid">
            {!! $acf['button_text'] !!}
            </a>
          </div>
        @endisset
      </div>

      <div id="register" class="relative">
        @isset ($signup['form_embed_code'])
          @if (!empty($signup['form_embed_code']))
            <div class="rounded-lg p-6 bg-white shadow-lg">
              {!! $signup['form_embed_code'] !!}
            </div>
          @endif
        @endisset
      </div>
    </div>
  </div>
</section>
@endif



<section class="component-section relative padding-collapse-t bg-white ">
  <div class="absolute bottom-0 border border-blue-900 -ml-4 w-full h-3/6 -mb-[1px] bg-blue-900"></div>

  <div class="component-inner-section relative ">

    @if ($style == 'oc2')
      <div class="relative bg-brand  overflow-hidden w-full rounded-2xl flex flex-col md:relative lg:flex-none lg:grid grid-cols-3 lg:gap-20">
        @if ($cta['cta_bg_image'])
          <div class="absolute inset-0 hidden lg:flex">
            <img src="{{ $cta['cta_bg_image']['sizes']['large'] }}" class="w-full h-full object-cover" alt="{{ $cta['cta_bg_image']['alt'] }}" style="object-position: center right" />
          </div>

          <div class="absolute inset-0 lg:hidden">
            <img src="/wp-content/uploads/2023/05/cta-bg-mb.jpg" class="w-full h-full object-cover" alt="" />
          </div>
        @endif

      <div class="col-span-2 order-2  p-9 z-10 md:p-20 flex flex-col justify-center text-lg md:order-1 lg:mb-0">
        @if ($cta['subtitle'])
          <div class="uppercase text-base font-semibold mb-3" style="color:#52B4FF;">
            {{ $cta['subtitle'] }}
          </div>
        @endif
        <h2 class="mb-0 font-bold text-white" style="font-size: 32px;">{{ $cta['title'] }}</h2>

        <div class="flex gap-6  mt-9 sm:mt-10  button-layout-buttons flex justify-start">
          @if ($cta['button_link'])
            <a href="{!! $cta['button_link'] !!}" class="button button-solid" style="background: #52B4FF;"><span class="font-semibold">
              {!! $cta['button_text'] !!}</span>
            </a>
          @endif
        </div>
      </div>

      <div class="relative flex flex-col  justify-center   lg:order-2 lg:hidden">
                  @isset ($cta['image']['sizes'])
                              <img class="w-full mx-auto lg:max-w-md"  src="{{ $cta['image']['sizes']['medium_large'] }}" alt="" />
                            @endisset

                                </div>
    </div>


    @else


    <div class="relative bg-light overflow-hidden w-full rounded-2xl flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 lg:gap-20">
@if ($cta['cta_bg_image'])
	<div class="absolute inset-0">
<img src="{{ $cta['cta_bg_image']['sizes']['large'] }}" class="w-full h-full object-cover" alt="{{ $cta['cta_bg_image']['alt'] }}" />
</div>
@endif
      <div class="order-2  p-9 z-10 md:p-20 flex flex-col justify-center text-lg md:order-1 lg:mb-0">
          @if ($cta['subtitle'])
          <div class="uppercase text-base font-semibold mb-3 text-action">
            {{ $cta['subtitle'] }}
          </div>
          @endif
          <h2 class="mb-0 font-bold">{{ $cta['title'] }}</h2>

                            <div class="flex gap-6  mt-9 sm:mt-10  button-layout-buttons flex justify-start">
                            @if ($cta['button_link'])
          <a href="{!! $cta['button_link'] !!}" class="button button-solid" style="background: #52B4FF;"><span class="font-semibold">
            {!! $cta['button_text'] !!}</span>
          </a>
        @endif
            </div>
              </div>

      <div class="relative pt-0 p-9 md:p-9 pb-0 md:p-0 flex flex-col  justify-center   md:order-2 ">
                  @isset ($cta['image']['sizes'])
                              <img class="rounded-lg w-full mx-auto lg:max-w-md"  src="{{ $cta['image']['sizes']['medium_large'] }}" alt="" />
                            @endisset

                                </div>
    </div>
    @endif

  </div>
</section>
