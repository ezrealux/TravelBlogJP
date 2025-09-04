<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

class FavoritesModal extends Component
{
    public $article;
    public $collections = [];
    public $selected = [];
    public $newCollectionName = '';

    protected $listeners = ['openFavoritesModal' => 'loadCollections'];

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function loadCollections()
    {
        $user = Auth::user();
        $this->collections = $user->collections()->get();

        // 預先勾選已經收藏的
        $this->selected = $this->collections
            ->filter(fn($c) => $c->articles->contains($this->article->id))
            ->pluck('id')
            ->toArray();
    }

    public function toggleCollection($collectionId)
    {
        $collection = Collection::findOrFail($collectionId);
        if (in_array($collectionId, $this->selected)) {
            $collection->articles()->syncWithoutDetaching([$this->article->id]);
        } else {
            $collection->articles()->detach($this->article->id);
        }
    }

    public function createCollection()
    {
        $user = Auth::user();
        if ($this->newCollectionName && !$user->collections()->where('name', $this->newCollectionName)->exists()) {
            $collection = $user->collections()->create([
                'name' => $this->newCollectionName,
            ]);
            $collection->articles()->attach($this->article->id);
            $this->newCollectionName = '';
            $this->loadCollections();
        }
    }

    public function render()
    {
        return view('livewire.favorites-modal');
    }
}
