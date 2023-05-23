@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->

    <style>
        .ayat-data .active {

            border-radius: 10px;
            border: 3px solid black;
        }

        .ayat-list .active a {
            color: black;
        }

        .ayat-list ul li {
            list-style: none;
            margin: 5px auto;
        }

        .ayat-list a span {
            flex-direction: row-reverse;
        }

        .ayat-list .active a {
            float: right;
            display: flex;


            font-weight: 400;
            font-size: 1.1rem;
            border-radius: 4px;
            padding: 10px 15px 10px 15px;
            line-height: 1.45;
            transition: padding 0.35s ease 0s !important;
            font-size: 1.2rem !important;
        }

        .ayat-list a {
            float: right;
            display: flex;
            animation: 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) 0s normal forwards 1 fadein;
            color: #565656;
            line-height: 1.45;
            font-weight: 400;
            border-radius: 4px;
            padding: 10px 15px 10px 15px;
            transition: padding 0.35s ease 0s !important;
            font-size: 1.2rem !important;
        }

        .ayat-list ul {
            padding: 0 !important;
            margin: 0 !important;
        }

        .ayat-list ul li i {
            margin-right: 1rem;
            float: left;
            font-size: 1.2rem;
        }

        .ayat-list ul li p {
            margin: 0 !important;
        }

        .card-body ul {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        .render-ayat {
            white-space: nowrap;
            overflow: hidden;
            background-image: linear-gradient(to left, #00000030, #ffff);
            border-radius: 10px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            display: inherit;
        }
    </style>

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">

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

                <h1 class="">{{ $surah->surah }}</h1>
                <h6 class="">{!! $surah->description !!}</h6>
                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">

                        <div class="col-md-9 col-9 ayat-insert">
                            <div class="card card-height">

                                <div class="card-content">
                                    <div class="card-body">

                                        @if (isset($ayat))
                                            <div id="no-ayat-added-div">
                                                <center> Please Select Ayat!</center>
                                            </div>
                                        @else
                                            <div id="no-ayat-added-div">
                                                No Ayat Added In This Surah Yet!</div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 ayat-data">
                            <div class="card ">
                                <div class="card-content">
                                    <div class="card-body">
                                        @foreach ($surah->ayats as $ayat)
                                            <div class="ayat-list">
                                                <ul class="" id="" data-menu="menu-navigation">

                                                    <li
                                                        class="@if (request()->is('*/' . $ayat->id)) active @endif render-ayat ">
                                                        <a href="{{ url('/ayat/edit/' . $surah->id . '/' . $ayat->id) }}">
                                                            <span class="d-flex menu-item new-item-ayat"
                                                                data-i18n="Analytics">{!! $ayat->ayat !!}
                                                            </span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        @endforeach
                                        <br>
                                        <div class="" id="" style="text-align: center">
                                            <a href="{{ url('ayat/create/' . $surah->id) }}"> <span
                                                    class="btn btn-primary mr-1 mb-1">Add
                                                    Ayat</span></a>
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
