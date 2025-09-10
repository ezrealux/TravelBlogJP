@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Simplicity is an acquired taste. - Katharine Gerould -->
  <h1 class="mb-4">所有分類</h1>

  <div class="list-group">
    @forelse ($categories as $category)
      <a href="{{ route('articles.byCategory', $category) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        {{ $category->name }}
        <!--<span class="badge bg-primary rounded-pill">{{ $category->articles_count }}</span>-->
      </a>
    @empty
      <p class="text-muted">目前還沒有分類。</p>
    @endforelse
  </div>
</div>
@endsection
