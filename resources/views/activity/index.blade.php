@extends('layouts.default_layout')

@section('content')
    {{-- <textarea id="summernote" name="editordata"></textarea> --}}


    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-5  mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Activities</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-left col-md-5  mb-2 d-flex" style="justify-content:end">
                    {{-- <div class="row breadcrumbs-top d-flex">
                        <form action="{{ url('book/during_period/' . $type) }}" method='POST' class="d-flex">
                            @csrf
                            <input class="form-control" type="date" name="s_date" id=""
                                value="{{ @$s_date }}">
                            <input class="form-control" type="date" name="e_date" id=""
                                value="{{ @$e_date }}">
                            <input type="hidden" name="type" value="{{ $type }}" id="">
                            <button class="btn-icon btn btn-primary btn-round  dropdown-toggle" type="submit"><span
                                    class="add-brand-font"></span> <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div> --}}
                </div>
                <div class="content-header-right text-md-right col-md-2  d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        {{-- <div class="dropdown">
                            <a href="{{ url("book/$type/create") }}"> <button
                                    class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"><span
                                        class="add-brand-font">Add Content</span> <i class="fa fa-plus"
                                        aria-hidden="true"></i>
                                </button></a>


                        </div> --}}
                    </div>
                </div>
            </div>
            @if (\Session::has('msg'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p class="mb-0">
                        {{ \Session::get('msg') }}
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="feather icon-x-circle"></i></span>
                    </button>
                </div>
            @endif
            <div class="modal fade bd-example-modal-lg" id="reason" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ url('/') }}" method="GET" id="reason_form">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Reason For Rejection</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12">
                                    <input type="hidden"name="book_id" id="book_id" placeholder="">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="basicInputFile">Reason</label>
                                            <div class="custom-file">
                                                <div class="position-relative">
                                                    <textarea name="reason" id="" cols="93" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>


                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-body">

                                    <!-- Table with outer spacing -->
                                    <div class="table-responsive">
                                        <table class="table" id="activity-table">
                                            <thead>
                                                <tr>
                                                    <th>Activity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Table with no outer spacing -->

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic Tables end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
