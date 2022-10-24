<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use DB;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('blogs.blogs');
    }
    public function add_blog()
    {
        $primary_services   =   MainCategory::where('publish','1')->get();
        return view('blogs.add-blog',compact('primary_services'));
    }
    public function blog_slug($blog_title){
        $blog_slug      =   Str::slug($blog_title);
        return response()->JSON([
            'blog_slug' =>  $blog_slug
        ]);
    }
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'title'            =>  'required',
            'blog_date'        =>  'required',
        ]);
        if($request->blog_id != ''){
            $save_blog             =   Blogs::find($request->blog_id);
            if (Blogs::WHERE('title', $request->title)->WHERE('id', '!=', $request->blog_id)->first()) {
                return response()->JSON([
                                    'status'    =>      'error',
                                    'msg'       =>      'title_already_exists',
                ]);
            }
        }else{
            $save_blog             =   new Blogs();
            if (Blogs::WHERE('title', $request->title)->first()) {
                return response()->JSON([
                                    'status'    =>      'error',
                                    'msg'       =>      'title_already_exists',
                ]);
            }
        }
        $save_blog->title      =   $request->title;
        $save_blog->page_slug  =   $request->page_slug;
        $save_blog->slug       =   $request->slug;
        $save_blog->tags       =   $request->tags;
        $save_blog->blog_date  =   $request->blog_date;
        if ($request->hasFile('blog_image')) {
            $blog_image        =   $request->blog_image->store('blog-images', 'public');
        }else{
            $blog_image        =   $request->hidden_image;
            if ($request->hidden_image == '') {
                return response()->json([
                    'status'   =>  'blog_image_error',
                    'msg'      =>  'blog_image_required'
                ]);
            }
        }
        // Cover image
        if ($request->hasFile('cover_image')) {
            $cover_image        =   $request->cover_image->store('blog-images', 'public');
        }else{
            $cover_image        =   $request->hidden_cover_image;
            if ($request->hidden_cover_image == '') {
                return response()->json([
                    'status'    =>  'cover_image_error',
                    'msg'       =>  'cover_image_required'
                ]);
            }
        }
           // Tabelt cover image
           if ($request->hasFile('tablet_cover_image')) {
            $tablet_cover_image        =   $request->tablet_cover_image->store('blog-images', 'public');
        }else{
            $tablet_cover_image        =   $request->hidden_tablet_cover_image;
            if ($request->hidden_cover_image == '') {
                return response()->json([
                    'status'    =>  'cover_image_error',
                    'msg'       =>  'cover_image_required'
                ]);
            }
        }
          // Mobile cover image
          if ($request->hasFile('mobile_cover_image')) {
            $mobile_cover_image        =   $request->mobile_cover_image->store('blog-images', 'public');
        }else{
            $mobile_cover_image        =   $request->hidden_mobile_cover_image;
            if ($request->hidden_cover_image == '') {
                return response()->json([
                    'status'    =>  'cover_image_error',
                    'msg'       =>  'cover_image_required'
                ]);
            }
        }
        $save_blog->image                   =   $blog_image;
        $save_blog->cover_image             =   $cover_image;
        $save_blog->tablet_cover_image      =   $tablet_cover_image;
        $save_blog->mobile_cover_image      =   $mobile_cover_image;
        $save_blog->blog_details            =   $request->blog_details;
        $save_blog->user_id                 =   Auth::user()->id;
        $save_blog->blog_type               =   $request->blog_type;
        $save_blog->primary_service_id      =   $request->primary_service_id;
        $save_blog->secondary_service_id    =   $request->secondary_service_id;
        $save_blog->sub_service_id          =   $request->sub_secondary_service_id;
        if($request->blog_id != ''){
        $save_blog->updated_by              =   Auth::user()->id;
        }else{
        $save_blog->created_by              =   Auth::user()->id;
        }
        $save_blog->save();
            return response()->json([
                'status'                    =>  'success',
                'msg'                       =>  'blog_added'
            ]);
    }
    public function all_blogs_list(Request $request)
    {
        // $all_blogs       =      Blogs::orderBy('id', 'DESC')
                                    // ->pluck('title','blog_date'->get();
        $all_blogs       =            DB::table('blogs')->select('id','title','blog_date','published')->orderBy('id', 'DESC')->get();
                                    
        return response()->JSON([
            'status'     =>     'success',
            'all_blogs'  =>     $all_blogs,
        ]);
    }
    public function blog_status_change(Request $request){
        $status_blog            =   Blogs::where('id',$request->id)->update([
            'published'         =>  $request->blog_status,
        ]);
        return response()->JSON([
            'status'            =>   'success',
            'msg'               =>   'status_change'
        ]);
    }
    public function delete_blog(Request $request)
    {
        $delete_blog        =   Blogs::where('id',$request->id)->delete();
        return response()->JSON([
                'status'    =>   'success',
                'msg'       =>   'blog_deleted'
        ]);
    }
   
    public function edit($id)
    {
        $primary_services          =   MainCategory::where('publish','1')->get();
        $blog_details              =   Blogs::where('id',$id)->first();
        return view('blogs.add-blog',compact(['blog_details','primary_services']));
    }
}
