<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;


class RegisterUsers extends DuskTestCase
{
    
    public function testAUserCanRegister()
    {

        $faker = Faker::create();

        $password = $faker->password;

        $this->browse(function (Browser $browser) use($faker, $password) {
            $browser->visit('/register')
                    ->assertSee('Name')
                    ->type('name', $faker->firstName)
                    ->type('email', $faker->email)
                    ->type('password', $password)
                    ->type('password_confirmation', $password)
                    ->press('REGISTER')
                    ->assertSee('Welcome to your Jetstream application')
                    ->assertPathIs('/dashboard');
        });
    }
}
