<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Campaign;
use App\Models\CampaignCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use Validator;

class CampaignController extends Controller
{
    public function index()
    {  
        return view('campaigns.list');
    }
    public function create()
    {
        $courses         =      Course::join('course_batch', 'course_batch.course_id', '=', 'course.id')
                                        ->whereRaw('course_batch.id NOT IN (SELECT batch_id FROM campaign_courses WHERE status = 1)')
                                        ->where('course_batch.status','!=','0')
                                        ->select('course.*','course_batch.batch_code','course_batch.id as batch_id')->get();
            return view('campaigns.create', compact('courses'));
    }
    public function getCourse($id)
    {
        $courses         =      Course::join('course_batch', 'course_batch.course_id', '=', 'course.id')
                                         ->whereRaw('course_batch.id NOT IN (SELECT batch_id FROM campaign_courses WHERE status = 1 AND campaign_id != '.$id.')')
                                        // ->leftjoin('campaign_courses','course_batch.id','=','campaign_courses.batch_id')
                                        ->select('course.*','course_batch.batch_code','course_batch.id as batch_id')->get();
        $campaign_courses   =   CampaignCourses::all();
     
           return response()->json([
                'status'  => 'success',
                'msg'     => 'Courses Fetched',
                'courses' =>    $courses,
                'campaign_courses'  => $campaign_courses
            ]);
    }
    public function store(Request $request)
    {
            $request->validate([
              
            ]);
            
        $validator = Validator::make($request->all(),[
            'start_date' => 'after:yesterday'
        ]);
        if($validator->fails()){
            return response()->json([ 
                'msg'     =>  'date_error',
                'status'  =>   'date_error'
            ]);
        }
        
        if($request->hidden_campaign_id){
            $campaign                 =   Campaign::where('id',$request->hidden_campaign_id)->first();
        }else{
            $campaign                 =   new Campaign();
        }
        $campaign->campaign_type      =   $request->campaign_type;
        $campaign->discount_type      =   $request->discount_type;
        $campaign->campaign_discount  =   $request->campaign_discount;
        $campaign->campaign_title     =   $request->campaign_title;
        $campaign->label_title        =   $request->label_title;
        $campaign->start_date         =   $request->start_date;
        $campaign->end_date           =   $request->end_date;
        $campaign->created_by         =   Auth::user()->id;
        if ($campaign->save()) {
            // dd($request->discount_on_batches);
            
            foreach ($request->discount_on_batches as $batch_id) {
                
                if($batch_id['campaign_id'] > 0){
                    $campaign_course              =    CampaignCourses::where('id',$batch_id['campaign_id'])->first();
                }else{
                     $campaign_course             =    new CampaignCourses();
                }
                $campaign_course->campaign_id     =    $campaign->id;
                $campaign_course->batch_id        =    $batch_id['batch_id'];
                $campaign_course->course_id       =    $batch_id['course_id'];
                // $campaign_course->course_id       =    $request->course_id;
                $campaign_course->created_by      =   Auth::user()->id;
                $campaign_course->save();
                $course_campaign_ids[]  = $campaign_course->id;
            }
            // dd($course_campaign_ids);
            
            CampaignCourses::where('campaign_id',$request->hidden_campaign_id)
                            ->whereNotIn('campaign_courses.id',$course_campaign_ids)->delete();

            return response()->json([
                'msg'     =>  'Campaigns Added',
                'status'  =>   'success'
            ]);
        } else {
            return response()->json([
                'msg'     =>  'failed',
                'status'  =>   'failed'
            ]);
        }
    }
    public function list(){
        $campaigns             =   Campaign::all();
        $campaign_courses      =   CampaignCourses::join('course','course.id','=','campaign_courses.course_id')
                                            ->join('course_batch','course_batch.id','=','campaign_courses.batch_id')
                                            ->join('sale_campaigns','sale_campaigns.id','=','campaign_courses.campaign_id')
                                            ->select('campaign_courses.*','course.course_code','course_batch.batch_code','sale_campaigns.campaign_title','sale_campaigns.id as campaign_id')
                                            ->get();
        // $campaigns      =   collect($campaigns)->map(function($x) use($campaign_courses) {
        //                   $x->campaign_courses  =     collect($campaign_courses)->where('campaign_id',$x->id);
        //                   return $x;
        // });
        return response()->json([
            'msg'       =>    'All Campaings Fetched',
            'status'    =>    'success',
            'campaigns' =>    $campaigns,
            'campaign_courses'=> $campaign_courses
        ]);
    }
    public function edit($id)
    {
        $campaign              =   Campaign::where('id',$id)->first();
        $campaign_courses      =   CampaignCourses::where('campaign_id',$id)
                                            ->join('course','course.id','=','campaign_courses.course_id')
                                            ->join('course_batch','course_batch.id','=','campaign_courses.batch_id')
                                            ->join('sale_campaigns','sale_campaigns.id','=','campaign_courses.campaign_id')
                                            ->select('campaign_courses.*','course.course_code','course_batch.batch_code','sale_campaigns.campaign_title','sale_campaigns.id as campaign_id')
                                           ->get();

                                        //    dd($campaign_courses);
        // $campaign      =   collect($campaign)->map(function($x) use($campaign_courses) {
         
        //                   $x->campaign_courses  =     collect($campaign_courses)->where('campaign_id',$x);
        //                   return $x;
        // });
        return view('campaigns.edit',compact('campaign','campaign_courses'));
    }
    public function getCampaignCourses($id)
    {
        $campaign_courses      =   CampaignCourses::where('campaign_id',$id)
                                            ->join('course','course.id','=','campaign_courses.course_id')
                                            ->join('course_batch','course_batch.id','=','campaign_courses.batch_id')
                                            ->select('campaign_courses.*','course.id as course_id','course_batch.id as batch_id')
                                           ->get();

                              
                    return response()->json([
                    'msg'               =>  'Campaigns Courses Fetched',
                    'campaign_courses'  =>   $campaign_courses,
                ]);
    }
    public function delete($id) 
    {
        $campaign = Campaign::find($id);
        $campaign->delete();
        // if you need to restore the deleted user
        // User::withTrashed()->find($id);->restore();
        return response()->json([
            'msg'       =>  'Campaign deleted',
            'status'    =>  'success'
        ]);
    }
    public function campaignStatusChange(Request $request){
         Campaign::where('id',$request->id)->update([
            'status'   =>  $request->campaign_status,
        ]);
        CampaignCourses::where('campaign_id',$request->id)->update([
            'status'   =>  $request->campaign_status,
        ]);
        return response()->JSON([
            'status'    =>   'success',
            'msg'       =>   'status_change'
        ]);
    }

  
}
