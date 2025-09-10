<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Article;

class FavoriteModal extends Component
{
    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function render()
    {
        return view('components.favorite-modal');
    }
}