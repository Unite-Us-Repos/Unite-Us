<section class="component-section">
  <div class="component-inner-section">
    <div class="grid-cards flex flex-col lg:grid lg:grid-cols-12 gap-8 w-full">
      @foreach ($cards as $card)

        <div class="grid-card col-span-{{ $card['acfe_layout_col'] }} relative flex flex-col justify-end bg-blue-100 p-8 pt-40 rounded-md">
          <div class="relative z-20">
          <h2 class="text-2xl !font-normal mb-4">{!! $card['title'] !!}</h2>
          {!! $card['description'] !!}
          </div>
          @if ($card['background_image'])
            <div class="absolute inset-0 sm:rounded-md overflow-hidden">
              <img fetchpriority="high" class="w-full h-full object-cover" src="{{ $card['background_image']['sizes']['medium'] }}" srcset="{{ $card['background_image']['sizes']['medium'] }} 300w, {{ $card['background_image']['sizes']['2048x2048'] }} 1024w" sizes="(max-width: 600px) 300px, 1024px" alt="{{ $card['background_image']['alt'] }}">
            </div>
          @endif
        </div>

      @endforeach
      </div>
  </div>
</section>
