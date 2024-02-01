@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
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
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Approved Content</h2>
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
            <div class="col-12">

                <div class="card">

                    <div class="card-content">
                        <div class="card-body">

                            <ul class="nav nav-pills nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link active" id="books-tab-fill" data-toggle="pill" href="#books-fill"
                                        aria-expanded="true">Books & Podcasts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="course-tab-fill" data-toggle="pill" href="#course-fill"
                                        aria-expanded="true">Courses</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="books-fill" aria-labelledby="books-tab-fill"
                                aria-expanded="true">
                                <div class="card">

                                    <div class="card-content">
                                        <div class="card-body">

                                            <!-- Table with outer spacing -->
                                            <div class="table-responsive">
                                                <table class="table" id="approved-book-table" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Cover</th>
                                                            <th class="">Title</th>
                                                            <th class="description-td">Description</th>
                                                            <th class="">Author</th>
                                                            <th class="">Type</th>
                                                            <th class="">Added By</th>
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

                            <div role="tabpanel" class="tab-pane" id="course-fill" aria-labelledby="course-tab-fill"
                                aria-expanded="true">
                                <div class="card">

                                    <div class="card-content">
                                        <div class="card-body">

                                            <!-- Table with outer spacing -->
                                            <div class="table-responsive">
                                                <table class="table" id="approved-by-you-courses-table"
                                                    style="width:100%;">
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
