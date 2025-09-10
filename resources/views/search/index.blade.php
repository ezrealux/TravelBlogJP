@extends('layouts.app')
@section('content')

<!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
@if(isset($query) && $query !== '')
    <h3>Search Results for "{{ $query }}"</h3>

    @if($articles->isEmpty())
        <p class="no-results">No articles found.</p>
    @else
        @include('partials.article-card', [
            'articles' => $articles,
        ])
    @endif
@endif

@endsection