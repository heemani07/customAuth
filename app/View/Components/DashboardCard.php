<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardCard extends Component
{
    public $title;
    public $count;
    public $color;

    public function __construct($title, $count, $color = 'primary')
    {
        $this->title = $title;
        $this->count = $count;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.dashboard-card');
    }
}
