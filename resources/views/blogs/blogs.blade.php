@extends('layouts.master')
@section('content')
<div class="row mt-2 mb-3">
  <div class="col-lg-6 col-md-6 col-sm-6">
    <h2 class="_head01">Blog <span> Management</span></h2>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
    <ol class="breadcrumb">
      <li><a href="#"><span>Add </span></a></li>
      <li><span>Blog </span></li>
    </ol>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="header">
          <a href="{{ route('add-blog') }}" class="btn add_button"><i class="fa fa-plus"></i>
            <span>Add Blog</span>
          </a>
          <h2>Blogs <span>List</span></h2>
      </div>
      <div style="min-height: 400px" class="loader">
        <img src="{{asset('images/loader.gif')}}" width="30px" height="auto"
            style="position: absolute; left: 50%; top: 45%;">
      </div>
      <div class="body all_blogs">
          
      </div>
    </div>
  </div>
</div>
@endsection
 
