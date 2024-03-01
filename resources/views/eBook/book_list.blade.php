@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Content Sequence</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                    </div>
                </div>
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

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">

                        <div class="col-md-12 col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">
                                        <section id="basic-datatable">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action={{ url('/book/update/sequence/') }} method="POST">
                                                        @csrf
                                                        <input type="hidden" name="pending_for_approval"
                                                            value="{{ $pending_for_approval }}">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <div class="card-body card-dashboard">
                                                                    <div class="table-responsive">
                                                                        <table class="table zero-configuration">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Chapter</th>
                                                                                    <th>Sequence</th>
                                                                                    <th>Content</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <input type="hidden" name="book_id"
                                                                                    class="{{ $book_id }}">
                                                                                @foreach ($content as $key => $c)
                                                                                    <tr>

                                                                                        <td
                                                                                            onclick="makeInput({{ $key }})">
                                                                                            <span
                                                                                                id="name-span-{{ $key }}">
                                                                                                {{ str_replace('.mp3', '', $c->book_name) }}</span>
                                                                                            <div id="name-input-div-{{ $key }}"
                                                                                                style="display: none !important">
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    name=""
                                                                                                    value="{{ str_replace('.mp3', '', $c->book_name) }}"
                                                                                                    id="input-{{ $key }}">
                                                                                                <span
                                                                                                    class="btn btn-success ml-1"
                                                                                                    onclick="saveFileName('{{ $c->_id }}' ,  '{{ $key }}')">
                                                                                                    <i
                                                                                                        class="fa fa-check "></i>
                                                                                                </span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td> <input type="hidden"
                                                                                                value="{{ $c->_id }}"
                                                                                                name="chapters[]"><input
                                                                                                type="number"
                                                                                                name="sequence[]"
                                                                                                class="form-control"
                                                                                                value="{{ $c->sequence == '' ? $key : $c->sequence }}">
                                                                                        </td>
                                                                                        <td>
                                                                                            <span> <audio controls>
                                                                                                    <source
                                                                                                        src="{{ $c->file }}"
                                                                                                        type="audio/mp3">
                                                                                                </audio></span>

                                                                                        </td>
                                                                                        <td><span class="ml-2"> <a
                                                                                                    href="{{ url('delete/audio/' . $c->_id) }}">
                                                                                                    <i class="fa fa-trash "
                                                                                                        style="font-size:24px;"></i></a></span>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-dark"
                                                            style="float:right">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic Vertical form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
