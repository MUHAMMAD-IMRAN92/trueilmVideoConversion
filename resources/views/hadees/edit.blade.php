@extends('layouts.default_layout')

@section('content')
    <style>
        .ayat-data .active {
            background-color: black;
            border-radius: 10px;
        }

        .active a {
            color: white;
        }

        .ayat-list ul li {
            list-style: none;
        }

        .ayat-list .active a {
            display: flex;
            background: linear-gradient(118deg, #141414, #141414);
            box-shadow: 0 0 10px 1px #141414;
            color: #fff;
            font-weight: 400;
            font-size: 1.1rem;
            border-radius: 4px;
            padding: 10px 15px 10px 15px;
            line-height: 1.45;
            transition: padding 0.35s ease 0s !important;
            font-size: 1.2rem !important;
        }

        .ayat-list a {
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
    </style>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Hadith Book</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('hadith') }}">Hadith Books</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Hadith Book
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
            <div class="modal fade" id="reference" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-dialog-centered">
                    <form action="{{ url('referencing') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Add Reference</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" value="2" name="referal">
                                <input type="hidden" value="{{ $hadees->id }}" name="referal_id">
                                <div class="col-12">
                                    <label for="">Reference Type</label>
                                    <fieldset class="form-group">
                                        <select class="form-control" id="" name="ref_type" required>
                                            <option value="3">eBook</option>
                                            <option value="4">Audio</option>
                                            <option value="5">Research Paper</option>
                                            <option value="6">Tafseer</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="basicInputFile">Refernce</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputGroupFile01"
                                                name="file">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose
                                                file</label>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="content-body">

                <h1 class="">{{ $hadeesBook->title }}</h1>
                <h6 class="">{!! $hadeesBook->description !!}</h6>
                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row ">

                        <div class="col-md-9 col-9 ayat-insert">
                            <div class="card ">

                                <div class="card-content">
                                    <div class="card-body">


                                        <form class="form form-vertical" action="{{ route('hadith.update') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">

                                                    <div class="col-12">
                                                        <input type="hidden" name="id" id=""
                                                            value="{{ $hadeesBook->id }}">
                                                        <input type="hidden" name="hadees_id" id=""
                                                            value="{{ $hadees->id }}">
                                                        <label for="">Hadith</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="summernote" name="hadith">{{ $hadees->hadees }}</textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-12">

                                                        <label for="">Type</label>
                                                        <fieldset class="form-group">
                                                            <select class="form-control" name="type" id="basicSelect">
                                                                <option value="1"
                                                                    {{ $hadees->type == 1 ? 'selected' : '' }}>
                                                                    Hadees-e-Qudsi</option>
                                                                <option value="2"
                                                                    {{ $hadees->type == 2 ? 'selected' : '' }}>
                                                                    Hadees-e-Zaeef</option>
                                                                <option value="3"
                                                                    {{ $hadees->type == 3 ? 'selected' : '' }}>
                                                                    Hadees-e-Sahih</option>
                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    @foreach ($hadees->translations as $h)
                                                        <div class="col-12">

                                                            <p>Language</p>
                                                            <fieldset class="form-group">
                                                                <select class="form-control" name="langs[]"
                                                                    id="basicSelect">
                                                                    <option value="ar"
                                                                        {{ $h->lang == 'ar' ? 'selected' : '' }}>Arabic
                                                                    </option>
                                                                    <option value="en"
                                                                        {{ $h->lang == 'en' ? 'selected' : '' }}>
                                                                        English
                                                                    </option>
                                                                    <option value="ur"
                                                                        {{ $h->lang == 'ur' ? 'selected' : '' }}>Urud
                                                                    </option>
                                                                    <option value="hi"
                                                                        {{ $h->lang == 'hi' ? 'selected' : '' }}>Hindi
                                                                    </option>
                                                                </select>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="">Translation</label>
                                                            <fieldset class="form-group">
                                                                <textarea class="summernote" name="translations[]">{{ $h->translation }}</textarea>
                                                            </fieldset>
                                                        </div>
                                                    @endforeach

                                                </div>
                                                <br>
                                                <div class="col-12" style="text-align: right">

                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#reference">
                                                        Add Reference
                                                    </button>

                                                    <span id="add-translation" class="btn btn-primary">Add
                                                        Translation</span>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-1 mb-1">Submit</button>

                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 ayat-data">
                            <div class="card ">
                                <div class="card-content">
                                    <div class="card-body">
                                        @foreach ($hadeesBook->hadees as $hadith)
                                            <div class="ayat-list">
                                                <ul class="" id="" data-menu="menu-navigation">

                                                    <li class="@if (request()->is('*/' . $hadith->id)) active @endif ">
                                                        <a
                                                            href="{{ url('/hadith/edit/' . $hadeesBook->id . '/' . $hadith->id) }}">
                                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                                            <span class="menu-item"
                                                                data-i18n="Analytics">{!! Str::limit("$hadith->hadees", 50) !!}
                                                            </span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        @endforeach
                                        <br>
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
