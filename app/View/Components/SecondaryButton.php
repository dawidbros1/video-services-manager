<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SecondaryButton extends Component
{
    public function __construct(
        public ?string $id,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.secondary-button');
    }
}
