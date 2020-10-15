<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GuestTest extends DuskTestCase
{
    /**
     * @test
     * @group core
     * @group guest
     * 
     * @return void
     */
    public function testHomepageAsGuest()
    {
        $this->browse(function (Browser $browser) {

            //SECTION Test core application is visible
            $browser->assertGuest()
                    ->visitRoute('homepage')
                    ->assertPathIs('/')
                    ->assertSeeLink('Home')
                    ->assertDontSeeLink('Manage monitors')
                    ->assertDontSeeLink('Manage custom alerts')
                    ->assertDontSeeLink('Logout')
                    ->assertMissing('#admin-logged-in')
                    ->assertVisible('#activeMonitors')
                    ->assertVisible('#monitorNameCol')
                    ->assertVisible('#monitorStatusCol')
                    ->assertVisible('#monitorLastCheckCol');
        });
    }
}
