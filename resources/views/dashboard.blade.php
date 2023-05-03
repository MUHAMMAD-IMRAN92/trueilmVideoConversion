@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row">
                        @if (auth()->user()->hasRole('Admin'))
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-primary p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="fa fa-book text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">{{ App\Models\AlQuran::count() }}</h2>
                                        <p class="mb-0">Surah</p>
                                    </div>
                                    {{-- <div class="card-content">
                                    <div id="line-area-chart-1"></div>
                                </div> --}} <br>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-danger p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">{{ App\Models\Hadees::count() }}</h2>
                                        <p class="mb-0">Hadis</p>
                                    </div>
                                    {{-- <div class="card-content">
                                    <div id="line-area-chart-3"></div>
                                </div> --}} <br>
                                </div>
                            </div>
                        @endif
                        @if (auth()->user()->hasRole('Admin') ||
                                auth()->user()->hasRole('Publisher'))
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-warning p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-package text-warning font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\Book::approved()->when(
                                                    !auth()->user()->hasRole('Admin'),
                                                    function ($query) {
                                                        $query->where('added_by', auth()->user()->id);
                                                    },
                                                )->count() }}
                                        </h2>
                                        <p class="mb-0">Books</p>
                                    </div>

                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-success p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="fa fa-language text-success font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\Book::pendingApprove()->when(
                                                    !auth()->user()->hasRole('Admin'),
                                                    function ($query) {
                                                        $query->where('added_by', auth()->user()->id);
                                                    },
                                                )->count() }}
                                        </h2>
                                        <p class="mb-0">Pending For Approval <u style="font-size: 10px">
                                                @if (auth()->user()->hasRole('Admin'))
                                                    <a href="{{ url('book/pending-for-approval') }}">Click</a>
                                                @endif
                                            </u>

                                        </p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-success p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="fa fa-language text-success font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\Book::rejected()->when(
                                                    !auth()->user()->hasRole('Admin'),
                                                    function ($query) {
                                                        $query->where('added_by', auth()->user()->id);
                                                    },
                                                )->count() }}
                                        </h2>
                                        <p class="mb-0">Rejected<u style="font-size: 10px">
                                                {{-- @if (auth()->user()->hasRole('Admin'))
                                                    <a href="{{ url('book/pending-for-approval') }}">Click</a>
                                                @endif --}}
                                            </u>

                                        </p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        @endif
                    </div>

                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
