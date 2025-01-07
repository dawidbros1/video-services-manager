<?php

namespace App\View\Components\Youtube;

use Illuminate\View\Component;
use Illuminate\View\View;

class Video extends Component
{
    public function __construct(
        public $details,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.youtube.video');
    }
}
