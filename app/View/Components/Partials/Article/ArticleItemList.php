<?php

namespace App\View\Components\Partials\Article;

use App\Models\Article;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ArticleItemList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Article $article,
        public bool $edit = false,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.partials.article.article-item-list');
    }
}
