<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    // init roles and permissions
    Artisan::call('update:roles-permissions');

    $this->admin = User::factory()->admin()->create();
    $this->client = User::factory()->client()->create();
    $this->moderator = User::factory()->moderator()->create();

    $this->userData = User::factory()->make()->toArray();
    $this->userData['password'] = 'password';
    $this->userData['password_confirmation'] = 'password';
});

test('all role can create order', function () {
    Sanctum::actingAs($this->admin);

    $response = post(
        route('orders.store'),
        [
            'amount' => 100,
            'payment_intent_id' => 'pi_123456789',
            'payment_status' => 'succeeded',
            'payment_address' => '123 Main St, Anytown, USA',
            'payment_method' => 'credit_card',
        ], [
        'Accept' => 'application/json', 'Accept-Language' => 'en'
    ]);

    $response->assertStatus(ResponseAlias::HTTP_CREATED);
    $this->assertDatabaseHas('orders', [
        'amount' => 100,
        'payment_intent_id' => 'pi_123456789',
        'payment_status' => 'succeeded',
        'payment_address' => '123 Main St, Anytown, USA',
        'payment_method' => 'credit_card',
    ]);
});

test('all roles can create order', function () {
    $users = [
        $this->admin,
        $this->client,
        $this->moderator,
    ];
    $roles = ['user', 'admin', 'moderator'];

    $orderData = [
        'status' => 'pending',
        'payment_intent_id' => 'pi_123456789',
        'amount' => 100.00,
        'payment_status' => 'succeeded',
        'payment_address' => '123 Main St, Anytown, USA',
        'payment_method' => 'credit_card',
    ];

    foreach ($users as $user) {
        Sanctum::actingAs($user);

        $response = post(
            route('orders.store'),
            $orderData, [
                'Accept' => 'application/json',
                'Accept-Language' => 'en'
            ]
        );

        $response->assertStatus(ResponseAlias::HTTP_CREATED);
        $this->assertDatabaseHas('orders', [
            'amount' => $orderData['amount'],
        ]);

        // Clean up orders for next iteration (optional)
//        \DB::table('orders')->delete();
    }
});

test('unauthenticated user cannot create order', function () {
    $orderData = [
        'status' => 'pending',
        'payment_intent_id' => 'pi_123456789',
        'amount' => 100.00,
        'payment_status' => 'succeeded',
        'payment_address' => '123 Main St, Anytown, USA',
        'payment_method' => 'credit_card',
    ];

    $response = $this->postJson(route('orders.store'), $orderData);

    $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
});

