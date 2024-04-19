<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
class UserTest extends TestCase
{
    use RefreshDatabase; // Pour réinitialiser la base de données entre les tests

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_create_user()
    {
        $user = User::factory()->create([
            'lastname' => 'Doe',
            'firstname' => 'John',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->assertNotNull($user);
        $this->assertEquals('Doe', $user->lastname);
        $this->assertEquals('john@example.com', $user->email);
    }
}
