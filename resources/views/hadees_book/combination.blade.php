@extends('layouts.default_layout')

@section('content')
    <style>
        #author-lang .select2.select2-container.select2-container--default {
            width: 100% !important;
        }

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

                        <div class="col-10 d-flex  " style="padding: 0px 35px">
                            <form action="{{ url('/hadith/books/combination/' . $type . '/' . $book->_id) }}"
                                method="GET">

                                <select class="select2 form-control " name="lang" id="">
                                    <option selected disabled>Select
                                        Language
                                    </option>
                                    <option value="">All
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
                                    <option value="">All
                                    </option>
                                    @foreach ($author as $auth)
                                        <option value="{{ $auth->_id }}"
                                            {{ request()->author == $auth->_id ? 'selected' : '' }}>
                                            {{ $auth->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <br>
                                <div class="mt-2">
                                    <div style="width: 201px">
                                        <button class="btn btn-dark" type="submit">Search</button>
                                        <a href="{{ url('/hadith/books/combination/' . $type . '/' . $book->_id) }}"
                                            class="btn btn-dark">
                                            Clear</a>
                                    </div>

                                    @php
                                        $permission_pass=''; 
                                        if( intval($type) === 1){
                                            $permission_pass='hadith-translations-combination-add'; 

                                        }else{
                                            $permission_pass='hadith-Tafseer-combination-add'; 

                                        }
                                    @endphp
                                        

                                    @permission($permission_pass)
                                    <div style="width: 201px" class="mt-1">
                                        <span style="width: 201px" class="btn btn-dark " data-toggle="modal"
                                            data-target="#author-lang"> Add
                                            New</span>
                                    </div>
                                    @endpermission

                                </div>

                            </form>
                        </div>

                        <div class="col-2 ">
                            <h2 class="content-header-title float-left mb-0 mt-1 checkclass">{{ $book->title }}</h2>
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
                                @forelse  ($combinations as $combination)
                                    <tr
                                        onclick="document.location ='/hadith/books/combination/{{ $type }}/{{ $book->_id }}/{{ $combination->_id }}'">


                                        <td class="product-name" style="font-size: 15px">
                                            {{ $combination->language->title }}
                                        </td>
                                        <td class="product-name" style="font-size: 15px">
                                            {{ $combination->author->name }}
                                        </td>
                                        {{-- <td class="product-name" style="font-size: 20px">{{ $combination->language->title }}
                                        </td> --}}
                                        <td class="product-price">
                                            {{ count($combination->HadithTranslations) . '/' . count($book->hadees) }}</td>
                                        <td class="product-action">
                                            <span class="action-edit"><i class="fa fa-external-link"></i></span>

                                        </td>

                                        @php
                                            $permission_pass=''; 
                                            if( intval($type) === 1){
                                                $permission_pass='hadith-translations-combination-action'; 

                                            }else{
                                                $permission_pass='hadith-Tafseer-combination-action'; 

                                            }
                                        @endphp
                                        

                                        @permission($permission_pass)
                                        <td class="product-action">
                                            <span class="action-edit"><a class="btn btn-dark"
                                                    href="{{ url('disable/author_lang/' . $combination->_id) }}">
                                                    @if ($combination->status == 1)
                                                        Disable
                                                    @else
                                                        Enable
                                                    @endif

                                                </a></span>
                                        </td>
                                        @endpermission
                                    </tr>
                                @empty
                                    <tr>


                                        <td class="product-name" style="font-size: 15px">

                                        </td>
                                        <td class="product-name" style="font-size: 15px">
                                            <b>No Data Found!</b>
                                        </td>


                                        <td class="product-price"></td>

                                    </tr>
                                @endforelse



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
                                    <span class="ml-1 mr-1"> <b> Note : </b>
                                        To add a new author and language, please enter their respective names or titles into
                                        the search bars of both dropdown menus. After entering the required information, you
                                        can create a combination by clicking the "Save" button.</span>
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
