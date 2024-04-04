@extends('layouts.default_layout')

@section('content')
    {{-- <textarea id="summernote" name="editordata"></textarea> --}}


    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-4  mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Content</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-left col-md-6  mb-2 d-flex" style="justify-content:end">
                    <div class="row breadcrumbs-top d-flex">
                        <form action="{{ url('book/during_period/' . $type) }}" method='POST' class="d-flex">
                            @csrf
                            <input class="form-control ml-1" type="date" name="s_date" id=""
                                value="{{ @$s_date }}">
                            <input class="form-control ml-1" type="date" name="e_date" id=""
                                value="{{ @$e_date }}">
                            <input type="hidden" name="type" value="{{ $type }}" id="">
                            <button class="btn-icon btn btn-primary btn-round  dropdown-toggle ml-1" type="submit"><span
                                    class="add-brand-font"></span> <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-2  d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <a href="{{ url("book/$type/create") }}"> <button
                                    class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"><span
                                        class="add-brand-font">Add Content</span> <i class="fa fa-plus"
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
                <div class="row {{ $hidden_table == 1 ? 'd-none' : '' }}" id="basic-table">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-body">
                                    <input type="hidden" name="type" value="{{ $type }}" id="ajax-table-type">
                                    <!-- Table with outer spacing -->
                                    <div class="table-responsive">
                                        <table class="table" id="ebook-table">
                                            <thead>
                                                <tr>
                                                    <th>Cover</th>
                                                    <th class="">Title</th>
                                                    {{-- <th class="description-td">Description</th> --}}
                                                    <th class="">Category</th>
                                                    <th class="">Author</th>
                                                    {{-- <th class="">Type</th> --}}
                                                    <th class="">Status</th>
                                                    <th class="">Added By</th>
                                                    <th class="">Approved By</th>
                                                    {{-- <th class="">Read By</th> --}}

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
                @if ($hidden_table == 1)
                    <div class="row " id="basic-table">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">

                                        <!-- Table with outer spacing -->
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Cover</th>
                                                        <th class="">Title</th>

                                                        <th class="">Author</th>
                                                        <th class="">Type</th>
                                                        <th class="">Status</th>
                                                        <th class="">Added By</th>
                                                        <th class="">Approved By</th>

                                                        {{-- <th class="">Read By</th> --}}
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($books as $b)
                                                        @php
                                                            if ($b->type == 1) {
                                                                $b->type = 'eBook';
                                                            }
                                                            if ($b->type == 2) {
                                                                $b->type = 'Audio Book';
                                                            }
                                                            if ($b->type == 3) {
                                                                $b->type = 'Research Paper';
                                                            }
                                                            if ($b->type == 7) {
                                                                $b->type = 'Podcast';
                                                            }

                                                            if ($b->approved == 0) {
                                                                $b->approved = 'Pending For Approval';
                                                            }
                                                            if ($b->approved == 2) {
                                                                $b->approved = 'Rejected';
                                                            }
                                                            if ($b->approved == 1) {
                                                                $b->approved = 'Approved';
                                                            }

                                                            $eye = 'feather icon-eye';
                                                            if ($b->status == 0) {
                                                                $eye = 'feather icon-eye-off';
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td><img class="td-img" src="{{ $b->image }}"></td>

                                                            <td>{{ $b->title }}</td>

                                                            <td>{{ @$b->author->name }}</td>
                                                            <td>{{ $b->type }}</td>
                                                            <td>{{ $b->approved }}</td>
                                                            <td>{{ @$b->user_name }}</td>
                                                            <td>{{ @$b->approver_name }}</td>
                                                            <td>{{ $b->numberOfUser }}</td>
                                                            <td>
                                                                <a class="ml-2"
                                                                    href="{{ url('book/' . $b->type . '/edit/' . $b->_id) }}"><i
                                                                        class="feather icon-edit-2"></i></a>

                                                                @if ($b->type == 'Audio Book')
                                                                    <a class="ml-2"
                                                                        href="{{ url('book/' . $b->type . '/list/' . $b->_id) }}">
                                                                        <i class="fa fa-list"> </i></a>
                                                                @endif
                                                            </td>
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
                @endif
                <!-- Basic Tables end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
