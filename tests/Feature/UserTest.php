<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegister()
    {
        // $user = User::factory()->create();
        $user = [
            'name' => 'zikri',
            'email' => 'zikri@gmail.com',
            'password' => 'inipassword'
        ];

        $this->post('/api/user-register', $user)->assertStatus(200);
    }
}