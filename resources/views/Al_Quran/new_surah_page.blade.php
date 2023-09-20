@extends('layouts.default_layout')

@section('content')
    <style>
        #author-lang .select2.select2-container.select2-container--default {
            width: 100% !important;
        }
    </style>
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
                    <div class="row  d-flex">

                        <div class="col-10 d-flex ">
                            <form action="{{ url('surah_translations/' . $type . '/' . $surah->_id) }}" method="GET">

                                <select class="select2 form-control " name="lang" id="">
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

                                <select class="select2 form-control " name="author" id="">
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
                                <br>
                                <span>
                                    <button class="btn btn-dark" type="submit">Search</button>
                                    <a href="{{ url('surah_translations/' . $type . '/' . $surah->_id) }}"
                                        class="btn btn-dark">
                                        Clear</a> <span class="btn btn-dark " data-toggle="modal"
                                        data-target="#author-lang"> Add
                                        New</span>
                                </span>

                        </div>
                        </form>

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
                                <tr class="m-0 p-0"
                                    style="background-color: transparent !important; box-shadow:none !important;">
                                    <td class="product-name" style="font-size: 15px">
                                        Language
                                    </td>
                                    <td class="product-name" style="font-size: 15px">
                                        Author
                                    </td>
                                    <td class="product-name"></td>
                                    <td class="product-name"></td>

                                </tr>
                                @foreach ($combinations as $combination)
                                    <tr
                                        onclick="document.location ='{{ url('surah/translations/' . $type . '/' . $surah->_id . '/' . $combination->_id) }}';">


                                        <td class="product-name" style="font-size: 15px">
                                            {{ $combination->language->title }}
                                        </td>
                                        <td class="product-name" style="font-size: 15px">
                                            {{ $combination->author->name }}
                                        </td>
                                        {{-- <td class="product-name" style="font-size: 20px">{{ $combination->language->title }}
                                        </td> --}}

                                        <td class="product-price">
                                            {{ count($combination->translations) . '/' . count($surah->ayats) }}</td>
                                        <td class="product-action">
                                            <span class="action-edit"><i class="fa fa-external-link"></i></span>

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

        <div class="modal fade bd-example-modal-lg" id="author-lang" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ url('/author_lang') }}" method="POST">
                    <div class="form-body">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Author - Language</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" value="{{ $type }}" name="combination_type">
                                <div class="row">
                                    <div class="col-12">

                                        <label for="">Author</label>
                                        <fieldset class="form-group">
                                            <select class="select2 form-control" name="author" id=""
                                                style="width:100% !important">

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
                                            <select class="select2 form-control" name="lang" id=""
                                                style="width:100% !important">
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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
