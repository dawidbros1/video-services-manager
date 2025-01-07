<?php

namespace App\View\Components\Groups;

use Illuminate\View\Component;
use Illuminate\View\View;

class Header extends Component
{
    public function __construct(
        public $name,
        public $description,
        public $thumb,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.groups.header');
    }
}
