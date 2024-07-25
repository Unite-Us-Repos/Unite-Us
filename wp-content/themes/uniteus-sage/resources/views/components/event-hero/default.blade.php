@php
$posts = App\View\Composers\Post::getPosts(1);

@endphp
@php
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

if (!$event_info['timezone']) {
  $event_info['timezone'] = 'America/New_York';
}

$utc = new DateTimeZone('UTC');
$dt = new DateTime('now', $utc);
$current_tz = new \DateTimeZone($event_info['timezone']);
$transition = $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
$abbr = $transition[0]['abbr'];

$d1 = new \DateTime($event_info['event_dates']['start']);
$d2 = new \DateTime($event_info['event_dates']['end']);
$dates = formatDateRange($d1, $d2, 'M d, Y');
$title_date = formatDateRange($d1, $d2);
$og_start_time = '';

if ($event_info['start_time'] AND $event_info['end_time']) {
  $og_start_time = $event_info['start_time'];
  $start_time = str_replace(' pm', '', $event_info['start_time']);
  $start_time = str_replace(' am', '', $start_time);


$times = $start_time . '&mdash;' . $event_info['end_time'] . ' ' . $abbr;
  $title_date .= '<br />' . 'from ' . $start_time . '&mdash;' . $event_info['end_time'] . ' ' . $abbr;
} elseif ($event_info['start_time']) {
  $title_date .= '<br />' . 'starting at ' . $event_info['start_time'];
	$times = $start_time . ' ' . $abbr;
}

if ('manual' == $event_info['title_display']) {
  $title_date = $event_info['subtitle'];
}

$cta = isset($acf['cta']) ? $acf['cta'] : [];

$background = [
  'has_divider' => true,
  'color' => 'light',
  ];

$zones = [
    'PST' => 'America/Los_Angeles',
    'EST' => 'America/New_York',
  ];

$gmdate_str = gmdate('Y-m-d H:i:s', strtotime($event_info['start_date_time']));
$countdown = $gmdate_str;
$today_time_stamp = strtotime(date('Ymd H:i:s') . ' +1 day');
$event_end_time_stamp = strtotime($countdown);
$show_date_time = false;
$registration_open = 0;
if ($event_end_time_stamp > $today_time_stamp) {
  $registration_open = 1;
}
$show_additinal_information = false;

if ('address-starting-time' == $event_info['title_display']) {
  $dates = $dates = formatDateRange($d1, $d2, 'l, F d');
  $times = 'Starting at ' . $og_start_time;
}

@endphp
<style>
  .counter {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-grow: 1;
  }
</style>

<section class="relative component-section padding-collapse text-white" style="background: #0B1538;">


       <div class="component-inner-section relative z-10 md:!pr-0">

     <div class="flex flex-col md:gap-10 md:grid md:grid-cols-12">

      <div class="md:col-span-6 md:mb-0 flex flex-col items-start py-10 md:py-20 justify-center order-2 md:order-1">


      @if ($event_info['logo'])
          <img class="w-48 h-auto mb-6" src="{{ $event_info['logo']['sizes']['medium_large'] }}" alt="" />
	  @endif

	  @if ($event_info['secondary_logo'])
          <img class="w-full h-auto mx-auto md:mx-0 mb-" style="max-width: 396px" src="{{ $event_info['secondary_logo']['sizes']['large'] }}" alt="" />
        @endif


	          <h1 class="text-[42px] md:text-5xl font-extrabold mb-6">
              {!! $event_info['title'] !!}
            </h1>


            <div class="max-w-lg">
            @if ($event_info['title'])
              <h2 class="text-[28px] font-semibold">
              {!! $event_info['sub_title'] !!}
              </h2>
            @endif

            @if ($show_date_time && $registration_open)

            <div class="w-full flex flex-col xl:flex-row flex-wrap gap-7">
              <span class="flex gap-4 items-center">
              <span class="w-6 h-6 flex justify-center items-center">
                <svg class="w-full h-full" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M6.56153 0.5C5.7331 0.5 5.06153 1.17157 5.06153 2V3.5H3.56153C1.90467 3.5 0.561523 4.84315 0.561523 6.50001V21.5C0.561523 23.1569 1.90467 24.5 3.56153 24.5H21.5616C23.2184 24.5 24.5616 23.1569 24.5616 21.5V6.50001C24.5616 4.84315 23.2184 3.5 21.5616 3.5H20.0616V2C20.0616 1.17157 19.39 0.5 18.5616 0.5C17.7331 0.5 17.0616 1.17157 17.0616 2V3.5H8.06154V2C8.06154 1.17157 7.38996 0.5 6.56153 0.5ZM6.56153 8.00001C5.7331 8.00001 5.06153 8.67159 5.06153 9.50001C5.06153 10.3284 5.7331 11 6.56153 11H18.5616C19.39 11 20.0616 10.3284 20.0616 9.50001C20.0616 8.67159 19.39 8.00001 18.5616 8.00001H6.56153Z" fill="currentColor"></path>
              </svg>
              </span>
              <span>{!! $dates !!}</span>
              <span class="flex gap-4 items-center">
              <span class="w-7 h-7 flex justify-center items-center">
                <svg class="w-6 h-6" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5615 24.5C19.1889 24.5 24.5615 19.1274 24.5615 12.5C24.5615 5.87259 19.1889 0.5 12.5615 0.5C5.9341 0.5 0.561523 5.87259 0.561523 12.5C0.561523 19.1274 5.9341 24.5 12.5615 24.5ZM14.0615 6.50001C14.0615 5.67158 13.3899 5.00001 12.5615 5.00001C11.7331 5.00001 11.0615 5.67158 11.0615 6.50001V12.5C11.0615 12.8978 11.2196 13.2794 11.5009 13.5607L15.7435 17.8033C16.3293 18.3891 17.279 18.3891 17.8648 17.8033C18.4506 17.2175 18.4506 16.2678 17.8648 15.682L14.0615 11.8787V6.50001Z" fill="currentColor"></path>
              </svg>
              </span>{!! $times !!}</span>
            </div>
            @endif




          <div class="text-xl">
            {!! $event_info['description'] !!}
          </div>
