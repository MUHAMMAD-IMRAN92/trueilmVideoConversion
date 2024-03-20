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
                            <h2 class="content-header-title float-left mb-0">Add Series</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">

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
                                            action="{{ route('series.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Title</label>
                                                            <div class="position-relative">
                                                                <input type="hidden" id="" class="form-control"
                                                                    name="id" value="{{ $series->_id }}">
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" value="{{ $series->title }}"
                                                                    placeholder="" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description">{{ $series->title }}</textarea>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <label for="">Image</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input mt-1"
                                                                    id="" name="image" accept="image/*">
                                                                <label class="custom-file-label" for="">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <img src="{{ $series->image }}" alt="course image"
                                                            style="width:150px; height:120px">
                                                    </div>

                                                    <div class="form-group col-12">
                                                        <label for="basicInputFile">Courses</label>

                                                        <select class="select2  form-control" multiple="multiple"
                                                            name="courses[]" required>
                                                            @foreach ($courses as $course)
                                                                <option value="{{ $course->_id }}"
                                                                    {{ in_array($course->_id, $series->courses) == true ? 'selected' : '' }}>
                                                                    {{ $course->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>



                                                </div>

                                                <div class="col-12" style="text-align: right">
                                                    {{-- <div class=""> --}}
                                                    {{-- <span class="btn btn-primary mr-1 mb-1" id="add-lesson">Add
                                                        Lesson</span> --}}
                                                    {{-- </div> --}}

                                                    <button type="submit" class="btn btn-primary mr-1 mb-1"
                                                        id="submit-btn">
                                                        <span class="spinner-border mr-1 ml-1" style="display: none"></span>
                                                        <span class="submit-text">Submit</span>
                                                    </button>
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
