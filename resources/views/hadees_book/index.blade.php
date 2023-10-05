@extends('layouts.default_layout')

@section('content')
    {{-- <textarea id="summernote" name="editordata"></textarea> --}}


    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-4">
                            <h2 class="content-header-title float-left mb-0">Hadith Books</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                        <div class="col-6 d-flex flex-row-reverse"style="margin-left: 7.5%; ">
                            <form action="{{ url('hadith/books/' . $content_type) }}" method="GET" class="">
                                <div class="form-label-group">
                                    <select class="select2 form-control checkclass" name="surah" id="">
                                        <option selected disabled>Select
                                            Surah
                                        </option>
                                        <option value="">All
                                        </option>
                                        @foreach ($hadithDropDown as $hadith)
                                            <option value="{{ $hadith->_id }}"
                                                {{ request()->surah == $hadith->_id ? 'selected' : '' }}>
                                                {{ $hadith->title }}
                                            </option>
                                        @endforeach


                                    </select>
                                    <button class="btn btn-dark" type="submit"> Search</button>
                                    <a href="{{ url('hadith/books/' . $content_type) }}" class="btn btn-dark">
                                        Clear</a>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">

                        <div class="dropdown">
                            <a href="{{ url('hadith/book/create/' . $content_type) }}"> <button
                                    class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"><span
                                        class="add-brand-font">Add Hadith Book</span> <i class="fa fa-plus"
                                        aria-hidden="true"></i>
                                </button></a>

                        </div>
                    </div>
                </div>
            </div>
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
            {{-- <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-body">

                                    <!-- Table with outer spacing -->
                                    <div class="table-responsive">
                                        <table class="table" id="hadees-table">
                                            <thead>
                                                <tr>
                                                    <th>Hadith</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Table with no outer spacing -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basic Tables end -->

            </div> --}}
            <div class="content-body">
                <!-- Data list view starts -->
                <section id="data-list-view" class="data-list-view-header">


                    <!-- DataTable starts -->
                    <div class="table-responsive">
                        <table class="table data-list-view">

                            <tbody>
                                @foreach ($hadeesBookCombination as $combination)
                                    <tr
                                        onclick="document.location ='combination/{{ $content_type }}/{{ $combination->book_id }}'">
                                        <td>{{ $combination->title }}</td>
                                        <td class="">{{ $combination->description }}
                                        </td>
                                        <td class="">{{ $combination->translation_count . '/' . $combinationCount }}
                                        </td>
                                        <td class="product-action">
                                            <span class="action-edit"><i class="fa fa-external-link"></i></span>

                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                    <div class="row mb-2 mr-2" style="display:flex;flex-direction:column;align-items:end;">
                        {!! $hadeesBookCombination->links() !!}
                    </div>
                    <!-- DataTable ends -->


                </section>
                <!-- Data list view end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
