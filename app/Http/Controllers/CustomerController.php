<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Customer;
use App\Models\CompanyPoc;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $poc=CompanyPoc::all();
        $customer=Customer::all();
        //$customer=Customer::with('companies')->first();

       return view("customer.customer", compact('customer','poc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
  ;  
         $data=$request->validate([
        'first_name' => 'required|max:255',
        'last_name' => 'required',
        'city' => 'required',
        'state' => 'required',
        'country' => 'required',
        'address' => 'required',
        'email' => 'required|email',
        'contact' => 'required',
        'customer_type' => 'required',
        'whatsapp' => 'required',
        'linked_in' => 'required',
        'wechat' => 'required',

                 ]); 
 
              
$customer=Customer::create($data);
           // $customer = new Customer();
           // $customer->first_name = $request->first_name;
           // $customer->last_name = $request->last_name;         
           // $customer->city = $request->city;         
           // $customer->state = $request->state;         
           // $customer->contact = $request->contact;         
           // $customer->whatsapp = $request->whatsapp;         
           // $customer->email = $request->email; 
           // $customer->country = $request->country; 
           // $customer->address = $request->address; 
           // $customer->linked_in = $request->linked_in; 
           // $customer->customer_type = $request->customer_type; 
           // $customer->wechat = $request->wechat;  
          
           //  $customer->save(); 
            $customer->companypocs()->attach([$request->company]);
 Session::flash('flash_message','Customer successfully Added.');
          return redirect('/customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
         return view('customer.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Customer $customer)
    {       
    
    
         $request->validate([
        'first_name' => 'required|max:255',
        'last_name' => 'required',
        'city' => 'required',
        'state' => 'required',
        'country' => 'required',
        'address' => 'required',
        'email' => 'required|email',
        'contact' => 'required',
        'customer_type' => 'required',
        'whatsapp' => 'required',
        'linked_in' => 'required',
        'wechat' => 'required',
                 ]); 
        

          $input = $request->except(['_token', '_method']);
          $customer->first_name = $request->first_name;
           $customer->last_name = $request->last_name;         
           $customer->city = $request->city;         
           $customer->state = $request->state;         
           $customer->contact = $request->contact;         
           $customer->whatsapp = $request->whatsapp;         
           $customer->email = $request->email; 
           $customer->country = $request->country; 
           $customer->address = $request->address; 
           $customer->linked_in = $request->linked_in; 
           $customer->customer_type = $request->customer_type; 
           $customer->wechat = $request->wechat; 
         //  $customer->compa = $request->company; 

             $customer->update($input);
             Session::flash('flash_message','Customer successfully Updated.');
              return redirect('/customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
    $customer=Customer::find($id);
        $customer->companypocs()->detach();
         $customer->destroy($id);
     Session::flash('flash_message','Customer successfully Deleted.');
        return redirect()->route('customer');
    }
}
