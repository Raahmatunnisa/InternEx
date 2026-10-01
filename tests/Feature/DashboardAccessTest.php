<?php

use App\Models\User;

test('mahasiswa diarahkan ke dashboard mahasiswa', function () {
    $user = User::factory()->mahasiswa()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertViewIs('dashboard.mahasiswa');
});

test('mentor diarahkan ke dashboard mentor', function () {
    $user = User::factory()->mentor()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertViewIs('dashboard.mentor');
});

test('guest tidak dapat mengakses dashboard', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

test('mahasiswa tidak dapat mengakses halaman khusus mentor', function () {
    $user = User::factory()->mahasiswa()->create();

    $this->actingAs($user)
        ->get(route('students.index'))
        ->assertForbidden();
});

test('mentor tidak dapat mengakses halaman khusus mahasiswa', function () {
    $user = User::factory()->mentor()->create();

    $this->actingAs($user)
        ->get(route('logbooks.index'))
        ->assertForbidden();
});
