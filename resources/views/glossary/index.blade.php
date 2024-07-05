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
                            <h2 class="content-header-title float-left mb-0">Glossory</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                @permission('glossory-create')

                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <a href="{{ url('glossary/create') }}"> <button
                                    class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"><span
                                        class="add-brand-font">Add Glossory</span> <i class="fa fa-plus"
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
                                        <table class="table" id="glossory-table">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>

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
