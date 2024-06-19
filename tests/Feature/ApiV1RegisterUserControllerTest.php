<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class ApiV1RegisterUserControllerTest extends TestCase
{
    public function test_user_register_without_name_fail()
    {
        // Cuando
        $response = $this->post('/api/v1/user/create');

        $response->assertJson([
            'status' => 'error',
            'message' => 'The name field is required.',
            'data' => null,
        ]);

        $response->assertStatus(422);
    }

    public function test_user_register_without_email_fail()
    {
        // Dato
        $name = 'Kennit';

        // Cuando
        $response = $this->post('/api/v1/user/create', [
            'name' => $name,
        ]);

        $response->assertJson([
            'status' => 'error',
            'message' => 'The email field is required.',
            'data' => null,
        ]);

        $response->assertStatus(422);
    }

    public function test_user_register_without_password_fail()
    {
        // Dato
        $name = 'Kennit';
        $email = 'kennit@gmailcom';

        // Cuando
        $response = $this->post('/api/v1/user/create', [
            'name' => $name,
            'email' => $email,
        ]);

        $response->assertJson([
            'status' => 'error',
            'message' => 'The password field is required.',
            'data' => null,
        ]);

        $response->assertStatus(422);
    }

    public function test_user_register_with_password_is_less_than_min_fail()
    {
        // Dato
        $name = 'Kennit';
        $email = 'kennit@gmailcom';
        $password = '1234567';

        // Cuando
        $response = $this->post('/api/v1/user/create', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertJson([
            'status' => 'error',
            'message' => 'The password must be at least 8 characters.',
            'data' => null,
        ]);

        $response->assertStatus(422);
    }

    public function test_user_register_with_email_exist_fail()
    {
        // Dado
        $user = new User();
        $user->name = 'Pepito';
        $user->email = 'kennit@gmailcom';
        $user->password = 'password';
        $user->save();

        $name = 'Kennit';
        $email = 'kennit@gmailcom';
        $password = '1234567';

        // Cuando
        $response = $this->post('/api/v1/user/create', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertJson([
            'status' => 'error',
            'message' => 'The email has already been taken.',
            'data' => null,
        ]);

        $response->assertStatus(422);
    }

    public function test_user_register_success_response()
    {
        // Dado
        Carbon::setTestNow('2024-06-19T00:56:22.000000Z');

        $name = 'Kennit';
        $email = 'kennit@gmail.com';
        $password = 'secret12';

        // Cuando
        $response = $this->post('/api/v1/user/create', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        // Se espera qué
        $response->assertJson([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => [
                'name' => $name,
                'email' => $email,
                'updated_at' => '2024-06-19T00:56:22.000000Z',
                'created_at' => '2024-06-19T00:56:22.000000Z',
            ],
        ]
        );

        $this->assertDatabaseHas('users', [
            'name' => 'Kennit',
            'email' => 'kennit@gmail.com',
        ]);

        $response->assertStatus(201);
    }
}
