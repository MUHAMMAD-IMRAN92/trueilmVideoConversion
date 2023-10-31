@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <style>
        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }
    </style>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-10">
                            <h2 class="content-header-title float-left mb-0">Quiz Result</h2>
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

                                        <div class="row d-flex justify-content-center">

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="">User</th>
                                                            <th>Total Question</th>
                                                            <th>Attemped</th>
                                                            <th>UnAttemped</th>
                                                            <th>Correct</th>
                                                            <th>Incorrect</th>
                                                            <th>Result</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($result as $key=> $res)
                                                            <tr>

                                                                <td id="title{{ $key }}">{{ $res->user }}
                                                                </td>

                                                                <td id="description{{ $key }}">
                                                                    {{ $res->attemped + $res->unattemped }}</td>

                                                                <td id="description{{ $key }}">
                                                                    {{ $res->attemped }}</td>

                                                                <td id="description{{ $key }}">
                                                                    {{ $res->unattemped }}</td>

                                                                <td id="description{{ $key }}">
                                                                    {{ $res->correct }}</td>

                                                                <td id="description{{ $key }}">
                                                                    {{ $res->incorrect }}</td>

                                                                <td id="description{{ $key }}">
                                                                    {{ $res->correct . '/' . $res->attemped + $res->unattemped }}
                                                                </td>

                                                            </tr>

                                                        @empty
                                                            <tr>
                                                                <center><b>No User Attemped This Quiz Yet !</b></center>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
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
