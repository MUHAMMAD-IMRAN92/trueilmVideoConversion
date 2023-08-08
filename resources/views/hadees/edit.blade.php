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
    .select2.select2-container.select2-container--default{
        width: 100% !important;
    }
</style>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">

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
                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="">{{ $hadeesBook->title }}</h1>
                            <h6 class="">{{ $hadeesBook->description }}</h6>
                        </div>
                    </div>
                    <div class="content-body">
                        <!-- Basic Vertical form layout section start -->
                        <div class="row">
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">

                                            <ul class="nav nav-pills nav-fill">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab-fill" data-toggle="pill"
                                                        href="#home-fill" aria-expanded="true">Hadith</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="translation-tab-fill" data-toggle="pill"
                                                        href="#translation-fill" aria-expanded="true">Add Translation</a>
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

                        </div>
                        <div class="row ">
                            <div class="col-md-9">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home-fill"
                                        aria-labelledby="home-tab-fill" aria-expanded="true">
                                        <div class="card">
                                            <div class="card-body">
                                                <form class="form form-vertical" action="{{ route('hadith.update') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-body">

                                                        <div class="row append-inputs">

                                                            <input type="hidden" name="book_id" id=""
                                                                value="{{ $hadeesBook->id }}">
                                                            <input type="hidden" name="hadees_id" id=""
                                                                value="{{ $hadees->id }}">
                                                            {{-- <div class="col-12">
                                                                <label for="">Hadith</label>
                                                                <fieldset class="form-group">
                                                                    <textarea class="" cols="110" rows="8" style="text-align: right;" name="hadith">{{ $hadees->hadees }}</textarea>
                                                                </fieldset>
                                                            </div> --}}
                                                            <div class="col-12">
                                                                <label for="">Hadith</label>
                                                                <fieldset class="form-group">
                                                                    <textarea class="form-control" rows="8" name="hadith">{{ $hadees->hadees }}</textarea>
                                                                </fieldset>
                                                            </div>
                                                            {{-- <div class="col-12">

                                                                <label for="">Type</label>
                                                                <fieldset class="form-group">
                                                                    <select class="select2 form-control" name="type"
                                                                        id="basicSelect" value=" {{ $hadees->type }}">
                                                                        <option value="1"
                                                                            {{ $hadees->type == 1 ? 'selected' : '' }}>
                                                                            Hadees-e-Qudsi</option>
                                                                        <option value="2"
                                                                            {{ $hadees->type == 2 ? 'selected' : '' }}>
                                                                            Hadees-e-Zaeef</option>
                                                                        <option
                                                                            value="3"{{ $hadees->type == 3 ? 'selected' : '' }}>
                                                                            Hadees-e-Sahih</option>
                                                                    </select>
                                                                </fieldset>
                                                            </div> --}}
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
                                                            <div class="form-group col-md-6 ">
                                                                <label for="basicInputFile">Glossary</label>

                                                                <select class="select2 multiple-select form-control"
                                                                    multiple="multiple" name="glossary[]">
                                                                    @foreach ($glossary as $gloss)
                                                                        <option value="{{ $gloss->_id }}"
                                                                            {{ $contentGlossary->contains('glossary_id', $gloss->id) == true ? 'selected' : '' }}>
                                                                            {{ $gloss->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">

                                                                <label for="">Hadith Chapter</label>
                                                                <fieldset class="form-group">
                                                                    <select class="select2 form-control" name="chapter"
                                                                        id="">
                                                                        <option disabled selected>Hadith Chapter</option>
                                                                        @foreach ($chapter as $ch)
                                                                            <option value="{{ $ch->_id }}"
                                                                                {{ $hadees->chapter_id == $ch->_id ? 'selected' : '' }}>
                                                                                {{ $ch->title }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </fieldset>
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
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="type" id="customRadio1"
                                                                                    value="1"
                                                                                    {{ $hadees->type == 1 ? 'checked' : '' }}>
                                                                                <label class="custom-control-label"
                                                                                    for="customRadio1">
                                                                                    Hadees-e-Sahih</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>
                                                                    <li class="d-inline-block mr-2">
                                                                        <fieldset>
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio"
                                                                                    class="custom-control-input"
                                                                                    name="type" id="customRadio2"
                                                                                    value="2"
                                                                                    {{ $hadees->type == 2 ? 'checked' : '' }}>
                                                                                <label class="custom-control-label"
                                                                                    for="customRadio2">Hadees-e-Zaeef:</label>
                                                                            </div>
                                                                        </fieldset>
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Hadith Number</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        name="hadith_number" class="form-control"
                                                                        value="{{ $hadees->hadith_number }}"
                                                                        placeholder="" required>


                                                                </div>

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
                                    <div role="tabpanel" class="tab-pane" id="translation-fill"
                                        aria-labelledby="translation-tab-fill" aria-expanded="true">
                                        <div class="row">
                                            <div class="col-9"></div>
                                            <div class="col-3"><span data-toggle="modal" data-target="#author-lang"
                                                    class="btn btn-primary">Create New</span></div>
                                        </div>
                                        <br>
                                        <div class="row hadith-append-inputs">
                                            {{-- @forelse ($hadees->translations as $key => $trans)
                                                @php
                                                    $hadeesId = $hadees->id;
                                                    $transId = $trans->id;
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
                                                                        onclick="saveHadithTranslation('{{ $hadeesId }}','{{ $transId }}','{{ $key }}')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>

                                                                    <h4
                                                                        onclick="deleteHadithTranslation('{{ $hadeesId }}','{{ $transId }}','{{ $key }}')">
                                                                        <span class="badge badge-danger ml-1"><i
                                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                            <div class="row ml-1"
                                                                id="non-editble-translation-{{ $key }}">

                                                                <p>Language :
                                                                    <b id="non-edit-lang-select-{{ $key }}">{{ $trans->lang_title }}
                                                                    </b>
                                                                </p>

                                                                <div class="col-12">

                                                                    <span class=""
                                                                        id="non-edit-para-des-{{ $key }}"
                                                                        style="margin-left:10px!important">
                                                                        {!! $trans->translation !!}</span>
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
                                                                                {{ $lang->_id == $trans->lang ? 'selected' : '' }}>
                                                                                {{ $lang->title }}
                                                                            </option>
                                                                        @endforeach

                                                                    </select>
                                                                </fieldset>

                                                                <div class="col-12 m-0 p-0">
                                                                    <label for="">Translation</label>

                                                                    <fieldset class="form-group">
                                                                        <textarea class="summernote" id="trans-input-{{ $key }}" name="translations[]">{{ $trans->translation }}</textarea>
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
                                                                        onclick="saveHadithTranslation('{{ $authlanggId }}','{{ $key }}')">
                                                                        <span class="badge badge-success ml-1"><i
                                                                                class="fa fa-save">&nbspSave</i></span>
                                                                    </h4>
                                                                    @php
                                                                        $translation = $hadees->translations->where('author_lang', $authlanggId)->first();
                                                                    @endphp
                                                                    <h4
                                                                        onclick="deleteHadithTranslation('{{ @$translation->_id }}','{{ $authlanggId }}','{{ $key }}' , 1)">
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
                                                                        value="{{ $hadees->_id }}">
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
                                                        {{--
                                                        <span onclick="addHadithTranslation('{{ $hadees->id }}')"
                                                            class="btn btn-primary">Add
                                                            Translation</span> --}}
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
                                                                            @forelse ($hadees->references as $key=>$reference)
                                                                                <tr class="ref-tr"
                                                                                    id="ref-tr-{{ $key }}">
                                                                                    <td>{{ $reference->reference_title }}
                                                                                    </td>
                                                                                    <td>{{ $reference->type == 1 ? 'eBook' : '' }}{{ $reference->type == 2 ? 'Audio Book' : '' }}
                                                                                        {{ $reference->type == 3 ? 'Audio Book' : '' }}
                                                                                    </td>
                                                                                    <td><i class="fa fa-trash"
                                                                                            onclick="deleteReference('{{ $hadees->id }}', '{{ $reference->_id }}' , '{{ $key }}')"></i>
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
                                                        <span onclick="addReference('{{ $hadees->id }}')"
                                                            class="btn btn-primary">Add
                                                            Reference</span>
                                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-3 col-3 ayat-data">
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
                        </div>


                    </div>
                    <div class="modal fade bd-example-modal-lg" id="author-lang" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <form action="{{ url('/author_lang') }}" method="POST">
                                <div class="form-body">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Author - Language</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-12">

                                                    <label for="">Author</label>
                                                    <fieldset class="form-group">
                                                        <select class="select2 form-control" name="author"
                                                            id="">

                                                            @foreach ($author as $auth)
                                                                <option value="{{ $auth->_id }}">
                                                                    {{ $auth->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </fieldset>
                                                </div>
                                                <div class="col-12">


                                                    <label for="">Language</label>
                                                    <fieldset class="form-group">
                                                        <select class="select2 form-control" name="lang"
                                                            id="">
                                                            @foreach ($languages as $lang)
                                                                <option value="{{ $lang->_id }}">
                                                                    {{ $lang->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </fieldset>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
