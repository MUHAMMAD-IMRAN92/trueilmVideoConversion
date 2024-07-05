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
                        <form action="{{ url('book/during_period/' . $type) }}" method="GET" class="d-flex">
                            @csrf
                            <input type="hidden" name="type" value="{{ $type }}">
                            {{-- <button class="btn-icon btn btn-primary rounded-circle p-0" type="submit"
                                    style="width: 36px; height: 36px;">
                                    <span class="add-brand-font"></span>
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button> --}}

                        </form>
                        <div class="mr-1">
                            <li class="d-inline-block mr-2" style="margin-top: 5px !important">
                                <fieldset>
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input type="checkbox" value="1" name="uncategorized" id="ajax-uncategorized"
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
                        </div>
                        {{-- <div class="mr-1" > --}}
                        <div class="form-label-group">
                            <select class="select2 form-control " name="category" id="ajax-table-category">
                                <option value="" selected disabled>Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->_id }}">
                                        {{ $cat->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- </div> --}}

                        <div class="mr-1 ml-1">
                            <fieldset class="form-group" style="width: 10rem !important">
                                <select class="select2 form-control" name="author" id="ajax-table-author">
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
                                <select class="selct2 form-control" name="price" id="ajax-table-price">

                                    <option value=" " selected disabled>Price Type</option>
                                    <option value="1" {{ @$p_type == '1' ? 'selected' : '' }}>Premium
                                    </option>
                                    <option value="0" {{ @$p_type == '0' ? 'selected' : '' }}>Freemium</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="mr-1">
                            <fieldset class="form-group">
                                <select class="selct2 form-control" name="approval" id="ajax-table-approval">

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


                @php
                $permission_pass=''; 
                $permission_edit='';
                $permission_toggle='';
                if($type == 1)
                {
                    $permission_pass='eBook-create';
                    $permission_edit='eBook-edit';
                    $permission_toggle='eBook-toggle';

                }
                if($type == 2)
                {
                    $permission_pass='audio-book-create';
                    $permission_edit='audio-book-edit';
                    $permission_toggle='audio-book-toggle';
                }
                if($type == 3)
                {
                    $permission_pass='papers-create';
                    $permission_edit='papers-edit';
                    $permission_toggle='papers-toggle';
                }
                if($type == 7)
                {
                    $permission_pass='podcast-create';
                    $permission_edit='podcast-edit';
                    $permission_toggle='podcast-toggle';
                }
                @endphp
                 

                @permission($permission_pass)
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
                @endpermission
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
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Most Read Content </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <canvas id="topReadBookChart" width="900" height="300"></canvas>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
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
                                                    <th class="">Price</th>
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
                                            <table class="table datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Cover</th>
                                                        <th class="">Title</th>
                                                        {{-- <th class="description-td">Description</th> --}}
                                                        <th class="">Category</th>

                                                        <th class="">Author</th>
                                                        {{-- <th class="">Type</th> --}}
                                                        <th class="">Status</th>
                                                        <th class="">Price</th>
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
                                                            $p_type = 'Freemium';
                                                            if ($p_type == 1) {
                                                                $p_type = 'Premium';
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
                                                            <td>{{ $p_type }}</td>
                                                            <td>{{ @$b->user_name ?? '--' }}</td>
                                                            <td>{{ @$b->approver_name ?? '--' }}</td>
                                                            <td>{{ $b->numberOfUser }} ttt</td>
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
                                            {{-- {{$books->links()}} --}}
                                        </div>
                                    </div>

                                    <!-- Table with no outer spacing -->

                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Basic Tables end -->
                {{-- <div class="modal fade bd-example-modal-lg" id="edit-book" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <form action="{{ route('podcast.episode') }}" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Quick Edit
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                <label for="basicInputFile">Title</label>
                                                <div class="custom-file">
                                                    <div class="position-relative">
                                                        <input type="hidden" id="" class="form-control"
                                                            name="book_id" value="">

                                                        <input type="text" id="modal-book-title" class="form-control"
                                                            name="book_title" placeholder="" required>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                <select class="select2 form-control" name="category"
                                                    id="ajax-table-category">
                                                    <option value=" " selected disabled>Category</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->_id }}">
                                                            {{ $cat->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                <select class="select2 form-control" name="author"
                                                    id="ajax-table-author">
                                                    <option value=" " selected disabled>Author</option>
                                                    @foreach ($authors as $auth)
                                                        <option value="{{ $auth->_id }}">
                                                            {{ $auth->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
