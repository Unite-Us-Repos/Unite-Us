<section @isset ($section['id']) id="{{ $section['id'] }}" @endisset class="component-section">
  <div class="component-inner-section">
    <div class="flex flex-col gap-10 lg:grid lg:grid-cols-12">
      <div class="lg:col-span-5">

<div class="text-marketing-14 uppercase font-semibold mb-3 hidden">
            About the Event
          </div>


<div class="mt-6 flex hidden">
<div class="mr-4 flex-shrink-0">
<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M3.88251 0.469971C3.34644 0.469971 2.91188 0.904535 2.91188 1.4406V2.41122H1.94125C0.869129 2.41122 0 3.28035 0 4.35248V14.0587C0 15.1309 0.869129 16 1.94125 16H13.5888C14.6609 16 15.53 15.1309 15.53 14.0587V4.35248C15.53 3.28035 14.6609 2.41122 13.5888 2.41122H12.6181V1.4406C12.6181 0.904535 12.1836 0.469971 11.6475 0.469971C11.1115 0.469971 10.6769 0.904535 10.6769 1.4406V2.41122H4.85313V1.4406C4.85313 0.904535 4.41857 0.469971 3.88251 0.469971ZM3.88251 5.3231C3.34644 5.3231 2.91188 5.75767 2.91188 6.29373C2.91188 6.82979 3.34644 7.26436 3.88251 7.26436H11.6475C12.1836 7.26436 12.6181 6.82979 12.6181 6.29373C12.6181 5.75767 12.1836 5.3231 11.6475 5.3231H3.88251Z" fill="#2874AF"></path>
</svg>

</div>
      <div class="text-brand text-2xl ">

Thursday, November 9, 2023
</div>
</div>

<div class="mt-6 flex hidden">
<div class="mr-4 flex-shrink-0">

<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M7.76499 16C12.0535 16 15.53 12.5235 15.53 8.23498C15.53 3.94649 12.0535 0.469971 7.76499 0.469971C3.47651 0.469971 0 3.94649 0 8.23498C0 12.5235 3.47651 16 7.76499 16ZM8.73562 4.35248C8.73562 3.81641 8.30106 3.38185 7.76499 3.38185C7.22893 3.38185 6.79437 3.81641 6.79437 4.35248V8.23498C6.79437 8.49241 6.89663 8.73929 7.07866 8.92132L9.824 11.6667C10.2031 12.0457 10.8176 12.0457 11.1967 11.6667C11.5757 11.2876 11.5757 10.673 11.1967 10.294L8.73562 7.83294V4.35248Z" fill="#2874AF"></path>
</svg>

</div>
      <div class="text-brand text-2xl">

2:00—4:00 pm EST
</div>
</div>
<h2 class="font-normal">Thank you for joining <span class="text-action font-extrabold">the Continuum.</span></h2>

	         </div>
      <div class="lg:col-span-7 pt-">
        <div class="event-description text-lg font-medium">
                <div class="hidden uppercase font-semibold mb-3">
          &nbsp;
        </div>
{!! $section['description'] !!}
        </div>

        @if ($buttons)
          @php
            $data = [
              'justify' => 'justify-start',
              'classes' => '!py-2 !px-6 !bg-marketing-14 !border-marketing-14',
            ];
          @endphp
          @include('components.action-buttons', $data)
        @endif

              </div>
    </div>
  </div>
</section>
