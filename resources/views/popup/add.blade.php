@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Add Popup</h2>
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
                                            action="{{ route('popup.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row ">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="" class="required">Title</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" placeholder="" required>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="" class="required">Text</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control " id="basicTextarea" rows="3" placeholder="" name="text" required></textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6" ><label for="" class="required">Select Device</label>
                                                        <fieldset class="form-group">
                                                            <select class="selct2 form-control reference-select"
                                                                name="device">
                                                                <option value="" disabled selected>Please Select
                                                                    Device
                                                                </option>
                                                                <option value="1">Mobile App</option>
                                                                <option value="2">Web App</option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6"><label for="">Select Type</label>
                                                        <fieldset class="form-group">
                                                            <select class="selct2 form-control reference-select"
                                                                name="type">
                                                                <option value="" disabled selected>Please Select Type
                                                                </option>
                                                                <option value="1">Promotional</option>
                                                                <option value="2">Alerts</option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-6">
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
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Start</label>
                                                            <div class="position-relative">
                                                                <input type="number" id="" class="form-control"
                                                                    name="start" placeholder="">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Interval</label>
                                                            <div class="position-relative">
                                                                <input type="number" id="" class="form-control"
                                                                    name="interval" placeholder="">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Link</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="" class="form-control"
                                                                    name="link" placeholder="">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Button Text</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="" class="form-control"
                                                                    name="button_text" placeholder="">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12" style="text-align: right">
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
