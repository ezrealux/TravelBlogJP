<!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
@forelse ($articles as $article)
<div class="card mb-3">
    <!--成為一個卡片內部內容區塊（有 padding）其子元素會以 Flexbox 排列（預設橫向）垂直置中對齊-->
    <div class="card-body d-flex align-items-center">
    <img src="{{ asset($article->user->avatar ?? 'images/default-avatar.png') }}"
            alt="avatar" class="rounded-circle me-2" width="40" height="40">
    <div class="mb-4">
        <h2>
        <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
        </h2>
        <p class="text-muted">
            作者：{{ $article->user->name }}
            @if($article->category)
                | 分類：<a href="{{ route('articles.byCategory', $article->category) }}">{{ $article->category->name }}</a>
            @endif
        </p>
        <p>
        標籤：
        @forelse($article->tags as $tag)
            <a href="{{ route('articles.byTag', $tag) }}" class="badge bg-secondary">{{ $tag->name }}</a>
        @empty
            <span class="text-muted">無</span>
        @endforelse
        </p>
    </div>

    <!--<div>
        <p class="text-muted">{{ Str::limit($article->body, 150) }}</p>
    </div>-->

    <button class="btn ms-auto"
            data-bs-toggle="modal"
            data-bs-target="#favoritesModal"
            wire:click="$dispatch('openFavoritesModal', {{ $article->id }})">
        <i class="bi bi-bookmark"></i>
    </button>

    </div>
</div>
@empty
<p>沒有符合條件的文章</p>
@endforelse