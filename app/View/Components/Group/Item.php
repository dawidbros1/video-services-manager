<?php

namespace App\View\Components\Group;

use Illuminate\View\Component;
use Illuminate\View\View;

class Item extends Component
{
    public function __construct(
        public $details,
        public ?string $open,
    ) {
        if (empty($details->thumb)) {
            $details->thumb = asset('images/image.png');
        }
    }

    public function render(): View
    {
        return view('components.group.item');
    }
}
