<?php

namespace App\View\Components\Partials\Tag;

use App\Models\Tag;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TagItemList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Tag $tag ,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.partials.tag.tag-item-list');
    }
}
