<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Auth;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $primary_services   =   MainCategory::where('publish','1')->get();
        return view('faqs.faqs',compact('primary_services'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_faqs_list(Request $request)
    {
        $all_faqs       =   Faqs::all();
        return response()->JSON([
            'status'    =>      'success',
            'all_faqs'  =>      $all_faqs,
        ]);
    }
    public function secondary_services($id){
        $secondary_services    =   SubCategory::where('primary_service_id',$id)
                                   ->where('publish','1')
                                   ->get();
        return response()->JSON([
            'status'           =>      'success',
            'sec_services'     =>       $secondary_services,
        ]);
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save_faqs(Request $request)
    {
        $validate = $this->validate($request, [
            'faq_type'            =>  'required',
            'faq_question'        =>  'required',
            // 'faq_answer'          =>  'required',
        ]);
        if($request->hidden_faq_id !=''){
            $save_faq                 =   Faqs::find($request->hidden_faq_id);
        }else{
            $save_faq                 =   new Faqs();
        }
        $save_faq->faq_type                 =   $request->faq_type;
        $save_faq->primary_service_id       =   $request->primary_service_id;
        $save_faq->secondary_service_id     =   $request->secondary_service_id;
        $save_faq->sub_service_id           =   $request->sub_secondary_service_id;
        $save_faq->question                 =   $request->faq_question;
        $save_faq->answer                   =   $request->faq_details;
        if($request->hidden_faq_id !=''){
        $save_faq->updated_by               =   Auth::user()->id;
        }else{
        $save_faq->created_by               =   Auth::user()->id;
        }
        $save_faq->save();
        return response()->JSON([
            'status'              =>  'success',
            'msg'                 =>  'faq_added'
        ]);
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
        $edit_faqs              =   Faqs::where('id',$id)->first();
        return response()->JSON([
            'status'            =>   'success',
            'faqs_result'       =>    $edit_faqs
        ]);
    }
    public function faq_status_change(Request $request){
        $status_faqs            =   Faqs::where('id',$request->id)->update([
            'status'            =>  $request->faq_status,
        ]);
        return response()->JSON([
            'status'            =>   'success',
            'msg'               =>   'status_change'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_faq(Request $request)
    {
        $delete_faq         =   Faqs::where('id',$request->id)->delete();
        return response()->JSON([
                'status'    =>   'success',
                'msg'       =>   'faq_deleted'
        ]);
    }
}
