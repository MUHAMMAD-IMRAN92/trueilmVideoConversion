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
                        <div class="col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="col-12">
                                            <h4>Overall Quiz Statics :</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">

                                        <div class="col-12">
                                            <canvas id="quiz-pie-chart" width="700" height="150"></canvas>
                                        </div>
                                        <div class="row d-flex justify-content-center">

                                            <script>
                                                new Chart(document.getElementById("quiz-pie-chart"), {
                                                    type: 'doughnut',
                                                    data: {
                                                        labels: ["Attempted", "UnAttempted", "Correct", "InCorrect"],
                                                        datasets: [{
                                                            label: "Population (millions)",
                                                            backgroundColor: ["#1E90FF", "#C0C0C0", "#90EE90", "#FF0000"],
                                                            data: ["{{ $attemptResults2->sum('attempted') }}",
                                                                "{{ $attemptResults2->sum('unattempted') }}",
                                                                "{{ $attemptResults2->sum('correct') }}",
                                                                "{{ $attemptResults2->sum('incorrect') }}"
                                                            ]
                                                        }]
                                                    },
                                                    options: {
                                                        title: {
                                                            display: true,
                                                            // text: 'Predicted world population (millions) in 2050'
                                                        }
                                                    }
                                                });
                                            </script>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="col-12">
                                            <h4>Quiz Statics By Users :</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @forelse ($result as $key=> $res)
                            <div class="col-4">
                                <div class="card">

                                    <div class="card-content">
                                        <div class="card-body">
                                            <h3>{{ ucfirst($key) }}</h3>

                                            <div class="row d-flex justify-content-center">

                                                <canvas id="pie-chart-{{ $key }}" width=""
                                                    height="200"></canvas>

                                                <script>
                                                    new Chart(document.getElementById("pie-chart-{{ $key }}"), {
                                                        type: 'doughnut',
                                                        data: {
                                                            labels: ["Attempted", "UnAttempted", "Correct", "InCorrect"],
                                                            datasets: [{
                                                                label: "Population (millions)",
                                                                labels: ["Attempted", "UnAttempted", "Correct", "InCorrect"],
                                                                backgroundColor: ["#1E90FF", "#C0C0C0", "#90EE90", "#FF0000"],
                                                                data: ["{{ $res->sum('attempted') }}", "{{ $res->sum('unattempted') }}",
                                                                    "{{ $res->sum('correct') }}", "{{ $res->sum('incorrect') }}"
                                                                ]
                                                            }]
                                                        },
                                                        options: {
                                                            title: {
                                                                display: true,
                                                                // text: 'Predicted world population (millions) in 2050'
                                                            }
                                                        }
                                                    });
                                                </script>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>
                @empty

                    <center><b>No User Attemped This Quiz Yet !</b></center>
                    @endforelse
            </div>

            </section>
            <!-- // Basic Vertical form layout section end -->

        </div>
    </div>
    </div>

    <!-- END: Content-->
@endsection
