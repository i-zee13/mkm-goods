<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as EMP;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;
use Auth;

class Notifications extends AccessRightsAuth
{
    private $controllerName = "Notifications";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('notifications.notifications', [ 'emp' => EMP::all(), 'codes' => DB::table('notifications_code')->get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        return view('notifications.viewAll');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        if(DB::table('subscribed_notifications')->where('emp_id', $request->emp_id)->first()){
            $delete_existing = DB::table('subscribed_notifications')->where('emp_id', $request->emp_id)->delete();
            if($delete_existing){
                foreach($request->notifications as $notifications){
                    $emailProp = 0;
                    $webProp = 0;
                    if(isset($notifications["properties"])){
                        foreach($notifications["properties"] as $props){
                            if($props == "email"){
                                $emailProp = 1;
                            }else{
                                $webProp = 1;
                            }
                        }
                        $insert = DB::table('subscribed_notifications')->insert([
                            'notification_code_id' => $notifications['code'],
                            'web' => $webProp,
                            'email' => $emailProp,
                            'emp_id' => $request->emp_id
                        ]);
                    }
                }
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            foreach($request->notifications as $notifications){
                $emailProp = 0;
                $webProp = 0;
                foreach($notifications["properties"] as $props){
                    if($props == "email"){
                        $emailProp = 1;
                    }else{
                        $webProp = 1;
                    }
                }
                $insert = DB::table('subscribed_notifications')->insert([
                    'notification_code_id' => $notifications['code'],
                    'web' => $webProp,
                    'email' => $emailProp,
                    'emp_id' => $request->emp_id
                ]);
            }
            echo json_encode('success');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($employeeId)
    {
        
        echo json_encode(DB::table('subscribed_notifications')->where('emp_id', $employeeId)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        //
    }

    public function readFourNotifs(Request $request)
    {
        

        if($request->notif_ids != ""){
            foreach($request->notif_ids as $notifications){
                DB::table('notification_read_status')->whereRaw('notif_id = "'.$notifications.'" AND emp_id = '.Auth::user()->id)->delete();
                DB::table('notification_read_status')->insert([
                    'notif_id' => $notifications,
                    'emp_id' => Auth::user()->id
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function notif_pref_against_emp($id){
        echo json_encode(DB::table('subscribed_notifications')->where('emp_id', $id)->get());
    }

    public function save_pref_against_emp(Request $request){
        if(DB::table('subscribed_notifications')->where('emp_id', $request->emp_id)->first()){
            $delete_existing = DB::table('subscribed_notifications')->where('emp_id', $request->emp_id)->delete();
            if($delete_existing){
                foreach($request->notifications as $notifications){
                    $emailProp = 0;
                    $webProp = 0;
                    if(isset($notifications["properties"])){
                        foreach($notifications["properties"] as $props){
                            if($props == "email"){
                                $emailProp = 1;
                            }else{
                                $webProp = 1;
                            }
                        }
                        $insert = DB::table('subscribed_notifications')->insert([
                            'notification_code_id' => $notifications['code'],
                            'web' => $webProp,
                            'email' => $emailProp,
                            'emp_id' => $request->emp_id
                        ]);
                    }
                }
                echo json_encode('success');
            }else{
                echo json_encode('failed');
            }
        }else{
            foreach($request->notifications as $notifications){
                $emailProp = 0;
                $webProp = 0;
                foreach($notifications["properties"] as $props){
                    if($props == "email"){
                        $emailProp = 1;
                    }else{
                        $webProp = 1;
                    }
                }
                $insert = DB::table('subscribed_notifications')->insert([
                    'notification_code_id' => $notifications['code'],
                    'web' => $webProp,
                    'email' => $emailProp,
                    'emp_id' => $request->emp_id
                ]);
            }
            echo json_encode('success');
        }
    }
}
