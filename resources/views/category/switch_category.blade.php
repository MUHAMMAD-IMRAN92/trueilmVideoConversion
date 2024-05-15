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
                            <h2 class="content-header-title float-left mb-0">Disable Category ({{$currentCategory->title}})</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <a href="{{ url('category/create') }}">

                            </a>
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
                @endif @if (\Session::has('dmsg'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p class="mb-0">
                            {{ \Session::get('dmsg') }}
                        </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="feather icon-x-circle"></i></span>
                        </button>
                    </div>
                @endif
                <div class="content-body">
                    <!-- Basic Tables start -->
                    <div class="row ">
                        <div class="col-12">
                            <form action="{{ url('category/change_content_category') }}" method="POST">
                                @csrf
                                <div class="col-12">
                                    <input type="hidden" name="old_categroy" value="{{ $currentCategory }}">
                                    <label for="">Alternative Category</label>
                                    <fieldset class="form-group">
                                        <select class="select2 form-control" name="alternative_category" id="basicSelect"
                                            required>
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->_id }}">
                                                    {{ $cat->title }}</option>
                                            @endforeach

                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>

                                </div>
                            </form>
                        </div>
                        <div class="col-12">
                            <h4>eBooks / Audio Books / Podcast</h4>
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">

                                        <!-- Table with outer spacing -->
                                        <div class="table-responsive">
                                            <table class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Cover</th>
                                                        <th>Title</th>
                                                        <th>Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($books as $book)
                                                        @php
                                                            $type = '';
                                                            if ($book->type == 1) {
                                                                $type = 'eBook';
                                                            }
                                                            if ($book->type == 2) {
                                                                $type = 'Audio Book';
                                                            }
                                                            if ($book->type == 3) {
                                                                $type = 'Research Paper';
                                                            }
                                                            if ($book->type == 7) {
                                                                $type = 'Podcast';
                                                            }
                                                        @endphp

                                                        <tr>
                                                            <td><img class="td-img" src={{ $book->image }} /></td>
                                                            <td>{{ $book->title }}</td>
                                                            <td>{{ $type }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Table with no outer spacing -->

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <h4>Courses</h4>
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">

                                        <!-- Table with outer spacing -->
                                        <div class="table-responsive">
                                            <table class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Cover</th>
                                                        <th>Title</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($courses as $course)
                                                        <tr>
                                                            <td><img class="td-img" src={{ $book->image }} /></td>
                                                            <td>{{ $book->title }}</td>

                                                        </tr>
                                                    @endforeach
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
