<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class CreateMonitorTest extends DuskTestCase
{
 /**
     * @test
     * @group monitors
     * @group admin
     * 
     * @return void
     */
    public function testAdminCreateAndDeleteMonitors()
    {
        $this->browse(function (Browser $browser) {

            $browser->loginAs(User::find(1))
                    ->assertAuthenticated()
                    ->visitRoute('admin_monitors')
                    ->assertPathIs('/monitors')
                    ->assertVisible('#admin-panel')
                    ->assertVisible('#monitored-apps')
                    ->assertMissing('@testapp')
                    ->type('url', 'https://example.com')
                    ->type('app_name', 'example')
                    ->click('button[type="submit"]')
                    ->assertVisible('@testapp')
                    ->visitRoute('admin_monitors')
                    ->click('@testapp')
                    ->acceptDialog()
                    ->assertMissing('@testapp')
                    ->logout();
        });
    }
}
