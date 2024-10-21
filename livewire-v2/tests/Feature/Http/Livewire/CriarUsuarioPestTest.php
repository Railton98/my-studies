<?php

use App\Http\Livewire\UserCreate;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

test('component can render', function () {
    livewire(UserCreate::class)
        ->assertSuccessful();
});

it('should be able to create an user', function () {
    livewire(UserCreate::class)
        ->set('name', 'Jeremias')
        ->set('email', 'jeremias@email.com')
        ->call('save')
        ->assertHasNoErrors();
    assertDatabaseHas('users', [
        'name' => 'Jeremias',
        'email' => 'jeremias@email.com'
    ]);
});

test('name should be required', function () {
    livewire(UserCreate::class)
        ->set('name')
        ->call('save')
        ->assertHasErrors(['name' => 'required']);
});

it('should make sure that live validation is working', function () {
    livewire(UserCreate::class)
        ->set('name', 'Jeremias')
        ->assertHasNoErrors()
        ->set('name', '')
        ->assertHasErrors(['name' => 'required']);
});

it('should emit an event after creating', function () {
    livewire(UserCreate::class)
        ->set('name', 'Jeremias')
        ->set('email', 'jeremias@email.com')
        ->call('save')
        ->assertHasNoErrors()
        ->assertEmitted('user::created');
});

it('should make sure that the form is being reset', function () {
    livewire(UserCreate::class)
        ->set('name', 'Jeremias')
        ->set('email', 'jeremias@email.com')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSet('name', '')
        ->assertset('email', '');
});

it('should check the html if has a certain message', function () {
    livewire(UserCreate::class)
        ->set('name', 'Rafael')
        ->set('email', 'rafael@email.com')
        ->call('save')
        ->assertSee('UUUUU Jeremias!!! Deu ruim nesse nome');
});
