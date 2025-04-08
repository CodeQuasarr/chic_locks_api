<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

test('All users can get products list', function () {

    $response = $this->get(route('products.index'), ['Accept' => 'application/json', 'Accept-Language' => 'en']);
    $response->assertStatus(ResponseAlias::HTTP_OK);
});

