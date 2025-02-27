<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});
