@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <img src="{{ asset($user->avatar) }}" class="rounded-circle" width="120" height="120" alt="avatar">
        <h2 class="mt-2">{{ $user->name }}</h2>
        <p class="text-muted">{{ '@'.$user->slug }}</p>
    </div>

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles"
                type="button" role="tab"><i class="bi bi-card-list"></i>文章</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="favorites-tab" data-bs-toggle="tab" data-bs-target="#favorites"
                type="button" role="tab"><i class="bi bi-bookmarks"></i>收藏清單</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="bio-tab" data-bs-toggle="tab" data-bs-target="#bio"
                type="button" role="tab"><i class="bi bi-person-square"></i>個人簡介</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3" id="profileTabsContent">

        <!-- Articles Tab -->
        <div class="tab-pane fade show active" id="articles" role="tabpanel">
            @if($articles->count())
                @foreach($articles as $article)
                    <div class="card mb-2">
                        <div class="card-body d-flex align-items-center">
                            <h5><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h5>
                            <p class="text-muted small">{{ $article->created_at->diffForHumans() }}</p>
                        
                            <div class="dropdown ms-auto">
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('articles.edit', $article) }}">編輯</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                                onsubmit="return confirm('確定要刪除嗎？')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">刪除</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            <button class="btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#favoritesModal"
                                    wire:click="$emitTo('favorites-modal', 'openFavoritesModal', {{ $article->id }})">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
                <livewire:favorites-modal />
                {{ $articles->links() }}
            @else
                <p class="text-muted">尚未發表文章</p>
            @endif
        </div>

        <!-- Favorites Tab -->
        <div class="tab-pane fade" id="favorites" role="tabpanel">
            @if($favoriteLists->count())
                @foreach($favoriteLists as $list)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>{{ $list->name }}</strong>
                            @if(!$list->is_default && auth()->id() === $user->id)
                                <form action="{{ route('favoriteLists.destroy', $list) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">刪除</button>
                                </form>
                            @endif
                        </div>
                        <div class="card-body">
                            @forelse($list->articles as $article)
                                <a href="{{ route('articles.show', $article) }}" class="d-block">
                                    {{ $article->title }}
                                </a>
                            @empty
                                <p class="text-muted">此清單尚無收藏文章</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">尚未建立任何收藏清單</p>
            @endif
        </div>

        <!-- Bio Tab -->
        <div class="tab-pane fade" id="bio" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    {!! nl2br(e($bio ?? '尚未填寫個人簡介')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
