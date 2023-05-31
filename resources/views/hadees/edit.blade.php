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
                                                <form class="form form-vertical" action="{{ route('hadith.store') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-body">
                                                        <div class="row append-inputs">

                                                            <div class="col-12">
                                                                <input type="hidden" name="book_id" id=""
                                                                    value="{{ $hadeesBook->id }}">
                                                                <label for="">Hadith</label>
                                                                <fieldset class="form-group">
                                                                    <textarea class="summernote" name="hadith">{{ $hadees->hadees }}</textarea>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-12">

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

                                        <div class="row hadith-append-inputs">
                                            @forelse ($hadees->translations as $key => $trans)
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
                                            @endforelse
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                    </div>
                                                    <div class="col-md-5">

                                                        <span onclick="addHadithTranslation('{{ $hadees->id }}')"
                                                            class="btn btn-primary">Add
                                                            Translation</span>
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

                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
