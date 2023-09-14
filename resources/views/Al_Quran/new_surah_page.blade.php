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

                        <div class="col-10 d-flex ">
                            <form action="{{ url('surah_translations/' . $surah->_id) }}" method="GET">
                                <div class="form-label-group">
                                    <select class="select2 form-control" name="lang" id="">
                                        <option selected disabled>Select
                                            Language
                                        </option>
                                        @foreach ($languages as $lang)
                                            <option value="{{ $lang->_id }}"
                                                {{ request()->lang == $lang->_id ? 'selected' : '' }}>
                                                {{ $lang->title }}
                                            </option>
                                        @endforeach

                                    </select>
                                    <select class="select2 form-control" name="author" id="">
                                        <option selected disabled>Select
                                            Author
                                        </option>
                                        @foreach ($author as $auth)
                                            <option value="{{ $auth->_id }}"
                                                {{ request()->author == $auth->_id ? 'selected' : '' }}>
                                                {{ $auth->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-dark" type="submit"> <i class="fa fa-search"></i></button>
                                    <a href="{{ url('surah_translations/' . $surah->_id) }}" class="btn btn-dark"> <i
                                            class="fa fa-close"></i></a>


                                </div>
                            </form>
                        </div>
                        <div class="col-2 ">
                            <h2 class="content-header-title float-left mb-0 mt-1">{{ $surah->surah }}</h2>
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
                                @foreach ($combinations as $combination)
                                    <tr>


                                        <td class="product-name" style="font-size: 15px">
                                            {{ $combination->language->title . ' - ' . $combination->author->name }}
                                        </td>
                                        {{-- <td class="product-name" style="font-size: 20px">{{ $combination->language->title }}
                                        </td> --}}

                                        <td class="product-price">
                                            {{ count($combination->translations) . '/' . count($surah->ayats) }}</td>
                                        <td class="product-action">
                                            <span class="action-edit"><a
                                                    href="{{ url('surah/translations/' . $surah->_id . '/' . $combination->_id) }}"><i
                                                        class="fa fa-external-link"></i></a></span>

                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-2 mr-2" style="display:flex;flex-direction:column;align-items:end;">
                        {!! $combinations->links() !!}
                    </div>
                    <!-- DataTable ends -->


                </section>
                <!-- Data list view end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
