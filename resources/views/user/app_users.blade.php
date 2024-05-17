@extends('layouts.default_layout')

@section('content')
    {{-- <textarea id="summernote" name="editordata"></textarea> --}}


    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-4 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">App User Management</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-left col-md-8 mb-2 d-flex" style="justify-content: end;">
                    <div class="row d-flex">
                        <div class="mr-1">
                            <li class="d-inline-block mr-2 " style="margin-top: 5px !important">
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" value="1" name="unsubscribed"
                                            id="user-ajax-table-unsubscribed">
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span class="">Unsubscribed </span>
                                    </div>
                                </fieldset>
                            </li>
                        </div>
                        <div class="mr-1">
                            <fieldset class="form-group">
                                <select class="selct2 form-control mr-2" name="plan_type" id="user-ajax-table-plan-type">

                                    <option value="" selected disabled>Subscription Type</option>
                                    <option value="1">Individual
                                    </option>
                                    <option value="2">Family</option>
                                    <option value="3">Big Family</option>
                                </select>
                            </fieldset>
                        </div>
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
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-body">

                                    <!-- Table with outer spacing -->
                                    <div class="table-responsive">
                                        <table class="table" id="{{ @$table ?? 'app-user-table' }}">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="description-td">Email</th>
                                                    <th class="">Phone</th>
                                                    <th class="">Status</th>
                                                    <th class="">Action</th>
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
