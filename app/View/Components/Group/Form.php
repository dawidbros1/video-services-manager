<?php

namespace App\View\Components\Group;

use Illuminate\View\Component;
use Illuminate\View\View;

class Form extends Component
{
    public function __construct(
        public ?string $id,
        public ?string $title,
        public ?string $open,
        public ?string $route,
    ) {}

    public function render(): View
    {
        return view('components.group.form');
    }
}
