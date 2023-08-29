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
                            <h2 class="content-header-title float-left mb-0">{{$support->title}}</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <a href="{{ url('course/create') }}"> </a>

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
            @endif
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-body">

                                    <section style="background-color: #eee;">
                                        <div class="container py-5">

                                            <div class="row">



                                                <div class="col-12">

                                                    <ul class="list-unstyled">
                                                        @foreach ($supportDetails as $supportDetail)
                                                            <li class="d-flex justify-content-between ">

                                                                <div class="card" style="width :100%">
                                                                    <div class="card-header ">
                                                                         <i class="fa fa-user "></i>
                                                                         <p class="fw-bold mb-0 ml-1">  {{ $supportDetail->user_name }}</p>

                                                                    </div>
                                                                    <div class="card-body">
                                                                        <p class="mb-0">
                                                                            {{ $supportDetail->description }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach

                                                        <form method="POST" action="{{ url('support/reply') }}">
                                                            @csrf
                                                            <li class="bg-white mb-3">
                                                                <div class="form-outline">
                                                                    <input type="hidden" name="support_id"
                                                                        value="{{ $support->_id }}">
                                                                    <textarea class="form-control" id="textAreaExample2" name="description" rows="4"></textarea>
                                                                    <label class="form-label"
                                                                        for="textAreaExample2">Message</label>
                                                                </div>
                                                            </li>
                                                            <button type="submit"
                                                                class="btn btn-primary btn-rounded float-end">Send</button>
                                                    </ul>

                                                </div>

                                            </div>

                                        </div>
                                    </section>

                                </div>



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
