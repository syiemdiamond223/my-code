<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    // Guest pages that are accessible without login, such as login and registration pages
    public function render(): View
    {
        return view('layouts.guest');
    }
}
