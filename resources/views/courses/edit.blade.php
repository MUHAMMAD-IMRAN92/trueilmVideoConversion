@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Edit Course</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('courses') }}">Courses</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Course
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        {{-- <div class="dropdown">
                        <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-settings"></i></button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Chat</a><a class="dropdown-item" href="#">Email</a><a class="dropdown-item" href="#">Calendar</a></div>
                    </div> --}}
                    </div>
                </div>
            </div>
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p class="mb-0">
                        {{ $error }}
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="feather icon-x-circle"></i></span>
                    </button>
                </div>
            @endforeach
            <div class="content-body">

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">

                        <div class="col-md-12 col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" id="disable-btn-submit"
                                            action="{{ route('course.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Name</label>
                                                            <div class="position-relative">
                                                                <input type="hidden" id="" class="form-control"
                                                                    name="id" placeholder=""
                                                                    value="{{ $course->_id }}" required>
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" placeholder=""
                                                                    value="{{ $course->title }}" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="summernote" name="description">{{ $course->description }}</textarea>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Image</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="inputGroupFile01" name="image" accept="image/*">
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-2 ">
                                                        <img src="{{$course->image}}" alt="course image" style="width:150px; height:120px">
                                                    </div>
                                                    <div class="col-12 " id="lesson-heading" style="display:none">
                                                        <h2>New Lessons:</h2>
                                                    </div>
                                                </div>

                                                <h2>Lessons:</h2>
                                                <div class="row">
                                                    @foreach ($course->lessons as $lesson)
                                                        <div class="col-md-4">
                                                            <video style="width:300px ; height:300px"
                                                                src="{{ $lesson->video }}" controls></video>
                                                            <h4>{{ $lesson->title }}</h4>
                                                            <p>{!! $lesson->description !!}</p>
                                                            {{--  <a
                                                                    href="{{ url('lesson/delete/' . $lesson->id) }}"
                                                                    class="btn btn-danger">Delete</a> --}}
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <br>
                                                <div class="col-12" id="add-lesson" style="text-align: right">
                                                    <span class="btn btn-primary mr-1 mb-1">Add
                                                        Lesson</span>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" id="submit-btn"
                                                        class="btn btn-primary mr-1 mb-1">Submit</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic Vertical form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
