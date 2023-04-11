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
                            <h2 class="content-header-title float-left mb-0">Edit Hadith</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('hadith') }}">Hadith</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Hadith
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
            <div class="content-body">

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">

                        <div class="col-md-12 col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" action="{{ route('hadith.update') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">

                                                    <div class="col-12">
                                                        <input type="hidden" name="id" id=""
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
                                                                        {{ $h->lang == 'en' ? 'selected' : '' }}>English
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
                                                    @foreach ($hadees->references as $r)
                                                        <div class="col-12">

                                                            <p>Reference</p>
                                                            <fieldset class="form-group">
                                                                <select class="form-control" name="reference_book[]"
                                                                    id="basicSelect">
                                                                    <option value="1"
                                                                        {{ $r->reference_book == '1' ? 'selected' : '' }}>
                                                                        Sahih ul Bukhari</option>
                                                                    <option value="2"
                                                                        {{ $r->reference_book == '2' ? 'selected' : '' }}>
                                                                        Al Sahih Li Muslim</option>
                                                                    <option value="3"
                                                                        {{ $r->reference_book == '3' ? 'selected' : '' }}>
                                                                        Jame ut Tirmezi</option>
                                                                    <option value="4"
                                                                        {{ $r->reference_book == '4' ? 'selected' : '' }}>
                                                                        Sunan e Abi Dawood</option>
                                                                    <option value="5"
                                                                        {{ $r->reference_book == '5' ? 'selected' : '' }}>
                                                                        Sunan e Nasa</option>
                                                                    <option value="6"
                                                                        {{ $r->reference_book == '6' ? 'selected' : '' }}>
                                                                        Sunan e Ibn-e-Maja</option>
                                                                </select>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="">Reference #</label>
                                                            <input type="number" id="" class="form-control"
                                                                name="ref_number[]"
                                                                value="{{ $r->reference_number }}"placeholder="">

                                                        </div>
                                                    @endforeach
                                                </div>
                                                <br>
                                                <div class="col-12">
                                                    <span type="" id="add-reference"
                                                        class="btn btn-primary mr-1 mb-1">Add
                                                        Reference</span>
                                                    <span type="" id="add-translation"
                                                        class="btn btn-primary mr-1 mb-1">Add
                                                        Translation</span>
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>

                                                </div>
                                            </div>
                                        </form>
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
