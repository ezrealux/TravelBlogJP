@extends('layouts.app')
<!-- Very little is needed to make a happy life. - Marcus Aurelius -->
@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">文章列表</h1>
  </div>

  <div class="row">
    <div class="col-md-9">
      @include('partials.article-card', [
        'articles' => $articles,
      ])
    </div>

    <div class="col-md-3">
      @include('partials.sidebar', [
          'categories' => \App\Models\Category::orderBy('id')->get(),
          'tags' => \App\Models\Tag::orderBy('name')->get(),
          'selectedCategory' => $selectedCategory ?? null,
          'selectedTag' => $selectedTag ?? null
      ])
    </div>
  </div>
  <livewire:favorites-modal as="favorites-modal"/>
</div>

{{ $articles->links() }}
@endsection
