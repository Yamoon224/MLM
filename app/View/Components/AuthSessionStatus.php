<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AuthSessionStatus extends Component
{
    public function __construct(public ?string $status)
    {
    }

    public function render()
    {
        return view('components.auth-session-status');
    }
}
