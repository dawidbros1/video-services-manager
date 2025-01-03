<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Popup extends Component
{
    public function __construct(
        public ?string $id,
        public ?string $title,
        public ?string $open,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.popup');
    }
}
