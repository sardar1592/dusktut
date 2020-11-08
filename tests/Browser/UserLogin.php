<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Team;

class UserLogin extends DuskTestCase
{
    
    use DatabaseMigrations;

    public function setup():void {

        parent::setUp();

        $team = Team::factory()->create();

    }

    public function testUserCanLoginWithCorrectCredentials()
    {

        $user_email = User::OrderBy('id', 'DESC')->first()->email;

        $user_name = User::OrderBy('id', 'DESC')->first()->name;


        $this->browse(function (Browser $browser) use($user_email, $user_name) {
            $browser->visit('/login')
                    ->assertSee('Email')
                    ->type('#email', $user_email)
                    ->type('#password', 'password')
                    ->press('LOGIN')
                    ->pause(5000)
                    ->assertSee('Laravel Jetstream')
                    ->assertPathIs('/dashboard')
                    ->assertSee($user_name);
        });
    }

    public function testUserCanNotLoginWithIncorrectCredentials()
    {

        $user_email = User::OrderBy('id', 'DESC')->first()->email;

        $user_name = User::OrderBy('id', 'DESC')->first()->name;


        $this->browse(function (Browser $browser) use($user_email, $user_name) {
            $browser->visit('/login')
                    ->assertSee('Email')
                    ->type('#email', $user_email)
                    ->type('#password', 'password123')
                    ->press('LOGIN')
                    ->pause(5000)
                    ->assertDontSee('Laravel Jetstream')
                    ->assertPathIs('/login')
                    ->assertDontSee($user_name)
                    ->assertSee('These credentials do not match our records.');
        });
    }
}
