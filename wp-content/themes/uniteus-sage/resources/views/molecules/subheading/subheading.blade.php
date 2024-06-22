@if ($section['subtitle'])
    @if ($section['subtitle_display_as_pill'])
        <div class="@if ($section['purple_text']) text-electric-purple @else text-action @endif bg-light mix-blend-multiply text-sm py-1 px-4 inline-block mb-6 rounded-full">
    @else
        <div class="subtitle mb-6">
    @endif
        {{ $section['subtitle'] }}
    </div>
@endif
