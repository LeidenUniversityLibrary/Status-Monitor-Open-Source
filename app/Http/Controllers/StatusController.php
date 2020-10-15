<?php

namespace App\Http\Controllers;

use App\Monitor as UptimeMonitor;
use App\Alert as Alert;
use Artisan;
use Illuminate\Contracts\Queue\Monitor;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function __construct(UptimeMonitor $monitors)
    {
        $this->monitors = $monitors;
    }

    public function index()
    {
        $monitors = UptimeMonitor::all();

        return view('monitors/admin_monitors')->with('data', [
            'monitors' => $monitors,
        ]);
    }

    public function store(Request $request)
    {
        $newMonitor = new UptimeMonitor;
        $newMonitor->url = $request->get('url');
        $newMonitor->look_for_string = $request->get('look_for_string') ?? '';
        $newMonitor->app_name = $request->get('app_name');
        $newMonitor->certificate_check_enabled = $request->get('certificate_check_enabled');
        $newMonitor->visible_to_admin_only = $request->get('visible_to_admin_only');
        $newMonitor->uptime_check_method = $request->get('uptime_check_method');
        
        if(!empty($request->input('look_for_string'))) {
           $newMonitor->uptime_check_method = "get";
        }
        else {
           $newMonitor->uptime_check_method = "head";
        }

        $request->validate([
                'url' => 'unique:monitors|required|min:3|max:255',
                'look_for_string' => 'max:255',
                'app_name' => 'unique:monitors|required|min:3|max:255',
                'visible_to_admin_only' => 'bool|required',
                'certificate_check_enabled' => 'bool|required'
            ]
        );

        $newMonitor->save();

        if ($newMonitor->save()) {
            return redirect()->route('admin_monitors')->with("status", "Success! The website will be monitored.");
        } else {
            return redirect()->route('admin_monitors')->with("status", "Something went wrong. Unable to create new monitor.");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function edit($id)
    {
        // NOTE Edit one  monitor
        $monitor = UptimeMonitor::where('id', $id)->first();
        //dd($monitor);
        return view('monitors/update_monitor') ->with('monitor', $monitor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // NOTE Accept form submission from the "edit Building" task form and pass it to the Building table in the Database
        $request->validate([
            'url' => 'required|min:3|max:255m|unique:monitors,url' . $id,
            'look_for_string' => 'max:255',
            'app_name' => 'required|min:3|max:255|unique:monitors,app_name' . $id,
            'visible_to_admin_only' => 'bool|required',
            'certificate_check_enabled' => 'bool|required'
        ]);

        {
            $monitor = UptimeMonitor::where('id', $id)->first();
            $monitor->url = $request->input('url');
            $monitor->look_for_string = $request->input('look_for_string') ?? '';
            $monitor->app_name = $request->input('app_name');
            $monitor->certificate_check_enabled = $request->input('certificate_check_enabled');
            $monitor->visible_to_admin_only = $request->input('visible_to_admin_only');

            if(!empty($request->input('look_for_string'))) {
                $monitor->uptime_check_method = "get";
            }
            else {
                $monitor->uptime_check_method = "head";
            }

            $monitor->save();

            if ($monitor->save()) {
                return redirect()->route('admin_monitors')->with("status", "The monitor has been successfuly updated.");
            } else {
                return redirect()->route('edit_monitor', [$id])->with("status", "Something went wrong and the monitor was not updated.");
            }
        }
    }

    public function destroy($id)
    {
        // NOTE Delete one monitor
        $monitor = UptimeMonitor::where('id', $id)->first();
        if ($monitor->delete()){
            return redirect()->route('admin_monitors')->with("status", "The monitor was successfully deleted");
        } else {
            return redirect()->route('admin_monitors')->with("status", "Unable to delete monitor");
        }
    }

    public function check_status_manually()
    {
       Artisan::call("monitor:check-uptime");
       return redirect()->route('admin_monitors')->with("status", Artisan::output());
       
    }

    public function check_SSL_certificates()
    {
       Artisan::call("monitor:check-certificate");
       return redirect()->route('admin_monitors')->with("status", Artisan::output());
       
    }

}
