<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\CourseAtribute;
use App\Models\CourseTag;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Auth;
use CKSource\CKFinder\Command\DeleteFiles;
use DateTime;
use Illuminate\Support\Facades\Storage;
use str;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class CourseController extends Controller
{
    public function index()
    {
        return view('course.add-course');
    }
    public function store(Request $request)
    {
      
    //   if($request->course_duration != null){
    //         $hours            =   $request->course_duration;
    //         $zero             =   new DateTime('@0');
    //         $offset           =   new DateTime('@' . $hours * 3600);
    //         $diff             =   $zero->diff($offset);
    //         $course_duration  =   $diff->format('%m Months, %d Days, %h Hours');
    //     }else{
    //         $course_duration  =   0;
    //     }
        if($request->gradutation_switch_btn){
            $gradutaion_btn    =  $request->gradutation_switch_btn; 
        }else{
            $gradutaion_btn    =  0; 
        }
        if($request->hidden_course_id != ''){
            CourseTag::where('course_id',$request->hidden_course_id)->delete();
            CourseAtribute::where('course_id',$request->hidden_course_id)->delete();
            $course     =   Course::where('id',$request->hidden_course_id)->first();
        }else{
            $course     =   new Course();
        }
    
        $course->main_category_id            =   $request->main_category_id;
        $course->sub_category_id             =   $request->sub_category_id;
        $course->course_methodology          =   $request->course_methodology;
        $course->course_type                 =   $request->course_type;
        $course->course_code                 =   $request->course_code;
        $course->course_level                =   $request->course_level;
        $course->course_pricing_model        =   $request->course_pricing_model;
        if($request->course_pricing_model == 1){
            $course->course_price            =   $request->course_price;
        }else{
            $course->course_price            =   0;
        }
        $course->course_subscription_method  =   $request->course_subscription_method;
        $course->course_duration             =   $request->course_duration;
        // $course->course_duration_in_hours    =   $request->course_duration;
        $course->course_incubator            =   $request->course_incubator;
        $course->course_title                =   $request->course_title;
        $course->short_description           =   $request->short_description;
        $course->long_description            =   $request->long_description;
        //Graduation Ceriteria
        $course->minimum_quiz_score          =   $request->minimum_quiz_score;
        $course->minimum_assignment_score    =   $request->minimum_assignment_score;
        $course->minimum_participation_score =   $request->minimum_participation_score;
        $course->minimum_attendnace          =   $request->minimum_attendnace;
        $course->quiz_weightage              =   $request->quiz_weightage;
        $course->assignment_weightage        =   $request->assignment_weightage;
        $course->attendance_weightage        =   $request->attendance_weightage;
        $course->participation_weightage     =   $request->participation_weightage;
        $course->total_weightage             =   $request->total_weightage;
        $course->seo_description             =   $request->seo_description;

        $course->youtube_link                =   $request->youtube_link;
        $course->age_restriction             =   3;
        if($request->hidden_course_id != ''){
            $course->status                      =   $request->hidden_course_status;
        }else{
            $course->status                      =   1;
        }
        $course->gradutation_switch_btn      =  $gradutaion_btn;
        if ($request->quiz_weightage){
            $course->quiz_check              =   1; //yes
        } else {
            $course->quiz_check              =   2; //No
        }
        if ($request->assignment_weightage){
            $course->assignment_check        =   1; //yes
        } else {
            $course->assignment_check        =   2; //No
        }
        if ($request->hasFile('course_thumbnail')){
            $course->course_thumbnail  =   $request->course_thumbnail->store('course', 'public');
        
         } else {
            $course->course_thumbnail  =    $request->hidden_course_thumbnail;
            if ($request->hidden_course_thumbnail == '') {
                     return response()->json([
                        'status'    =>  'error',
                        'msg'       =>  "Image Should Not be Empty",
                     ]);
            }
         }
         if ($request->hasFile('meta_property_image')) {
            $course->meta_property_image  =   $request->meta_property_image->store('seo', 'public');
         }  
        if ($request->hasFile('course_desktop_cover_image')) {
            $course->course_desktop_cover_image  =   $request->course_desktop_cover_image->store('course', 'public');
         } else {
            $course->course_desktop_cover_image  =    $request->hidden_course_desktop_cover_image;
            if ($request->hidden_course_desktop_cover_image == '') {
                     return response()->json([
                        'status'    =>  'error',
                        'msg'       =>  "Image Should Not be Empty",
                     ]);
            }
         }
         if ($request->hasFile('course_tablet_cover_image')) {
            $course->course_tablet_cover_image  =   $request->course_tablet_cover_image->store('course', 'public');
         } else {
            $course->course_tablet_cover_image  =    $request->hidden_course_tablet_cover_image;
            if ($request->hidden_course_tablet_cover_image == '') {
                     return response()->json([
                        'status'    =>  'error',
                        'msg'       =>  "Image Should Not be Empty",
                     ]);
            }
         }
         if ($request->hasFile('course_mobile_cover_image')) {
            $course->course_mobile_cover_image  =   $request->course_mobile_cover_image->store('course', 'public');
         } else {
            $course->course_mobile_cover_image  =    $request->hidden_course_mobile_cover_image;
            if ($request->hidden_course_mobile_cover_image == '') {
                     return response()->json([
                        'status'    =>  'error',
                        'msg'       =>  "Image Should Not be Empty",
                     ]);
            }
         }
         $course->save();
        if ($request->multiple_tags){
            foreach ($request->multiple_tags as $tag) {
                CourseTag::create([
                    'tag_name'   =>     $tag['tag'],
                    'course_id'  =>     $course->id,
                    'created_by' =>     Auth::user()->id,
                    'updated_by' =>     Auth::user()->id,
                ]);
            }
        }
        if ($request->multiple_attribute) {
            foreach ($request->multiple_attribute as $attribute) {
                CourseAtribute::create([
                    'attribute_id'         =>     $attribute['attribute_id'],
                    'attribute_value_id'   =>     $attribute['attribute_value_id'],
                    'course_id'            =>     $course->id,
                    'created_by'           =>     Auth::user()->id,
                    'updated_by'           =>     Auth::user()->id,
                ]);
            }
        }
       $course_id  = $course->id;
        if($course_id > 0){
            return response()->json([
                'msg'        =>  'course has been Added',
                'status'     =>  'success'
            ]);
        }
    }
    public function getData()
    {
        $attribute         =   Attribute::all();
        $attribute_values  =   AttributeValue::all();
        $main_category     =   MainCategory::all();
        $sub_category      =   SubCategory::all();
        return response()->json([
            'attribute'         =>  $attribute,
            'main_category'     =>  $main_category,
            'sub_category'      =>  $sub_category,
            'attribute_values'  =>  $attribute_values,
        ]);
    }
    public function getAttributeValue($id)
    {
        $attribute  =   AttributeValue::where('attribute_id', $id)->get();
        return response()->json([
            'msg'        =>  'Attribute Value Fetched',
            'status'     =>  'success',
            'attribute'  =>   $attribute
        ]);
    }
    public function courseList(Course $course)
    {
        $course_list    =   Course::all();
        return response()->json([
            'client'    =>  $course_list
        ]);
        // echo json_encode(array('client' => $course_list));
    }
    public function show()
    {
        return view('course.list');
    }
    public function edit($id)
    {   
        // $tag       = collect();
        // $attribute = collect();
    $course            =   Course::where('course.id',$id)
                            ->leftjoin('main_services','main_services.id','=','course.main_category_id')
                            ->leftjoin('secondary_services','secondary_services.id','=','course.sub_category_id')
                            ->select('course.*','main_services.service_name as main_category','secondary_services.service_name as sub_category' )
                            ->first();
    $seo_description             =  json_decode($course->seo_description,true);
    $course_attribute   =   CourseAtribute::where('course_id',$id)
                                            ->leftjoin('attributes','attributes.id','=','course_attribute.attribute_id')
                                            ->leftjoin('attribute_value','attribute_value.id','=','course_attribute.attribute_value_id')
                                            ->select('course_attribute.*','attributes.name as attibure_name','attribute_value as attribute_value' )
                                            ->get();
    $course_tags        =   CourseTag::where('course_id',$id)->get();
    
        // $courses =   collect($courses)->map(function ($x) use ($course_attribute, $course_tags) {
        //                         $x->attribute    =   collect($course_attribute)->where('course_id', $x->id);                               
        //                         $x->tags         =   collect($course_tags)->where('course_id', $x->id);                               
        //                      return $x;
        //                         });
                                // dd(json_decode($courses->seo_description,true));
        // foreach($course_tags as $tags){
        //         $tag->push([
        //             'tag' => $tags->tag_name,
        //         ]);
        //       }  
        
            
        return view('course.edit-course',compact('course','course_tags','course_attribute','seo_description'));
    }

    public function getAttributeAndTags($id){
        $course_tags        =   CourseTag::where('course_id',$id)->get();
        $course_attribute   =   CourseAtribute::where('course_id',$id)
                                ->leftjoin('attributes','attributes.id','=','course_attribute.attribute_id')
                                ->leftjoin('attribute_value','attribute_value.id','=','course_attribute.attribute_value_id')
                                ->select('course_attribute.*','attributes.name as attibure_name','attribute_value as attribute_value' )
                                ->get();
                    return response()->json([
                        'msg'               =>   'Attributes fetched',
                        'status'            =>   'success',
                        'course_attribute'  =>   $course_attribute,
                        'course_tags'       =>  $course_tags,
                    ]);
    }
    public function updateCourseStatus(Request $request){
        Course::where('id',$request->course_id)->update([
            'status'   =>   $request->updated_status
        ]);
        return response()->json([
            'msg'       =>  'Status Updated',
            'status'    =>  'success'
        ]);
    }
}
