<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUp\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    public function __construct()
    {
    }

    public function store(StoreRequest $request)
    {
        $user = new User;
        $user->email = $request->safe()->email;
        $user->password = Hash::make($request->safe()->password);
        $user->name = $request->safe()->name;
        $user->save();
        return response([], 201);
    }
}
