{{--
  Template Name: Press - In The News
--}}
{{--
  Template Post Type: page
--}}
@extends('layouts.app')
@section('content')
    <section class="bg-brand relative component-section">
        <div class="absolute inset-0 opacity-75 bg-electric-purple-overlay"></div>
        <div class="relative w-full">

            <div class="component-inner-section">
                <div class="relative max-w-3xl">
                    <div class="mb-6">
                        @php
                            $data = [
                                'color' => 'white',
                            ];
                        @endphp
                        @include('ui.breadcrumbs.simple-with-slashes', $data)
                    </div>
                    <h1 class="text-4xl font-extrabold tracking-tight mb-0 text-white md:text-5xl lg:text-6xl">
                        {!! get_the_title() !!}
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <section id="kh-top" class="component-section">

        <div class="component-inner-section">

            <div id="kh-top" class="mb-8">
                <div id="kh-filters" class="ajax-filters kh-filters relative z-20">
                    @php
                        echo do_shortcode('[searchandfilter slug="studies-data-copy-copy-copy"]');
                    @endphp
                </div>
            </div>


            <div id="kh-search-results">

                {!! do_shortcode('[searchandfilter slug="studies-data-copy-copy-copy" show="results"]') !!}

            </div>
        </div>
    </section>
    <section id="" class="component-section relative bg-white  padding-collapse ">
        <div class="absolute bottom-0 border border-blue-900 -ml-4 w-full h-3/6 -mb-[1px] bg-blue-900"></div>

        <div class="component-inner-section relative ">
            <div
                class="bg-light w-full rounded-2xl flex flex-col md:relative md:flex-none md:grid md:grid-cols-2 lg:gap-20">

                <div class=" p-9 md:p-20 md:pr-0 flex flex-col  justify-center  text-lg  md:order-1  lg:mb-0">

                    <h1 class="mb-5 lg:text-4xl font-bold h2">
                        Sign up for<br>
                        the newsletter
                    </h1>



                </div>

                <div class="relative p-9 md:p-9  flex flex-col  justify-center   md:order-2 ">


                    <div class="">
                        <iframe src="https://marketing.uniteus.com/l/1001871/2022-12-15/31f9" width="100%"
                            type="text/html" frameborder="0" allowtransparency="true" style="border: 0"
                            title="Join our Newsletter"></iframe>
                        <p class="text-sm mt-2">We care about the protection of your data. Read our <a
                                href="/privacy-policy">Privacy Policy</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
    jQuery().ready(function($) {
        $(document).on("sf:ajaxfinish", ".searchandfilter", function() {
            lazyLoadInstance.update(); // refresh lazy loading on ajax call
        });
    });
</script>
