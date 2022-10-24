<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Company;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $company=Company::all();
      
        return view("company.company",compact('company'));
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
      $data= $request->validate([
        'name' => 'required|max:255',
        'contact' => 'required',
        'address' => 'required',
        'email' => 'required|email',
         ]); 

      Company::create($data);

     
  Session::flash('flash_message','Company successfully Add.');
        return redirect('/company');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
       $company = Company::find($id);

         return view('company.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $company = Company::find($id);

         return view('company.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Company $company)
    {

       $request->validate([
        'name' => 'required|max:255',
        'contact' => 'required',
        'address' => 'required',
        'email' => 'required|email',
         ]); 

        $input = $request->except(['_token', '_method']);
         //  $company->$request->all();
            $company->name = $request->name;        
           $company->contact = $request->contact;         
           $company->address = $request->address;         
           $company->email = $request->email; 
           $company->update($input);

  Session::flash('flash_message','Company successfully Updated.');
        return redirect()->route('company');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 

         Company::destroy($id);
        Session::flash('flash_message_delete','Company successfully deleted.');

        return redirect()->route('company');
                       
    }
}
