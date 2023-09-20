@extends('layouts.default_layout')
<style>
    @font-face {
        font-family: 'arabicfontfirst';
        src: url('../../../../app-assets/fonts/UTHMANICHAFS1VER18.woff') format('woff');
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
                                {{ $surah->surah }}</h2>

                        </div>
                    </div>

                    <div class="row" style="padding: 0px 16px">


                        <div class="col-5 d-flex">

                            <form action="{{ url('surah_translations/' . $type . '/' . $surah->_id) }}" method="GET">
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
                                        <a href="{{ url('surah_translations/' . $type . '/' . $surah->_id) }}"
                                            class="btn btn-dark"> Clear</a>
                                    </div>



                                </div>
                            </form>
                        </div>
                        <div class="col-2 d-flex pl-3">
                            <canvas id="chartId" aria-label="chart" width="100px"></canvas>

                            <script>
                                var chrt = document.getElementById("chartId").getContext("2d");
                                var chartId = new Chart(chrt, {
                                    type: 'doughnut',
                                    data: {
                                        // labels: ["HTML", "CSS", "JAVASCRIPT", "CHART.JS", "JQUERY", "BOOTSTRP"],
                                        datasets: [{
                                            label: "online tutorial subjects",
                                            data: ['{{ count($currentCombination->translations) }}',
                                                '{{ count($surah->ayats) }}'
                                            ],
                                            backgroundColor: ['rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
                                            hoverOffset: 5
                                        }],
                                    },
                                    options: {
                                        responsive: false,
                                    },
                                });
                            </script>
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
                        <div class="col-5 d-flex flex-row-reverse">

                            <form
                                action="{{ url('/surah/translations/' . $type . '/' . $surah->_id . '/' . $currentCombination->_id) }}"
                                method="GET">
                                <div class="form-label-group">
                                    <select class="select2 form-control" name="ayat_id" id="" style="width: 320px">
                                        <option selected disabled>Select
                                            Surah
                                        </option>
                                        <option value="">All
                                        </option>
                                        @foreach ($surah->ayats as $aya)
                                            <option style="height: fit-content;width:inherit" class="checkclass" value="{{ $aya->_id }}"
                                                {{ request()->aya == $aya->_id ? 'selected' : '' }}>
                                                {{ $aya->sequence . ' : ' . $aya->ayat }}
                                            </option>
                                        @endforeach


                                    </select>
                                    <div class="mt-2">
                                        <button class="btn btn-dark" type="submit"> Search</button>
                                        <a href="{{ url('surah/translations/' . $type . '/' . $surah->_id . '/' . $currentCombination->_id) }}"
                                            class="btn btn-dark">Clear</i></a>
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

                            <tbody>
                                @foreach ($ayats as $key => $aya)
                                    <div class="col-12 lang translation-div-{{ $key }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <input type="hidden" id="ayat-id-{{ $key }}"
                                                        value="{{ $aya->_id }}">
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
                                                    <h4 onclick="editable('{{ $key }}')">
                                                        <span class="badge badge-info ml-1"><i class="fa fa-pencil"
                                                                style="cursor: pointer;">&nbspEdit</i></span>
                                                    </h4>
                                                    <h4
                                                        onclick="saveTranslation('{{ $currentCombination->_id }}','{{ $key }}', {{ $type }})">
                                                        <span class="badge badge-success ml-1"><i class="fa fa-save"
                                                                style="cursor: pointer;">&nbspSave</i></span>
                                                    </h4>

                                                    <h4
                                                        onclick="deleteTranslation('{{ @$aya->translations[0]->_id }}','{{ $currentCombination->_id }}','{{ $key }}' ,{{ $type }})">
                                                        <span class="badge badge-danger ml-1" style="cursor: pointer;"><i
                                                                class="fa fa-trash">&nbspDelete</i></span>
                                                    </h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 checkclass"
                                                        id="non-editble-translation-{{ $key }}">
                                                        <div class="row d-flex flex-row-reverse pr-2"
                                                            style="align-items:center;gap:12px;">

                                                            <div class="" style="text-align: right;">:
                                                                {{ $aya->sequence }} </div>

                                                            <p id="non-edit-lang-select-{{ $key }}"
                                                                class="mt-1"
                                                                style="text-align: right; line-height:50px">
                                                                {{ $aya->ayat }}

                                                            </p>

                                                        </div>

                                                        <div class="col-12 mt-2"
                                                            style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') display: flex;flex-direction: column;align-content: end; @endif">


                                                            <input type="hidden" id="ayat-id-{{ $key }}"
                                                                value="{{ request()->ayat_id }}">
                                                            <input type="hidden" id="trans-id-{{ $key }}"
                                                                value="{{ @$aya->translations[0]->translation }}">
                                                            <input type="hidden" id="type-{{ $key }}"
                                                                value="{{ $type }}">
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row ml-1"
                                                    style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') display: flex;flex-direction: column;align-content: end; @endif">

                                                    <span class="" id="non-edit-para-des-{{ $key }}"
                                                        style="margin-left:10px!important; ">
                                                        {{ @$aya->translations[0]->translation }}</span>
                                                </div>

                                                <div id="editble-{{ $key }}" style="display:none">
                                                    <div class="row checkclass" style=" text-align:right"
                                                        id="editble-{{ $key }}">

                                                        <div class="col-12">

                                                            <p id="non-edit-lang-select-{{ $key }}">
                                                                {{ $aya->ayat }}

                                                            </p>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12" id="textarea-div-{{ $key }}">
                                                            {{-- <label for="">Translation</label> --}}
                                                            <input type="hidden" name="author_langs[]"
                                                                value="{{ $currentCombination->_id }}">
                                                            <fieldset class="form-group">
                                                                <textarea class="form-control" rows="8" style="@if ($currentCombination->language->title == 'Urdu' || $currentCombination->language->title == 'Arabic') text-align:right; @endif"
                                                                    id="trans-input-{{ $key }}" name="translations[]">{{ @$aya->translations[0]->translation }}</textarea>
                                                            </fieldset>
                                                        </div>

                                                        <div class="spinner-grow text-dark"
                                                            style="margin-left:50% !important;display:none"
                                                            id="spinner-grow-{{ $key }}"></div>


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
                        {!! $ayats->links() !!}
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
