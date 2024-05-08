@extends('layouts.default_layout')

@section('content')
    {{-- <textarea id="summernote" name="editordata"></textarea> --}}


    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-2  mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Content</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-left col-md-8 mb-2 d-flex" style="justify-content: end;">
                    <div class="row d-flex">
                        <form action="{{ url('book/during_period/' . $type) }}" method="POST" class="d-flex">
                            @csrf
                            {{-- <div class="mr-1">
                                <li class="d-inline-block mr-2">
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" value="1" name="uncategorized"
                                                {{ @$uncategorized == 1 ? 'checked' : '' }}>
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">Uncategorized </span>
                                        </div>
                                    </fieldset>
                                </li>
                            </div> --}}
                            {{-- <div class="mr-1">
                                <fieldset class="form-group">
                                    <select class="selct2 form-control" name="approved">
                                        <option value="" selected disabled>Status</option>
                                        <option value="3" {{ @$approved == 3 ? 'selected' : '' }}>Pending For Approval
                                        </option>
                                        <option value="1" {{ @$approved == 1 ? 'selected' : '' }}>Approved</option>
                                        <option value="2" {{ @$approved == 2 ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </fieldset>
                            </div> --}}
                            {{-- <div class="mr-1">
                                <fieldset class="form-group">
                                    <select class="selct2 form-control" name="status">
                                        <option value="" selected disabled>Status</option>
                                        <option value="1">Uncategorized</option>
                                        <option value="2">All Category</option>
                                    </select>
                                </fieldset>
                            </div> --}}
                            {{-- <div class="mr-1">
                                <input class="form-control" type="date" name="s_date" value="{{ @$s_date }}">
                            </div>
                            <div class="mr-1">
                                <input class="form-control" type="date" name="e_date" value="{{ @$e_date }}">
                            </div>
                            <input type="hidden" name="type" value="{{ $type }}">
                            <button class="btn-icon btn btn-primary rounded-circle p-0" type="submit"
                                style="width: 36px; height: 36px;">
                                <span class="add-brand-font"></span>
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button> --}}

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
                                                        {{-- <th class="description-td">Description</th> --}}
                                                        <th class="">Category</th>

                                                        <th class="">Author</th>
                                                        {{-- <th class="">Type</th> --}}
                                                        <th class="">Status</th>
                                                        <th class="">Added By</th>
                                                        <th class="">Approved By</th>

                                                        <th class="">Read By</th>
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
                                                            {{-- <td>{{ $b->description }}</td> --}}
                                                            <td>{{ @$b->category->title ?? '--' }}</td>
                                                            <td>{{ @$b->author->name ?? '--' }}</td>
                                                            {{-- <td>{{ $b->type }}</td> --}}
                                                            <td>{{ $b->approved }}</td>
                                                            <td>{{ @$b->user_name ?? '--' }}</td>
                                                            <td>{{ @$b->approver_name ?? '--' }}</td>
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
