<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class AdminTest extends DuskTestCase
{
/**
     * @test
     * @group admin
     * @group core
     * 
     * @return void
     */
    public function testHomepageLoggedInAsAdmin()
    {
        $this->browse(function (Browser $browser) {

            //SECTION Test Admin can see extra buttons and columns
            $browser->loginAs(User::find(1))
                    ->assertAuthenticated()
                    ->visitRoute('homepage')
                    ->assertPathIs('/')
                    ->assertVisible('#manageMonitorsBtn')
                    ->assertVisible('#manageAlertsBtn')
                    ->assertVisible('#logoutBtn')
                    ->assertVisible('#admin-logged-in')
                    ->assertVisible('#currentStatusAlert')
                    ->assertVisible('#activeMonitors')
                    ->assertVisible('#monitorStatusCol')
                    ->assertVisible('#monitorLastCheckCol')
                    ->logout();
        });
    }
}