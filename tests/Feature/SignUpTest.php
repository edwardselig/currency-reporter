<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SignUpTest extends TestCase
{
    use WithFaker;
    public function testStore()
    {
        $data = [
            'name' => $this->faker->lexify("???????"),
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->lexify("???????????")
        ];
        $this
            ->postJson('/api/sign-up', $data)
            ->assertCreated();
        $user = User::latest()->first();
        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
    }

    public function testStoreUnprocessable()
    {
        $data = [
            'email' => $this->faker->lexify("??????"),
            'password' => $this->faker->lexify("??")
        ];
        $this
            ->postJson('/api/sign-up', $data)
            ->assertUnprocessable()
            ->assertJsonValidationErrorFor('name')
            ->assertJsonValidationErrorFor('email')
            ->assertJsonValidationErrorFor('password');
    }
}
