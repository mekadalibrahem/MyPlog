<?php

namespace App\View\Components\Widgits;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class DropdownCheckbox extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $id,
        public string $togleitem ,
        public string $title,
        public Collection $list,
        public string $filtername,
        public $oldf = null
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgits.dropdown-checkbox');
    }
}
