<?php

namespace App\View\Components\Partials\Tag;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class TagList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Collection $tags ,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.partials.tag.tag-list');
    }
}
