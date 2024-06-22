@if ($testimonials)
    <div class="relative -mt-40 lg:-mt-72">
        @if ($background['has_divider'])
            <div class="hidden lg:block">
                @includeIf('dividers.waves')
            </div>
        @endif
        <section
            class="relative component-section {{ $section_classes }} @if ($section_settings['collapse_padding']) {{ $section_settings['padding_class'] }} @endif">
            @if ($background['image'])
                <div class="absolute inset-0" style="bottom: -1px">

                    <img class="w-full h-full object-contain xl:object-cover @if ('top' == $background['position']) object-top @endif @if ('bottom' == $background['position']) object-bottom @endif"
                        src="{{ $background['image']['sizes']['medium'] }}"
                        srcset="{{ $background['image']['sizes']['medium'] }} 300w, {{ $background['image']['sizes']['2048x2048'] }} 1024w"
                        sizes="(max-width: 600px) 300px, 1024px" alt="{{ $background['image']['alt'] }}">
                </div>
            @endif
            <div
                class="relative z-10 pt-28 lg:pt-48 component-inner-section @if ($section_settings['fullscreen']) fullscreen @endif">
                @if ($section['title'] || $section['description'])
                    <div class="text-center max-w-4xl mx-auto">
                        @if ($section['title'])
                            <h2>{!! $section['title'] !!}</h2>
                        @endif
                        @if ($section['description'])
                            {!! $section['description'] !!}
                        @endif
                    </div>
                @endif
                <div class="flex flex-col lg:grid lg:grid-cols-2 mb-8 gap-10 md:gap-20 lg:gap-52">



                    @foreach ($testimonials as $index => $testimonial)
                        <blockquote
                            class="!p-0 !border-none !not-italic @if ($loop->index == 0) lg:mt-44 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="33" viewBox="0 0 41 33"
                                fill="none">
                                <path
                                    d="M0.44873 21.3128C0.44873 12.9745 5.16172 5.36118 11.8082 0.648193L17.488 5.36118C13.6209 7.65726 9.63302 12.6119 8.7871 16.7207C9.14964 16.5999 10.1164 16.3582 10.8415 16.3582C14.9502 16.3582 18.0922 19.5002 18.0922 23.9715C18.0922 28.5636 14.346 32.3098 9.87471 32.3098C4.92003 32.3098 0.44873 28.3219 0.44873 21.3128ZM22.8052 21.3128C22.8052 12.9745 27.5182 5.36118 34.1647 0.648193L39.8445 5.36118C35.9774 7.65726 31.9895 12.6119 31.1436 16.7207C31.5061 16.5999 32.4729 16.3582 33.198 16.3582C37.3067 16.3582 40.4487 19.5002 40.4487 23.9715C40.4487 28.5636 36.7025 32.3098 32.2312 32.3098C27.2765 32.3098 22.8052 28.3219 22.8052 21.3128Z"
                                    fill="#425C77" />
                            </svg>
                            <div
                                class="text-lg @if ($background['color'] == 'dark') text-white @else text-brand @endif my-6">
                                {!! $testimonial['quote'] !!}
                            </div>

                            <div class="flex items-center mt-6 gap-6">

                                @isset($testimonial['image']['sizes'])
                                    <img class="w-20 h-14 object-cover" src="{{ $testimonial['image']['sizes']['medium'] }}"
                                        alt="{{ $testimonial['image']['alt'] }}" />
                                @endisset
                                <div
                                    class="text-base @if ($background['color'] == 'dark') text-white @else text-brand @endif">
                                    <span class="font-bold">{!! $testimonial['name'] !!}</span>
                                    @if ($testimonial['title_position'])
                                        ,
                                        <div class="text-base font-semibold">{!! $testimonial['title_position'] !!}</div>
                                    @endif
                                </div>
                            </div>
                        </blockquote>
                    @endforeach



                </div>
            </div>
        </section>
    </div>
    @if ($background['divider_bottom'])
        <div class="hidden lg:block">
            @includeIf('dividers.waves-bottom')
        </div>
    @endif
@endif
<style>
