@extends('layouts.default_layout')

@section('content')
    <style>
        @font-face {
            font-family: 'arabicfontfirst';
            src: url('../../../../../app-assets/fonts/KFGQPCUthmanicScriptHAFS1.woff') format('woff');
        }


        @font-face {
            font-family: 'arabicfontsecond';
            src: url('../../../../app-assets/fonts/ZEENASKHDARUSALAM.woff') format('woff');
        }

        @font-face {
            font-family: 'indopak';
            src: url('../../../../app-assets/fonts/ indopak-nastaleeq-waqf-lazim-v4.2.1.woff') format('woff');
        }

        .checkclass {
            font-family: 'arabicfontfirst' !important;
            font-size: 26px;
        }

        .checkclasssecond {
            font-family: 'arabicfontsecond' !important;
        }

        .checkclassthird {
            font-family: 'indopak' !important;
            font-size: 26px;
        }
    </style>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <div class="row  d-flex">
                        <div class="col-6">
                            <h2 class="content-header-title float-left mb-0 ml-1">Surah</h2>
                        </div>
                        <div class="col-5 d-flex flex-row-reverse"style="margin-left: 7.5%; ">
                            <form action="{{ url('all_surah_translations/' . $content_type) }}" method="GET"
                                class="">
                                <div class="form-label-group">
                                    <select class="select2 form-control checkclassthird" name="surah" id="">
                                        <option selected disabled>Select
                                            Surah
                                        </option>
                                        <option value="">All
                                        </option>
                                        @foreach ($surahDropDown as $surah)
                                            <option value="{{ $surah->_id }}"
                                                {{ request()->surah == $surah->_id ? 'selected' : '' }}>
                                                {{ $surah->surah . ' : ' . $surah->sequence }}
                                            </option>
                                        @endforeach


                                    </select>
                                    <button class="btn btn-dark" type="submit"> Search</button>
                                    <a href="{{ url('all_surah_translations/' . $content_type) }}" class="btn btn-dark">
                                        Clear</a>

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
                                @foreach ($surahs as $surah)
                                    <tr
                                        onclick="document.location ='{{ url('surah_translations/' . $content_type . '/' . $surah->surah_id) }}';">
                                        <td>{{ $surah->sequence }}.</td>
                                        <td class="product-name checkclassthird" style="font-size: 20px">{{ $surah->title }}
                                        </td>

                                        <td>
                                            @php
                                                $class = 'success';
                                                $type = 'Madni Surah';
                                                if ($surah->type == '1') {
                                                    $class = 'dark';
                                                    $type = 'Makki Surah';
                                                }

                                            @endphp

                                            <div class="chip chip-{{ $class }}">
                                                <div class="chip-body">
                                                    <div class="chip-text">{{ $type }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="product-price">
                                            @php
                                                $count = 0;
                                                if ($content_type == 1) {
                                                    $count = $surah->translation_count ?? 0;
                                                } elseif ($content_type == 2) {
                                                    $count = $surah->tafseer_count ?? 0;
                                                } else {
                                                    $count = $surah->audio_count ?? 0;
                                                }
                                            @endphp
                                            {{ $count . '/' . $combinationCount }}</td>
                                        <td class="product-action">
                                            <span class="action-edit"><i class="fa fa-external-link"></i></span>

                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-2 mr-2" style="display:flex;flex-direction:column;align-items:end;">
                        {!! $surahs->links() !!}
                    </div>
                    <!-- DataTable ends -->


                </section>
                <!-- Data list view end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
