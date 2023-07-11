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
            @if (\Session::has('dmsg'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p class="mb-0">
                    {{ \Session::get('dmsg') }}
                </p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="feather icon-x-circle"></i></span>
                </button>
            </div>
        @endif
            <section id="basic-vertical-layouts">
                <div class="row">

                    <div class="col-12">
                        <h1 class="">{{ $surah->surah }}</h1>
                        <h6 class="">{!! $surah->description !!}</h6>
                    </div>
                </div>

                <div class="content-body">

                    <!-- Basic Vertical form layout section start -->
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
                                                                <textarea class="" cols="110" rows="8" name="ayat" style="text-align: right;">{{ $ayat->ayat }}</textarea>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">

                                                            <label for="">Juz</label>
                                                            <fieldset class="form-group">
                                                                <select class="form-control" name="juz"
                                                                    id="basicSelect">
                                                                    <option disabled selected>Select juz</option>
                                                                    @foreach ($juzs as $juz)
                                                                        <option
                                                                            {{ $juz->_id == $ayat->para_no ? 'selected' : '' }}
                                                                            value="{{ $juz->_id }}">
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
                                                        <div class="form-group col-md-6 ">
                                                            <label for="basicInputFile">Tags</label>

                                                            <select class="select2 multiple-select form-control"
                                                                multiple="multiple" name="tags[]">
                                                                @foreach ($tags as $tag)
                                                                    <option value="{{ $tag->title }}"
                                                                        {{ $contentTags->contains('tag_id', $tag->id) == true ? 'selected' : '' }}>
                                                                        {{ $tag->title }}</option>
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
                                    <div role="tabpanel" class="tab-pane" id="translation-fill"
                                        aria-labelledby="translation-tab-fill" aria-expanded="true">
                                        <div class="row">
                                            <div class="col-9"></div>
                                            <div class="col-3"><span data-toggle="modal" data-target="#author-lang"
                                                    class="btn btn-primary">Create New</span></div>
                                        </div>
                                        <br>
                                        <div class="row append-inputs">
                                            {{-- @forelse ($ayat->translations as $key => $aya)
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
                                                                    <b id="non-edit-lang-select-{{ $key }}">{{ $aya->lang_title }}
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
                                                                    <select class="select2 form-control" name="langs[]"
                                                                        id="lang-select-{{ $key }}"
                                                                        id="basicSelect">
                                                                        @foreach ($languages as $langkey => $lang)
                                                                            <option value="{{ $lang->_id }}"
                                                                                {{ $lang->_id == $aya->lang ? 'selected' : '' }}>
                                                                                {{ $lang->title }}
                                                                            </option>
                                                                        @endforeach

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
                                                <div class="col-12 " id="no-translation-div" style="display:none">

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <center>
                                                                No Translation Added In This Ayat
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12 " id="no-translation-div">

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <center>
                                                                No Translation Added In This Ayat
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse --}}
                                            @forelse ($authorLanguages as $key => $authLang)
                                                @php
                                                    // $key = $key1 + count($authorLanguages);
                                                    $authlanggId = $authLang->id;
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
                                                                    <h4 id="translation-delete-span-{{ $key }}"
                                                                        style="display:none"> <span
                                                                            class="badge badge-success "><i
                                                                                class="fa fa-check">Translation
                                                                                Deleted</i></span></h4>
                                                                </div>
                                                                <div class="col-4 d-flex">
                                                                    <h4 onclick="editable('{{ $key }}')"><span
                                                                            class="badge badge-info ml-1"><i
                                                                                class="fa fa-pencil">&nbspEdit</i></span>
                                                                    </h4>
                                                                    <h4
                                                                        onclick="saveTranslation('{{ $authlanggId }}','{{ $key }}')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>
                                                                    @php
                                                                        $translation = $ayat->translations
                                                                            ->where('author_lang', $authlanggId)
                                                                            ->where('type', 1)
                                                                            ->first();
                                                                    @endphp
                                                                    <h4
                                                                        onclick="deleteTranslation('{{ @$translation->_id }}','{{ $authlanggId }}','{{ $key }}' , 1)">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-translation-{{ $key }}">

                                                                <p>Author - Language :
                                                                    <b id="non-edit-lang-select-{{ $key }}">{{ $authLang->author->name }}
                                                                        - {{ $authLang->language->title }}
                                                                    </b>
                                                                </p>
                                                                {{-- <p>Language :
                                                                    <b id="non-edit-lang-select-{{ $key }}">
                                                                    </b>
                                                                </p> --}}

                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="non-edit-para-des-{{ $key }}"
                                                                        style="margin-left:10px!important">
                                                                        {{ @$translation->translation }}</span>
                                                                    <input type="hidden"
                                                                        id="ayat-id-{{ $key }}"
                                                                        value="{{ request()->ayat_id }}">
                                                                    <input type="hidden"
                                                                        id="trans-id-{{ $key }}"
                                                                        value="{{ @$translation->_id }}">
                                                                    <input type="hidden" id="type-{{ $key }}"
                                                                        value="1">
                                                                </div>

                                                            </div>
                                                            <div class="row m-0 p-0" id="editble-{{ $key }}"
                                                                style="display:none">
                                                                {{-- <label for="">Language</label> --}}
                                                                {{-- <fieldset class="form-group">
                                                                    <select class="select2 form-control" name="langs[]"
                                                                        id="lang-select-{{ $key }}"
                                                                        id="basicSelect">
                                                                        @foreach ($languages as $langkey => $lang)
                                                                            <option value="{{ $lang->_id }}"
                                                                                {{ $lang->_id == $aya->lang ? 'selected' : '' }}>
                                                                                {{ $lang->title }}
                                                                            </option>
                                                                        @endforeach

                                                                    </select>
                                                                </fieldset> --}}
                                                                <p>Author - Language :
                                                                    <b id="non-edit-lang-select-{{ $key }}">{{ $authLang->author->name }}
                                                                        - {{ $authLang->language->title }}
                                                                    </b>
                                                                </p>

                                                                <div class="col-12 m-0 p-0">
                                                                    {{-- <label for="">Translation</label> --}}
                                                                    <input type="hidden" name="author_langs[]"
                                                                        value="{{ $authlanggId }}">
                                                                    <fieldset class="form-group">
                                                                        <textarea class="" cols="110" rows="8" id="trans-input-{{ $key }}" name="translations[]">{{ @$translation->translation }}</textarea>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 " id="no-translation-div" style="display:none">

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <center>
                                                                No Translation Added In This Ayat
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12 " id="no-translation-div">

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

                                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tafseer-fill"
                                        aria-labelledby="tafseer-tab-fill" aria-expanded="true">
                                        <div class="row">
                                            <div class="col-9"></div>
                                            <div class="col-3"> <span onclick="addTafseer('{{ $ayat->id }}')"
                                                    class="btn btn-primary" data-toggle="modal"
                                                    data-target="#author-lang">Create New</span></div>
                                        </div>
                                        <br>
                                        <div class="row tafseer-append-inputs">
                                            @forelse ($authorLanguages as $key1 => $authLang)
                                                @php
                                                    $key = $key1 + count($authorLanguages);
                                                    $authlanggId = $authLang->id;
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
                                                                    <h4 id="translation-delete-span-{{ $key }}"
                                                                        style="display:none"> <span
                                                                            class="badge badge-success "><i
                                                                                class="fa fa-check">Translation
                                                                                Deleted</i></span></h4>
                                                                </div>
                                                                <div class="col-4 d-flex">
                                                                    <h4 onclick="editable('{{ $key }}')"><span
                                                                            class="badge badge-info ml-1"><i
                                                                                class="fa fa-pencil">&nbspEdit</i></span>
                                                                    </h4>
                                                                    <h4
                                                                        onclick="saveTranslation('{{ $authlanggId }}','{{ $key }}')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>
                                                                    @php
                                                                        $translation = $ayat->translations
                                                                            ->where('author_lang', $authlanggId)
                                                                            ->where('type', 2)
                                                                            ->first();
                                                                    @endphp
                                                                    <h4
                                                                        onclick="deleteTranslation('{{ @$translation->_id }}','{{ $authlanggId }}','{{ $key }}' , 1)">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-translation-{{ $key }}">

                                                                <p>Author - Language :
                                                                    <b id="non-edit-lang-select-{{ $key }}">{{ $authLang->author->name }}
                                                                        - {{ $authLang->language->title }}
                                                                    </b>
                                                                </p>
                                                                {{-- <p>Language :
                                                                <b id="non-edit-lang-select-{{ $key }}">
                                                                </b>
                                                            </p> --}}
                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="non-edit-para-des-{{ $key }}"
                                                                        style="margin-left:10px!important">
                                                                        {{ @$translation->translation }}</span>
                                                                    <input type="hidden"
                                                                        id="ayat-id-{{ $key }}"
                                                                        value="{{ request()->ayat_id }}">
                                                                    <input type="hidden"
                                                                        id="trans-id-{{ $key }}"
                                                                        value="{{ @$translation->_id }}">
                                                                    <input type="hidden" id="type-{{ $key }}"
                                                                        value="2">
                                                                </div>

                                                            </div>
                                                            <div class="row m-0 p-0" id="editble-{{ $key }}"
                                                                style="display:none">
                                                                {{-- <label for="">Language</label> --}}
                                                                {{-- <fieldset class="form-group">
                                                                <select class="select2 form-control" name="langs[]"
                                                                    id="lang-select-{{ $key }}"
                                                                    id="basicSelect">
                                                                    @foreach ($languages as $langkey => $lang)
                                                                        <option value="{{ $lang->_id }}"
                                                                            {{ $lang->_id == $aya->lang ? 'selected' : '' }}>
                                                                            {{ $lang->title }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </fieldset> --}}
                                                                <p>Author - Language :
                                                                    <b id="non-edit-lang-select-{{ $key }}">{{ $authLang->author->name }}
                                                                        - {{ $authLang->language->title }}
                                                                    </b>
                                                                </p>

                                                                <div class="col-12 m-0 p-0">
                                                                    {{-- <label for="">Translation</label> --}}

                                                                    <fieldset class="form-group">
                                                                        <textarea cols="110" rows="8" id="trans-input-{{ $key }}" name="tafseers[]">{{ @$translation->translation }}</textarea>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 " id="no-translation-div" style="display:none">

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <center>
                                                                No Translation Added In This Ayat
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12 " id="no-translation-div">

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
                                                    <div class="col-md-7 col-lg-8">
                                                    </div>
                                                    <div class="col-md-5 col-lg-4">

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
                                                                <h4 id="reference-saved-span" style="display:none">
                                                                    <span class="badge badge-success "><i
                                                                            class="fa fa-check">Reference
                                                                            Attached</i></span>
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
                                                                                <tr class="ref-tr"
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
                                                                                <tr class="no-reference-tr"
                                                                                    style="display:none">
                                                                                    <td></td>
                                                                                    <td>
                                                                                        No Reference Added In This Ayat
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            @empty
                                                                                <tr class="no-reference-tr">
                                                                                    <td></td>
                                                                                    <td class="ml-2">
                                                                                        No Reference Added In This Ayat
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
                    <div class="modal fade bd-example-modal-lg" id="author-lang" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <form action="{{ url('/author_lang') }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Author - Language</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-12">

                                        </div>
                                        <div class="col-12">
                                            @if (\Session::has('msg'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                    role="alert">
                                                    <p class="mb-0">
                                                        {{ \Session::get('msg') }}
                                                    </p>
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true"><i
                                                                class="feather icon-x-circle"></i></span>
                                                    </button>
                                                </div>
                                            @endif
                                            <label for="">Author</label>
                                            <fieldset class="form-group">
                                                <select class=" select2 form-control" name="author" id="basicSelect1"
                                                    required>
                                                    <option disabled selected>Select Author</option>
                                                    @foreach ($author as $auth)
                                                        <option value="{{ $auth->_id }}">
                                                            {{ $auth->name }}</option>
                                                    @endforeach

                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-12">

                                            <label for="">Languages</label>
                                            <fieldset class="form-group">
                                                <select class=" select2 form-control" name="lang" id="basicSelect2"
                                                    required>
                                                    <option disabled selected>Select Author</option>
                                                    @foreach ($languages as $lang)
                                                        <option value="{{ $lang->_id }}">
                                                            {{ $lang->title }}</option>
                                                    @endforeach

                                                </select>
                                            </fieldset>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </section>


        </div>
    @endsection
