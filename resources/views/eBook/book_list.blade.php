@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-10">
                            <h2 class="content-header-title float-left mb-0">Content Sequence ({{@$book->title}})</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                        @permission('add-audio-book-chapter')
                        <div class="col-2">
                            <button class="btn btn-dark" data-toggle="modal" data-target="#add-episode"> Add
                                Chapter</button>

                        </div>
                        @endpermission
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
                                                                        <table class="table datatable">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Chapter</th>
                                                                                    <th>Sequence</th>
                                                                                    <th>Content</th>
                                                                                    @permission('delete-audio-book-chapter') <th>Action</th>@endpermission
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
                                                                                                @permission('edit-audio-book-chapter')<span
                                                                                                    class="btn btn-success ml-1"
                                                                                                    onclick="saveFileName('{{ $c->_id }}' ,  '{{ $key }}')">
                                                                                                    <i
                                                                                                        class="fa fa-check "></i>
                                                                                                </span>
                                                                                                 @endpermission
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
                                                                                        @permission('delete-audio-book-chapter')
                                                                                        <td><span class="ml-2"> <a
                                                                                                    href="{{ url('delete/audio/' . $c->_id) }}">
                                                                                                    <i class="fa fa-trash "
                                                                                                        style="font-size:24px;"></i></a></span>
                                                                                        </td>@endpermission
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @permission('edit-audio-book-chapter')
                                                        <button type="submit" class="btn btn-dark"
                                                            style="float:right">Submit</button> @endpermission
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal fade bd-example-modal-lg" id="add-episode" tabindex="-1"
                                                role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <form action="{{ url('add/audio/chapter') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        <div class="form-body">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">Add
                                                                        Episode
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">


                                                                    <input type="hidden" id=""
                                                                        class="form-control" name="book_id"
                                                                        placeholder="" value={{ $book_id }}>

                                                                    <div class="col-md-12">
                                                                        <fieldset class="form-group">
                                                                            <label for="basicInputFile">Content</label>
                                                                            <div class="custom-file">
                                                                                <input type="file"
                                                                                    class="file-input file-upload-input custom-file-input  episode-custom-file-input"
                                                                                    id="fileinput-0" name=""
                                                                                    multiple required>

                                                                                <span id="duration-info-0"></span>
                                                                                <label class="custom-file-label"
                                                                                    for="inputGroupFile01">Choose
                                                                                    file</label>
                                                                                <input type="hidden" class="file-input file_name" id="file-names-from-s3"
                                                                                    name="file">
                                                                                <input type="hidden" class="file-input  file_durations" id="file-durations"
                                                                                    name="file_durations">
                                                                               
                                                                            </div>
                                                                            
                                                                        </fieldset>
                                                                        <div id="file-info">
                                                                            <p id="file-name"></p>
                                                                            <div id="progress-container" style="display: none;">
                                                                                <progress id="file-progress" value="0"
                                                                                    max="100"></progress>
                                                                                <span id="progress-percentage">0%</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"  class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" id="submit-btn"
                                                                        class="btn submit-btn btn-primary">Save</button>
                                                                </div>
                                                            </div>
                                                        </div>
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