</div>

          @if ($registration_open)
            @php
              $data = [
                'buttons' =>$event_info['buttons'],
                'justify' => 'justify-start',
                'classes' => '!py-2 !px-6',
              ];
            @endphp
            @include('components.action-buttons', $data)
          @endif

      </div>

      <div class="relative md:col-span-6 order-1 md:order-2 -mx-8 sm:mx-auto">
        @if ($event_info['hero_image'])
              <div class="relative">
              @if ($event_info['video'])
          <img class="relative z-10 w-full h-full object-contain" src="{{ $event_info['hero_image']['sizes']['medium_large'] }}" alt="{{ $event_info['hero_image']['alt'] }}">
          <div class="absolute inset-0 overflow-hidden" style="margin-left: 2px; margin-right: 2px;">

          <div class="relative responsive-embed" style="border-radius: 0;margin-top: 18%; transform: scale(1.2); transform-origin: center;">
            {!! $event_info['video'] !!}
          </div>

            </div>
            @endif
            </div>
        @else
          <img class="w-full h-full object-contain" src="/wp-content/uploads/2023/09/1c-collage-2023.png" alt="">
        @endif
      </div>

    </div>
  </div>
</section>
@if ($registration_open)

<div style="background: #216CFF;" class="relative w-full z-20 countdown-container-2 mx-auto md:mx-0 md:mb-0 text-center flex flex-col md:flex-row items-center justify-between overflow-hidden">


<div id="countdown" class="countdown component-inner-section w-full md:h-full flex flex-col gap-2 flex-wrap md:flex-row md:flex-nowrap md:items-center p-5 justify-between" data-date="{{ $countdown }}" data-timezone="{{ $event_info['timezone'] }}">

<div class="counter text-2xl md:text-xl lg:text-2xl col-span-2 text-white flex-shrink-0">
Time Left to RSVP
</div>

<div class="grid grid-cols-2 gap-6 md:flex bg-white md:bg-[#216CFF] md:text-white md:justify-evenly w-full max-w-sm mx-auto md:max-w-none rounded-xl p-2">
  <div class="counter flex flex-col md:gap-2 md:flex-row">
  <span id="days" class="value block text-2xl font-extrabold" data-days="">00</span>
  <span class="suffix block uppercase text-[#2F71F4] md:text-white text-sm md:text-lg">Days</span>
  </div>

  <div class="counter flex flex-col md:gap-2 md:flex-row">
  <span id="hours" class="value block text-2xl font-extrabold" data-hours="">00</span>
  <span class="suffix block uppercase text-[#2F71F4] md:text-white text-sm md:text-lg">Hours</span>
  </div>

  <div class="counter flex flex-col md:gap-2 md:flex-row">
  <span id="minutes" class="value block text-2xl font-extrabold" data-minutes="">00</span>
  <span class="suffix block uppercase text-[#2F71F4] md:text-white text-sm md:text-lg">Mins</span>
  </div>

  <div class="counter flex flex-col md:gap-2 md:flex-row">
  <span id="seconds" class="value block text-2xl font-extrabold" data-seconds="">00</span>
  <span class="suffix block uppercase text-[#2F71F4] md:text-white text-sm md:text-lg">Secs</span>
  </div>
</div>
</div>
</div>
@endif














@if ($event_info['about_layout'] == 'default')
<section class="component-section">
  <div class="component-inner-section">
    <div class="flex flex-col gap-10 lg:grid lg:grid-cols-12">
      <div class="lg:col-span-5">
        @if ('dynamic' == $event_info['title_display'])
          <div class="uppercase font-semibold mb-3" style="color: #216CFF;">
            About the Event
          </div>
	  @endif
	   @if (('address' == $event_info['title_display']) OR ('address-starting-time' == $event_info['title_display']))

