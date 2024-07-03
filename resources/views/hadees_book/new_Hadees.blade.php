@extends('layouts.default_layout')
<style>
    @font-face {
        font-family: 'arabicfontfirst';
        src: url('../../../../../app-assets/fonts/KFGQPCUthmanicScriptHAFS1.woff') format('woff');
    }

    @font-face {
        font-family: 'arabicfontsecond';
        src: url('../../../../app-assets/fonts/ZEENASKHDARUSALAM.woff') format('woff');
    }


    .checkclass {
        font-family: 'arabicfontfirst' !important;
        font-size: 26px;
    }

    .checkclasssecond {
        font-family: 'arabicfontsecond' !important;
        font-size: 24px;
    }

    .arabic-text-alignment {
        text-align: right !important;
        direction: rtl;
    }
</style>


@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
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
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <div class="row d-flex justify-content-center   mb-2">
                        <div class="col-2  mb-2">
                            <h2 class="content-header-title float-left mb-0 mt-1 checkclass">
                                {{ $book->title }}</h2>

                        </div>
                    </div>

                    <div class="row" style="padding: 0px 16px">


                        <div class="col-5 d-flex">

                            <form action="{{ url('/hadith/books/combination/' . $type . '/' . $book->_id) }}"
                                method="GET">
                                <div class="form-label-group">
                                    <select class="select2 form-control" name="lang" id="">
                                        <option selected disabled>Select
                                            Language
                                        </option>
                                        <option value="">All
                                        </option>
                                        @foreach ($languages as $lang)
                                            <option value="{{ $lang->_id }}"
                                                {{ request()->lang == $lang->_id ? 'selected' : '' }}
                                                {{ $currentCombination->lang_id == $lang->_id ? 'selected' : '' }}>
                                                {{ $lang->title }}
                                            </option>
                                        @endforeach

                                    </select>
                                    <select class="select2 form-control" name="author" id="">
                                        <option selected disabled>Select
                                            Author
                                        </option>
                                        <option value="">All
                                        </option>
                                        @foreach ($author as $auth)
                                            <option value="{{ $auth->_id }}"
                                                {{ request()->author == $auth->_id ? 'selected' : '' }}
                                                {{ $currentCombination->author_id == $auth->_id ? 'selected' : '' }}>
                                                {{ $auth->name }}
                                            </option>
                                        @endforeach


                                    </select>
                                    <div class="mt-2">
                                        <button class="btn btn-dark" type="submit"> Search</button>
                                        <a href="{{ url('/hadith/books/combination/' . $type . '/' . $book->_id) }}"
                                            class="btn btn-dark"> Clear</a>
                                    </div>



                                </div>
                            </form>
                        </div>
                        <div class="col-3 d-flex ">
                            {{-- <canvas id="chartId" aria-label="chart" width="106px"></canvas>

                            <script>
                                var second;
                                if ('{{ count($book->hadees) == count($currentCombination->hadith_translations) }}' ||
                                    '{{ count($currentCombination->hadith_translations) }}' == 0) {
                                    second = 0
                                } else {
                                    second = '{{ count($book->hadees) - count($currentCombination->hadith_translations) }}'
                                }
                                var chrt = document.getElementById("chartId").getContext("2d");
                                var chartId = new Chart(chrt, {
                                    type: 'pie',
                                    data: {
                                        labels: ["Translation", "Total Hadith"],
                                        datasets: [{
                                            label: "online tutorial subjects",
                                            data: [second,
                                                '{{ count($book->hadees) }}'
                                            ],
                                            backgroundColor: ['rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                                            hoverOffset: 5
                                        }],
                                    },
                                    options: {
                                        responsive: false,
                                    },
                                });
                            </script> --}}
                        </div>
                        {{-- <div class="col-2 d-flex background pl-3">

                            <div class="mb-0"
                                style="
                                        background: rgb(4, 4, 4);
                                        color: white;
                                        height:75px;
                                        width:75px;
                                        padding: -3px;
                                        border-radius: 40px;
                                        position: relative;
                                        transform:scale(0.8)
                                    ">
                                                                <div
                                                                    style="

                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                            ">
                                                                    <span style="font-size: 18px">{{ count($surah->ayats) }}</span>
                                                                </div>
                                                                <div class="mb-0"
                                                                    style="
                                                            background: rgb(13, 116, 13);
                                                                color: white;
                                                                height: 30opx;
                                                                width: 30opx;
                                                                padding: -3px;
                                                                position: absolute;
                                                                border-radius: 27px;
                                                                left: 28%;
                                                                top: 32%;
                                                        ">
                                                                    <div
                                                                        style="

                                                        display: flex;
                                                        justify-content: center;
                                                        align-items: center;
                                                    ">
                                        <span style="font-size: 18px"
                                            id="translation-count">{{ count($currentCombination->translations) }}</span>
                                    </div>

                                </div>

                            </div>
                        </div> --}}
                        <div class="col-4 d-flex flex-row-reverse">

                            <form
                                action="{{ url('hadith/books/combination/' . $type . '/' . $book->_id . '/' . $currentCombination->_id) }}"
                                method="GET">
                                <div class="form-label-group">
                                    <select class="select2 form-control get_ayat" name="ayat_id" id="">
                                        <option selected disabled>Select
                                            Hadith
                                        </option>
                                        <option value="All">All</option>
                                        @foreach ($hadiths as $hadith)
                                            <option style="height: fit-content;width:inherit" class="   "
                                                value="{{ $hadith->_id }}"
                                                {{ request()->aya == $hadith->_id ? 'selected' : '' }}>
                                                {{ $hadith->hadees }}
                                            </option>
                                        @endforeach


                                    </select>
                                    <div class="mt-2">
                                        <button class="btn btn-dark search_hadith" type="button"> Search</button>
                                        <button class="btn btn-dark search_clear" type="button"> Clear</button>
                                        <!-- <a href="{{ url('hadith/books/combination/' . $type . '/' . $book->_id . '/' . $currentCombination->_id) }}"
                                            class="btn btn-dark">Clear</i></a> -->
                                        <a href="{{ url('hadith/create/' . $type . '/' . $book->_id . '/' . $currentCombination->_id) }}"
                                            class="btn btn-dark">Add
                                            Hadith</i></a>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Data list view starts -->
                <section id="data-list-view" class="data-list-view-header">


                    <!-- DataTable starts -->
                    <div class="table-responsive">
                        <table class="table data-list-view">
                            <input type="hidden" id="book_id" value="{{ $book->_id }}">

                            <tbody>
                                @if ($type == 4)
                                    <div class="col-12 lang translation-div--1">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" id="ayat-id--1" value="{{ $book->_id }}">
                                                    <h4 id="translation-saved-span--1" style="display:none">
                                                        <span class="badge badge-success "><i
                                                                class="fa fa-check">Translation
                                                                Saved</i></span>
                                                    </h4>
                                                    <h4 id="translation-delete-span--1" style="display:none">
                                                        <span class="badge badge-success "><i
                                                                class="fa fa-check">Translation
                                                                Deleted</i></span>
                                                    </h4>
                                                </div>

                                                <div class="row d-flex">
                                                    <h4 id="edit-button--1" onclick="editable('-1')">
                                                        <span class="badge badge-info ml-1"><i class="fa fa-pencil"
                                                                style="cursor: pointer;">&nbspEdit</i></span>
                                                    </h4>

                                                    <h4
                                                        onclick="saveHadithTranslation('{{ $currentCombination->_id }}','-1', '0')">
                                                        <span class="badge badge-success ml-1" id="save-button--1"
                                                            style="cursor: pointer; display:none"><i
                                                                class="fa fa-save">&nbspSave</i></span>
                                                    </h4>

                                                    <h4
                                                        onclick="deleteHadithTranslation('{{ @$book->introduction->_id }}','{{ $currentCombination->_id }}','-1', '0')">
                                                        <span class="badge badge-danger ml-1" id="delete-button--1"
                                                            style="cursor: pointer; display:none"><i
                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                    </h4>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12 checkclass" id="non-editble-translation--1">
                                                        <div class="row d-flex flex-row-reverse pr-2"
                                                            style="align-items:center;gap:12px;">


                                                            <p id="non-edit-lang-select--1" class="mt-1"
                                                                style="text-align: right; line-height:50px">
                                                                <b>Introduction</b>

                                                            </p>

                                                        </div>

                                                        <div class="col-12 mt-2"
                                                            style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') display: flex;flex-direction: column;align-content: end;margin-right:3%; @endif">


                                                            <input type="hidden" id="ayat-id--1"
                                                                value="{{ request()->ayat_id }}">
                                                            <input type="hidden" id="trans-id--1"
                                                                value="{{ @$book->translations[0]->translation }}">
                                                            <input type="hidden" id="type--1" value="-1">
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row ml-1"
                                                    style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') display: flex;flex-direction: column;align-content: end;margin-right:3%; @endif">

                                                    <span class="" id="non-edit-para-des--1"
                                                        style="margin-left:10px!important; ">
                                                        {{ @$book->introduction->translation }}</span>
                                                </div>

                                                <div id="editble--1" style="display:none">
                                                    <div class="row checkclass" style=" text-align:right"
                                                        id="editble--1">

                                                        <div class="col-12">

                                                            <p id="non-edit-lang-select--1">
                                                                <b>Introduction</b>

                                                            </p>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12" id="textarea-div--1">

                                                            <input type="hidden" name="author_langs[]"
                                                                value="{{ $currentCombination->_id }}">
                                                            <fieldset class="form-group">
                                                                <textarea class="form-control" rows="8" style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') text-align:right; @endif"
                                                                    id="trans-input--1" name="translations[]"> {{ @$book->introduction->translation }}</textarea>
                                                            </fieldset>
                                                        </div>

                                                        <div class="spinner-grow text-dark"
                                                            style="margin-left:50% !important;display:none"
                                                            id="spinner-grow--1"></div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @foreach ($hadiths as $key => $hadith)
                                    <div class="col-12 lang all_hide show_{{$hadith->_id}}  translation-div-{{ $key }}">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">
                                                    <input type="hidden" id="ayat-id-{{ $key }}"
                                                        value="{{ $hadith->_id }}">
                                                    <h4 id="translation-saved-span-{{ $key }}"
                                                        style="display:none"> <span class="badge badge-success "><i
                                                                class="fa fa-check">Translation
                                                                Saved</i></span></h4>
                                                    <h4 id="translation-delete-span-{{ $key }}"
                                                        style="display:none"> <span class="badge badge-success "><i
                                                                class="fa fa-check">Translation
                                                                Deleted</i></span></h4>
                                                </div>

                                                <div class="row d-flex">
                                                    <h4 id="edit-button-{{ $key }}"
                                                        onclick="editable('{{ $key }}')">
                                                        <span class="badge badge-info ml-1"><i class="fa fa-pencil"
                                                                style="cursor: pointer;">&nbspEdit Translation</i></span>
                                                    </h4>
                                                    @if ($type == 4)
                                                        <h4 id="revelation-edit-button-{{ $key }}"
                                                            onclick="editableRevelation('{{ $key }}')">
                                                            <span class="badge badge-info ml-1"><i class="fa fa-pencil"
                                                                    style="cursor: pointer;">&nbspEdit
                                                                    Revelation</i></span>
                                                        </h4>
                                                        <h4
                                                            onclick="saveHadithTranslation('{{ $currentCombination->_id }}','{{ $key }}', '4')">
                                                            <span class="badge badge-success ml-1"
                                                                id="revelation-save-button-{{ $key }}"
                                                                style="cursor: pointer; display:none"><i
                                                                    class="fa fa-save">&nbspSave</i></span>
                                                        </h4>

                                                        <h4
                                                            onclick="deleteHadithTranslation('{{ @$hadith->revelation[0]->_id }}','{{ $currentCombination->_id }}','{{ $key }}' ,{{ $type }})">
                                                            <span class="badge badge-danger ml-1"
                                                                id="revelation-delete-button-{{ $key }}"
                                                                style="cursor: pointer; display:none"><i
                                                                    class="fa fa-trash">&nbspDelete</i></span>
                                                        </h4>
                                                    @endif
                                                    @if ($type == 3)
                                                        <h4 id="notes-edit-button-{{ $key }}"
                                                            onclick="editableNotes('{{ $key }}')">
                                                            <span class="badge badge-info ml-1"><i class="fa fa-pencil"
                                                                    style="cursor: pointer;">&nbspEdit
                                                                    Notes</i></span>
                                                        </h4>
                                                        <h4
                                                            onclick="saveHadithTranslation('{{ $currentCombination->_id }}','{{ $key }}', '3')">
                                                            <span class="badge badge-success ml-1"
                                                                id="notes-save-button-{{ $key }}"
                                                                style="cursor: pointer; display:none"><i
                                                                    class="fa fa-save">&nbspSave</i></span>
                                                        </h4>

                                                        <h4
                                                            onclick="deleteHadithTranslation('{{ @$hadith->notes[0]->_id }}','{{ $currentCombination->_id }}','{{ $key }}' ,{{ $type }})">
                                                            <span class="badge badge-danger ml-1"
                                                                id="notes-delete-button-{{ $key }}"
                                                                style="cursor: pointer; display:none"><i
                                                                    class="fa fa-trash">&nbspDelete</i></span>
                                                        </h4>
                                                    @endif
                                                    @php
                                                        $tranlation_type = 1;
                                                        if ($type == 3) {
                                                            $tranlation_type = 5;
                                                        } else {
                                                            $tranlation_type = 6;
                                                        }
                                                    @endphp
                                                    <h4
                                                        onclick="saveHadithTranslation('{{ $currentCombination->_id }}','{{ $key }}', {{ $tranlation_type }})">
                                                        <span class="badge badge-success ml-1"
                                                            id="save-button-{{ $key }}"
                                                            style="cursor: pointer; display:none"><i
                                                                class="fa fa-save">&nbspSave</i></span>
                                                    </h4>

                                                    <h4
                                                        onclick="deleteHadithTranslation('{{ @$hadith->translations[0]->_id }}','{{ $currentCombination->_id }}','{{ $key }}' ,{{ $tranlation_type }})">
                                                        <span class="badge badge-danger ml-1"
                                                            id="delete-button-{{ $key }}"
                                                            style="cursor: pointer; display:none"><i
                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                    </h4>


                                                </div>
                                                <div class="row">
                                                    <div class="col-12 checkclasssecond"
                                                        id="non-editble-translation-{{ $key }}">
                                                        <div class="row d-flex flex-row-reverse pr-2"
                                                            style="align-items:center;gap:12px;">

                                                            <div class="" style="text-align: right;">
                                                                {{ $hadith->sequence }} </div>

                                                            <p id="non-edit-lang-select-{{ $key }}"
                                                                class="mt-1 checkclasssecond arabic-text-alignment"
                                                                style="text-align: left; line-height:50px;">
                                                                {!! nl2br($hadith->hadees) !!}

                                                            </p>

                                                        </div>

                                                        <div class="col-12 mt-2"
                                                            style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') display: flex;flex-direction: column;align-content: end;margin-right:3%; @endif">


                                                            <input type="hidden" id="ayat-id-{{ $key }}"
                                                                value="{{ request()->ayat_id }}">

                                                            <input type="hidden" id="type-{{ $key }}"
                                                                value="{{ $type }}">
                                                        </div>

                                                    </div>
                                                </div> @php
                                                    if ($type == 3) {
                                                        $title = '~ Translation ~';
                                                    } else {
                                                        $title = '~ Tafseer ~';
                                                    }
                                                @endphp

                                                <b class="mr-1"> {{ $title }}</b>
                                                <div class="row ml-1"
                                                    style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') display: flex;flex-direction: column;align-content: end;margin-right:3%; @endif">

                                                    <span class="" id="non-edit-para-des-{{ $key }}"
                                                        style="margin-left:10px!important; ">

                                                        {{ @$hadith->translations[0]->translation }}
                                                    </span>
                                                </div>
                                                @if ($type == 4)
                                                    <b class="mr-1"> ~ Revelation ~</b>
                                                    <div class="row ml-1 mt-2"
                                                        style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') display: flex;flex-direction: column;align-content: end;margin-right:3%; @endif">

                                                        <span class="" id="bold-revelation-{{ $key }}"
                                                            style="margin-left:10px!important; ">
                                                            <br>
                                                            {{ @$hadith->revelation[0]->translation }}</span>
                                                    </div>
                                                @endif
                                                @if ($type == 3)
                                                    <b class="mr-1">~ Notes ~</b>

                                                    <div class="row ml-1 mt-2"
                                                        style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') display: flex;flex-direction: column;align-content: end;margin-right:3%; @endif">

                                                        <span class="" id="bold-notes-{{ $key }}"
                                                            style="margin-left:10px!important; ">

                                                            {{ @$hadith->notes[0]->translation }}</span>
                                                    </div>
                                                @endif
                                                <div id="editble-{{ $key }}" style="display:none">
                                                    <div class="row checkclass" style=" text-align:right"
                                                        id="editble-{{ $key }}">

                                                        <div class="col-12">

                                                            <p id="non-edit-lang-select-{{ $key }}">
                                                                {{ $hadith->hadees }}

                                                            </p>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="trans-id-{{ $key }}"
                                                        value="{{ @$hadith->translations[0]->translation }}">
                                                    <div class="row">
                                                        <div class="col-12" id="textarea-div-{{ $key }}">
                                                            {{-- <label for="">Translation</label> --}}
                                                            <input type="hidden" name="author_langs[]"
                                                                value="{{ $currentCombination->_id }}">
                                                            <fieldset class="form-group">
                                                                <textarea class="form-control" rows="8" style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') text-align:right; @endif"
                                                                    id="trans-input-{{ $key }}" name="translations[]">{{ @$hadith->translations[0]->translation }}</textarea>
                                                            </fieldset>
                                                        </div>




                                                    </div>
                                                </div>
                                                <div id="revelation-editble-{{ $key }}" style="display:none">
                                                    <div class="row checkclass" style=" text-align:right"
                                                        id="editble-{{ $key }}">

                                                        <div class="col-12">

                                                            <p id="non-edit-lang-select-{{ $key }}">
                                                                {{ $hadith->hadees }}

                                                            </p>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="revelation-trans-id-{{ $key }}"
                                                        value="{{ @$hadith->translations[0]->translation }}">
                                                    <div class="row">
                                                        <div class="col-12" id="textarea-div-{{ $key }}">
                                                            {{-- <label for="">Translation</label> --}}
                                                            <input type="hidden" name="author_langs[]"
                                                                value="{{ $currentCombination->_id }}">
                                                            <fieldset class="form-group">
                                                                <textarea class="form-control" rows="8" style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') text-align:right; @endif"
                                                                    id="revelation-trans-input-{{ $key }}" name="translations[]">{{ @$hadith->revelation[0]->translation }}</textarea>
                                                            </fieldset>
                                                        </div>




                                                    </div>
                                                </div>
                                                <div class="spinner-grow text-dark"
                                                    style="margin-left:50% !important;display:none"
                                                    id="spinner-grow-{{ $key }}"></div>
                                                <div id="notes-editble-{{ $key }}" style="display:none">
                                                    <div class="row checkclass" style=" text-align:right"
                                                        id="editble-{{ $key }}">

                                                        <div class="col-12">

                                                            <p id="non-edit-lang-select-{{ $key }}">
                                                                {{ $hadith->hadees }}

                                                            </p>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="notes-trans-id-{{ $key }}"
                                                        value="{{ @$hadith->translations[0]->translation }}">
                                                    <div class="row">
                                                        <div class="col-12" id="textarea-div-{{ $key }}">

                                                            <input type="hidden" name="author_langs[]"
                                                                value="{{ $currentCombination->_id }}">
                                                            <fieldset class="form-group">
                                                                <textarea class="form-control" rows="8" style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') text-align:right; @endif"
                                                                    id="notes-trans-input-{{ $key }}" name="translations[]">{{ @$hadith->notes[0]->translation }}</textarea>
                                                            </fieldset>
                                                        </div>




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-2 mr-2" style="display:flex;flex-direction:column;align-items:end;">
                        {!! $hadiths->links() !!}
                    </div>
                    <!-- DataTable ends -->


                </section>
                <!-- Data list view end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
