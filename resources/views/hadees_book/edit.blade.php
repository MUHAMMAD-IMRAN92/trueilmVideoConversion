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
                            <h2 class="content-header-title float-left mb-0">Edit Surah</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('al-Quran') }}">Surah</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Surah
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        {{-- <div class="dropdown">
                        <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-settings"></i></button>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Chat</a><a class="dropdown-item" href="#">Email</a><a class="dropdown-item" href="#">Calendar</a></div>
                    </div> --}}
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

                <h1 class="">{{ $hadeesBook->title }}</h1>
                <h6 class="">{!! $hadeesBook->description !!}</h6>
                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">

                        <div class="col-md-9 col-9 ayat-insert">
                            <div class="card card-height">

                                <div class="card-content">
                                    <div class="card-body">

                                        @if (!isset($hadees))
                                            <div id="no-ayat-added-div">
                                                Please Select Hadith!</div>
                                        @else
                                            <div id="no-ayat-added-div">
                                                No Hadees Added In This Book Yet!</div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 ayat-data">
                            <div class="card card-height">
                                <div class="card-content">
                                    <div class="card-body">
                                        @foreach ($hadeesBook->hadees as $hadith)
                                            <ul class="" id="" data-menu="menu-navigation">

                                                <li class="@if (request()->is($hadeesBook->id . '/' . $hadith->id)) active @endif "><a
                                                        href="{{ url('/hadith/edit/' . $hadeesBook->id . '/' . $hadith->id) }}">
                                                        <span class="menu-item"
                                                            data-i18n="Analytics">{!! $hadith->hadees !!}</span></a>
                                                </li>
                                            </ul>
                                        @endforeach
                                        <div class="" id="" style="text-align: center">
                                            <a href="{{ url('hadith/create/' . $hadeesBook->id) }}"> <span
                                                    class="btn btn-primary mr-1 mb-1">Add
                                                    Hadith</span></a>
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
