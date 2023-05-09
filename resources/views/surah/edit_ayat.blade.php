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
                                            {{-- <form class="form form-vertical" action="{{ route('ayat.update') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-body">
                                                    <div class="row append-inputs">
                                                        <input type="hidden" id="" class="form-control"
                                                            name="surah_id" placeholder="" value="{{ $surah->id }}"
                                                            required>
                                                        <input type="hidden" id="" class="form-control"
                                                            name="ayat_id" placeholder="" value="{{ $ayat->id }}"
                                                            required>


                                                        <div class="col-12">
                                                            <label for="">Ayat</label>
                                                            <fieldset class="form-group">
                                                                <textarea class="summernote" name="ayat">{{ $ayat->ayat }}</textarea>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Para#</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        class="form-control" name="para" placeholder=""
                                                                        value="{{ $ayat->para_no }}" required>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        @foreach ($ayat->translations as $aya)
                                                            <div class="col-12">

                                                                <p>Language</p>
                                                                <fieldset class="form-group">
                                                                    <select class="form-control" name="langs[]"
                                                                        id="basicSelect">
                                                                        <option value="ar"
                                                                            {{ $aya->lang == 'ar' ? 'selected' : '' }}>
                                                                            Arabic</option>
                                                                        <option value="en"
                                                                            {{ $aya->lang == 'en' ? 'selected' : '' }}>
                                                                            English</option>
                                                                        <option value="ur"
                                                                            {{ $aya->lang == 'ur' ? 'selected' : '' }}>Urud
                                                                        </option>
                                                                        <option value="hi"
                                                                            {{ $aya->lang == 'hi' ? 'selected' : '' }}>
                                                                            Hindi</option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="">Ayat</label>
                                                                <fieldset class="form-group">
                                                                    <textarea class="summernote" name="translations[]">{{ $aya->translation }}</textarea>
                                                                </fieldset>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-12" id="add-translation" style="text-align: right">
                                                        <span class="btn btn-primary mr-1 mb-1">Add
                                                            Translation</span>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Submit</button>

                                                    </div>

                                                </div>
                                            </form> --}}
                                            <div id="no-ayat-added-div">
                                                Please Select Ayat!</div>
                                        @else
                                            {{-- <form class="form form-vertical" action="{{ route('ayat.store') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-body" id="add-ayat-div" style="display:none">
                                                    <div class="row append-inputs">
                                                        <input type="hidden" id="" class="form-control"
                                                            name="surah_id" placeholder="" value="{{ $surah->id }}"
                                                            required>
                                                        <div class="col-12">
                                                            <label for="">Ayat</label>
                                                            <fieldset class="form-group">
                                                                <textarea class="summernote" name="ayat"></textarea>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Para#</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        class="form-control" name="para" placeholder=""
                                                                        value="" required>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-12" id="add-translation" style="text-align: right">
                                                        <span class="btn btn-primary mr-1 mb-1">Add
                                                            Translation</span>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Submit</button>

                                                    </div>

                                                </div>
                                            </form> --}}
                                            <div id="no-ayat-added-div">
                                                No ,.m Added In This Surah Yet!</div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 ayat-data">
                            <div class="card card-height">
                                <div class="card-content">
                                    <div class="card-body">
                                        @foreach ($surah->ayats as $ayat)
                                            <ul class="navigation navigation-main" id="main-menu-navigation"
                                                data-menu="menu-navigation">

                                                <li class="@if (request()->is($surah->id . '/' . $ayat->id . '*')) active @endif "><a
                                                    href="{{ url('/ayat/edit/' . $surah->id . '/' . $ayat->id) }}">
                                                    <span class="menu-item"
                                                        data-i18n="Analytics">{!! $ayat->ayat !!}</span></a>
                                            </li>
                                            </ul>
                                        @endforeach
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
