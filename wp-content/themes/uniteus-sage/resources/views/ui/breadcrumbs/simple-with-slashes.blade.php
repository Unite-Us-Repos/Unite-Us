@if ($pageBreadcrumbs)
<nav class="breadcrumbs flex @if (isset($data['align']) && $data['align'] == 'center') justify-center @endif" aria-label="Breadcrumb">
  <ol role="list" class="flex items-center mb-0 space-x-2 sm:space-x-4">
    <li>
      <div>
        <a href="/" class="@if ( get_post_type() != 'team' ) crumb @endif text-{{ $data['color'] }}">
          <!-- Heroicon name: solid/home -->
          <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
          </svg>
          <span class="sr-only">Home</span>
        </a>
      </div>
    </li>


    @if ($pageBreadcrumbs['parents'])
      @foreach ($pageBreadcrumbs['parents'] as $parent)
        <li>
          <div class="flex items-center">
            <svg class="flex-shrink-0 h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
              <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
            </svg>
            <a href="{{ $parent['permalink'] }}" class="@if ( get_post_type() != 'team' ) crumb @endif ml-2 sm:ml-4 text-sm font-medium text-{{ $color }}">{!! $parent['title'] !!}</a>
          </div>
        </li>
      @endforeach
    @endif

    @if ($pageBreadcrumbs['current_page'])
      <li @if (!$pageBreadcrumbs['children']) class="current-item" @endif>
        <div class="flex items-center">
          <svg class="flex-shrink-0 h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
          </svg>
          @if ($pageBreadcrumbs['current_page']['permalink'])
            <a href="{{ $pageBreadcrumbs['current_page']['permalink'] }}" class="@if ( get_post_type() != 'team' ) crumb @endif ml-4 text-sm font-medium text-{{ $data['color'] }}" aria-current="page">
          @endif
            {!! $pageBreadcrumbs['current_page']['title'] !!}
          @if ($pageBreadcrumbs['current_page']['permalink'])
            </a>
          @endif
        </div>
      </li>
    @endif

    @if ($pageBreadcrumbs['children'])
      @foreach ($pageBreadcrumbs['children'] as $child)
        <li class="current-item">
          <div class="flex items-center">
            <svg class="flex-shrink-0 h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
              <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
            </svg>
            <a href="{{ $child['permalink'] }}" class="ml-2 sm:ml-4 text-sm font-medium text-{{ $color }}">{{ $child['title'] }}</a>
          </div>
        </li>
      @endforeach
    @endif
  </ol>
</nav>
@endif
