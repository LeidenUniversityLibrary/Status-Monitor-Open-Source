<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class ManualMonitorCheckTest extends DuskTestCase
{
    /**
     * @group monitors
     * @group admin
     * @group artisan
     * 
     * @return void
     */
    public function testManualMonitorCheck()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->assertAuthenticated()
                    ->visitRoute('admin_monitors')
                    ->assertPathIs('/monitors')
                    ->click('#manualMonitorCheckBtn')
                    ->waitFor('#session-status',30)
                    ->assertSee('Start checking the uptime of');
        });
    }
}
