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
                            <h2 class="content-header-title float-left mb-0">User Profile</h2>
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
                                            <form class="form form-vertical" action="{{ url('app-user/subscription') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" id="" class="form-control" name="id"
                                                    placeholder="" value="{{ $user->_id }}">
                                                <div class="form-body">
                                                    <div class="row append-inputs">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">Name</label>
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="name" placeholder=""
                                                                        value="{{ $user->name }}" disabled>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Email</label>
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="email" placeholder=""
                                                                        value="{{ $user->email }}" disabled>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Phone</label>
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="phone" placeholder=""
                                                                        value="{{ $user->phone }}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="col-6 ">

                                                                {{-- <label for="">Life Time Member</label> --}}

                                                                {{-- <input type="checkbox" id="" name="subscription"
                                                            value="1" placeholder="" style=""> <span> Life Time Member</span> --}}

                                                                <li class="d-inline-block mr-2">
                                                                    <fieldset>
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                            <input type="checkbox"
                                                                                {{ in_array(1, $checkLifeTime) == true ? 'checked' : '' }}
                                                                                value="1" name="subscription[]">
                                                                            <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                    <i
                                                                                        class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                            </span>
                                                                            <span class="">Individual(Life Time
                                                                                Member)</span>
                                                                        </div>
                                                                    </fieldset>
                                                                </li>
                                                            </div>
                                                            <div class="col-6 ">

                                                                {{-- <label for="">Life Time Member</label> --}}

                                                                {{-- <input type="checkbox" id="" name="subscription"
                                                            value="1" placeholder="" style=""> <span> Life Time Member</span> --}}

                                                                <li class="d-inline-block mr-2">
                                                                    <fieldset>
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                            <input type="checkbox"
                                                                                {{ in_array(2, $checkLifeTime) == true ? 'checked' : '' }}
                                                                                value="2" name="subscription[]">
                                                                            <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                    <i
                                                                                        class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                            </span>
                                                                            <span class="">Family (Life Time
                                                                                Member)</span>
                                                                        </div>
                                                                    </fieldset>
                                                                </li>
                                                            </div>
                                                            <div class="col-6 ">

                                                                {{-- <label for="">Life Time Member</label> --}}

                                                                {{-- <input type="checkbox" id="" name="subscription"
                                                            value="1" placeholder="" style=""> <span> Life Time Member</span> --}}

                                                                <li class="d-inline-block mr-2">
                                                                    <fieldset>
                                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                                            <input type="checkbox"
                                                                                {{ in_array(3, $checkLifeTime) == true ? 'checked' : '' }}
                                                                                value="3" name="subscription[]">
                                                                            <span class="vs-checkbox">
                                                                                <span class="vs-checkbox--check">
                                                                                    <i
                                                                                        class="vs-icon feather icon-check"></i>
                                                                                </span>
                                                                            </span>
                                                                            <span class="">Big Family (Life Time
                                                                                Member)</span>
                                                                        </div>
                                                                    </fieldset>
                                                                </li>
                                                            </div>
                                                        </div>
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
                            <div class="content-header-left col-md-9 col-12 mb-2">
                                <div class="row breadcrumbs-top">
                                    <div class="col-12">
                                        <h2 class="content-header-title float-left mb-0">User Subscription</h2>
                                        <div class="breadcrumb-wrapper col-12">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 m-0 p-0">
                                <div class="card">

                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Plan</th>
                                                            <th class="description-td">Plan Description</th>
                                                            <th>Price</th>
                                                            <th>Expiry Duration</th>
                                                            <th>Membership </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($user->subscription as $subs)
                                                            @php
                                                                $type = 'Life Time';
                                                                if (@$subs->plan->type == 1) {
                                                                    $type = 'Monthly';
                                                                } elseif (@$subs->plan->type == 2) {
                                                                    $type = 'Yearly';
                                                                }
                                                                $mtype = 'Big Family';
                                                                if (@$subs->type == 1) {
                                                                    $mtype = 'Individual';
                                                                } elseif (@$subs->type == 2) {
                                                                    $mtype = 'Family';
                                                                }
                                                            @endphp
                                                            <tr>
                                                                <td>{{ @$subs->plan->product_title }}</td>
                                                                <td>{{ @$subs->plan->description }}</td>
                                                                <td>{{ @$subs->plan->price }}</td>
                                                                <td>{{ @$type }}</td>
                                                                <td>{{ @$mtype }}</td>
                                                            </tr>
                                                        @empty
                                                            <center><b>No Plan Subscribed Yet!</b></center>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
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
