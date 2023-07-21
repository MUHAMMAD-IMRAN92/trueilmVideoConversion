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

            <!-- Modal -->
            <div class="row">

                <div class="col-12">
                    <h1 class="">{{ $surah->surah }}</h1>
                    <h6 class="">{!! $surah->description !!}</h6>
                </div>

            </div>

            <div class="content-body">

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-md-9 ">

                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">

                                        <ul class="nav nav-pills nav-fill">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab-fill" data-toggle="pill"
                                                    href="#home-fill" aria-expanded="true">Ayat</a>
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
                            <form class="form form-vertical" action="{{ route('ayat.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home-fill"
                                        aria-labelledby="home-tab-fill" aria-expanded="true">
                                        <div class="card">
                                            <div class="card-body">


                                                <div class="form-body" id="add-ayat-div">
                                                    <div class="row">
                                                        <input type="hidden" id="" class="form-control"
                                                            name="surah_id" placeholder="" value="{{ $surah->id }}"
                                                            required>

                                                        <div class="col-12">
                                                            <label for="">Ayat</label>
                                                            <fieldset class="form-group">
                                                                <textarea style="text-align: right;width:100%"  class="form-control" rows="8" name="ayat"></textarea>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">

                                                            <label for="">Juz</label>
                                                            <fieldset class="form-group">
                                                                <select class=" select2 form-control" name="juz"
                                                                    id="basicSelect">
                                                                    <option disabled selected>Select juz</option>
                                                                    @foreach ($juzs as $juz)
                                                                        <option value="{{ $juz->_id }}">
                                                                            {{ $juz->juz }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Mazil</label>
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        placeholder="e.g. 1234" class="form-control"
                                                                        name="manzil" placeholder="" value=""
                                                                        required>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Ruku</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        placeholder="e.g. 1234" class="form-control"
                                                                        name="ruku" placeholder="" value=""
                                                                        required>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Sajda</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        placeholder="e.g. 1234" class="form-control"
                                                                        name="sajda" placeholder="" value=""
                                                                        required>
                                                                </div>

                                                            </div>
                                                        </div>


                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Sequence </label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        placeholder="e.g. 1234" class="form-control"
                                                                        name="sequence" placeholder=""
                                                                        value="{{ \App\Models\AlQuran::max('sequence') + 1 }}"
                                                                        required>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Waqf </label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        placeholder="e.g. 1234" class="form-control"
                                                                        name="waqf" placeholder="" value=""
                                                                        required>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 ">
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
                                                    </div>

                                                    <div class="col-12" style="text-align: right">

                                                        <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Submit</button>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>

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

            </div>
        </div>

        </section>

    </div>
    </div>
    </div>
@endsection
