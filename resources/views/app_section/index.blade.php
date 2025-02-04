@extends('layouts.default_layout')

@section('content')
    {{-- <textarea id="summernote" name="editordata"></textarea> --}}


    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">App Sections</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                @permission('app-section-create')
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <a href="{{ route('app-section.add') }}"> <button
                                    class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"><span
                                        class="add-brand-font">Add Section</span> <i class="fa fa-plus"
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
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-body">

                                    <!-- Table with outer spacing -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th class="description-td">Sub Title</th>
                                                    <th>Content</th>
                                                    <th>Sequence</th>
                                                    <th>Added By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($section as $sec)
                                                    @php
                                                        $eye = 'feather icon-eye';
                                                        if ($sec->status == 0) {
                                                            $eye = 'feather icon-eye-off';
                                                        }
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $sec->title }}</td>
                                                        <td>{{ $sec->sub_title }}</td>
                                                        <td>
                                                            <span>eBook : </span> <b>
                                                                {{ count($sec->eBook) }}</b> <br>
                                                            <span>Audio Book : </span> <b>
                                                                {{ count($sec->audioBook) }}</b> <br>
                                                            <span>Podcast : </span> <b>
                                                                {{ count($sec->podcast) }}</b> <br>
                                                            <span>Course : </span> <b>
                                                                {{ count($sec->course) }}</b> <br>
                                                        </td>
                                                        <td>{{ $sec->sequence }}</td>
                                                        <td>{{ $sec->user->name }}</td>
                                                        <td>
                                                            @permission('app-section-edit')
                                                            <a class="ml-2"
                                                                href="{{ url("app-section/edit/$sec->_id") }}"><i
                                                                    class="feather icon-edit-2"></i></a>
                                                            @endpermission
                                                            @permission('app-section-toggle')

                                                            <a class="ml-2"
                                                                href="{{ url("app-section/update-status/$sec->_id") }}"><i
                                                                    class="{{ $eye }}"></i></a>
                                                            @endpermission
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <td></td>
                                                    <td></td>
                                                    <td style="align-content: center">No Data Found !</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endforelse
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
