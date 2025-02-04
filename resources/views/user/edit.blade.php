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
                            <h2 class="content-header-title float-left mb-0">Edit User</h2>
                            <div class="breadcrumb-wrapper col-12">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">


                    </div>
                </div>
            </div>
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p class="mb-0">
                        {{ $error }}
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="feather icon-x-circle"></i></span>
                    </button>
                </div>
            @endforeach
            <div class="content-body">

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">

                        <div class="col-md-12 col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" action="{{ route('user.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <input type="hidden" value="{{ $user->_id }}"
                                                                name="id">
                                                            <label for="">Name</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="" class="form-control"
                                                                    name="name" value="{{ $user->name }}"
                                                                    placeholder="" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Email</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="" class="form-control"
                                                                    name="email" value="{{ $user->email }}"
                                                                    placeholder="" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Phone</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="" class="form-control"
                                                                    name="phone" value="{{ $user->phone }}"
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Password</label>
                                                            <div class="position-relative">
                                                                <input type="text" id="" class="form-control"
                                                                    name="password" placeholder=""  required>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-12">
                                                        <label for="">Role</label>
                                                        <fieldset class="form-group">
                                                            <select class="form-control" id="" name="role"
                                                                required>
                                                                <option>Select Role
                                                                        
                                                                    </option>
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->_id }}"
                                                                        {{ $user->my_role_id == $role->_id ? 'selected' : '' }}>
                                                                        {{ $role->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    @if ($user->hasRole('Institute'))
                                                        <div class="col-12">
                                                            <div class="radio_for_institute_type">
                                                                <h5>Institution Type</h5>
                                                                <ul class="list-unstyled mb-0 mt-1">
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="institute_type" id="customRadio1"
                                                                                    {{$user->institute_type == 1 ? 'checked':''}} value="1">
                                                                                <label class="custom-control-label"
                                                                                    for="customRadio1">Bulk
                                                                                    Subscription</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="institute_type" id="customRadio2"
                                                                                    value="2" {{$user->institute_type == 2 ? 'checked':''}}>
                                                                                <label class="custom-control-label"
                                                                                    for="customRadio2">Subscription For
                                                                                    Students</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mt-2" id="bulk_plan_form"
                                                            style="{{ $user->institute_type == 2 ? 'display:none' : '' }}">


                                                            <div class="">
                                                                {{-- <h5 class="">Seats</h5> --}}

                                                                <div class="form-group">
                                                                    <label for="">Seats</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" id=""
                                                                            class="form-control" name="seats"
                                                                            placeholder="" value="{{ $user->seats }}">

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Expiry Date</label>
                                                                    <div class="position-relative">
                                                                        <input type="date" id=""
                                                                            class="form-control" name="expiry_date"
                                                                            placeholder=""
                                                                            value="{{ \Carbon\Carbon::parse($user->expiry_date)->toDateString() }}">

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <br>
                                                        <div class="col-12" id="plan_form"
                                                            style="{{ $user->institute_type == 1 ? 'display:none' : '' }}">

                                                            <div class="form-group">
                                                                <label for="">Seats</label>
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="seats"
                                                                        placeholder="" value="{{ $user->seats }}">

                                                                </div>
                                                            </div>

                                                            {{-- <div class="">
                                                                <h5 class="">Monthly Plan:</h5>

                                                                <div class="form-group">
                                                                    <label for="">Plan Title</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" id=""
                                                                            class="form-control" name="monthly_plan_title"
                                                                            placeholder="">

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Amount</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" id=""
                                                                            class="form-control" name="monthly_amount"
                                                                            placeholder="">

                                                                    </div>
                                                                </div>

                                                            </div> --}}
                                                            <div class="">
                                                                <h5 class="">Yearly Plan:</h5>

                                                                <div class="form-group">
                                                                    <label for="">Plan Title</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" id=""
                                                                            class="form-control" name="yearly_plan_title"
                                                                            placeholder=""
                                                                            value="{{ $instituteSubscription->product_title }}"
                                                                            disabled>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="">Amount</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" id=""
                                                                            class="form-control" name="price"
                                                                            placeholder=""
                                                                            value="{{ $instituteSubscription->price }}">

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    @endif
                                                    <div class="col-12" style="text-align: right">
                                                        <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Submit</button>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic Vertical form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
