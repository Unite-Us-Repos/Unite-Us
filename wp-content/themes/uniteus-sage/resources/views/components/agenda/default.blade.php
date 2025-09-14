@php
    $agendas = [];
    // Safe replacement for: $info = $acf['event_info'];
    $infoRaw = $acf['event_info'] ?? null;

    if (is_array($infoRaw)) {
        $info = $infoRaw;
    } elseif (is_string($infoRaw)) {
        $decoded = json_decode($infoRaw, true);
        $info = is_array($decoded) ? $decoded : [];
    } else {
        $info = [];
    }
    $info['timezone'] = $info['timezone'] ?? 'America/New_York';
    $info['event_dates'] = is_array($info['event_dates'] ?? null)
        ? $info['event_dates']
        : ['start' => null, 'end' => null];

    $signup = isset($acf['sign_up']) ? $acf['sign_up'] : [];
    $featured_speakers[] =
        isset($acf['featured_speaker']) && !empty($acf['featured_speaker']['first_name'])
            ? $acf['featured_speaker']
            : [];
    $style = isset($acf['event_style']) ? $acf['event_style'] : false;
    $show_social = true;

    if (!function_exists('formatDateRange')) {
        function formatDateRange($d1, $d2, $format = '')
        {
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
    }
    if (!$info['timezone']) {
        $info['timezone'] = 'America/New_York';
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

    if ($info['start_time'] and $info['end_time']) {
        $start_time = str_replace(' pm', '', $info['start_time']);
        $start_time = str_replace(' am', '', $start_time);
        $times = $start_time . '&mdash;' . $info['end_time'] . ' ' . $abbr;
        $title_date .= '<br />' . 'from ' . $start_time . '&mdash;' . $info['end_time'] . ' ' . $abbr;
    } elseif ($info['start_time']) {
        $title_date .= '<br />' . 'starting at ' . $info['start_time'];
        $times = $start_time . ' ' . $abbr;
    }

    $agendas = $agenda;
    $tabs = [];
    $sessions = [];
    if (is_array($agendas)) {
        foreach ($agendas as $index => $item) {
            $tabs[] = [
                'title' => date('l', strtotime($item['date'])),
                'summary' => $item['summary'],
                'sessions' => $item['sessions'],
            ];
        }
    }

    $zones = [
        'PST' => 'America/Los_Angeles',
        'EST' => 'America/New_York',
    ];

    $gmdate_str = gmdate('Y-m-d H:i:s', strtotime($info['start_date_time']));
    $countdown = $gmdate_str;
    $today = date('Ymd');
    $registration_open = 1;
    if ($info['event_dates']['end'] <= $today) {
        $registration_open = 0;
    }
    $show_additinal_information = false;
@endphp
@php
    $s_settings = [
        'collapse_padding' => false,
        'fullscreen' => '',
    ];
    $section_settings = isset($acf['components'][$index]['layout_settings']['section_settings'])
        ? $acf['components'][$index]['layout_settings']['section_settings']
        : $s_settings;
@endphp
@if ($background['has_divider'])
    @includeIf('dividers.waves')
@endif
<section id="{{ $id }}"
    class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">

    <div class="absolute inset-0">
        @if ($background['image'])
            <img fetchPriority="high"
                class="w-full h-full @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                src="{{ $background['image']['sizes']['medium'] }}"
                srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
                sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
        @endif
    </div>

    <div class="relative component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif"">
        <div class="text-center mb-6 @if ($background['image']) text-green @endif">{{ $subtitle }}</div>
        <h2 class="text-center mb-6 @if ($background['image']) text-white @else text-brand @endif">
            {{ $title }}</h2>


        <div class="flex items-center justify-center mx-auto">
            <div class="container mx-auto h-full flex flex-col justify-center items-stretch" x-data="{ tab: 0 }">

                <!-- TABS -->
                <div
                    class="flex flex-col items-center md:items-start md:flex-row text-xl justify-center md:gap-10 mb-4 z-10">
                    @if (count($tabs) > 1)
                        <span
                            class="text-brand font-medium md:py-4 no-underline font-medium inline-block align-middle">Explore
                            each day: </span>
                        <div class="flex gap-10">
                            @foreach ($tabs as $tab_index => $tab)
                                <a href="!#0" @click.prevent="tab = {{ $tab_index }}"
                                    :class="{
                                        'cursor-default border-b-2 border-action text-xl font-bold': tab ===
                                            {{ $tab_index }},
                                        'focus:outline-none focus:shadow-outline': tab !==
                                            {{ $tab_index }}
                                    }"
                                    class="py-4 no-underline font-medium inline-block align-middle">
                                    {{ $tab['title'] }}
                                </a>
                            @endforeach
                        </div>
                </div>
                @endif


                <!-- Tabs Contains -->
                @foreach ($tabs as $tab_index => $tab)
                    <div x-show="tab === {{ $tab_index }}" class="z-0">
                        <div
                            class="text-lg text-center max-w-3xl mx-auto @if ($background['image']) text-white @endif">
                            {!! $tab['summary'] !!}
                        </div>
                        <div class="flex flex-wrap gap-4 accordion accordion-vertical mt-10" x-data="{ selected: {{ $tab_index . '999' }} }">
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

                                        <div class="@if ($session['breakout_session']) breakout-session lg:basis-[49%] xl:basis-[49.25%] @else basis-full @endif"
                                            x-ref="container{{ $tab_index . '_' . $s_index }}"
                                            :class="{ 'open': selected === '{{ $tab_index . '_' . $s_index }}' }">

                                            <div
                                                class="relative social-card py-6 px-9 lg:p-10 bg-white rounded-lg shadow-lg">

                                                @if ($session['description'] || !empty($session['topic']) || $session['presenters'] || $session['video'])
                                                    <button type="button" class="w-full"
                                                        @click="selected !== '{{ $tab_index . '_' . $s_index }}' ? selected = '{{ $tab_index . '_' . $s_index }}' : selected = null">
                                                @endif

                                                @if ($session['breakout_session'])
                                                    <div class="breakout flex flex-col gap-8 md:grid lg:grid-cols-12">
                                                        <div class="lg:col-span-6 order-3 lg:order-1">
                                                            <div class="flex gap-6 items-center">
                                                                @if ($session['video'])
                                                                    <svg width="26" height="26"
                                                                        viewBox="0 0 26 26" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M12.8808 23.1899C18.573 23.1899 23.1875 18.5755 23.1875 12.8833C23.1875 7.19108 18.573 2.57664 12.8808 2.57664C7.18865 2.57664 2.57422 7.19108 2.57422 12.8833C2.57422 18.5755 7.18865 23.1899 12.8808 23.1899ZM12.3072 9.23467C11.9118 8.97111 11.4035 8.94654 10.9846 9.17073C10.5657 9.39493 10.3042 9.83149 10.3042 10.3066V15.4599C10.3042 15.9351 10.5657 16.3716 10.9846 16.5958C11.4035 16.82 11.9118 16.7954 12.3072 16.5319L16.1721 13.9552C16.5306 13.7163 16.7458 13.314 16.7458 12.8833C16.7458 12.4525 16.5306 12.0503 16.1721 11.8113L12.3072 9.23467Z"
                                                                            fill="#216CFF" />
                                                                    </svg>
                                                                @else
                                                                    @if ($session_time)
                                                                        <svg width="26" height="26"
                                                                            viewBox="0 0 26 26" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M12.8832 8.70556V13L16.104 16.2208M22.5456 13C22.5456 18.3364 18.2196 22.6625 12.8832 22.6625C7.54674 22.6625 3.2207 18.3364 3.2207 13C3.2207 7.66356 7.54674 3.33752 12.8832 3.33752C18.2196 3.33752 22.5456 7.66356 22.5456 13Z"
                                                                                stroke="#216cff" stroke-width="2.14721"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                        </svg>
                                                                    @endif

                                                                    @if ($session['icon'])
                                                                        <img class="lazy  w-6 h-6 acf-icon-action"
                                                                            src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $session['icon'] }}.svg"
                                                                            alt="Icon" />
                                                                    @endif
                                                                @endif

                                                                <span
                                                                    class="text-medium-gray text-base font-semibold flex items-center gap-2">
                                                                    @if ($session['video'])
                                                                        Watch On-Demand
                                                                    @else
																																		 @if ($session['top_left_label'])
                                                                        {{ $session['top_left_label'] }}
                                                                    @endif

                                                                        @if ($session_time)
                                                                            {!! $session_time !!} {{ $abbr }}
                                                                        @endif
                                                                    @endif

                                                                    @if ($session['left_label'])
                                                                        {{ $session['left_label'] }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="lg:col-span-6 order-1 lg:order-2">
                                                            <div class="flex flex-col items-start lg:items-end gap-6">
                                                                <div class="">
                                                                    @if ($session['label'])
                                                                        <div
                                                                            class="min-w-[140px] text-base text-center inline-block shrink-0 px-4 py-1 bg-action rounded-full text-white"@if ($session['label_color']) style="background: {{ $session['label_color'] }}" @endif>
                                                                            {{ $session['label'] }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="lg:col-span-12 order-2 lg:order-3">
                                                            <div class="flex flex-col items-start gap-6">
                                                                <div class="">
                                                                    <h3
                                                                        class="heading mb-0 text-xl font-normal lg:pr-12">
                                                                        {!! $session['title'] !!}
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="flex flex-col gap-8 md:grid lg:grid-cols-12">
                                                        <div class="lg:col-span-3 order-2 lg:order-1">
                                                            <div class="flex gap-6">
                                                                @if ($session['video'])
                                                                    <svg width="26" height="26"
                                                                        viewBox="0 0 26 26" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M12.8808 23.1899C18.573 23.1899 23.1875 18.5755 23.1875 12.8833C23.1875 7.19108 18.573 2.57664 12.8808 2.57664C7.18865 2.57664 2.57422 7.19108 2.57422 12.8833C2.57422 18.5755 7.18865 23.1899 12.8808 23.1899ZM12.3072 9.23467C11.9118 8.97111 11.4035 8.94654 10.9846 9.17073C10.5657 9.39493 10.3042 9.83149 10.3042 10.3066V15.4599C10.3042 15.9351 10.5657 16.3716 10.9846 16.5958C11.4035 16.82 11.9118 16.7954 12.3072 16.5319L16.1721 13.9552C16.5306 13.7163 16.7458 13.314 16.7458 12.8833C16.7458 12.4525 16.5306 12.0503 16.1721 11.8113L12.3072 9.23467Z"
                                                                            fill="#216CFF" />
                                                                    </svg>
                                                                @else
                                                                    @if ($session_time)
                                                                        <svg width="26" height="26"
                                                                            viewBox="0 0 26 26" fill="none"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M12.8832 8.70556V13L16.104 16.2208M22.5456 13C22.5456 18.3364 18.2196 22.6625 12.8832 22.6625C7.54674 22.6625 3.2207 18.3364 3.2207 13C3.2207 7.66356 7.54674 3.33752 12.8832 3.33752C18.2196 3.33752 22.5456 7.66356 22.5456 13Z"
                                                                                stroke="#216cff" stroke-width="2.14721"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round" />
                                                                        </svg>
                                                                    @endif
                                                                @endif
                                                                @if ($session['icon'])
                                                                    <img class="lazy  w-6 h-6 acf-icon-action"
                                                                        src="/wp-content/themes/uniteus-sage/resources/icons/acf/{{ $session['icon'] }}.svg"
                                                                        alt="Icon" />
                                                                @endif
                                                                <span class="text-medium-gray text-base font-semibold">
                                                                    @if ($session['video'])
                                                                        Watch On-Demand
                                                                    @else
																																		
																																		 @if ($session['top_left_label'])
                                                                        {{ $session['top_left_label'] }}
                                                                    @endif

                                                                        @if ($session_time)
                                                                            {!! $session_time !!} {{ $abbr }}
                                                                        @endif
                                                                    @endif

                                                                    @if ($session['left_label'])
                                                                        {{ $session['left_label'] }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="lg:col-span-9 order-1 lg:order-2">
                                                            <div class="flex flex-col items-start lg:flex-row gap-6">
                                                                <div class="">
                                                                    @if ($session['label'])
                                                                        <div
                                                                            class="min-w-[140px] text-base text-center inline-block shrink-0 px-4 py-1 bg-action rounded-full text-white"@if ($session['label_color']) style="background: {{ $session['label_color'] }}" @endif>
                                                                            {{ $session['label'] }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="">
                                                                    <h3
                                                                        class="heading mb-0 text-xl font-normal lg:pr-12">
                                                                        {!! $session['title'] !!}
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($session['description'] || !empty($session['topic']) || $session['presenters'] || $session['video'])
                                                    </button>
                                                @endif

                                                @if ($session['description'] || !empty($session['topic']) || $session['presenters'] || $session['video'])
                                                    <div class="relative overflow-hidden transition-all max-h-0 duration-700"
                                                        x-ref="container{{ $tab_index . '_' . $s_index }}"
                                                        x-bind:style="selected === '{{ $tab_index . '_' . $s_index }}' ?
                                                            'max-height: ' + $refs
                                                            .container{{ $tab_index . '_' . $s_index }}.scrollHeight +
                                                            'px' : ''">
                                                        @if ($session['breakout_session'])
                                                            <div class="flex flex-col gap-4 lg:grid lg:grid-cols-12">

                                                                <!-- Featured Image -->

                                                                @isset($session['featured_image']['sizes'])
                                                                    <div class="lg:col-span-12">
                                                                        <img class="mt-10 mx-auto"
                                                                            src="{{ $session['featured_image']['sizes']['medium'] }}"
                                                                            alt="" />
                                                                    </div>
                                                                @endisset

                                                                <!-- Topic -->
                                                                <div class="lg:col-span-6 lg:order-2">
                                                                    @if (!empty($session['topic']))
                                                                        <div class="topic">
                                                                            <h3
                                                                                class="mb-4 mt-5 uppercase font-bold text-blue-600 text-sm">
                                                                                TOPIC
                                                                            </h3>
                                                                            <div
                                                                                class="text-action bg-light mix-blend-multiply text-sm py-1 px-4 inline-block mb-6 rounded-full">
                                                                                {!! $session['topic'] !!}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <!-- Presenters -->
                                                                <div class="lg:col-span-6 lg:order-1">
                                                                    @if ($session['presenters'])
                                                                        @foreach ($session['presenters'] as $group)
                                                                            <h3
                                                                                class="mb-4 @if ($loop->index === 0) mt-5 @else mt-10 @endif font-bold text-action text-sm">
                                                                                {{ $group['group_title'] }}
                                                                            </h3>
                                                                            @if ($group['members'])
                                                                                @foreach ($group['members'] as $m)
                                                                                    <div class="flex gap-3 mb-2">
                                                                                        @if ($m['image'])
                                                                                            <div class="shrink-0">
                                                                                                <img class="rounded-full w-9 h-9 object-cover"
                                                                                                    src="{{ $m['image']['sizes']['thumbnail'] }}"
                                                                                                    alt="" />
                                                                                            </div>
                                                                                        @else
                                                                                            @if ($m['name'])
                                                                                                <div class="shrink-0">
                                                                                                    <img class="rounded-full w-9 h-9 object-cover"
                                                                                                        src="@asset('/images/person-head.svg')" />
                                                                                                </div>
                                                                                            @endif
                                                                                        @endif
                                                                                        <div class="mb-4 text-sm">
                                                                                            <span
                                                                                                class="font-bold">{!! $m['name'] !!}</span>

                                                                                            <div class="text-sm">
                                                                                                {!! $m['title'] !!}
                                                                                            </div>

                                                                                            @if ($m['social_media_link'] && $show_social)
                                                                                                <div
                                                                                                    class="social-media-links mt-2 flex items-center gap-2">
                                                                                                    @foreach ($m['social_media_link'] as $link)
                                                                                                        <a href="{{ $link['url'] }}"
                                                                                                            target="_blank"
                                                                                                            class="inline-block">
                                                                                                            @isset($link['icon'])
                                                                                                                @if (!empty($link['icon']))
                                                                                                                    <span
                                                                                                                        class="inline-flex items-center justify-center rounded-md text-gray-400 shadow-lg">
                                                                                                                        <img class="lazy h-4 w-4"
                                                                                                                            data-src="/wp-content/themes/uniteus-sage/resources/icons/social/{{ $link['icon'] }}.svg"
                                                                                                                            alt="" />
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

                                                                <!-- Video and Description -->
                                                                <div
                                                                    class="col-span-12 text-lg border-t border-blue-300 lg:mr-16 lg:mt-6 pt-6 lg:order-3">
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
                                                        @else
                                                            <div class="flex flex-col gap-8 lg:grid lg:grid-cols-12">

                                                                <div class="lg:col-span-3">
                                                                    @isset($session['featured_image']['sizes'])
                                                                        <img class="mt-10 mx-auto"
                                                                            src="{{ $session['featured_image']['sizes']['medium'] }}"
                                                                            alt="" />
                                                                    @endisset

                                                                    @if (!empty($session['topic']))
                                                                        <div class="topic pb-4">
                                                                            <h3
                                                                                class="mb-4 mt-5 uppercase font-bold text-blue-600 text-sm">
                                                                                TOPIC</h3>
                                                                            <div
                                                                                class=" text-action bg-light mix-blend-multiply text-sm py-1 px-4 inline-block mb-6 rounded-full">
                                                                                {!! $session['topic'] !!}
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    @if ($session['presenters'])
                                                                        @foreach ($session['presenters'] as $group)
                                                                            <h3
                                                                                class="mb-4 @if ($loop->index === 0) mt-5  @else mt-10 @endif font-bold text-action text-sm">
                                                                                {{ $group['group_title'] }}</h3>
                                                                            @if ($group['members'])
                                                                                @foreach ($group['members'] as $m)
                                                                                    <div class="flex gap-3 mb-2">
                                                                                        @if ($m['image'])
                                                                                            <div class="shrink-0">
                                                                                                <img class="rounded-full w-9 h-9 object-cover"
                                                                                                    src="{{ $m['image']['sizes']['thumbnail'] }}"
                                                                                                    alt="" />
                                                                                            </div>
                                                                                        @else
                                                                                            @if ($m['name'])
                                                                                                <div class="shrink-0">
                                                                                                    <img class="rounded-full w-9 h-9 object-cover"
                                                                                                        src="@asset('/images/person-head.svg')" />
                                                                                                </div>
                                                                                            @endif
                                                                                        @endif
                                                                                        <div class="mb-4 text-sm">
                                                                                            <span
                                                                                                class="font-bold">{!! $m['name'] !!}</span>

                                                                                            <div class="text-sm">
                                                                                                {!! $m['title'] !!}
                                                                                            </div>

                                                                                            @if ($m['social_media_link'] && $show_social)
                                                                                                <div
                                                                                                    class="social-media-links mt-2 flex items-center gap-2">
                                                                                                    @foreach ($m['social_media_link'] as $link)
                                                                                                        <a href="{{ $link['url'] }}"
                                                                                                            target="_blank"
                                                                                                            class="inline-block">
                                                                                                            @isset($link['icon'])
                                                                                                                @if (!empty($link['icon']))
                                                                                                                    <span
                                                                                                                        class="inline-flex items-center justify-center rounded-md text-gray-400 shadow-lg">
                                                                                                                        <img class="lazy h-4 w-4"
                                                                                                                            data-src="/wp-content/themes/uniteus-sage/resources/icons/social/{{ $link['icon'] }}.svg"
                                                                                                                            alt="" />
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

                                                                <div
                                                                    class="lg:col-span-9 text-lg border-t border-blue-300 lg:mr-16 lg:mt-6 pt-6">
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
                                                        @endif
                                                    </div>
                                                @endif
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
@if ($background['divider_bottom'])
    @includeIf('dividers.waves-bottom')
@endif
