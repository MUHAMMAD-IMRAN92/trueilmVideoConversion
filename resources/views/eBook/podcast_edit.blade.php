@extends('layouts.default_layout')
<style>
    .select2.select2-container.select2-container--default {
        width: 100% !important;
    }
</style>
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
                            <h2 class="content-header-title float-left mb-0">Edit Content</h2>
                            <div class="breadcrumb-wrapper col-12">

                            </div>
                        </div>
                        <div class="col-2  d-flex justify-content-end">
                            <i class="fa fa-pencil mr-1 pointer" data-toggle="modal" data-target="#author-lang"></i>

                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">

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
            <div class="content-body">

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">

                        <div class="col-md-12 col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Name</label>
                                                            <div class="position-relative">
                                                                <input type="hidden" id=""
                                                                    value="{{ $type }}" class="form-control"
                                                                    name="type" placeholder="" required>
                                                                <input type="hidden" id="" class="form-control"
                                                                    name="id" placeholder=""
                                                                    value="{{ $book->_id }}" required>
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" placeholder=""
                                                                    value="{{ $book->title }}" disabled required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" disabled rows="3" placeholder="" name="description">{{ $book->description }}</textarea>
                                                        </fieldset>
                                                    </div>
                                                    @if ($type != 7)
                                                        <div class="col-md-6">
                                                            <fieldset class="form-group">
                                                                <label for="basicInputFile">Content</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="inputGroupFile01" name="file[]" disabled
                                                                        multiple>
                                                                    <label class="custom-file-label"
                                                                        for="inputGroupFile01">Choose
                                                                        file</label>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Cover Image</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="inputGroupFile01" disabled name="cover">
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    {{-- <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Tags</label>
                                                            <div class="position-relative">
                                                                <input type="text" name="tags[]" data-role="tagsinput"
                                                                    id="" class="form-control" name="title"
                                                                    placeholder="" required>

                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-6">

                                                        <label for="">Author</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="author_id"
                                                                id="">
                                                                <option disabled selected>Select Author</option>
                                                                @foreach ($author as $auth)
                                                                    <option
                                                                        {{ $book->author_id == $auth->_id ? 'selected' : '' }}
                                                                        value="{{ $auth->_id }}">
                                                                        {{ $auth->name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6  text-md-left">
                                                        <label for="">
                                                            Category</label>
                                                        <div class="form-label-group">
                                                            <select class="select2 form-control" disabled
                                                                name="category_id" id="create-product-category-attribute">
                                                                <option selected disabled>Select
                                                                    Category
                                                                </option>
                                                                {!! getCategorydropdown(0, 0, 0, $type) !!}

                                                            </select>
                                                        </div>
                                                    </div>
                                                    @if ($type != 7 && $type != 2)
                                                        <div class="col-md-6">
                                                            <fieldset class="form-group">
                                                                <label for="basicInputFile">Serial Number</label>
                                                                <div class="custom-file">
                                                                    <div class="position-relative">
                                                                        <input type="text" id=""
                                                                            class="form-control" name="sr_no"
                                                                            placeholder="" disabled
                                                                            value="{{ $book->serial_no }}" required>

                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <fieldset class="form-group">
                                                                <label for="basicInputFile">Book Pages</label>
                                                                <div class="custom-file">
                                                                    <div class="position-relative">
                                                                        <input type="number" id=""
                                                                            class="form-control" name="pages"
                                                                            placeholder="" disabled
                                                                            value="{{ $book->book_pages }}" required>

                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    @endif
                                                    <div class="form-group col-md-6 ">
                                                        <label for="basicInputFile">Tags</label>

                                                        <select class="select2 multiple-select form-control"
                                                            multiple="multiple" disabled name="tags[]">
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->title }}"
                                                                    {{ $contentTags->contains('tag_id', $tag->id) == true ? 'selected' : '' }}>
                                                                    {{ $tag->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">

                                                        <label for="">Content Suitable</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" disabled name="suitble"
                                                                id="">
                                                                <option disabled>Select Suitable</option>
                                                                @foreach ($suitbles as $suitble)
                                                                    <option value="{{ $suitble->_id }}"
                                                                        {{ $book->content_suitble == $suitble->_id ? 'selected' : '' }}>
                                                                        {{ $suitble->title }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">

                                                        <label for="">GLossary</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 multiple-select form-control" disabled
                                                                multiple="multiple" name="glossary[]">

                                                                @foreach ($glossary as $g)
                                                                    <option value="{{ $g->_id }}"
                                                                        {{ $contentGlossary->contains('glossary_id', $g->id) == true ? 'selected' : '' }}>
                                                                        {{ $g->title }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">

                                                        <label for="">Publsiher</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" disabled
                                                                name="publisher_id" id="">
                                                                <option disabled selected>Select Publsiher</option>
                                                                @foreach ($publisher as $p)
                                                                    <option value="{{ $p->_id }}"
                                                                        {{ $book->publisher_id == $p->_id ? 'selected' : '' }}>
                                                                        {{ $p->name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Max Age</label>
                                                            <div class="position-relative">
                                                                <input type="number" id="" disabled
                                                                    class="form-control" name="age" placeholder=""
                                                                    value="{{ $book->age }}">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 mt-2">
                                                        <li class="d-inline-block mr-2">
                                                            <fieldset>
                                                                <div class="vs-radio-con">
                                                                    <input class="pRadio" disabled type="radio"
                                                                        name="pRadio" onchange="priceRadioFunction(0)"
                                                                        {{ $book->p_type == 0 ? 'checked' : '' }}
                                                                        value="0">
                                                                    <span class="vs-radio">
                                                                        <span class="vs-radio--border"></span>
                                                                        <span class="vs-radio--circle"></span>
                                                                    </span>
                                                                    <span class="">Freemium</span>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        <li class="d-inline-block mr-2">
                                                            <fieldset>
                                                                <div class="vs-radio-con">
                                                                    <input class="pRadio" type="radio" disabled
                                                                        name="pRadio" onchange="priceRadioFunction(1)"
                                                                        value="1"
                                                                        {{ $book->p_type == 1 ? 'checked' : '' }}>
                                                                    <span class="vs-radio">
                                                                        <span class="vs-radio--border"></span>
                                                                        <span class="vs-radio--circle"></span>
                                                                    </span>
                                                                    <span class="">Premium</span>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </div>
                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="">Price</label>
                                                            <input type="number" class="form-control" disabled
                                                                name="price" placeholder="" id="price" required
                                                                value="{{ $book->price }}"
                                                                {{ $book->p_type == 0 ? 'disabled' : '' }}>

                                                        </div>


                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Sample File</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="sample-file" name="sample_file" disabled>
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <h2 id="episodes-heading" style="display:none">
                                                    Episodes:</h2>
                                                <div class="row episode-append-inputs">

                                                </div>


                                                {{-- <div class="form-group col col-md-6">
                                                    <fieldset class="form-group">
                                                        <label for="basicInputFile">Tag</label>
                                                        <select class="select2 multiple-select form-control"
                                                            multiple="multiple" name="tags[]">
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->title }}"
                                                                    {{ $contentTags->contains('tag_id', $tag->id) == true ? 'selected' : '' }}>
                                                                    {{ $tag->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </fieldset>
                                                </div> --}}

                                                {{-- <div class="col-12" x="text-align: right">
                                                    @if ($type == 7)
                                                        <span id="add-podcast-episode"
                                                            class="btn btn-primary mr-1 mb-1">Add
                                                            Episode</span>
                                                    @endif
                                                    <button type="submit"
                                                        class="btn btn-primary mr-1 mb-1">Submit</button>

                                                </div> --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-10">
                                            <h2 class="">
                                                Episodes:</h2>
                                        </div>
                                        <div class="col-2">
                                            <span class="btn btn-primary" data-toggle="modal"
                                                data-target="#add-episode">Add Episode</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center">

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="">Title</th>
                                                        <th class="">Description</th>
                                                        <th>Host</th>
                                                        <th>Guest</th>
                                                        <th class="description-td">Content</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($book->content as $key=> $con)
                                                        <tr>
                                                            <input type="hidden" name=""
                                                                id="episode_id{{ $key }}"
                                                                value="{{ $con->_id }}">
                                                            <td id="title{{ $key }}">{{ $con->title }}</td>
                                                            <td id="description{{ $key }}">
                                                                {{ $con->description ?? '--' }}</td>
                                                            <td id="host{{ $key }}">{{ $con->host }}</td>
                                                            <td id="guest{{ $key }}">{{ $con->guest }}</td>
                                                            <td>
                                                                @if ($con->type == 1)
                                                                    <audio src="{{ $con->file }}" style=""
                                                                        controls></audio>
                                                                @else
                                                                    <video style="width:300px;" src="{{ $con->file }}"
                                                                        controls></video>
                                                                @endif
                                                            </td>

                                                            <td> <i class="fa fa-pencil pointer"
                                                                    onclick="editEpisodeModal({{ $key }})"></i>
                                                            </td>

                                                        </tr>

                                                    @empty
                                                        <tr>
                                                            <center><b>No Episode Added Yet !</b></center>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal fade bd-example-modal-lg" id="author-lang" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form action="{{ route('book.update') }}" method="POST">
                                        <div class="form-body">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Author -
                                                        Language
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row append-inputs">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">Name</label>
                                                                <div class="position-relative">
                                                                    <input type="hidden" id=""
                                                                        value="{{ $type }}" class="form-control"
                                                                        name="type" placeholder="" required>
                                                                    <input type="hidden" id=""
                                                                        class="form-control" name="id"
                                                                        placeholder="" value="{{ $book->_id }}"
                                                                        required>
                                                                    <input type="text" id=""
                                                                        class="form-control" name="title"
                                                                        placeholder="" value="{{ $book->title }}"
                                                                        required>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="">Description</label>
                                                            <fieldset class="form-group">
                                                                <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description">{{ $book->description }}</textarea>
                                                            </fieldset>
                                                        </div>
                                                        @if ($type != 7)
                                                            <div class="col-md-6">
                                                                <fieldset class="form-group">
                                                                    <label for="basicInputFile">Content</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="inputGroupFile01" name="file[]" multiple>
                                                                        <label class="custom-file-label"
                                                                            for="inputGroupFile01">Choose
                                                                            file</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-6">
                                                            <fieldset class="form-group">
                                                                <label for="basicInputFile">Cover Image</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="inputGroupFile01" name="cover">
                                                                    <label class="custom-file-label"
                                                                        for="inputGroupFile01">Choose
                                                                        file</label>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        {{-- <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">Tags</label>
                                                                <div class="position-relative">
                                                                    <input type="text" name="tags[]" data-role="tagsinput"
                                                                        id="" class="form-control" name="title"
                                                                        placeholder="" required>

                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-6">

                                                            <label for="">Author</label>
                                                            <fieldset class="form-group">
                                                                <select class="select2 form-control" name="author_id"
                                                                    id="">
                                                                    <option disabled selected>Select Author</option>
                                                                    @foreach ($author as $auth)
                                                                        <option
                                                                            {{ $book->author_id == $auth->_id ? 'selected' : '' }}
                                                                            value="{{ $auth->_id }}">
                                                                            {{ $auth->name }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-6  text-md-left w-100">
                                                            <label for="">
                                                                Category</label>
                                                            <div class="form-label-group w-100">
                                                                <select class="select2 form-control w-100"
                                                                    name="category_id"
                                                                    id="create-product-category-attribute">
                                                                    <option selected>Select
                                                                        Category
                                                                    </option>
                                                                    {!! getCategorydropdown(0, 0, 0, $type) !!}

                                                                </select>
                                                            </div>
                                                        </div>
                                                        @if ($type != 7 && $type != 2)
                                                            <div class="col-md-6">
                                                                <fieldset class="form-group">
                                                                    <label for="basicInputFile">Serial
                                                                        Number</label>
                                                                    <div class="custom-file">
                                                                        <div class="position-relative">
                                                                            <input type="text" id=""
                                                                                class="form-control" name="sr_no"
                                                                                placeholder=""
                                                                                value="{{ $book->serial_no }}" required>

                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <fieldset class="form-group">
                                                                    <label for="basicInputFile">Book Pages</label>
                                                                    <div class="custom-file">
                                                                        <div class="position-relative">
                                                                            <input type="number" id=""
                                                                                class="form-control" name="pages"
                                                                                placeholder=""
                                                                                value="{{ $book->book_pages }}" required>

                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        @endif
                                                        <div class="form-group col-md-6 ">
                                                            <label for="basicInputFile">Tags</label>

                                                            <select class="select2 multiple-select form-control"
                                                                multiple="multiple" name="tags[]">
                                                                @foreach ($tags as $tag)
                                                                    <option value="{{ $tag->title }}"
                                                                        {{ $contentTags->contains('tag_id', $tag->id) == true ? 'selected' : '' }}>
                                                                        {{ $tag->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-6">

                                                            <label for="">Content Suitable</label>
                                                            <fieldset class="form-group">
                                                                <select class="select2 form-control" name="suitble"
                                                                    id="">
                                                                    <option>Select Suitable</option>
                                                                    @foreach ($suitbles as $suitble)
                                                                        <option value="{{ $suitble->_id }}"
                                                                            {{ $book->content_suitble == $suitble->_id ? 'selected' : '' }}>
                                                                            {{ $suitble->title }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">

                                                            <label for="">GLossary</label>
                                                            <fieldset class="form-group">
                                                                <select class="select2 multiple-select form-control"
                                                                    multiple="multiple" name="glossary[]">

                                                                    @foreach ($glossary as $g)
                                                                        <option value="{{ $g->_id }}"
                                                                            {{ $contentGlossary->contains('glossary_id', $g->id) == true ? 'selected' : '' }}>
                                                                            {{ $g->title }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">

                                                            <label for="">Publsiher</label>
                                                            <fieldset class="form-group">
                                                                <select class="select2 form-control" name="publisher_id"
                                                                    id="">
                                                                    <option selected>Select Publsiher</option>
                                                                    @foreach ($publisher as $p)
                                                                        <option value="{{ $p->_id }}"
                                                                            {{ $book->publisher_id == $p->_id ? 'selected' : '' }}>
                                                                            {{ $p->name }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="">Max Age</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        class="form-control" name="age"
                                                                        placeholder="" value="{{ $book->age }}">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 mt-2">
                                                            <li class="d-inline-block mr-2">
                                                                <fieldset>
                                                                    <div class="vs-radio-con">
                                                                        <input class="pRadio" type="radio"
                                                                            name="pRadio"
                                                                            onchange="priceRadioFunction(0)"
                                                                            {{ $book->p_type == 0 ? 'checked' : '' }}
                                                                            value="0">
                                                                        <span class="vs-radio">
                                                                            <span class="vs-radio--border"></span>
                                                                            <span class="vs-radio--circle"></span>
                                                                        </span>
                                                                        <span class="">Freemium</span>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                            <li class="d-inline-block mr-2">
                                                                <fieldset>
                                                                    <div class="vs-radio-con">
                                                                        <input class="pRadio" type="radio"
                                                                            name="pRadio"
                                                                            onchange="priceRadioFunction(1)"
                                                                            value="1"
                                                                            {{ $book->p_type == 1 ? 'checked' : '' }}>
                                                                        <span class="vs-radio">
                                                                            <span class="vs-radio--border"></span>
                                                                            <span class="vs-radio--circle"></span>
                                                                        </span>
                                                                        <span class="">Premium</span>
                                                                    </div>
                                                                </fieldset>
                                                            </li>
                                                        </div>
                                                        <div class="col-md-6">

                                                            <div class="form-group">
                                                                <label for="">Price</label>
                                                                <input type="number" class="form-control price"
                                                                    name="price" placeholder="" required
                                                                    value="{{ $book->price }}"
                                                                    {{ $book->p_type == 0 ? 'disabled' : '' }}>

                                                            </div>


                                                        </div>
                                                        <div class="col-md-6">
                                                            <fieldset class="form-group">
                                                                <label for="basicInputFile">Sample File</label>
                                                                <div class="custom-file">
                                                                    <input type="file"
                                                                        class="custom-file-input sample-file"
                                                                        id="" name="sample_file"
                                                                        {{ $book->p_type == 0 ? 'disabled' : '' }}>
                                                                    <label class="custom-file-label"
                                                                        for="inputGroupFile01">Choose
                                                                        file</label>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                </div>
                                </form>
                            </div>
                            <div class="modal fade bd-example-modal-lg" id="add-episode" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form action="{{ route('podcast.episode') }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="form-body">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Episode
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Title</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="hidden" id=""
                                                                        class="form-control" name="podcast_id"
                                                                        placeholder="" value={{ $book->_id }}>
                                                                    <input type="text" id=""
                                                                        class="form-control" name="episode_title"
                                                                        placeholder="" required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="episode_description"></textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Host</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="host"
                                                                        placeholder="" required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Guest</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="guest"
                                                                        placeholder="" required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Content</label>
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input  episode-custom-file-input"
                                                                    id="fileinput-0" onchange="duration(0)"
                                                                    name="podcast_file" required>
                                                                <input type="hidden" name="duration[]"
                                                                    id="input-duration-0" required />
                                                                <span id="duration-info-0"></span>
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal fade bd-example-modal-lg" id="edit-episode" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form action="{{ route('podcast.episode') }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="form-body">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Episode
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Title</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="hidden" id=""
                                                                        class="form-control" name="podcast_id"
                                                                        placeholder="" value="{{ $book->_id }}">
                                                                    <input type="hidden" id="modal-episode-id"
                                                                        class="form-control" name="episode_id"
                                                                        placeholder="" value="">
                                                                    <input type="text" id="modal-episode-title"
                                                                        class="form-control" name="episode_title"
                                                                        placeholder="" required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" id="modal-episode-description"
                                                                name="episode_description"></textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Host</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="text" id="modal-episode-host"
                                                                        class="form-control" name="host"
                                                                        placeholder="" required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Guest</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="text" id="modal-episode-guest"
                                                                        class="form-control" name="guest"
                                                                        placeholder="" required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Content</label>
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input  episode-custom-file-input"
                                                                    id="fileinput-1" onchange="duration(1)"
                                                                    name="podcast_file">
                                                                <input type="hidden" name="duration[]"
                                                                    id="input-duration-1" />
                                                                <span id="duration-info-1"></span>
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
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
    {{-- modal --}}


    <!-- END: Content-->
@endsection
