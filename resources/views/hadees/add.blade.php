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
                            <div class="col-md-3">
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

                                                    <div class="col-12">
                                                        <input type="hidden" name="book_id" id=""
                                                            value="{{ $hadeesBook->id }}">
                                                        <label for="">Hadith</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="summernote" name="hadith"></textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-12">

                                                        <label for="">Type</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="type"
                                                                id="basicSelect">
                                                                <option value="1">
                                                                    Hadees-e-Qudsi</option>
                                                                <option value="2">
                                                                    Hadees-e-Zaeef</option>
                                                                <option value="3">
                                                                    Hadees-e-Sahih</option>
                                                            </select>
                                                        </fieldset>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label for="basicInputFile">Tags</label>

                                                        <select class="select2 multiple-select form-control"
                                                            multiple="multiple" name="tags[]">
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->title }}">
                                                                    {{ $tag->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-12" style="text-align: right">

                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>

                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-3 ayat-data">
                                <div class="card card-height">
                                    <div class="card-content">
                                        <div class="card-body">
                                            @foreach ($hadeesBook->hadees as $hadith)
                                                <ul class="" id="" data-menu="menu-navigation">

                                                    <li class="@if (request()->is($hadeesBook->id . '/' . $hadith->id . '*')) active @endif "><a
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
                    </div>
            </div>

    </section>
@endsection
