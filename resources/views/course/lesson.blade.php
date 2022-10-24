@extends('layouts.master')
@section('data-sidebar')
<div id="product-cl-sec" class="faqs-sidebar">
    <a href="#" id="pl-close" class="close-btn-pl"></a>
    <div class="pro-header-text">New <span>Lesson</span></div>
    <div class="pc-cartlist">
        <div class="overflow-plist">
            <div class="plist-content">
                <div class="_left-filter">
                    <form id="saveLessonForm">
                        @csrf
                        <input type="hidden" class="course_id" name="course_id" value="{{$course_id}}">
                        <input type="hidden" class="lesson_id" name="hidden_lesson_id">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div id="floating-label" class="card p-20 top_border mb-3">
                                        <h2 class="_head03">Lesson <span>Details</span></h2>
                                        <div class="form-wrap p-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Title *</label>
                                                        <input type="text" id="" class="form-control lesson-required" placeholder="" name="title">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-12 pt-9">
                                                        <label class="font12 mb-5">Description *</label>
                                                        <textarea name="faq_answer"></textarea>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label mb-10">Sequence *</label>
                                                        <input type="text" id="" class="form-control only_numerics lesson-required" placeholder="" name="sequence">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="_cl-bottom">
        <button type="submit" class="btn btn-primary mr-2 save-lesson" id="save-lesson">Save</button>
        <button id="pl-close" type="submit" class="btn btn-cancel mr-2 faq-cancel" id="faq-cancel">Cancel</button>
    </div>
</div>
@endsection

@section('content')
<div class="row mt-2 mb-3">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <h2 class="_head01">Lesson <span>Managment</span></h2>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb">
            <li><a href="#"><span>Lesson </span></a></li>
            <li><span>Add</span></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <button type="button" class="btn add_button add_lesson"><i class="fa fa-plus"></i> <span>Add
                        Lesson</span></button>
                <h2>Lessons <span>List</span></h2>
            </div>
            <div style="min-height: 400px" class="loader">
                <img src="{{asset('images/loader.gif')}}" width="30px" height="auto" style="position: absolute; left: 50%; top: 45%;">
            </div>
            <div class="body lesson_list">

            </div>
        </div>
    </div>
</div>
@endsection
<!-- push('js')
<script src="mix('js/custom/faq.js'"></script>
endpush -->