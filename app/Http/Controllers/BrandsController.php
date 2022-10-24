<?php

namespace App\Http\Controllers;

use App\Brands;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function index(){
        return view('brands.index');
    }
    public function getAllBrands(){
        $brands = Brands::all();
        return $brands;
    }
    public function getBrand($id){
        $brand = Brands::find($id);
        return $brand;
    }
    public function addBrand(){
      $data= request()->validate([
        'name'=>'required',
        'description'=>'required'
    ]);
 //    $getClientOriginalName = request()->file('image')->getClientOriginalName();
 //    $getClientOriginalName = explode('.', $getClientOriginalName);
 //    $filename = $getClientOriginalName[0].'_'.rand().time().'.'.last($getClientOriginalName);

 //    request()->image->move('storage/participants/', $filename);
 //    dd('here');
 //    Storage::put('public/participants/'.$filename, request()->file('image'));
    
    $path = request()->file('image') ? request()->file('image')->store('brands','public') : '';
 //    $newPath = str_replace('public/participants/','',$path);
    $brand["brand_name"] =    $data['name'];
    $brand["brand_custom_id"] = request()->brand_id;
    $brand["description"] =  $data['description'];
    $brand["thumbnail"] = $path;
    $obj = new Brands($brand);
    if($obj->save()){
        echo "success";
    }else{
        echo "error";
    }
    
    }
    public function update($id){
        
        $brand = Brands::find($id);
        $name = request()->name;
        $description = request()->description;
        $brand->brand_name = $name;
        $brand->description = $description;
        $brand->brand_custom_id = request()->brand_custom_id ? request()->brand_custom_id : null;
        // $brand->updated_at = date('Y-m-d H-i-s');
        if(request()->file()){
            $brand->thumbnail = request()->file('image')->store('brands','public');
        }
       if($brand->save()){
           return "updated";
       }
       else{
           return "something went wrong";
       }
    }
    public function delete($id){
        $obj = Brands::find($id);
        if($obj->delete()){
            return "deleted";
        }
        else{
            return "something went wrong";
        }
    }
    public function getBrandToUpdate($id){
            $brand = Brands::find($id);
            return $brand;
    }
}
