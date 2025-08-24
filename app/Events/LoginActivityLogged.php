<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Http\Request;
use App\Models\User;

class LoginActivityLogged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $request;

    public function __construct(User $user, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }
}
