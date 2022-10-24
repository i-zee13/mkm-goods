<?php

namespace App\Http\Controllers;

use App\Models\CourseLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseLessonController extends Controller
{
    public function index($id){   
        $course_id  =   $id;
        return view('course.lesson',compact('course_id'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
    //    dd($request->all());
        $request->validate([
            'course_id'        =>  'required',
            'title'            =>  'required',
            'sequence'         =>  'required',
        ]);
        if($request->hidden_lesson_id == '' || $request->hidden_lesson_id == null ){
            $lesson             =     new CourseLesson();
        }else{
            $lesson             =   CourseLesson::find($request->hidden_lesson_id);
        }
        $lesson->course_id      =   $request->course_id ;
        $lesson->title          =   $request->title;
        $lesson->description    =   $request->lesson_description;
        $lesson->sequence       =   $request->sequence;
        $lesson->created_by     =   Auth::user()->id;
        $lesson->updated_by     =   Auth::user()->id;
        $lesson->save();
        if($lesson->save()){
            return response()->json([
                'msg'       =>  'Lesson has been Added',
                'status'    =>  'success',
            ]);
        }else{
            return response()->json([
                'msg'       =>  'failed',
                'status'    =>  'failed'
            ]);
        }
    }
    public function edit($id)
    {
        $lesson     =   CourseLesson::where('id',$id)->first();
        return response()->json([
            'msg'       =>  'Lesson fetched for Edit',
            'status'    =>  'success',
            'lesson'    =>  $lesson
        ]);
    }

    public function lessonList($course_id){
         $lessons   =   CourseLesson::where('course_id',$course_id)->get();
         return  response()->json([
            'msg'       =>  'Lessons has Fetched',
            'status'    =>  'success',
            'lessons'   =>  $lessons
         ]);
    }

   
    public function destroy(Request $request)
    {
        $delete = CourseLesson::where('id',$request->id)->delete();
        if($delete){
            return response()->json([
                'msg'      =>  'deleted',
                'status'   =>   'success'
            ]);
        }
        else{
            return response()->json([
                'msg'      =>  'NOt Deleted',
                'status'   =>   'failed'
            ]);
        }
        
        //
    }
}
