@extends('layouts.default_layout')

@section('content')
    <style>
        .cat-img {
            width: 125px;
            height: 125px;
        }
    </style>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Edit Category</h2>
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
                                        <form class="form form-vertical" action="{{ route('category.update') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Name</label>
                                                            <div class="position-relative">

                                                                <input type="hidden" id="" class="form-control"
                                                                    name="id" placeholder=""
                                                                    value="{{ $category->_id }}" required>
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" placeholder=""
                                                                    value="{{ $category->title }}" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description">{{ $category->description }}</textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">

                                                        <label for="">Parent Category</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="parent_id"
                                                                id="basicSelect">
                                                                <option selected value="0">No Parent</option>
                                                                @foreach ($pcategories as $cat)
                                                                    <option
                                                                        {{ $cat->_id == $category->parent_id ? 'selected' : '' }}
                                                                        value="{{ $cat->_id }}">
                                                                        {{ $cat->title }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">

                                                        <label for="">Category Color</label>

                                                        <input type="color" id="colorpicker" class="form-control"
                                                            name="color" value="#{{ $category->color }}">
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Icon</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="inputGroupFile01" name="icon" accept="image/*">
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">

                                                        <img class="cat-img" src="{{ $category->image }}" alt="No Icon">
                                                    </div>
                                                    {{-- <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Image</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="inputGroupFile01" name="image">
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div> --}}
                                                </div>

                                                <div class="col-12" style="text-align: right">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>

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
