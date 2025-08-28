@php
  $bookmarked = $bookmarked ?? (auth()->check() ? auth()->user()->bookmarks->contains($post->id) : false);
  $count = $count ?? $post->bookmarkedBy()->count();
@endphp

<button
  class="btn btn-sm {{ $bookmarked ? 'btn-warning' : 'btn-outline-warning' }} js-bookmark-btn"
  data-post-id="{{ $post->id }}"
  data-bookmarked="{{ $bookmarked ? '1' : '0' }}"
>
  ブックマーク <span class="js-bookmark-count">{{ $count }}</span>
</button>
