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
                            <h2 class="content-header-title float-left mb-0">Add Course</h2>
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
                                            action="{{ route('course.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Title</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" required placeholder="" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description"></textarea>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="">Image</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="" name="image" accept="image/*">
                                                                <label class="custom-file-label" for="">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label for="basicInputFile">Tags</label>

                                                        <select class="select2 multiple-select form-control"
                                                            multiple="multiple" name="tags[]">
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->title }}">
                                                                    {{ $tag->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <div class="col-6">

                                                        <label for="">Category</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="category"
                                                                id="basicSelect">
                                                                <option disabled selected>Select Category</option>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->_id }}">
                                                                        {{ $category->title }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div> --}}
                                                    <div class="col-6  text-md-left">
                                                        <label for="">Product
                                                            Category</label>
                                                        <div class="form-label-group">
                                                            <select class="select2 form-control" name="category_id"
                                                                id="create-product-category-attribute">
                                                                <option selected disabled>Select
                                                                    Category
                                                                </option>
                                                                {!! getCategorydropdown(0, 0, 0, 4) !!}

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Max Age</label>
                                                            <div class="position-relative">
                                                                <input type="number" id="" class="form-control"
                                                                    name="age" placeholder="">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 " id="lesson-heading" style="display:none">
                                                        <h2>Lessons:</h2>
                                                    </div>
                                                </div>

                                                <div class="col-12" style="text-align: right">
                                                    {{-- <div class=""> --}}
                                                    <span class="btn btn-primary mr-1 mb-1" id="add-lesson">Add
                                                        Lesson</span>
                                                    {{-- </div> --}}
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1"
                                                        id="submit-btn">Submit</button>
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
