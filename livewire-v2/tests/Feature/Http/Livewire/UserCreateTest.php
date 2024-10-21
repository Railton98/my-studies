<?php

namespace Tests\Feature\Http\Livewire;

use App\Http\Livewire\UserCreate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function component_can_render()
    {
        Livewire::test(UserCreate::class)
            ->assertSuccessful();
    }

    /** @test */
    public function it_should_be_able_to_create_an_user()
    {
        Livewire::test(UserCreate::class)
            ->set('name', 'Jeremias')
            ->set('email', 'jeremias@email.com')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'Jeremias',
            'email' => 'jeremias@email.com'
        ]);
    }

    /** @test */
    public function name_should_be_required()
    {
        Livewire::test(UserCreate::class)
            ->set('name')
            ->call('save')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function it_should_make_sure_that_live_validation_is_working()
    {
        Livewire::test(UserCreate::class)
            ->set('name', 'Jeremias')
            ->assertHasNoErrors()
            ->set('name', '')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function it_should_emit_an_event_after_creating()
    {
        Livewire::test(UserCreate::class)
            ->set('name', 'Jeremias')
            ->set('email', 'jeremias@email.com')
            ->call('save')
            ->assertHasNoErrors()
            ->assertEmitted('user::created');
    }

    /** @test */
    public function it_should_make_sure_that_the_form_is_being_reset()
    {
        Livewire::test(UserCreate::class)
            ->set('name', 'Jeremias')
            ->set('email', 'jeremias@email.com')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('name', '')
            ->assertset('email', '');
    }
}
