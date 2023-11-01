@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <style>
        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-3">
                            <h2 class="content-header-title float-left mb-0">User Results</h2>
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
                    <div class="row ">
                        <div class="col-12 ">

                            @if (count($result) > 0)
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table" id="">
                                                    <thead>
                                                        <tr>
                                                            <th class="">Sr.</th>
                                                            <th>Total Questions</th>
                                                            <th class="">Attempted</th>
                                                            <th>UnAttempted</th>
                                                            <th>Correct</th>
                                                            <th>Incorrect</th>
                                                            <th>Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($result as $key => $res)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $res->attempted + $res->unattempted }}</td>
                                                                <td>{{ $res->attempted }}</td>
                                                                <td>{{ $res->unattempted }}</td>
                                                                <td>{{ $res->correct }}</td>
                                                                <td>{{ $res->incorrect }}</td>
                                                                <td>{{ $res->correct . '/' . $res->attempted + $res->unattempted }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>

            <!-- // Basic Vertical form layout section end -->

        </div>
    </div>
    </div>

    <!-- END: Content-->
@endsection
