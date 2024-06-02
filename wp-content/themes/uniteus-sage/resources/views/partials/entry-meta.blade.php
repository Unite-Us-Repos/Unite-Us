@php
if (!isset($linkable)) {
  $linkable = true;
}
@endphp
<div class="flex text-center text-xl justify-center">
  @if ($linkable)
    <a href="/{{ $catSlug }}/">
  @endif
    <span class="text-sm font-medium text-white mr-6">
      <span class="inline-block bg-action font-medium rounded-full px-4 py-1">
        {{ $type }}
      </span>
    </span>
  @if ($linkable)
    </a>
  @endif
  <time class="text-white" datetime="{{ get_post_time('c', true) }}">
    {{ get_the_date() }}
  </time>
</div>
