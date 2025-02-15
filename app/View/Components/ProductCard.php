<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCard extends Component
{

    public $product ,$className ,$key, $wishlistSection;

    /**
     * Create a new component instance.
     */
    public function __construct($product , $key=null ,$className=null,$wishlistSection =null)
    {
        $this->product = $product;
        $this->key = $key ;
        $this->className = $className;
        $this->wishlistSection = $wishlistSection;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-card');
    }
}
