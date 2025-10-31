<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $route;
    public $buttonValue;

    public function __construct($title,$route,$buttonValue)
    {
        $this->title=$title;
        $this->route=$route;
        $this->buttonValue=$buttonValue;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.page-header');
    }
}
