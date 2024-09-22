<?php

namespace App\View\Components\Partials\Article;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class ArticleList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public LengthAwarePaginator $articles,
        public bool $edit= false,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.partials.article.article-list');
    }
}
