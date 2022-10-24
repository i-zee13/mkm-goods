<?php

namespace App\Http\Controllers\Auth;

use App\City;
use App\Country;
use App\Http\Controllers\Employee;
use App\State;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Input;
use URL;
use DB;
use Auth;
use App\Http\Controllers\Core\AccessRightsAuth;

class RegisterController extends AccessRightsAuth
{
    public $controllerName = "register";
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     // $this->middleware('guest');
    // }

    protected $request;

    public function __contruct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:6'],
            'username' => ['required', 'string', 'max:100', 'unique:users']
        ]);
    }

    public function EmployeesList(){
        echo json_encode(User::selectRaw('id, name, phone, active, username, email, sin, city, state, country, address, designation, (Select designation from designations where id = users.designation) as designation_name')->where('super', 0)->get());
    }

    public function UploadUserImage(Request $request){
        echo json_encode("HERE");die;
        // if($request->hasFile('employeePicture')){
        //     echo json_encode("FILE");die;
        // }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
    
     */
    protected function create(array $data)
    {
      
        $userPicture = '';
        if(isset($_FILES["employeePicture"])){
            $userPicture = './storage/employees/' . time().'-'.str_replace(' ', '_', basename($_FILES["employeePicture"]["name"]));
            move_uploaded_file($_FILES["employeePicture"]["tmp_name"], $userPicture);
        }
        $status = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'sin' => $data['sin'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'reporting_to' => $data['reporting'],
            'address' => $data['address'],
            'hiring' => $data['hiring'],
            'designation' => $data['designation'],
            'department_id' => $data['department'],
            'salary' => $data['salary'],
            'picture' => $userPicture,
            'password' => Hash::make($data['password']),
            'created_by' => Auth::user()->id
        ]);
       
        if($status){
            echo json_encode('success');
            die;
        }else{
            echo json_encode($status);
            die;
        }
    }

    public function showRegistrationForm(){
        $countries  =   Country::all();
        $states     =   State::all();
        $cities     =   City::all();
        return view('auth.register', ['countries'=>$countries,'states'=>$states,'cities'=>$cities,'users' => DB::table('users')->get(), 'designations' => DB::table('designations')->get(), 'departments' => DB::table('departments')->get()]);
    }

    public function edit_profile(){
         
        $designation    =   DB::table('designations')->where('id',Auth::user()->designation)->first();
        $reporting_to   =   User::where('reporting_to',Auth::user()->reporting_to)->first();
        return view('includes.edit_profile', ['notifications_code' => DB::table('notifications_code')->get(),'designation'=>$designation,'reporting_to'=>$reporting_to]);
    }

    public function changeEmpStatus(Request $req){
        $user = User::find($req->id);
        $user->active = $req->status;
        $user->save();
    }
}
