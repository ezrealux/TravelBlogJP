@extends('layouts.app')

@section('content')
<li class="nav-item">
    <a class="nav-link" href="{{ route('users.show', Auth::user()) }}">
        我的主頁
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('home') }}">
        首頁
    </a>
</li>

<div class="container">
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset($user->avatar ?? 'storage/avatars/default-avatar.png') }}" 
             class="rounded-circle me-3" width="80" height="80" alt="avatar">
        <div>
            <h2>{{ $user->name }}</h2>
            <p class="text-muted">已發表 {{ $articles->total() }} 篇文章</p>
        </div>
    </div>

    <h3>{{ $user->name }} 的文章</h3>
    {{--@include('articles.partials.list', ['articles' => $articles])--}}
</div>
@endsection
