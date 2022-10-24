<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Hash;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function change_password(){
        return view('auth.change_password');
    }

    public function ChangeUserPassword(Request $request){
        $user_data = DB::table('users')->whereRaw('username = "'.$request->pass_username.'"')->first();
        if(Hash::check($request->old_pass, $user_data->password)){
            if(Hash::check($request->new_password, $user_data->password)){
                echo json_encode(101);
            }else{
                $update = DB::table('users')->whereRaw('username = "'.$request->pass_username.'"')->update([
                    'password' => bcrypt($request->new_password),
                    'password_changed' => 1
                    ]);
                if($update){
                    echo json_encode(200);
                }else{
                    echo json_encode(202);
                }
            }
        }else{
            echo json_encode(201);
        }
        
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    public function username(){
        return 'username';
    }
}
