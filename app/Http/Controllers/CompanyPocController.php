<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use App\Models\CompanyPoc;
use Illuminate\Http\Request;

class CompanyPocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     $poc=CompanyPoc::all();
        $company=Company::all();
           return view("poc.index",compact('company','poc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $poc=CompanyPoc::all();
         return view('index',compact('poc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data= $request->validate([
        'first_name' => 'required|max:255',
        'last_name' => 'required',
        'job_title' => 'required',
        'business' => 'required',
        'contact' => 'required',
        'whatsapp' => 'required',
        'email' => 'required|email',
        'image' => 'required|image|mimes:jpg,png,jpeg,JPEG,PNG',
         ]); 

      if($request->hasFile('image')){

            $image =$request->image->store('images','public');  
                } 
      
 
        $poc = new CompanyPoc();
         $poc->first_name = $request->first_name;
           $poc->last_name = $request->last_name;         
           $poc->job_title = $request->job_title;         
           $poc->business = $request->business;         
           $poc->contact = $request->contact;         
           $poc->whatsapp = $request->whatsapp;         
           $poc->email = $request->email; 
           $poc->image = $image; 
           //   $poc->attach($company_id);
             // $poc->company_id = $request->company; 
            $poc->save();

      $poc->companies()->attach($request->company);
        Session::flash('flash_message','Company POC successfully Added.');
        return redirect('/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company_poc  $company_poc
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $poc = CompanyPoc::find($id);

         return view('poc.show',compact('poc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company_poc  $company_poc
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poc = CompanyPoc::find($id);

         return view('poc.edit',compact('poc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company_poc  $company_poc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyPoc $companypoc)
    {
         $request->validate([
        'first_name' => 'required|max:255',
        'last_name' => 'required',
        'job_title' => 'required',
        'business' => 'required',
        'contact' => 'required',
        'whatsapp' => 'required',
        'email' => 'required|email',
          ]); 
      

           $input = $request->except(['_token', '_method']);
           $companypoc->first_name = $request->first_name;
           $companypoc->last_name = $request->last_name;         
           $companypoc->job_title = $request->job_title;         
           $companypoc->business = $request->business;         
           $companypoc->contact = $request->contact;         
           $companypoc->whatsapp = $request->whatsapp;         
           $companypoc->email = $request->email; 
    
           if($request->hasFile('image')){
            $image =$request->image->store('images','public');     
          $companypoc->image = $image;  
           } 
           
       $companypoc->update($input);
            
             // $companypoc->company_id = $request->company; 
          
         Session::flash('flash_message','Company Poc  successfully updated.');
        return redirect('/index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company_poc  $company_poc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {      
      //$poc->companies()->attach($company);

        $companypoc=CompanyPoc::find($id);
        $companypoc->companies()->detach();
         $companypoc->destroy($id);
        Session::flash('flash_message_delete','Company POC successfully deleted.');

        return redirect()->route('index');
    }
}
