<?php

namespace App\View\Components\Group;

use Illuminate\View\Component;
use Illuminate\View\View;

class Items extends Component
{
    public function __construct(
        public $groups,
    ) {}

    public function render(): View
    {
        return view('components.group.items');
    }
}