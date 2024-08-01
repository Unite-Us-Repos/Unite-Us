@php
use Illuminate\Support\Str;

$s_settings = [
    'collapse_padding' => false,
    'fullscreen' => '',
];
$section_settings = isset($acf["components"][$index]['layout_settings']['section_settings']) ? $acf["components"][$index]['layout_settings']['section_settings'] : $s_settings;
@endphp

<section @isset($section['id']) id="{{ $section['id'] }}" @endisset class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
  <div class="component-inner-section">

      <!-- Display review credit icon and text -->
      @if ($review_credit)
      <div class="review-credit mb-6 text-center">
        <div class="icon mb-6 flex justify-center gap-2 items">
          @if ($review_credit['icon'])
            <img src="{{ $review_credit['icon']['sizes']['medium'] }}" alt="{{ $review_credit['icon']['alt'] }}" class="inline-block w-8">
          @endif
          @if ($review_credit['text'])
            <div class="text-lg mt-2">{!! $review_credit['text'] !!}</div>
          @endif
        </div>
      </div>
      @endif

    <div class="text-center mb-7">
      @if ($section['subtitle'])
        @if ($section['subtitle_display_as_pill'])
          <span class="@if($section['purple_text']) text-electric-purple @else text-action @endif text-sm py-1 px-4 inline-block mb-6 rounded-full">
        @else
          <span class="block text-base mb-8 font-semibold uppercase tracking-wider text-action">
        @endif
          {!! $section['subtitle'] !!}
          </span>
      @endif
      @if ($section['title'])
        <h2 class="width-30 m-auto mb-6">{!! $section['title'] !!}</h2>
      @endif
      @if ($section['description'])
        <div class="text-lg">
          <div class="max-w-4xl mx-auto">{!! $section['description'] !!}</div>
        </div>
      @endif
    </div>
  </div>

  <div class="relative component-inner-section z-10">
    @if (isset($reviews) && is_array($reviews) && count($reviews) > 0)
      <div class="flex flex-col flex-wrap justify-center sm:flex-row -mx-2 relative z-10">
        @foreach ($reviews as $review)
          @php
            $review_date = $review['date'];
            $review_title = $review['review_title'];
            $review_content = $review['review'];
            $reviewer_name = $review['reviewer'];
            $reviewer_title = $review['reviewer_title'];
          @endphp
          <div class="relative sm:basis-6/12 p-3 lg:basis-2/6">
            <div class="group">
             
                <div class="relative z-10 w-full p-9 text-lg">
                  <div class="stars-and-date flex justify-start items-center mb-5">
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.48705 1.71386C8.84185 0.621894 10.3867 0.621894 10.7415 1.71386L12.0092 5.6154C12.1678 6.10374 12.6229 6.43437 13.1364 6.43437H17.2387C18.3869 6.43437 18.8643 7.9036 17.9354 8.57847L14.6165 10.9898C14.2011 11.2916 14.0273 11.8265 14.186 12.3149L15.4537 16.2164C15.8085 17.3084 14.5587 18.2164 13.6298 17.5416L10.3109 15.1303C9.89552 14.8285 9.33302 14.8285 8.91761 15.1303L5.59876 17.5416C4.66988 18.2164 3.42008 17.3084 3.77488 16.2164L5.04257 12.3149C5.20124 11.8265 5.02741 11.2916 4.61201 10.9898L1.29316 8.57847C0.364278 7.9036 0.84166 6.43437 1.98982 6.43437H6.09214C6.60561 6.43437 7.06069 6.10374 7.21936 5.6154L8.48705 1.71386Z" fill="#9643FF"/>
                    </svg>
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.48705 1.71386C8.84185 0.621894 10.3867 0.621894 10.7415 1.71386L12.0092 5.6154C12.1678 6.10374 12.6229 6.43437 13.1364 6.43437H17.2387C18.3869 6.43437 18.8643 7.9036 17.9354 8.57847L14.6165 10.9898C14.2011 11.2916 14.0273 11.8265 14.186 12.3149L15.4537 16.2164C15.8085 17.3084 14.5587 18.2164 13.6298 17.5416L10.3109 15.1303C9.89552 14.8285 9.33302 14.8285 8.91761 15.1303L5.59876 17.5416C4.66988 18.2164 3.42008 17.3084 3.77488 16.2164L5.04257 12.3149C5.20124 11.8265 5.02741 11.2916 4.61201 10.9898L1.29316 8.57847C0.364278 7.9036 0.84166 6.43437 1.98982 6.43437H6.09214C6.60561 6.43437 7.06069 6.10374 7.21936 5.6154L8.48705 1.71386Z" fill="#9643FF"/>
                    </svg>
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.48705 1.71386C8.84185 0.621894 10.3867 0.621894 10.7415 1.71386L12.0092 5.6154C12.1678 6.10374 12.6229 6.43437 13.1364 6.43437H17.2387C18.3869 6.43437 18.8643 7.9036 17.9354 8.57847L14.6165 10.9898C14.2011 11.2916 14.0273 11.8265 14.186 12.3149L15.4537 16.2164C15.8085 17.3084 14.5587 18.2164 13.6298 17.5416L10.3109 15.1303C9.89552 14.8285 9.33302 14.8285 8.91761 15.1303L5.59876 17.5416C4.66988 18.2164 3.42008 17.3084 3.77488 16.2164L5.04257 12.3149C5.20124 11.8265 5.02741 11.2916 4.61201 10.9898L1.29316 8.57847C0.364278 7.9036 0.84166 6.43437 1.98982 6.43437H6.09214C6.60561 6.43437 7.06069 6.10374 7.21936 5.6154L8.48705 1.71386Z" fill="#9643FF"/>
                    </svg>
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.48705 1.71386C8.84185 0.621894 10.3867 0.621894 10.7415 1.71386L12.0092 5.6154C12.1678 6.10374 12.6229 6.43437 13.1364 6.43437H17.2387C18.3869 6.43437 18.8643 7.9036 17.9354 8.57847L14.6165 10.9898C14.2011 11.2916 14.0273 11.8265 14.186 12.3149L15.4537 16.2164C15.8085 17.3084 14.5587 18.2164 13.6298 17.5416L10.3109 15.1303C9.89552 14.8285 9.33302 14.8285 8.91761 15.1303L5.59876 17.5416C4.66988 18.2164 3.42008 17.3084 3.77488 16.2164L5.04257 12.3149C5.20124 11.8265 5.02741 11.2916 4.61201 10.9898L1.29316 8.57847C0.364278 7.9036 0.84166 6.43437 1.98982 6.43437H6.09214C6.60561 6.43437 7.06069 6.10374 7.21936 5.6154L8.48705 1.71386Z" fill="#9643FF"/>
                    </svg>
                    <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.48705 1.71386C8.84185 0.621894 10.3867 0.621894 10.7415 1.71386L12.0092 5.6154C12.1678 6.10374 12.6229 6.43437 13.1364 6.43437H17.2387C18.3869 6.43437 18.8643 7.9036 17.9354 8.57847L14.6165 10.9898C14.2011 11.2916 14.0273 11.8265 14.186 12.3149L15.4537 16.2164C15.8085 17.3084 14.5587 18.2164 13.6298 17.5416L10.3109 15.1303C9.89552 14.8285 9.33302 14.8285 8.91761 15.1303L5.59876 17.5416C4.66988 18.2164 3.42008 17.3084 3.77488 16.2164L5.04257 12.3149C5.20124 11.8265 5.02741 11.2916 4.61201 10.9898L1.29316 8.57847C0.364278 7.9036 0.84166 6.43437 1.98982 6.43437H6.09214C6.60561 6.43437 7.06069 6.10374 7.21936 5.6154L8.48705 1.71386Z" fill="#9643FF"/>
                    </svg>
                  <span class="text-gray-500 text-xs">{{ $review_date }}</span>
                </div>
                  <div class="text-block relative">
                    @if ($review_title)
                      <h3 class="text-xl font-semibold mb-4">{!! $review_title !!}</h3>
                    @endif
                    @if ($review_content)
                      <div class="text-lg w-full mb-4">
                          {!! $review_content !!}
                      </div>
                    @endif
                    <div class="review-meta text-sm">
                      <span class="font-bold">{{ $reviewer_name }}</span><br /><span class="text-gray-500 text-xs">{{ $reviewer_title }}</span>
                    </div>
                  </div>
                </div>
              
            </div>
          </div>
        @endforeach
      </div>
    @else
      <p>No reviews available.</p>
    @endif
  </div>
</section>