<div class="uppercase font-semibold mb-3" style="color: #216CFF;">
            About the Eventsss
          </div>

          @if ($event_info['address'])
<div class="mt-6 flex">
      <div class="mr-4 flex-shrink-0 pt-2">
      <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7422 2.92334C16.8859 6.06706 16.8859 11.164 13.7422 14.3078L8.04999 20L2.35779 14.3078C-0.785929 11.164 -0.785929 6.06706 2.35779 2.92334C5.5015 -0.220378 10.5985 -0.220379 13.7422 2.92334ZM8.05024 10.9155C9.32049 10.9155 10.3502 9.88574 10.3502 8.61549C10.3502 7.34523 9.32049 6.31549 8.05024 6.31549C6.77998 6.31549 5.75024 7.34523 5.75024 8.61549C5.75024 9.88574 6.77998 10.9155 8.05024 10.9155Z" fill="#216CFF;"/>
</svg>

	</div>
      <div class="text-brand text-2xl">
      		{!! $event_info['address'] !!}
	</div>
    </div>
    @endif

<div class="mt-6 flex">
<div class="mr-4 flex-shrink-0 pt-2">
<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M3.88251 0.469971C3.34644 0.469971 2.91188 0.904535 2.91188 1.4406V2.41122H1.94125C0.869129 2.41122 0 3.28035 0 4.35248V14.0587C0 15.1309 0.869129 16 1.94125 16H13.5888C14.6609 16 15.53 15.1309 15.53 14.0587V4.35248C15.53 3.28035 14.6609 2.41122 13.5888 2.41122H12.6181V1.4406C12.6181 0.904535 12.1836 0.469971 11.6475 0.469971C11.1115 0.469971 10.6769 0.904535 10.6769 1.4406V2.41122H4.85313V1.4406C4.85313 0.904535 4.41857 0.469971 3.88251 0.469971ZM3.88251 5.3231C3.34644 5.3231 2.91188 5.75767 2.91188 6.29373C2.91188 6.82979 3.34644 7.26436 3.88251 7.26436H11.6475C12.1836 7.26436 12.6181 6.82979 12.6181 6.29373C12.6181 5.75767 12.1836 5.3231 11.6475 5.3231H3.88251Z" fill="#216CFF"/>
</svg>

</div>
      <div class="text-brand text-2xl">

{!! $dates !!}
</div>
</div>

<div class="mt-6 flex">
<div class="mr-4 flex-shrink-0 pt-2">

<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M7.76499 16C12.0535 16 15.53 12.5235 15.53 8.23498C15.53 3.94649 12.0535 0.469971 7.76499 0.469971C3.47651 0.469971 0 3.94649 0 8.23498C0 12.5235 3.47651 16 7.76499 16ZM8.73562 4.35248C8.73562 3.81641 8.30106 3.38185 7.76499 3.38185C7.22893 3.38185 6.79437 3.81641 6.79437 4.35248V8.23498C6.79437 8.49241 6.89663 8.73929 7.07866 8.92132L9.824 11.6667C10.2031 12.0457 10.8176 12.0457 11.1967 11.6667C11.5757 11.2876 11.5757 10.673 11.1967 10.294L8.73562 7.83294V4.35248Z" fill="#216CFF"/>
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
        @if ('manual' != $event_info['title_display'])
        <div class="hidden lg:block uppercase font-semibold mb-3">
          &nbsp;
        </div>
        @endif
          {!! $event_info['about_description'] !!}
        </div>
        @if ($registration_open)

	@isset ($event_info['about_button_link'])
	<div class="mt-6 inline-flex rounded-md shadow">
          <a href="{{ $event_info['about_button_link'] }}" class="button button-solid !py-2 !px-6" style="border-color: {{ $event_info['about_button_color'] }}; background-color: {{ $event_info['about_button_color'] }}">
            {{ $event_info['about_button_text'] }}
          </a>
        </div>
	@else
	@if ($registration_open)
            @php
              $data = [
                'buttons' =>$event_info['buttons_alt'],
                'justify' => 'justify-start',
                'classes' => '!py-2 !px-6',
              ];
            @endphp
            @include('components.action-buttons', $data)
          @endif
	@endisset
        @endif
      </div>
    </div>
  </div>
</section>
@endif
@if ($event_info['about_layout'] == 'two-column-text-media')
<section class="component-section">
  <div class="component-inner-section">

      <div class="flex flex-col lg:grid lg:grid-cols-2 gap-10 lg:gap-20">
        <div>
          @if ($event_info['about_title'])
            <h2 class="text-3xl mb-6">{!! $event_info['about_title'] !!}</h2>
            <div class="description text-lg">
              {!! $event_info['description'] !!}
            </div>
          @endif
        </div>
        <div class="flex flex-col justify-center">
          @foreach ($event_info['about_media'] as $media)
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



