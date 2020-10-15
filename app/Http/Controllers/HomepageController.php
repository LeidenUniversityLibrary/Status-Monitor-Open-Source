<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Monitor as UptimeMonitor;
use App\Alert as Alert;

class HomepageController extends Controller
{
    public function index()
    {
        $alerts = Alert::all();
        $monitors = UptimeMonitor::all();
        $down_detector = UptimeMonitor::where('uptime_status', '=', 'down')->count() > 0;
        
        //dd($monitors);

        return view('status/index')->with('data', [
            'alerts' => $alerts,
            'monitors' => $monitors,
            'down_detector' => $down_detector,
            
        ]);
    }
}
