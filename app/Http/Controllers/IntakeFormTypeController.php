<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\AccessRightsAuth;
use App\IntakeFormType;
use Illuminate\Http\Request;

class IntakeFormTypeController extends AccessRightsAuth
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $formtypes    =   IntakeFormType::all();
        return view('intake-form-types.index',compact('formtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('intake-form-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try{
            $isCount    =   IntakeFormType::where('name', 'like',$request->name)->count();
            if($isCount == 0) {
                IntakeFormType::insert([
                    'name'      => $request->name,
                    'document'  => $request->document,
                ]);
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Form type added successfully'
                ]);
            }else{
                return response()->json([
                    'status'    => 'error',
                    'msg'       =>  'Form Type name Already exists'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'msg'       =>  $e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $formtype    =   IntakeFormType::find($id);
        return view('intake-form-types.create',compact('formtype'));

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
        try{
            $isCount    =   IntakeFormType::where('id','!=',$id)->where('name', 'like',$request->name)->count();
            if($isCount == 0) {
                IntakeFormType::where('id',$id)
                                ->update([
                                    'name'      => $request->name,
                                    'document'  => $request->document,
                                ]);
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Form type updated successfully'
                ]);
            }else{
                return response()->json([
                    'status'    => 'error',
                    'msg'       =>  'Form Type name Already exists'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status'    => 'error',
                'msg'       =>  $e->getMessage()
            ]);
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
}
