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
                <div class="content-header-left col-md-3 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Approved Content</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-left col-md-9 mb-2 d-flex" style="justify-content: end;">


                    <div class="mr-1">
                        <li class="d-inline-block mr-2" style="margin-top: 5px !important">
                            <fieldset>
                                <div class="vs-checkbox-con vs-checkbox-primary">
                                    <input type="checkbox" value="1" name="uncategorized"
                                        id="ajax-approved-uncategorized" {{ @$uncategorized == 1 ? 'checked' : '' }}>
                                    <span class="vs-checkbox">
                                        <span class="vs-checkbox--check">
                                            <i class="vs-icon feather icon-check"></i>
                                        </span>
                                    </span>
                                    <span class="">Uncategorized </span>
                                </div>
                            </fieldset>
                        </li>
                    </div>
                    <div class="mr-1">
                        <fieldset class="form-group" style="width: 10rem !important">
                            <select class="select2 form-control" name="category" id="ajax-approved-table-category">
                                <option value=" " selected disabled>Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->_id }}">
                                        {{ $cat->title }}
                                    </option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                    <div class="mr-1">
                        <fieldset class="form-group" style="width: 10rem !important">
                            <select class="select2 form-control" name="author" id="ajax-approved-table-author">
                                <option value=" " selected disabled>Author</option>
                                @foreach ($authors as $auth)
                                    <option value="{{ $auth->_id }}">
                                        {{ $auth->name }}
                                    </option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                    <div class="mr-1">
                        <fieldset class="form-group">
                            <select class="selct2 form-control" name="price" id="ajax-approved-table-price">

                                <option value=" " selected disabled>Price Type</option>
                                <option value="1" {{ @$p_type == '1' ? 'selected' : '' }}>Premium
                                </option>
                                <option value="0" {{ @$p_type == '0' ? 'selected' : '' }}>Freemium</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="mr-1">
                        <fieldset class="form-group">
                            <select class="selct2 form-control" name="content_type" id="ajax-approved-content-type-table">

                                <option value=" " selected disabled>Content Type</option>
                                <option value="1">eBooks
                                </option>
                                <option value="2">Audio Books</option>
                                <option value="3">Papers</option>
                                <option value="7">Podcasts</option>
                            </select>
                        </fieldset>
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
                                            <a class="nav-link" id="course-tab-fill" data-toggle="pill"
                                                href="#course-fill" aria-expanded="true">Courses</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="books-fill"
                                aria-labelledby="books-tab-fill" aria-expanded="true">
                                <div class="card">

                                    <div class="card-content">
                                        <div class="card-body">

                                            <!-- Table with outer spacing -->
                                            <div class="table-responsive">
                                                <table class="table w-100" id="approved-book-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Cover</th>
                                                            <th class="">Title</th>
                                                            <th class="description-td">Description</th>
                                                            <th class="">Category</th>
                                                            <th class="">Author</th>
                                                            <th class="">Type</th>
                                                            <th class="">Added By</th>
                                                            <th class="">Approved By</th>
                                                            <th class="action-td">Action</th>
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
                                                <table class="table w-100" id="approved-by-you-courses-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="">Image</th>
                                                            <th>Title</th>
                                                            <th class="description-td">Description</th>
                                                            <th class="">Category</th>
                                                            <th>Added By</th>
                                                            <th class="">Approved By</th>
                                                            <th class="action-td">Action</th>
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
