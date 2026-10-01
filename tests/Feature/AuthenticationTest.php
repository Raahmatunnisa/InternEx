<?php

use App\Models\User;

test('halaman login dapat diakses', function () {
    $this->get(route('login'))->assertOk();
});

test('user dapat login dengan kredensial yang benar', function () {
    $user = User::factory()->mahasiswa()->create(['password' => bcrypt('password123')]);

    $response = $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('dashboard'));
});

test('user tidak dapat login dengan kredensial yang salah', function () {
    $user = User::factory()->mahasiswa()->create(['password' => bcrypt('password123')]);

    $response = $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'salah',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

test('user dapat logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $this->assertGuest();
    $response->assertRedirect(route('login'));
});
