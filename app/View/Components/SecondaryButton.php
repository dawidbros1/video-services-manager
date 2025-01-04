<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SecondaryButton extends Component
{
    public function __construct() {}

    public function render(): View
    {
        return view('components.secondary-button');
    }
}
