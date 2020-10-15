<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class PrivateMonitorsTest extends DuskTestCase
{

    /**
     * @test
     * @group monitors
     * @group admin
     * @group newTest
     * 
     * @return void
     */
    public function testCreateAndDeletePrivateMonitors()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->assertAuthenticated()
                    ->visit('/monitors')
                    ->assertMissing('@testapp')
                    ->type('url', 'https://example.com')
                    ->type('app_name', 'example')
                    ->radio('visible_to_admin_only', '1')
                    ->click('button[type="submit"]')
                    ->assertVisible('@testapp')
                    ->logout()
                    ->assertGuest()
                    ->visitRoute('homepage')
                    ->assertMissing('@testapp')
                    ->loginAs(User::find(1))
                    ->assertAuthenticated()
                    ->visit('/monitors')
                    ->click('@testapp')
                    ->acceptDialog()
                    ->visitRoute('homepage')
                    ->assertMissing('@testapp')
                    ->logout();
        });
    }

}
