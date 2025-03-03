<?php


use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

describe('User Creation Test', function () {

    beforeEach(function () {
        Artisan::call('update:roles-permissions');
        // Création des utilisateurs avant chaque test
        $this->admin = User::factory()->admin()->create();
        $this->moderator = User::factory()->moderator()->create();
        $this->client = User::factory()->client()->create();
    });

    test('Admin User Can Create User', function () {

        $user = User::factory()->make()->toArray();
        $user['password'] = 'password';
        $user['password_confirmation'] = 'password';

        Sanctum::actingAs($this->admin);

        $this->post(route('users.store'), $user)
            ->assertStatus(ResponseAlias::HTTP_CREATED);

        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
        ]);
    });

    test('prevents a client from creating a user', function () {
        $user = User::factory()->make()->toArray();
        $user['password'] = 'password';
        $user['password_confirmation'] = 'password';

        Sanctum::actingAs($this->client);

        $this->post(route('users.store'), $user)
            ->assertStatus(403);

    });

    test('prevents a moderator from creating a user', function () {
        $user = User::factory()->make()->toArray();
        $user['password'] = 'password';
        $user['password_confirmation'] = 'password';

        Sanctum::actingAs($this->moderator);

        $this->post(route('users.store'), $user)
            ->assertStatus(403);

    });
});
