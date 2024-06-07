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
                <div class="content-header-left col-md-12  d-flex" style="justify-content: end;">
                    <div class="row d-flex">
                        <form action="{{ url('book/during_period/') }}" method="GET" class="d-flex">
                            @csrf
                            <input class="form-control mr-2" type="date" name="s_date"
                                value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}" id="s_date_dashboard">
                            <input class="form-control" type="date" name="e_date"
                                value="{{ \Carbon\Carbon::now()->endOfMonth()->toDateString() }}" id="e_date_dashboard">
                        </form>
                    </div>
                </div>
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    {{-- <div class="row">
                        @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">

                                        <h2 class="text-bold-700 mt-1" id="trails"></h2>
                                        <p class="mb-0">New Trial</p>
                                    </div>
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">

                                        <h2 class="text-bold-700 mt-1" id="new-subscription"></h2>
                                        <p class="mb-0">New Subscription</p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">

                                        <h2 class="text-bold-700 mt-1" id="expire-subscription"></h2>
                                        <p class="mb-0">Expire Subscription</p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">

                                        <h2 class="text-bold-700 mt-1" id="renewal-subscription"></h2>
                                        <p class="mb-0">Renewal</p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Users Registered </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <canvas id="usersChart" width="900" height="300"></canvas>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Most Read Content </h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <canvas id="contentChart" width="900" height="300"></canvas>
                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr> --}}
                    <div class="row">
                        @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-primary p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="fa fa-book text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">{{ App\Models\Surah::count() }}</h2>
                                        <p class="mb-0">Surah</p>
                                    </div>
                                    <br>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-danger p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="fa fa-book text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">{{ App\Models\Hadees::count() }}</h2>
                                        <p class="mb-0">Hadis</p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        @endif
                        @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Publisher') || auth()->user()->hasRole('Super Admin'))
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-warning p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="fa fa-book text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\Book::when(!auth()->user()->hasRole('Super Admin'), function ($query) {
                                                $query->where('added_by', auth()->user()->id);
                                            })->count() }}
                                        </h2>
                                        <p class="mb-0">Total Books</p>
                                    </div>

                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-success p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="fa fa-book text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        {{-- @php
                                            $total_pending = App\Models\Book::pendingApprove()
                                                ->count();
                                        @endphp --}}
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\Book::pendingApprove()->when(auth()->user()->hasRole('Publisher'), function ($query) {
                                                    $query->where('added_by', auth()->user()->id);
                                                })->count() }}
                                        </h2>
                                        <p class="mb-0">Pending For Approval Book <u style="font-size: 10px">
                                                @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                                                    <a href="{{ url('book/pending-for-approval/1') }}">Click</a>
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
                                                <i class="fa fa-book text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\Book::rejected()->when(!auth()->user()->hasRole('Super Admin'), function ($query) {
                                                    $query->where('added_by', auth()->user()->id);
                                                })->count() }}
                                        </h2>
                                        <p class="mb-0">Rejected Books<u style="font-size: 10px">

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
                                                <i class="fa fa-book text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\Book::approved()->ebook()->when(!auth()->user()->hasRole('Super Admin'), function ($query) {
                                                    $query->where('added_by', auth()->user()->id);
                                                })->count() }}
                                        </h2>
                                        <p class="mb-0">eBooks<u style="font-size: 10px">

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
                                                <i class="fa fa-book text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\Book::approved()->audio()->when(!auth()->user()->hasRole('Super Admin'), function ($query) {
                                                    $query->where('added_by', auth()->user()->id);
                                                })->count() }}
                                        </h2>
                                        <p class="mb-0">Audio Books<u style="font-size: 10px">

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
                                                <i class="fa fa-book text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\Book::approved()->paper()->when(!auth()->user()->hasRole('Super Admin'), function ($query) {
                                                    $query->where('added_by', auth()->user()->id);
                                                })->count() }}
                                        </h2>
                                        <p class="mb-0">Research Papers<u style="font-size: 10px">

                                            </u>

                                        </p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        @endif
                        @if (auth()->user()->hasRole('Institute'))
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">
                                        <div class="avatar bg-rgba-success p-50 m-0">
                                            <div class="avatar-content">
                                                <i class="fa fa-user text-primary font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700 mt-1">
                                            {{ App\Models\User::where('institute_id', auth()->user()->_id)->count() }}
                                        </h2>
                                        <p class="mb-0">Users<u style="font-size: 10px">

                                            </u>

                                        </p>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-9 col9">
                                {{-- <input type="text" value="Hello World" id="myInput"> --}}

                                <!-- The button used to copy the text -->
                                {{-- <div class="card">
                                    <div class="form-group d-flex">
                                        <div class="col-10">
                                            <div class="position-relative">
                                                <input type="text" id="myInput" class="form-control" name="seats"
                                                    placeholder="" disabled
                                                    value="https://app.trueilm.com/{{ auth()->user()->_id . '/' . auth()->user()->name }}">

                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-dark" onclick="myFunction()">Copy Link</button>

                                        </div>
                                    </div>
                                </div> --}}
                                <div class="card  d-flex">
                                    <div class="card-header d-flex flex-column align-items-start pb-0">

                                        <div class="col-12 d-flex ">
                                            <div class="col-10">
                                                <div class="position-relative">
                                                    <input type="text" id="myInput" class="form-control"
                                                        name="" placeholder="" readonly="readonly"
                                                        value="https://app.trueilm.com/sign-up/{{ auth()->user()->_id . '/' . auth()->user()->name }}">

                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button class="btn btn-dark" id="copy-link-btn"
                                                    onclick="myFunction()">Copy Link</button>

                                            </div>
                                        </div>
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
<script>
    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");
        /* Select the text field */
        copyText.select();
        console.log(copyText.select());

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        $('#copy-link-btn').html('Copied !');
        setTimeout(() => {
            $('#copy-link-btn').html('Copy Link')
        }, 3000);
    }
</script>
