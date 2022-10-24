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
    <input type="hidden" id="b_type"  value="{{@$blog_details->blog_type}}">
    <input type="hidden" id="p_service" value="{{@$blog_details->primary_service_id}}">
    <input type="hidden" id="s_service" value="{{@$blog_details->secondary_service_id}}">
    <input type="hidden" id="s_s_service" value="{{@$blog_details->sub_service_id}}">
    <form id="SaveBlogForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="blog_id" name="blog_id" value="{{@$blog_details->id}}">
        <input type="hidden" id="page_slug" name="page_slug" value="{{@$blog_details->page_slug}}">
        <div class="row">
            <div class="col-12 mb-30">
                <div class="card">
                    <div class="header">
                        <h2>Add <span>Blog Card</span></h2>
                    </div>
                    <div class="body">
                        <div id="floating-label">
                            <div class="form-wrap p-0">
                                <div class="row">
                                    <div class="col-md-8 PB-10">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Blog Title *</label>
                                            <input type="text" name="title" id="title" value="{{@$blog_details->title}}" class="form-control blog-required" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 PB-10">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Date *</label>
                                            <input type="text" id="datepicker" name="blog_date" value="{{@$blog_details->blog_date}}" class="form-control datepicker blog-required" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4 PB-10">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Blog Type *</label>
                                            <select class="form-control blog-required" name="blog_type" id="blog_type">
                                                <option selected value="0">Select  Type</option>
                                                <option value="1" {{@$blog_details->blog_type == 1 ? 'selected' : ''}}>General</option>
                                                <option value="2" {{@$blog_details->blog_type == 2 ? 'selected' : ''}}>Category Related</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 PB-10 services_row" id="services_row" style="display: none">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Select Main Category *</label>
                                            <select class="form-control services-info" name="primary_service_id" id="primary_service_id">
                                                <option selected value="0">Main Category</option>
                                                @foreach ($primary_services as $primary_service)
                                                    <option value="{{$primary_service->id}}" {{@$blog_details->primary_service_id == $primary_service->id ? 'selected' : ''}}>{{$primary_service->service_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 PB-10 services_row" id="services_row" style="display: none">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Select Sub Category</label>
                                            <select class="form-control" name="secondary_service_id" id="secondary_services">
                                                <!-- <option selected value="0">Sub Category</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4 PB-10 services_row" id="services_row" style="display: none">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Select Sub Secondary Serivce</label>
                                            <select class="form-control" name="sub_secondary_service_id" id="sub_secondary_services">
                                                <option selected value="0">Sub Secondary Services</option>
                                            </select>
                                        </div>
                                    </div> -->
                                </div>
                                  <div class="header">
                                    <h2>Add <span>Blog Images</span></h2>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-6">
                                        <div class="form-wrap p-0">
                                            <label class="font13 mb-5">Blog Thumbnail (650 x 400) *</label>
                                            <div class="upload-pic"></div>
                                            <input type="hidden" value="{{@$blog_details->image}}" name="hidden_image">
                                            <input type="file" id="input-file-now" name="blog_image" data-default-file="/storage/{{@$blog_details->image}}" class="dropify"
                                            data-min-width="649" data-max-width="651" data-min-height="399" data-max-height="401" data-old_input="hidden_image" accept="image/jpg, image/png, image/jpeg, image/JPEG" data-allowed-file-extensions="jpg png jpeg JPEG"/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-wrap p-0">
                                            <label class="font13 mb-5">Desktop (1920px X 640) *</label>
                                            <div class="upload-pic"></div>
                                            <input type="hidden" value="{{@$blog_details->cover_image}}" name="hidden_cover_image">
                                            <input type="file" id="input-file-now" name="cover_image" data-default-file="/storage/{{@$blog_details->cover_image}}" class="dropify"
                                            data-min-width="1919" data-max-width="1921" data-min-height="639" data-max-height="641" data-old_input="hidden_cover_image" accept="image/jpg, image/png, image/jpeg, image/JPEG" data-allowed-file-extensions="jpg png jpeg JPEG"/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-wrap p-0">
                                            <label class="font13 mb-5">Tablet (1024 x 519) *</label>
                                            <div class="upload-pic"></div>
                                            <input type="hidden" value="{{@$blog_details->tablet_cover_image}}" name="hidden_tablet_cover_image">
                                            <input type="file" id="input-file-now" name="tablet_cover_image" data-default-file="/storage/{{@$blog_details->tablet_cover_image}}" class="dropify"
                                            data-min-width="1023" data-max-width="1025" data-min-height="518" data-max-height="520" data-old_input="hidden_tablet_cover_image" accept="image/jpg, image/png, image/jpeg, image/JPEG" data-allowed-file-extensions="jpg png jpeg JPEG"/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-wrap p-0">
                                            <label class="font13 mb-5">Mobile (480 x 791) *</label>
                                            <div class="upload-pic"></div>
                                            <input type="hidden" value="{{@$blog_details->mobile_cover_image}}" name="hidden_mobile_cover_image">
                                            <input type="file" id="input-file-now" name="mobile_cover_image" data-default-file="/storage/{{@$blog_details->mobile_cover_image}}" class="dropify"
                                            data-min-width="479" data-max-width="481" data-min-height="790" data-max-height="792" data-old_input="hidden_mobile_cover_image" accept="image/jpg, image/png, image/jpeg, image/JPEG" data-allowed-file-extensions="jpg png jpeg JPEG"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-30">
                <div class="card">
                    <div class="header">
                        <h2>Add <span>Blog Details *</span></h2>
                    </div>
                    <div class="body">
                        {{-- <div
                            style="padding:50px; font-size: 25px; opacity: 0.5; background-color: rgb(233, 233, 233); text-align: center;
                    display: block; height:400px;">
                            Text Editor Here...</div> --}}
                            {{-- <textarea name="editor_value" id="editor_value_id"></textarea> --}}
                            <textarea id="ckeditor">{{@$blog_details->blog_details}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-wrap p-0">
                    <label class="font13 mb-5">Slug *</label>
                    <input class="form-control blog-required" type="text" id="blog-slug" name="slug" value="{{@$blog_details->slug}}"/>
                </div>
            </div>
            <div class="col-6">
                <div class="form-wrap p-0">
                    <label class="font13 mb-5">Tags</label>
                    <input class="form-control" type="text" id="blog-tags" name="tags" value="{{@$blog_details->tags}}"/>
                </div>
            </div>
            <div class="col-md-12 text-center PT-15">
                <button type="button" class="btn btn-primary mr-2 save-blog" id="save-blog">Save</button>
                <a href="/blogs" type="button" class="btn btn-cancel cancel-blog" id="cancel-blog">Cancel</a>
            </div>
        </div>
    </form>
@endsection
 