<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    //loads the main application layout used for logged-in users.
    public function render(): View
    {
        return view('layouts.app');
    }
}
