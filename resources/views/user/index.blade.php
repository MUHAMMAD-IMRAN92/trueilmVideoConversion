@extends('layouts.default_layout')

@section('content')
    {{-- <textarea id="summernote" name="editordata"></textarea> --}}

    <!-- Add this modal to your HTML -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">
                        {{ auth()->user()->hasRole('Super Admin') == true ? 'Reset Password' : 'Change Password' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="resetPasswordForm" method="POST" action="{{ url('reset-password') }}">
                        @csrf
                        <div class="form-group">
                            <label for="newPassword">New Password:</label>
                            <input type="password" name="newPassword" id="newPassword" class="form-control" required>
                            <input type="hidden" name="user_id" id="user_id" class="form-control" min="4"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password:</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control"
                                required>
                            <span class="danger mt-1" id="did-not-match" style="display:none;">Password does not
                                match</span>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: right">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">User Management</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <a href="{{ route('user.add') }}"> <button
                                    class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"><span
                                        class="add-brand-font">Add User</span> <i class="fa fa-plus" aria-hidden="true"></i>
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
                    <div class="row" id="basic-table">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">

                                        <!-- Table with outer spacing -->
                                        <div class="table-responsive">
                                            <table class="table" id="user-table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th class="description-td">Email</th>
                                                        <th class="">Phone</th>
                                                        <th class="">Role</th>
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
<script></script>
