@php
        $jobInfo = App\View\Composers\Greenhouse::getJob($job['id']);
        $office_class = '';
        foreach ($jobInfo['offices'] as $index => $office) {
        $office_class .= ' gh-filter-' . $office['id'];
        }
        @endphp
        <div
          class="relative flex flex-col overflow-hidden rounded-lg shadow-lg p-9 border border-gray-300 gh-job-card {{ $office_class }}">

          <div class="flex-1 bg-white flex flex-col justify-between">
            <div class="flex flex-col flex-1">
              @if ($job['title'])
              <h3 class="text-lg font-bold mb-2">
                <a class="flex gap-3 justify-between no-underline text-action"
                  href="/our-careers/job-openings/job/?gh_jid={{ $job['id'] }}">
                  <span>{!! $job['title'] !!}</span>
                  <svg class="w-5 h-5 shrink-0 grow-0" width="26" height="27" viewBox="0 0 26 27" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M10.9277 7.23717H6.76107C5.61047 7.23717 4.67773 8.219 4.67773 9.43015V20.3951C4.67773 21.6062 5.61047 22.588 6.76107 22.588H17.1777C18.3283 22.588 19.2611 21.6062 19.2611 20.3951V16.0091M15.0944 5.04419H21.3444M21.3444 5.04419V11.6231M21.3444 5.04419L10.9277 16.0091"
                      stroke="#216CFF" stroke-width="2.54468" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>
              </h3>
              <div class="text-sm">
                {!! getGhExcerpt($jobInfo['content'], $job['title']) !!}
              </div>
              <p class="leading-normal flex flex-row flex-1 flex-wrap gap-2 text-sm font-medium text-action mt-6 mb-2">
                @isset ($jobInfo['location'])
                <span
                  class="inline-flex gap-1 items-center self-end bg-light font-medium rounded-full text-brand text-xs py-2 px-3 pill-span">

                  <svg class="self-start shrink-0" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M14.2019 4.05025C16.7989 6.78392 16.7989 11.2161 14.2019 13.9497L9.49961 18.8995L4.79735 13.9497C2.20036 11.2161 2.20036 6.78392 4.79735 4.05025C7.39434 1.31658 11.6049 1.31658 14.2019 4.05025ZM9.50034 11C10.5497 11 11.4003 10.1046 11.4003 9.00001C11.4003 7.89544 10.5497 7.00001 9.50034 7.00001C8.451 7.00001 7.60034 7.89544 7.60034 9.00001C7.60034 10.1046 8.451 11 9.50034 11Z"
                      fill="#216CFF" />
                  </svg>

                  {{ $jobInfo['location']['name'] }}
                </span>
                @endisset

                @foreach ($jobInfo['departments'] as $index => $department)
                <span
                  class="inline-flex gap-1 items-center self-end bg-light font-medium rounded-full text-brand text-xs py-2 px-3 pill-span">

                  <svg class="self-start shrink-0" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M9.49961 9C11.0736 9 12.3496 7.65685 12.3496 6C12.3496 4.34315 11.0736 3 9.49961 3C7.9256 3 6.64961 4.34315 6.64961 6C6.64961 7.65685 7.9256 9 9.49961 9Z"
                      fill="#216CFF" />
                    <path
                      d="M2.84961 18C2.84961 14.134 5.82692 11 9.49961 11C13.1723 11 16.1496 14.134 16.1496 18H2.84961Z"
                      fill="#216CFF" />
                  </svg>

                  {{ $department['name'] }}
                </span>
                @endforeach
              </p>
              @endif
            </div>
            <a class="absolute inset-0"
                  href="/our-careers/job-openings/job/?gh_jid={{ $job['id'] }}">
                  <span class="sr-only">View {!! $job['title'] !!} job description</span>
            </a>
            <div>
            </div>
          </div>
        </div>
