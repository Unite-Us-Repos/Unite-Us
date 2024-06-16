@php
$posts = App\View\Composers\Post::getPosts(1);
//print_r($posts);
//print_r($acf_fields);
$event_info = $acf['event_info'];
if (is_page('one-continuum')) {
  $event_info = get_field('event_info', $posts[0]['ID']);
}
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

if ($event_info['start_time'] AND $event_info['end_time']) {
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
$registration_open = 0;
if ($event_end_time_stamp > $today_time_stamp) {
  $registration_open = 1;
}
$show_additinal_information = false;

@endphp

<section class="relative component-section padding-collapse lg:rounded-bl-[100px]" style="background: linear-gradient(180deg, rgba(255, 255, 255, 0.00) 60.61%, #E3EBF3 100%);">


       <div class="component-inner-section relative z-10">

     <div class="flex flex-col lg:gap-10 lg:grid lg:grid-cols-12">

      <div class=" lg:col-span-6 lg:mb-0 flex flex-col py-10 lg:py-20 justify-center gap-10 order-2 lg:order-1">


      <svg xmlns="http://www.w3.org/2000/svg" width="217" height="46" viewBox="0 0 217 46" fill="none">
  <path d="M34.3757 0.00012207C28.9941 0.00012207 25.8591 2.90106 25.8591 7.86071V25.8278C25.8591 30.7874 28.9941 33.6884 34.3757 33.6884C39.8096 33.6884 42.9968 30.7874 42.9968 25.8278V21.8975L37.6674 21.6635V25.3131C37.6674 27.9333 36.5701 29.103 34.5324 29.103C32.4947 29.103 31.3975 27.9333 31.3975 25.781V7.9075C31.3975 5.7552 32.4947 4.58546 34.5324 4.58546C36.5701 4.58546 37.6674 5.7552 37.6674 8.37539V11.0424L42.9968 10.8084V7.86071C42.9968 2.90106 39.8096 0.00012207 34.3757 0.00012207Z" fill="#2C405A"/>
  <path d="M56.1729 0.00012207C50.6345 0.00012207 47.2383 3.135 47.2383 8.28181V25.4067C47.2383 30.5535 50.6345 33.6884 56.1729 33.6884C61.7112 33.6884 65.1074 30.5535 65.1074 25.4067V8.28181C65.1074 3.135 61.7112 0.00012207 56.1729 0.00012207ZM56.1729 4.58546C58.3673 4.58546 59.569 5.89556 59.569 8.3286V25.3599C59.569 27.7929 58.3673 29.103 56.1729 29.103C53.9784 29.103 52.7767 27.7929 52.7767 25.3599V8.3286C52.7767 5.89556 53.9784 4.58546 56.1729 4.58546Z" fill="#2C405A"/>
  <path d="M88.4937 33.2205V0.468014L83.2688 0.468014V19.9791H83.1643L76.6332 0.468014L70.4678 0.468014V33.2205H75.6927V11.5103H75.7972L83.0598 33.2205L88.4937 33.2205Z" fill="#2C405A"/>
  <path d="M109.34 5.14694V0.468014L91.9935 0.468014V5.14694H97.8977V33.2205H103.436V5.14694L109.34 5.14694Z" fill="#2C405A"/>
  <path d="M118.356 33.2205V0.468014L112.818 0.468014V33.2205H118.356Z" fill="#2C405A"/>
  <path d="M142.324 33.2205V0.468014L137.099 0.468014V19.9791H136.995L130.464 0.468014L124.298 0.468014V33.2205H129.523V11.5103H129.628L136.89 33.2205H142.324Z" fill="#2C405A"/>
  <path d="M165.104 0.468014L159.566 0.468014V25.7342C159.566 28.1204 158.364 29.0094 156.431 29.0094C154.497 29.0094 153.296 28.1204 153.296 25.7342V0.468014L147.966 0.468014V25.8746C147.966 31.0214 151.258 33.6884 156.483 33.6884C161.812 33.6884 165.104 31.0214 165.104 25.8746V0.468014Z" fill="#2C405A"/>
  <path d="M187.555 0.468014L182.016 0.468014V25.7342C182.016 28.1204 180.815 29.0094 178.881 29.0094C176.948 29.0094 175.746 28.1204 175.746 25.7342V0.468014L170.417 0.468014V25.8746C170.417 31.0214 173.709 33.6884 178.934 33.6884C184.263 33.6884 187.555 31.0214 187.555 25.8746V0.468014Z" fill="#2C405A"/>
  <path d="M216.641 33.2205V0.468014L209.169 0.468014L204.885 18.0608H204.78L200.444 0.468014L193.181 0.468014V33.2205H198.406V10.4809H198.511L203.108 28.5415H206.4L210.998 10.4809H211.103V33.2205H216.641Z" fill="#2C405A"/>
  <path d="M19.7736 12.1947V12.0946H19.6735L1.27673 12.0946H1.17659V12.1947L1.17659 14.8228V14.9229H1.27673L11.7285 14.9229L1.24797 18.0646L1.17659 18.086V18.1605L1.17659 21.2617V21.3618H1.27673H19.6735H19.7736V21.2617V18.6336V18.5334H19.6735H7.98684L19.7022 15.0239L19.7736 15.0025V14.9279V12.1947ZM3.95241 1.36731V1.26717L3.85227 1.26717L1.27673 1.26717L1.17658 1.26717V1.36731L1.17658 9.19907V9.29921H1.27673L19.6735 9.29921H19.7736V9.19907V1.36731V1.26717L19.6735 1.26717L17.0979 1.26717L16.9978 1.26717V1.36731V6.31313L11.7316 6.31314V2.33971V2.23957L11.6315 2.23957L9.05592 2.23957H8.95578V2.33971V6.31314L3.95241 6.31314L3.95241 1.36731ZM0.913775 28.452C0.913775 29.8664 1.3613 31.018 2.18608 31.8157C3.01045 32.613 4.2006 33.0462 5.66567 33.0462H15.2845C16.7496 33.0462 17.9398 32.613 18.7641 31.8157C19.5889 31.018 20.0364 29.8664 20.0364 28.452C20.0364 27.0376 19.5889 25.886 18.7641 25.0883C17.9398 24.291 16.7496 23.8578 15.2845 23.8578L5.66567 23.8578C4.2006 23.8578 3.01045 24.291 2.18608 25.0883C1.3613 25.8861 0.913775 27.0376 0.913775 28.452ZM3.6896 28.452C3.6896 27.924 3.86447 27.528 4.19148 27.2616C4.52183 26.9924 5.02146 26.8439 5.69195 26.8439H15.2583C15.9287 26.8439 16.4284 26.9924 16.7587 27.2616C17.0857 27.528 17.2606 27.924 17.2606 28.452C17.2606 28.98 17.0857 29.376 16.7587 29.6424C16.4284 29.9116 15.9287 30.0601 15.2583 30.0601L5.69195 30.0601C5.02146 30.0601 4.52183 29.9116 4.19148 29.6424C3.86447 29.376 3.6896 28.98 3.6896 28.452Z" fill="#2C405A" stroke="#2C405A" stroke-width="0.200281"/>
  <path d="M109.597 45.9906C107.776 45.9906 106.616 44.4682 106.616 42.3178C106.616 40.1674 107.776 38.645 109.597 38.645C110.98 38.645 111.63 39.5286 111.992 40.3483L110.81 40.87C110.597 40.3057 110.182 39.9119 109.597 39.9119C108.66 39.9119 108.085 40.9232 108.085 42.3178C108.085 43.7124 108.66 44.7237 109.597 44.7237C110.203 44.7237 110.619 44.2766 110.821 43.6911L112.002 44.2021C111.651 45.0537 111.002 45.9906 109.597 45.9906Z" fill="#2C405A"/>
  <path d="M113.617 42.3178C113.617 40.2099 114.724 38.645 116.576 38.645C118.439 38.645 119.546 40.2099 119.546 42.3178C119.546 44.4363 118.439 45.9906 116.576 45.9906C114.724 45.9906 113.617 44.4363 113.617 42.3178ZM118.088 42.3178C118.088 40.9445 117.555 39.9119 116.576 39.9119C115.607 39.9119 115.086 40.9445 115.086 42.3178C115.086 43.6698 115.607 44.7237 116.576 44.7237C117.555 44.7237 118.088 43.6698 118.088 42.3178Z" fill="#2C405A"/>
  <path d="M128.17 45.8628H126.765V40.9871L125.168 45.8628H124.582L123.007 40.9871V45.8628H121.591V38.7621H123.507L124.88 43.0204L126.264 38.7621H128.17V45.8628Z" fill="#2C405A"/>
  <path d="M137.063 45.8628H135.658V40.9871L134.061 45.8628H133.475L131.9 40.9871V45.8628H130.484V38.7621H132.4L133.773 43.0204L135.157 38.7621H137.063V45.8628Z" fill="#2C405A"/>
  <path d="M139.377 43.4143V38.7621H140.814V43.4249C140.814 44.266 141.218 44.7344 141.974 44.7344C142.73 44.7344 143.135 44.266 143.135 43.4249V38.7621H144.572V43.4143C144.572 45.0537 143.582 45.9906 141.974 45.9906C140.367 45.9906 139.377 45.0537 139.377 43.4143Z" fill="#2C405A"/>
  <path d="M152.103 45.8628H150.74L148.313 41.3384V45.8628H146.897V38.7621H148.345L150.677 43.1056V38.7621H152.103V45.8628Z" fill="#2C405A"/>
  <path d="M155.844 45.8628H154.418V38.7621H155.844V45.8628Z" fill="#2C405A"/>
  <path d="M160.773 45.8628H159.346V40.0183H157.76V38.7621H162.348V40.0183H160.773V45.8628Z" fill="#2C405A"/>
  <path d="M167.21 45.8628H165.783V42.9352L163.59 38.7621H165.166L166.497 41.6152L167.827 38.7621H169.403L167.21 42.9352V45.8628Z" fill="#2C405A"/>
  <path d="M178.814 45.8628H174.194V44.7131C176.792 42.19 177.334 41.6258 177.334 40.8167C177.334 40.2738 176.919 39.9225 176.387 39.9225C175.759 39.9225 175.259 40.2099 174.875 40.7209L174.024 39.8267C174.599 39.0602 175.44 38.6557 176.408 38.6557C177.782 38.6557 178.782 39.486 178.782 40.8061C178.782 41.8813 178.058 42.7968 176.27 44.6066H178.814V45.8628Z" fill="#2C405A"/>
  <path d="M180.682 42.3178C180.682 40.2951 181.438 38.6557 183.195 38.6557C184.962 38.6557 185.707 40.2951 185.707 42.3178C185.707 44.3298 184.973 45.9906 183.195 45.9906C181.438 45.9906 180.682 44.3298 180.682 42.3178ZM184.259 42.3178C184.259 40.9445 184.025 39.9225 183.195 39.9225C182.375 39.9225 182.141 40.9445 182.141 42.3178C182.141 43.6804 182.375 44.7237 183.195 44.7237C184.025 44.7237 184.259 43.6804 184.259 42.3178Z" fill="#2C405A"/>
  <path d="M192.213 45.8628H187.593V44.7131C190.19 42.19 190.733 41.6258 190.733 40.8167C190.733 40.2738 190.318 39.9225 189.786 39.9225C189.158 39.9225 188.657 40.2099 188.274 40.7209L187.422 39.8267C187.997 39.0602 188.838 38.6557 189.807 38.6557C191.18 38.6557 192.181 39.486 192.181 40.8061C192.181 41.8813 191.457 42.7968 189.669 44.6066H192.213V45.8628Z" fill="#2C405A"/>
  <path d="M193.953 44.8408L194.805 43.9572C195.167 44.4256 195.731 44.7344 196.327 44.7344C197.072 44.7344 197.413 44.3405 197.413 43.7869C197.413 43.1162 196.955 42.8714 196.263 42.8714C196.029 42.8714 195.71 42.882 195.603 42.8927V41.6258C195.71 41.6365 196.061 41.6365 196.231 41.6365C196.881 41.6365 197.317 41.3597 197.317 40.7955C197.317 40.1993 196.891 39.9119 196.274 39.9119C195.72 39.9119 195.22 40.178 194.858 40.6251L194.049 39.8054C194.56 39.0921 195.369 38.6557 196.391 38.6557C197.796 38.6557 198.723 39.3263 198.723 40.5825C198.723 41.3916 198.116 42.0516 197.381 42.2007C198.105 42.3071 198.829 42.9459 198.829 43.904C198.829 45.1389 197.882 45.9906 196.391 45.9906C195.252 45.9906 194.4 45.4902 193.953 44.8408Z" fill="#2C405A"/>
  <rect y="39.2111" width="99.7045" height="6.01345" fill="url(#paint0_linear_17696_48579)"/>
  <rect x="204.017" y="39.2111" width="12.6225" height="6.01332" fill="#F07012"/>
  <defs>
    <linearGradient id="paint0_linear_17696_48579" x1="0" y1="42.2178" x2="99.7045" y2="42.2178" gradientUnits="userSpaceOnUse">
      <stop offset="0.09375" stop-color="#2874AF"/>
      <stop offset="0.385417" stop-color="#82C9BD"/>
      <stop offset="0.697917" stop-color="#EAA1F2"/>
      <stop offset="1" stop-color="#F07012"/>
    </linearGradient>
  </defs>
</svg>


	          <h1 class="text-brand text-[42px] md:text-5xl font-extrabold mb-0">
              {!! $event_info['title'] !!}
            </h1>


            @if ($registration_open)

            <div class="w-full flex flex-col xl:flex-row flex-wrap gap-7">
<span class="flex gap-4 items-center">
<span class="w-6 h-6 flex justify-center items-center text-marketing-2">
  <svg class="w-full h-full" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M6.56153 0.5C5.7331 0.5 5.06153 1.17157 5.06153 2V3.5H3.56153C1.90467 3.5 0.561523 4.84315 0.561523 6.50001V21.5C0.561523 23.1569 1.90467 24.5 3.56153 24.5H21.5616C23.2184 24.5 24.5616 23.1569 24.5616 21.5V6.50001C24.5616 4.84315 23.2184 3.5 21.5616 3.5H20.0616V2C20.0616 1.17157 19.39 0.5 18.5616 0.5C17.7331 0.5 17.0616 1.17157 17.0616 2V3.5H8.06154V2C8.06154 1.17157 7.38996 0.5 6.56153 0.5ZM6.56153 8.00001C5.7331 8.00001 5.06153 8.67159 5.06153 9.50001C5.06153 10.3284 5.7331 11 6.56153 11H18.5616C19.39 11 20.0616 10.3284 20.0616 9.50001C20.0616 8.67159 19.39 8.00001 18.5616 8.00001H6.56153Z" fill="currentColor"></path>
</svg>
</span>
<span>{!! $dates !!}</span>
 <span class="flex gap-4 items-center">
 <span class="w-7 h-7 flex justify-center items-center text-marketing-2">
  <svg class="w-6 h-6" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M12.5615 24.5C19.1889 24.5 24.5615 19.1274 24.5615 12.5C24.5615 5.87259 19.1889 0.5 12.5615 0.5C5.9341 0.5 0.561523 5.87259 0.561523 12.5C0.561523 19.1274 5.9341 24.5 12.5615 24.5ZM14.0615 6.50001C14.0615 5.67158 13.3899 5.00001 12.5615 5.00001C11.7331 5.00001 11.0615 5.67158 11.0615 6.50001V12.5C11.0615 12.8978 11.2196 13.2794 11.5009 13.5607L15.7435 17.8033C16.3293 18.3891 17.279 18.3891 17.8648 17.8033C18.4506 17.2175 18.4506 16.2678 17.8648 15.682L14.0615 11.8787V6.50001Z" fill="currentColor"></path>
</svg>
</span>{!! $times !!}</span>
</div>
@endif




          <div class="text-xl">
            {!! $event_info['description'] !!}
          </div>

          @if ($registration_open)

                <div style="max-width:550px" class="relative z-20 countdown-container w-full mx-auto lg:mx-0 lg:mb-0 text-center flex flex-col lg:flex-row items-center justify-between overflow-hidden rounded-2xl lg:rounded-full border border-blue-100 shadow-lg">


          <div class="countdown w-full lg:h-full grid grid-cols-2 gap-6 lg:flex lg:items-center py-4 lg:py-0 px-6 justify-between bg-white" data-date="{{ $countdown }}" data-timezone="{{ $event_info['timezone'] }}">
            <div class="counter">
              <span id="days" class="value block text-3xl font-extrabold text-brand" data-days="">00</span>
              <span class="suffix block uppercase text-sm text-marketing-2">Days</span>
            </div>

            <div class="counter">
              <span id="hours" class="value block text-3xl font-extrabold text-brand" data-hours="">00</span>
              <span class="suffix block uppercase text-sm text-marketing-2">Hours</span>
            </div>

            <div class="counter">
              <span id="minutes" class="value block text-3xl font-extrabold text-brand" data-minutes="">00</span>
              <span class="suffix block uppercase text-sm text-marketing-2">Mins</span>
            </div>

            <div class="counter">
              <span id="seconds" class="value block text-3xl font-extrabold text-brand" data-seconds="">00</span>
              <span class="suffix block uppercase text-sm text-marketing-2">Secs</span>
            </div>
          </div>
          <a class="bg-marketing-2 w-full lg:w-auto px-6 no-underline shrink-0 text-white hover:text-white text-base font-normal p-6" href="{{ $event_info['registration_link'] }}" target="_blank">Register Now</a>
        </div>
        @else
        <div class="">
          @if (is_page('one-continuum'))
          <a href="/one-continuum/community-2023/" class="inline-flex items-center button button-solid !py-2 !px-4">
            <span class="mr-4 inline-block">View the Recap</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2929 3.67497C10.6834 3.28445 11.3166 3.28445 11.7071 3.67497L17.7071 9.67497C18.0976 10.0655 18.0976 10.6987 17.7071 11.0892L11.7071 17.0892C11.3166 17.4797 10.6834 17.4797 10.2929 17.0892C9.90237 16.6987 9.90237 16.0655 10.2929 15.675L14.5858 11.3821L3 11.3821C2.44772 11.3821 2 10.9344 2 10.3821C2 9.82979 2.44772 9.38208 3 9.38208H14.5858L10.2929 5.08919C9.90237 4.69866 9.90237 4.0655 10.2929 3.67497Z" fill="#3B8BCA"/>
            </svg>
          </a>
          @endif
        </div>
@endif
      </div>

      <div class="relative lg:col-span-6 order-1 lg:order-2">

      <img class="w-full h-full max-w-lg mx-auto object-contain" src="/wp-content/uploads/2023/09/1c-collage-2023.png" alt="">


      </div>
    </div>
  </div>
</section>
