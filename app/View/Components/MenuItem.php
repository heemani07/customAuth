<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItem extends Component
{
    /**
     * Create a new component instance.
     */

    public $icon;
    public $name;
    public $path;

    public function __construct($icon, $name, $path)
    {
        $this->icon = $icon;
        $this->name = $name;
        $this->path = $path;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu-item');
    }
}
