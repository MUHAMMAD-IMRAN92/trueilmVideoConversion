@extends('layouts.default_layout')

@section('content')
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
            overflow: hidden;
            border-radius: 10px;
            border: 1px solid;
            text-align: right;
        }
    </style>
    <section>
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
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

                <section id="basic-vertical-layouts">

                    <!-- Modal -->
                    <div class="row">

                        <div class="col-12">
                            <h1 class="">{{ $hadeesBook->title }}</h1>
                            <h6 class="">{!! $hadeesBook->description !!}</h6>
                        </div>

                    </div>

                    <div class="content-body">

                        <!-- Basic Vertical form layout section start -->
                        <div class="row">
                            <div class="col-md-9 ">

                                <div class="card">

                                    <div class="card-content">
                                        <div class="card-body">

                                            <ul class="nav nav-pills nav-fill">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab-fill" data-toggle="pill"
                                                        href="#home-fill" aria-expanded="true">Hadith</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-3">
                                <div class="row">
                                    {{-- <div class="col-9">

                                    </div> --}}
                                    <div class="col-12">
                                         <span class="badge badge-success span-text-size">Total Hadith :
                                                {{ App\Models\Hadees::where('book_id', $hadeesBook->_id)->count() }} </span></h5>
                                         <span class="badge badge-success span-text-size">Hadees-e-Sahih :
                                                {{ App\Models\Hadees::where('book_id', $hadeesBook->_id)->where('type', "1")->count() }} </span>
                                        </h5>
                                         <span class="badge badge-success span-text-size">Hadees-e-Zaeef :
                                                {{ App\Models\Hadees::where('book_id', $hadeesBook->_id)->where('type', "2")->count() }} </span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="form form-vertical" action="{{ route('hadith.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">

                                                    <input type="hidden" name="book_id" id=""
                                                        value="{{ $hadeesBook->id }}">
                                                    {{-- <div class="col-12">
                                                        <label for="">Hadith</label>
                                                        <fieldset class="form-group">
                                                            <textarea  class="form-control" rows="8" style="text-align: right;" name="hadith"></textarea>
                                                        </fieldset>
                                                    </div> --}}
                                                    <div class="col-12">
                                                        <label for="">Hadith</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control"  name="hadith"></textarea>
                                                        </fieldset>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="basicInputFile">Tags</label>

                                                        <select class="select2 multiple-select form-control"
                                                            multiple="multiple" name="tags[]">
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->title }}">
                                                                    {{ $tag->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 ">
                                                        <label for="basicInputFile">Glossary</label>

                                                        <select class="select2 multiple-select form-control"
                                                            multiple="multiple" name="glossary[]">
                                                            @foreach ($glossary as $gloss)
                                                                <option value="{{ $gloss->_id }}">
                                                                    {{ $gloss->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Hadith Number</label>
                                                        <div class="position-relative">
                                                            <input type="number" id="" name="hadith_number"
                                                                class="form-control" placeholder=""
                                                                value="" required>


                                                        </div>

                                                    </div>
                                                    <div class="form-group col-md-6">

                                                        <label for="" class="mb-1">Type</label>

                                                        {{-- <fieldset class="form-group">
                                                            <select class="select2 form-control" name="type"
                                                                id="basicSelect">
                                                                <option value="1">
                                                                    Hadees-e-Qudsi</option>
                                                                <option value="2">
                                                                    Hadees-e-Zaeef</option>
                                                                <option value="3">
                                                                    Hadees-e-Sahih</option>
                                                            </select>
                                                        </fieldset> --}}
                                                        {{-- Hadees-e-Sahih: <input type="radio" name="type" id="" value="1">
                                                        Hadees-e-Zaeef:  <input type="radio" name="type" id="" value="2"> --}}


                                                        <ul class="list-unstyled mb-0">
                                                            <li class="d-inline-block mr-2">
                                                                <fieldset>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                            name="type" id="customRadio1" value="1"
                                                                            checked>
                                                                        <label class="custom-control-label"
                                                                            for="customRadio1"> Hadees-e-Sahih</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2">
                                                                <fieldset>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input"
                                                                            name="type" id="customRadio2"
                                                                            value="2">
                                                                        <label class="custom-control-label"
                                                                            for="customRadio2">Hadees-e-Zaeef</label>
                                                                    </div>
                                                                </fieldset>
                                                            </li>

                                                        </ul>
                                                    </div>

                                                    <div class="form-group col-md-9">

                                                        <label for="">Hadith Chapter</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="chapter_id"
                                                                id="chapter_select">
                                                                <option disabled selected>Hadith Chapter</option>
                                                                @foreach ($chapter as $ch)
                                                                    <option value="{{ $ch->_id }}">
                                                                        {{ $ch->title }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <span data-toggle="modal" data-target="#author-lang"
                                                            class="btn btn-primary mt-2">Add Chapter</span>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-12" style="text-align: right">

                                                    <button type="submit"
                                                        class="btn btn-primary mr-1 mb-1">Submit</button>

                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-3 col-3 ayat-data">
                                <div class="card card-height">
                                    <div class="card-content">
                                        <div class="card-body">
                                            @foreach ($hadeesBook->hadees as $hadith)
                                                <div class="ayat-list">
                                                    <ul class="" id="" data-menu="menu-navigation">
                                                        <li
                                                            class="@if (request()->is('*/' . $hadeesBook->id . '/' . $hadith->id . '*')) active @endif render-ayat ">
                                                            <a
                                                                href="{{ url('/hadith/edit/' . $hadeesBook->id . '/' . $hadith->id) }}">
                                                                <span class="d-flex menu-item new-item-ayat"
                                                                    data-i18n="Analytics">{!! $hadith->hadees !!}
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endforeach
                                            <div class="" id="" style="text-align: center">
                                                <a href="{{ url('hadith/create/' . $hadeesBook->id) }}"> <span
                                                        class="btn btn-primary mr-1 mb-1">Add
                                                        Hadith</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-3 col-3 ayat-data">
                                <div class="card ">
                                    <div class="card-content">
                                        <div class="card-body">
                                            @foreach ($hadeesBook->hadees as $hadith)
                                                <div class="ayat-list">
                                                    <ul class="" id="" data-menu="menu-navigation">
                                                        <li
                                                            class="@if (request()->is('*/' . $hadeesBook->id . '/' . $hadith->id . '*')) active @endif render-ayat ">
                                                            <a
                                                                href="{{ url('/hadith/edit/' . $hadeesBook->id . '/' . $hadith->id) }}">
                                                                <span class="d-flex menu-item new-item-ayat"
                                                                    data-i18n="Analytics">{!! $hadith->hadees !!}
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
                            <div class="modal fade bd-example-modal-lg" id="author-lang" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form  method="POST">
                                        <div class="form-body">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Chapter</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group col-md-12">
                                                        <label for="">Title</label>
                                                        <div class="position-relative">
                                                            <input type="hidden" id="hadith_book" name="hadith_book"
                                                                class="form-control" placeholder=""
                                                                value="{{ $hadeesBook->_id }}">
                                                            <input type="text" name="title" id="modal_title"
                                                                class="form-control" placeholder="" required>


                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <span type="" id="save_chapter" class="btn btn-primary">Save</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

    </section>
@endsection

