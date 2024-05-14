@extends('layouts.default_layout')

@section('content')
    {{-- <textarea id="summernote" name="editordata"></textarea> --}}


    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-2 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Courses</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-left col-md-8 mb-2 d-flex" style="justify-content: end;">
                    <div class="row d-flex">


                        </form>
                        <div class="mr-1">
                            <li class="d-inline-block mr-2 " style="margin-top: 5px !important">
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" value="1" name="uncategorized"
                                            id="course-ajax-uncategorized" {{ @$uncategorized == 1 ? 'checked' : '' }}>
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
                                <select class="select2 form-control" name="category" id="course-ajax-table-category"
                                    style="width: 33rem">
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
                                <select class="select2 form-control" name="category" id="course-ajax-table-author"
                                    style="width: 33rem">
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
                                <select class="selct2 form-control" name="price" id="course-ajax-table-price">

                                    <option value=" " selected disabled>Price Type</option>
                                    <option value="1">Premium
                                    </option>
                                    <option value="0">Freemium</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="mr-1">
                            <fieldset class="form-group">
                                <select class="selct2 form-control" name="approval" id="course-ajax-table-approval">

                                    <option value=" " selected disabled>Approval Type</option>
                                    <option value="0">Pending For Approval
                                    </option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="content-header-right text-md-right col-md-2  d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <a href="{{ url('course/create') }}"> <button
                                    class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"><span
                                        class="add-brand-font">Add Course</span> <i class="fa fa-plus"
                                        aria-hidden="true"></i>
                                </button></a>

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
                                        <table class="table" id="courses-table">
                                            <thead>
                                                <tr>
                                                    <th class="">Image</th>
                                                    <th>Title</th>
                                                    <th class="description-td">Description</th>
                                                    <th>Category</th>
                                                    <th>Added By</th>
                                                    <th>Status</th>
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
