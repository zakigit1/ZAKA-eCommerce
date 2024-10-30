<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCategoryType extends Component
{
    public $catdata;
    /**
     * Create a new component instance.
     */
    public function __construct($catdata)
    {
        $this->catdata = $catdata;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-category-type');
    }
}
