<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\FavoriteList;
use Illuminate\Support\Facades\Auth;

class FavoritesModal extends Component
{
    public $article;
    public $favoriteLists = [];
    public $selected = [];
    public string $newListName = '';

    protected $listeners = ['openFavoritesModal' => 'loadFavoriteLists'];

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function loadFavoriteLists($articleId)
    {    
        dd(Auth::id(), Auth::user());
        logger("⭐ loadFavoriteLists fired for articleId={$articleId}");

        $this->article = Article::findOrFail($articleId);
        $user = Auth::user();

        $this->favoriteLists = $user->favoriteLists()->with('articles')->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'selected' => $c->articles->contains($this->article->id)
            ])
            ->toArray();

        $this->selected = collect($this->favoriteLists)
            ->filter(fn($c) => $c['selected'])
            ->pluck('id')
            ->toArray();
    }

    public function toggleFavoriteList($listId)
    {
        $favoriteList = FavoriteList::findOrFail($listId);
        if (in_array($collectionId, $this->selected)) {
            // 移除
            $favoriteList->articles()->detach($this->article->id);
            $this->selected = array_diff($this->selected, [$listId]);
        } else {
            // 加入
            $favoriteList->articles()->attach($this->article->id);
            $this->selected[] = $listId;
        }
    }

    public function createFavoriteList()
    {
        $user = Auth::user();
        if (!$this->newListName) return;
        if (!$user->favoriteLists()->where('name', $this->newListName)->exists()) {
            $collection = $user->favoriteLists()->create([
                'name' => $this->newListName,
            ]);
            $collection->articles()->attach($this->article->id);
            $this->newListName = '';
            $this->loadfavoriteLists();
        }
    }

    public function render()
    {
        return view('livewire.favorites-modal');
    }
}
