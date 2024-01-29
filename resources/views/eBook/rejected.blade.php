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
                            <h2 class="content-header-title float-left mb-0">Rejected Content</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
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

                                    <ul class="nav nav-pills nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="books-tab-fill" data-toggle="pill"
                                                href="#books-fill" aria-expanded="true">Books & Podcasts</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="course-tab-fill" data-toggle="pill" href="#course-fill"
                                                aria-expanded="true">Courses</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="books-fill" aria-labelledby="books-tab-fill"
                                aria-expanded="true">
                                <div class="card">

                                    <div class="card-content">
                                        <div class="card-body">

                                            <!-- Table with outer spacing -->
                                            <div class="table-responsive">
                                                <table class="table" id="rejected-book-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Cover</th>
                                                            <th class="">Title</th>
                                                            <th class="description-td">Description</th>
                                                            <th class="">Author</th>
                                                            <th class="">Type</th>
                                                            <th class="">Added By</th>
                                                            <th class="">Reason</th>
                                                            @if (auth()->user()->hasRole('Admin') ||
                                                                    auth()->user()->hasRole('Super Admin'))
                                                                <th>Action</th>
                                                            @else
                                                                <th></th>
                                                            @endif

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Table with no outer spacing -->

                            </div>
                            <div role="tabpanel" class="tab-pane" id="course-fill" aria-labelledby="course-tab-fill"
                                aria-expanded="true">
                                <div class="card">

                                    <div class="card-content">
                                        <div class="card-body">

                                            <!-- Table with outer spacing -->
                                            <div class="table-responsive">
                                                <table class="table" id="rejected-courses-table" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="">Image</th>
                                                            <th>Title</th>
                                                            <th class="description-td">Description</th>
                                                            <th>Added By</th>
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
                    </div>
                </div>
                <!-- Basic Tables end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
