<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Core\AccessRightsAuth;
use DB;
use Illuminate\Support\Str;

class Categories extends AccessRightsAuth
{
    public $primary_id = 0;
    private $controllerName = "Services";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('categories.primary');
    }
    public function subCategory() {
        $main =     DB::table('main_services')->get();
        return view('categories.sub',compact('main'));
    }
    public function storeSubCat(Request $request)
    {
        if(DB::table('secondary_services')->where('secondary_services.primary_service_id',$request->primary_service_id)->where('secondary_services.service_name',$request->service_name)->first()){
        return response()->json([
             'msg'   => 'duplicate',
             'status'=>  'error',
        ]);
        }else{
            if($request->hasFile('service_icon')){
                $service_icon =  $request->service_icon->store('categories', 'public');
             }else{
                     return response()->json([
                         'msg'       =>  'Image should not be empty',
                         'status'    =>  'image_failed'
                     ]);
                 }
            $secondary_id        = DB::table('secondary_services')->insertGetId([
                                    'service_name'       => $request->service_name,
                                    'primary_service_id' => $request->primary_service_id,
                                    'publish'            => $request->publish_service,
                                    'service_icon'       => $service_icon,
                                    ]);
            // if ($secondary_id) {
            //     if ($request->publish_service == 1) {
            //         $page_id    = DB::table('pagebuilder__pages')
            //             ->insertGetId([
            //                 'name'        =>    $request->service_name,
            //                 'layout'      =>    'master',
            //                 'page_status' =>      1,
            //                 'page_type'   =>      2,
            //                 'primary_service_id' => $request->primary_service_id,
            //                 'secondary_service_id' => $secondary_id,
            //             ]);
            //         DB::table('pagebuilder__page_translations')
            //             ->insertGetId([
            //                 'title'         => 'KHANLLP - ' . $request->service_name,
            //                 'page_id'       => $page_id,
            //                 'locale'        => 'en',
            //                 'route'         => '/' . Str::slug( Str::slug($request->service_name)),
            //             ]);
            //     }

            // }
            return response()->json([
                'msg'   => 'Sub Catefory Added',
                'status'=>  'success',
                ]);
        }
    } 
    public function updateSubCat(Request $request, $id)
    {
        $id =   trim($id);
            $query   =  DB::table('secondary_services')->where('secondary_services.primary_service_id',$request->primary_service_id)
                                  ->where('secondary_services.service_name',$request->service_name)
                                  ->where('secondary_services.id','!=',$id)->first();
            if($query){
                    return response()->json([
                    'msg'   => 'duplicate',
                    'status'=>  'duplicate',
                    ]);
            }else{
                if($request->hasFile('service_icon')){
                    $service_icon =  $request->service_icon->store('categories', 'public');
                 }else{
                     if($request->hidden_service_icon == ''){
                         return response()->json([
                             'msg'       =>  'Image should not be empty',
                             'status'    =>  'image_failed'
                         ]);
                     }else{
                         $service_icon =  $request->hidden_service_icon;
                     }
                 }
                        DB::table('secondary_services')->where('id', $id)->update([
                                            'service_name'       => $request->service_name,
                                            'primary_service_id' => $request->primary_service_id,
                                            'publish'            => $request->publish_service,
                                            'service_icon'       => $service_icon,
                                        ]);
                                        return response()->json([
                                            'msg'   => 'Updated',
                                            'status'=>  'success',
                                            ]);
            }
    }
    public function listSubCategories()
    {
        $data =  DB::table('secondary_services')
                ->leftjoin('main_services', 'main_services.id', '=', 'secondary_services.primary_service_id')
                ->select('secondary_services.*', 'main_services.service_name as main_category')->get();

        return response()->json([
            'msg'       =>  'Sub Cat Fetched',
            'status'    =>  'success',
            'data'      =>   $data
        ]);
    }
    public function getSubCatToUpdate($id)
    {
        $query    =  DB::table('secondary_services')->where('secondary_services.id', $id)
                        ->leftjoin('main_services', 'main_services.id', '=', 'secondary_services.primary_service_id')
                        ->select(
                            'secondary_services.*',
                            'main_services.service_name as main_category',
                        )->first();
                        return response()->json([
                            'msg'       =>  'Sub Cat Fetched for update',
                            'status'    =>  'success',
                            'sub_cat'     =>   $query
                        ]);
    }
    public function getMainCategories()
    {
        $maincat = DB::table('main_services')->get();
        return response()->json([
          'maincat'   =>  $maincat,
        ]);
        // echo json_encode(DB::table('main_services')->get());
    }
    public function store(Request $request)
    {
        // dd($request->service_icon);
        if(DB::table('main_services')->where('main_services.service_name',$request->service_name)->first()){
            return response()->json([
                 'msg'   => 'duplicate',
                 'status'=>  'duplicate',
            ]);
        }else{
            if($request->hasFile('service_icon')){
                $service_icon =  $request->service_icon->store('categories', 'public');
             }else{
                     return response()->json([
                         'msg'       =>  'Image should not be empty',
                         'status'    =>  'image_failed'
                     ]);
                 }
           DB::table('main_services')->insertGetId([
                'service_name' => $request->service_name,
                'publish'      => $request->publish_service,
                'service_icon' => $service_icon,
            ]);
            return response()->json([
                'msg'   => 'Added',
                'status'=>  'success',
            ]);
        }
    } 
    public function update(Request $request,$id)
    {
        $query  =   DB::table('main_services')->where('main_services.service_name',$request->service_name)
                         ->where('main_services.id','!=',$id)->first();
        if($query){
            return response()->json([
                 'msg'   => 'duplicate',
                 'status'=>  'duplicate',
            ]);
        }else{   
            // dd($request->all());
            if($request->hasFile('service_icon')){
               $service_icon =  $request->service_icon->store('categories', 'public');
            }else{
                if($request->hidden_service_icon == ''){
                    return response()->json([
                        'msg'       =>  'Image should not be empty',
                        'status'    =>  'image_failed'
                    ]);
                }else{
                    $service_icon =  $request->hidden_service_icon;
                }
            }
                DB::table('main_services')->where('main_services.id', $id)->update([
                                    'service_name'  => $request->service_name,
                                    'publish'       => $request->publish_service,
                                    'service_icon'  => $service_icon,
                                    ]);
        
            return response()->json([
                'msg'   => 'Added',
                'status'=>  'success',
           ]);
        }
    }
    public function show($id)
    {   $get_category   =   DB::table('main_services')->where('id', $id)->first();
       return response()->json([
            'msg'       =>  'Fetched',
            'status'    =>  'success',
            'category'  =>  $get_category,
       ]);
    }
    public function destroy($id)
    {
        if (DB::table('main_services')->where('id', $id)->delete()) {
            DB::table('secondary_services')->where('primary_service_id', $id)->delete();
           return response()->json([
                'msg'       =>  'Deleted',
                'status'    =>  'success'
           ]);
        }
       return response()->json([
        'msg'       =>  'failed',
        'status'    =>  'failed'
       ]);
    }
    public function delSubCat($id)
    {
        if (DB::table('secondary_services')->where('id', $id)->delete()) {
           return response()->json([
                'msg'       =>  'Deleted',
                'status'    =>  'success'
           ]);
        }
       return response()->json([
        'msg'       =>  'failed',
        'status'    =>  'failed'
       ]);
    }
    public function GetPrimaryServices()
    {
        $primary_services       =    DB::table('main_services')->get();

        return $primary_services;
    }
    public function GetSecondaryServicesAgainstPrimary($id)
    {
        $secondary_services     =  DB::Select("SELECT * From secondary_services Where primary_service_id = $id ");
        return $secondary_services;
    }
}
