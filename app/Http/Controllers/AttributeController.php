<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Auth;
use DB;
class AttributeController extends Controller
{
    public function index() {
        return view('course.attribute');
    }
    Public function get_attribute($id){
        $attribute  =   Attribute::where('id',$id)->first();
        return response()->json([
            'msg'        =>  'Attribute Fetched',
            'status'     =>  'success',
            'attribute'  =>   $attribute
        ]);
    }

    Public function get_AttributeValue($id){
        $attribute  =   AttributeValue::where('id',$id)->first();
        return response()->json([
            'msg'        =>  'Attribute Value Fetched',
            'status'     =>  'success',
            'attribute'  =>   $attribute
        ]);
    }
    public function getAllAttributes(){
       
        $attributes                      =   Attribute::all();
        $attribute_value                 =   AttributeValue::leftjoin('attributes','attributes.id','=','attribute_value.attribute_id')
                                                            ->select('attribute_value.*','attributes.name as attribute_name')
                                                            ->get();
        
        // $states                       =   DB::SELECT("SELECT states.id as state_id,states.name,states.country_id,attributes.id as country_id,attributes.name as country_name FROM `states` inner join attributes on attributes.id=states.country_id");
        $total_attributes                =   $attributes->count();
        $total_attribute_value           =   $attribute_value->count(); 
        $result                          =   [];
        $result['attributes']            =   $attributes;
        $result['total_attributes']      =   $total_attributes;
        $result['attribute_value']       =   $attribute_value;
        $result['total_attribute_value'] =   $total_attribute_value;
        return $result;
    }
    //Save Attribute
   public function save_attribute(Request $request){
    // dd($request->all());
        ///Query for Attribute
        if($request->operation == 'add_attribute'){
            $check = Attribute::whereRaw('name = "'.$request->attribute_name.'"')->first();
                if($check){
                   return response()->json([
                    'msg'       =>  'already_exist',
                    'status'    =>  'failed'
                ]);
                }else{
                    $insert = Attribute::insertGetId([
                      'name'             => $request->attribute_name,
                      'created_by'       =>    Auth::user()->id,
                      'updated_by'       =>    Auth::user()->id,
                    ]);
                    $get_lastinserted_data  =   Attribute::where('id',$insert)->first();
                    if($insert){
                       return response()->json([
                        'msg'           =>  'Attibute Added',
                        'status'        =>  'success',
                        // 'attribute_id'  =>  $insert
                        'data'          => $get_lastinserted_data
                    ]);
                    }else{
                       return response()->json([
                        'msg'       =>  'Not Added',
                        'status'    =>  'failed'
                    ]);
                    }
                }
        }elseif($request->operation == 'update_attribute'){
            if(Attribute::whereRaw('name = "'.$request->attribute_name.'" AND id Not IN ('.$request->hidden_attribute_id.')')->first()){
                return response()->json([
                    'msg'       =>  'already_exist',
                    'status'    =>  'failed'
                ]); 
            }else{
                Attribute::where('id', $request->hidden_attribute_id)->update([
                    'name'       => $request->attribute_name,
                    'updated_by' => Auth::user()->id
                    ]);
                return response()->json([
                    'msg'       =>  'Attribute Updated',
                    'status'    =>  'success'
                ]);
            }
        } elseif($request->operation_state == 'add_attribute_value'){
            $check = AttributeValue::whereRaw('attribute_value = "'.$request->attribute_value.'" And attribute_id = "'.$request->attribute_id.'"')->first();
                if($check){
                    return response()->json([
                        'msg'       =>  'already_exist',
                        'status'    =>  'failed'
                    ]); 
                }else{
                    $insert = AttributeValue::insertGetId([
                        'attribute_value'   => $request->attribute_value,
                        'attribute_id'      => $request->attribute_id,
                        'created_by'        => Auth::user()->id
                    ]);
                  
                    if($insert){
                        $get_last_inserted_val  =   AttributeValue::where('id',$insert)->first();
                        return response()->json([
                            'msg'       =>  'Attribute Value Addded ',
                            'status'    =>  'success',
                            'value'     =>  $get_last_inserted_val,
                        ]); 
                    }else{
                        return response()->json([
                            'msg'       =>  'Value not be Added.',
                            'status'    =>  'failed'
                        ]); 
                    }
                }
        }elseif($request->operation_state == 'update_attribute_value'){
            if(AttributeValue::whereRaw('attribute_value = "'.$request->attribute_value.'" And attribute_id = "'.$request->attribute_id.'"  AND id Not IN ('.$request->hidden_attributevalue_id.')')->first()){
                return response()->json([
                    'msg'       =>  'already_exist',
                    'status'    =>  'failed'
                ]); 
            }else{
                 AttributeValue::where('id', $request->hidden_attributevalue_id)->update([
                                        'attribute_id'          => $request->attribute_id,
                                        'attribute_value'       => $request->attribute_value,
                                        'updated_by'            => Auth::user()->id
                                        ]);
                return response()->json([
                    'msg'       =>  'Updated',
                    'status'    =>  'success'
                ]); 
            }
        }else{
            return response()->json([
                'msg'       =>  'Error in Query Function',
                'status'    =>  'failed'
            ]); 
        }
    }
    public function deleteAttribute(Request $request){
        // dd($request->all());
        if($request->type == 'attribute'){
          
            $delete = Attribute::where('id', $request->id)->delete();
            AttributeValue::where('attribute_id',$request->id)->delete();
        }
        if($request->type == 'attribute_value'){
            $delete = AttributeValue::where('id', $request->id)->delete();
        }
        if($delete){
            return response()->json([
                'msg'       =>  'Deleted',
                'status'    =>  'success'
            ]);
        }else{
            return response()->json([
                'msg'       =>  'Not delete',
                'status'    =>  'failed'
            ]);
        }
    }
    // public function changeAttributeStatus(Request $request)
    // {
    //   $id       = $request->id; 
    //   $status   = $request->status;
    //   $change_status        =   Attribute::where('id', $id)->update(['default_status' => '1']);
    //   $change_status_all    =   Attribute::where('id', '!=', $id)->update(['default_status' => '0']);
    //                         return response()->JSON([
    //                             'msg'      =>  'Status Change',
    //                             'status_id'=>   $id
    //                         ]);
      
    // }


}
