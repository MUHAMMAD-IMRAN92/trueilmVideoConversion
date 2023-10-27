@extends('layouts.default_layout')

@section('content')
    {{-- <textarea id="summernote" name="editordata"></textarea> --}}


    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-7 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Publisher Books Details</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-left col-md-5 col-12 mb-2 d-flex " style="justify-content:end">
                    <div class="row breadcrumbs-top d-flex">
                        <form action="{{ url('publisher/books_reading_details/' . $user_id) }}" method='GET'
                            class="d-flex">
                            @csrf
                            <input class="form-control" type="date" name="s_date" id=""
                                value="{{ @$s_date }}">
                            <input class="form-control" type="date" name="e_date" id=""
                                value="{{ @$e_date }}">
                            <input type="hidden" name="user_id" value="{{ $user_id }}" id="">
                            <button class="btn-icon btn btn-primary btn-round  dropdown-toggle" type="submit"><span
                                    class="add-brand-font"></span> <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
                {{-- <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <a href="{{ route('user.add') }}"> <button
                                    class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"><span
                                        class="add-brand-font">Add User</span> <i class="fa fa-plus" aria-hidden="true"></i>
                                </button></a>

                        </div>
                    </div>
                </div> --}}
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
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-content">
                                <div class="card-body">

                                    <!-- Table with outer spacing -->
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sr#</th>
                                                    <th class="description-td">Book Title</th>
                                                    <th class="">Content Type</th>

                                                    <th class="">Pages Read</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($book_read as $key => $br)
                                                    @php

                                                        if ($br->type == 1) {
                                                            $vType = 'Ebook';
                                                        } elseif ($br->type == 2) {
                                                            $vType = 'Audio';
                                                        } elseif ($br->type == 3) {
                                                            $vType = 'Research Paper';
                                                        } else {
                                                            $vType = 'Podcast';
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ @$br->title }}</td>
                                                        <td>{{ $vType }}</td>

                                                        <td>{{ @$br->bookTraking->total_pages }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{ $book_read->links() }}
                                <!-- Table with no outer spacing -->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basic Tables end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
