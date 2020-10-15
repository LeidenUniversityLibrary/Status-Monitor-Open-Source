<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class CreateAlertTest extends DuskTestCase
{
/**
     * @test
     * @group alerts
     * @group admin
     * 
     * @return void
     */
    public function testCreateAndDeleteAlerts()
    {
        $this->browse(function (Browser $browser) {

            $browser->loginAs(User::find(1))
                    ->assertAuthenticated()
                    ->visitRoute('admin_alerts')
                    ->assertVisible('#admin-panel')
                    ->assertVisible('#available-alerts')
                    ->visitRoute('admin_alerts')
                    ->assertMissing('@testalert')
                    ->type('title', 'example')
                    ->type('custom_alert', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean dictum quis ligula nec malesuada. Maecenas eleifend turpis at libero rutrum, ullamcorper condimentum lectus fermentum. Cras non mauris sit amet urna viverra porttitor in et ante.')
                    ->click('button[type="submit"]')
                    ->assertVisible('@testalert')
                    ->visitRoute('admin_alerts')
                    ->click('@testalert')
                    ->acceptDialog()
                    ->assertMissing('@testalert')
                    ->logout();
        });
    }
}
