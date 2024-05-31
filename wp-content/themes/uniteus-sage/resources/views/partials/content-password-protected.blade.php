<section class="component-section">
  <div class="component-inner-section text-center">
    <div class="flex flex-col md:grid md:grid-cols-2 gap-10 lg:gap-20 xl:gap-32">
      <div class="px-4 mx-auto sm:max-w-2xl sm:px-6 sm:text-center md:px-0 md:text-left md:flex md:items-center order-2 md:order-1">
        <div class="md:py-14">
          <h1 class="mt-4 text-4xl tracking-tight font-extrabold sm:mt-5 sm:text-5xl md:mt-6 xl:text-6xl">
            <span class="block leading-norma">This content is protected</span>
          </h1>
          <p class="text-lg">
            This content is password protected for licensed Unite Us network partners. To view it, please enter your
            password below or contact your Unite Us point of contact.
          </p>
          <div class="">
            {!! get_the_password_form('') !!}
          </div>
        </div>
      </div>
      <div class="flex items-center justify-center md:m-0 relative order-1 md:order-2">
        <div class="mx-auto max-w-sm lg:max-w-none md:m-0">
          <img class="w-full h-auto" src="@asset('/images/protected-lock.png')" alt="" />
        </div>
      </div>
    </div>
  </div>
</section>
