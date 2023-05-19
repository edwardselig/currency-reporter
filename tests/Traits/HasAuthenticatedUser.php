<?php

namespace Tests\Traits;

use App\Models\User;

trait HasAuthenticatedUser
{
    protected function getUser(): User
    {
        $user = User::where('name', '=', 'admin')->first();
        $user->createToken('token-name')->plainTextToken;
        return $user;
    }
}
