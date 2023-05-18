@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
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
            margin: 5px auto;
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

        .render-ayat {
            white-space: nowrap;
            overflow: hidden;
            background-image: linear-gradient(to right, #00000030, #ffff);
            border-radius: 10px;
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
            <div class="row">

                <div class="col-9">
                    <h1 class="">{{ $surah->surah }}</h1>
                    <h6 class="">{!! $surah->description !!}</h6>
                </div>
                <div class="col-3"></div>
            </div>





            <div class="content-body">

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-md-9 col-9 ">

                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">

                                        <ul class="nav nav-pills nav-fill">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab-fill" data-toggle="pill"
                                                    href="#home-fill" aria-expanded="true">Ayat</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="translation-tab-fill" data-toggle="pill"
                                                    href="#translation-fill" aria-expanded="true">Add Translation</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tafseer-tab-fill" data-toggle="pill"
                                                    href="#tafseer-fill" aria-expanded="true">Add Tafseer</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="reference-tab-fill" data-toggle="pill"
                                                    href="#reference-fill" aria-expanded="true">Add Reference</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3">
                        </div>
                    </div>
                    <div class="row ">

                        <div class="col-md-9">


                            <form class="form form-vertical" action="{{ route('ayat.update') }}" method="POST"
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
                                                        <input type="hidden" id="" class="form-control"
                                                            name="ayat_id" placeholder="" value="{{ $ayat->id }}"
                                                            required>
                                                        <div class="col-12">
                                                            <label for="">Ayat</label>
                                                            <fieldset class="form-group">
                                                                <textarea class="summernote" name="ayat">{{ $ayat->ayat }}</textarea>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Juz#</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        class="form-control" name="para"
                                                                        placeholder="" value="{{ $ayat->para_no }}"
                                                                        required>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Mazil</label>
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        placeholder="e.g. 1234" class="form-control"
                                                                        name="manzil" placeholder=""
                                                                        value="{{ $ayat->manzil }}" required>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Ruku</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        placeholder="e.g. 1234" class="form-control"
                                                                        name="ruku" placeholder=""
                                                                        value="{{ $ayat->ruku }}" required>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Sajda</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        placeholder="e.g. 1234" class="form-control"
                                                                        name="sajda" placeholder=""
                                                                        value="{{ $ayat->sajda }}" required>
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
                                                                        value="{{ $ayat->sequence }}" required>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="contact-info-icon">Waqf </label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        placeholder="e.g. 1234" class="form-control"
                                                                        name="waqf" placeholder=""
                                                                        value="{{ $ayat->waqf }}" required>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-12" style="text-align: right">

                                                        {{-- <button type="button" class="btn btn-primary"
                                                            data-toggle="modal" data-target="#reference">
                                                            Add Reference
                                                        </button> --}}
                                                        <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Submit</button>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="translation-fill"
                                        aria-labelledby="translation-tab-fill" aria-expanded="true">

                                        <div class="row append-inputs">
                                            @forelse ($ayat->translations as $key => $aya)
                                                @php
                                                    $ayatId = $ayat->id;
                                                    $transId = $aya->id;
                                                @endphp
                                                <div class="col-12 lang translation-div-{{ $key }}">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-8 ">

                                                                    <h4 id="translation-saved-span-{{ $key }}"
                                                                        style="display:none"> <span
                                                                            class="badge badge-success "><i
                                                                                class="fa fa-check">Translation
                                                                                Saved</i></span></h4>
                                                                </div>
                                                                <div class="col-4 d-flex">
                                                                    <h4 onclick="editable('{{ $key }}')"><span
                                                                            class="badge badge-info ml-1"><i
                                                                                class="fa fa-pencil">&nbspEdit</i></span>
                                                                    </h4>
                                                                    <h4
                                                                        onclick="saveTranslation('{{ $ayatId }}','{{ $transId }}','{{ $key }}')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>

                                                                    <h4
                                                                        onclick="deleteTranslation('{{ $ayatId }}','{{ $transId }}','{{ $key }}')">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-translation-{{ $key }}">

                                                                <p>Language :
                                                                    <b id="non-edit-lang-select-{{ $key }}">{{ $aya->lang }}
                                                                    </b>
                                                                </p>

                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="non-edit-para-des-{{ $key }}"
                                                                        style="margin-left:10px!important">
                                                                        {!! $aya->translation !!}</span>
                                                                </div>

                                                            </div>
                                                            <div class="row m-0 p-0" id="editble-{{ $key }}"
                                                                style="display:none">
                                                                <label for="">Language</label>
                                                                <fieldset class="form-group">
                                                                    <select class="form-control" name="langs[]"
                                                                        id="lang-select-{{ $key }}"
                                                                        id="basicSelect">
                                                                        <option value="ar"
                                                                            {{ $aya->lang == 'ar' ? 'selected' : '' }}>
                                                                            Arabic
                                                                        </option>
                                                                        <option value="en"
                                                                            {{ $aya->lang == 'en' ? 'selected' : '' }}>
                                                                            English
                                                                        </option>
                                                                        <option value="ur"
                                                                            {{ $aya->lang == 'ur' ? 'selected' : '' }}>
                                                                            Urud
                                                                        </option>
                                                                        <option value="hi"
                                                                            {{ $aya->lang == 'hi' ? 'selected' : '' }}>
                                                                            Hindi
                                                                        </option>
                                                                    </select>
                                                                </fieldset>

                                                                <div class="col-12 m-0 p-0">
                                                                    <label for="">Translation</label>

                                                                    <fieldset class="form-group">
                                                                        <textarea class="summernote" id="trans-input-{{ $key }}" name="translations[]">{{ $aya->translation }}</textarea>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @empty
                                                <div class="col-12 no-translation-div">

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <center>
                                                                No Translation Added In This Ayat
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                    </div>
                                                    <div class="col-md-5">
                                                        {{-- <span id="add-translation" class="btn btn-primary">Add
                                                            Translation</span> --}}
                                                        <span onclick="addTranslation('{{ $ayat->id }}')"
                                                            class="btn btn-primary">Add
                                                            Translation</span>
                                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tafseer-fill"
                                        aria-labelledby="tafseer-tab-fill" aria-expanded="true">

                                        <div class="row tafseer-append-inputs">
                                            @forelse ($ayat->tafseers as $key=> $tafseer)
                                                @php
                                                    $ayatId = $ayat->id;
                                                    $tafseerId = $tafseer->id;
                                                @endphp
                                                <div class="col-12 tafseer-divs tafseer-div-{{ $key }}">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-8 ">

                                                                    <h4 id="tafseer-saved-span-{{ $key }}"
                                                                        style="display:none"> <span
                                                                            class="badge badge-success "><i
                                                                                class="fa fa-check">Tafseer
                                                                                Saved</i></span></h4>
                                                                </div>
                                                                <div class="col-4 d-flex">
                                                                    <h4 onclick="editableTafseer('{{ $key }}')">
                                                                        <span class="badge badge-info ml-1"><i
                                                                                class="fa fa-pencil">&nbspEdit</i></span>
                                                                    </h4>
                                                                    <h4
                                                                        onclick="saveTafseer('{{ $ayatId }}','{{ $tafseerId }}','{{ $key }}')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>

                                                                    <h4
                                                                        onclick="deleteTafseer('{{ $ayatId }}','{{ $tafseerId }}','{{ $key }}')">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-tafseer-{{ $key }}">

                                                                <p>Language :
                                                                    <b
                                                                        id="tafseer-non-edit-lang-select-{{ $key }}">{{ $tafseer->lang }}
                                                                    </b>
                                                                </p>

                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="tafseer-non-edit-para-des-{{ $key }}"
                                                                        style="margin-left:10px!important">
                                                                        {!! $tafseer->tafseer !!}</span>
                                                                </div>

                                                            </div>
                                                            <div class="row m-0 p-0"
                                                                id="tafseer-editble-{{ $key }}"
                                                                style="display:none">
                                                                <label for="">Language</label>
                                                                <fieldset class="form-group">
                                                                    <select class="form-control" name="langs[]"
                                                                        id="tafseer-lang-select-{{ $key }}"
                                                                        id="basicSelect">
                                                                        <option value="ar"
                                                                            {{ $tafseer->lang == 'ar' ? 'selected' : '' }}>
                                                                            Arabic
                                                                        </option>
                                                                        <option value="en"
                                                                            {{ $tafseer->lang == 'en' ? 'selected' : '' }}>
                                                                            English
                                                                        </option>
                                                                        <option value="ur"
                                                                            {{ $tafseer->lang == 'ur' ? 'selected' : '' }}>
                                                                            Urud
                                                                        </option>
                                                                        <option value="hi"
                                                                            {{ $tafseer->lang == 'hi' ? 'selected' : '' }}>
                                                                            Hindi
                                                                        </option>
                                                                    </select>
                                                                </fieldset>

                                                                <div class="col-12 m-0 p-0">
                                                                    <label for="">Translation</label>

                                                                    <fieldset class="form-group">
                                                                        <textarea class="summernote" id="tafseer-trans-input-{{ $key }}" name="translations[]">{{ $tafseer->tafseer }}</textarea>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12 no-tafseer-div">

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <center>
                                                                No Tafseer Added In This Ayat
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-7 col-lg-8">
                                                    </div>
                                                    <div class="col-md-5 col-lg-4">
                                                        <span onclick="addTafseer('{{ $ayat->id }}')"
                                                            class="btn btn-primary">Add
                                                            Tafseer</span>
                                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="reference-fill"
                                        aria-labelledby="reference-tab-fill" aria-expanded="true">
                                        <div class="row reference-append-inputs">

                                            <div class="col-12 references ">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                                <div class="col-10">
                                                                    <h4 id="reference-saved-span"
                                                                        style="display:none">
                                                                        <span class="badge badge-success "><i
                                                                                class="fa fa-check">Translation
                                                                                Saved</i></span>
                                                                    </h4>
                                                                </div>

                                                            </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="table bordered">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <th>Book Title</th>
                                                                            <th>Type</th>
                                                                            <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="ref-table">
                                                                            @forelse ($ayat->references as $key=>$reference)
                                                                                <tr class=""
                                                                                    id="ref-tr-{{ $key }}">
                                                                                    <td>{{ $reference->reference_title }}
                                                                                    </td>
                                                                                    <td>{{ $reference->type == 1 ? 'eBook' : '' }}{{ $reference->type == 2 ? 'Audio Book' : '' }}
                                                                                        {{ $reference->type == 3 ? 'Audio Book' : '' }}
                                                                                    </td>
                                                                                    <td><i class="fa fa-trash"
                                                                                            onclick="deleteReference('{{ $ayat->id }}', '{{ $reference->_id }}' , '{{ $key }}')"></i>
                                                                                    </td>
                                                                                </tr>
                                                                            @empty
                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td>
                                                                                        <center>
                                                                                            No Reference Added In This Ayat
                                                                                        </center>
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            @endforelse
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- <p>Book : <b>{{ $reference->reference_title }}</b> </p>

                                                        <p>Type :
                                                            <b>b>
                                                        </p> --}}



                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-7">
                                                    </div>
                                                    <div class="col-md-6 col-lg-5">
                                                        <span onclick="addReference('{{ $ayat->id }}')"
                                                            class="btn btn-primary">Add
                                                            Reference</span>
                                                        <button type="submit" class="btn btn-primary ">Submit</button>
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
                                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                                            <span class="menu-item"
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
