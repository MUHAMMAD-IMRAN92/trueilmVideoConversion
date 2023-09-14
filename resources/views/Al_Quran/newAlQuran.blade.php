@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <div class="row  d-flex">
                        <div class="col-8">
                            <h2 class="content-header-title float-left mb-0">Surah</h2>
                        </div>
                        <div class="col-4 d-flex flex-row-reverse">
                            <form action="{{ url('/all_surah_translations') }}" method="GET">
                                <div class="form-label-group">
                                    <select class="select2 form-control" name="surah" id="" >
                                        <option selected disabled>Select
                                            Surah
                                        </option>
                                        @foreach ($surahDropDown as $surah)
                                            <option value="{{ $surah->_id }}"
                                                {{ request()->surah == $surah->_id ? 'selected' : '' }}>
                                                {{ $surah->surah . ' : ' . $surah->sequence }}
                                            </option>
                                        @endforeach


                                    </select>
                                    <button class="btn btn-dark" type="submit"> <i class="fa fa-search"></i></button>
                                    <a href="{{ url('/all_surah_translations') }}" class="btn btn-dark"> <i
                                            class="fa fa-close"></i></a>


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
                                    <tr>
                                        <td>{{ $surah->sequence }}.</td>
                                        <td class="product-name" style="font-size: 20px">{{ $surah->surah }}</td>

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
                                            {{-- {{ $surah->combination_translations . '/' . $combinationCount }}</td> --}}
                                        <td class="product-action">
                                            <span class="action-edit"><a
                                                    href="{{ url('surah_translations/' . $surah->_id) }}"><i
                                                        class="fa fa-external-link"></i></a></span>

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
