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
                            <h2 class="content-header-title float-left mb-0">Add Content</h2>
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
            <div class="content-body">

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row match-height">

                        <div class="col-md-12 col-12">
                            <div class="card">

                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-vertical" action="{{ route('book.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Title</label>
                                                            <div class="position-relative">
                                                                <input type="hidden" id=""
                                                                    value="{{ $type }}" class="form-control"
                                                                    name="type" placeholder="" required>
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" placeholder="" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description"></textarea>
                                                        </fieldset>
                                                    </div>


                                                    @php
                                                        $validation = 'accept=.epub';
                                                        if ($type == 2 || $type == 7) {
                                                            $validation = 'accept=.mp3';
                                                        } elseif ($type == 3) {
                                                            $validation = 'accept=.pdf, .docx, .epub';
                                                        }

                                                    @endphp
                                                    @if ($type != 7)
                                                        <div class="col-md-6">
                                                            <fieldset class="form-group">
                                                                <label for="basicInputFile">Content</label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="inputGroupFile01" name="file[]"
                                                                        {{ $validation }} multiple>
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
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Author</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="author" placeholder=""
                                                                        required>

                                                                </div>
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
                                                    <div class="col-6  text-md-left">
                                                        <label for="">
                                                            Category</label>
                                                        <div class="form-label-group">
                                                            <select class="select2 form-control" name="category_id"
                                                                id="create-product-category-attribute">
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
                                                                            placeholder="" required>

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
                                                                            placeholder="" required>

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
                                                                <option value="{{ $tag->title }}">
                                                                    {{ $tag->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">

                                                        <label for="">Content Suitable</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="suitble"
                                                                id="">
                                                                <option disabled selected>Select Suitable</option>
                                                                @foreach ($suitbles as $suitble)
                                                                    <option value="{{ $suitble->_id }}">
                                                                        {{ $suitble->title }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">

                                                        <label for="">Publsiher</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="publisher_id"
                                                                id="">
                                                                <option disabled selected>Select Publsiher</option>
                                                                @foreach ($publisher as $p)
                                                                    <option value="{{ $p->_id }}">
                                                                        {{ $p->name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="form-group col-md-6 ">
                                                        <label for="basicInputFile">Glossary</label>

                                                        <select class="select2 multiple-select form-control"
                                                            multiple="multiple" name="glossary[]">
                                                            @foreach ($glossary as $g)
                                                                <option value="{{ $g->_id }}">
                                                                    {{ $g->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Max Age</label>
                                                            <div class="position-relative">
                                                                <input type="number" id="" class="form-control"
                                                                    name="age" placeholder="">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 mt-2">
                                                        <li class="d-inline-block mr-2">
                                                            <fieldset>
                                                                <div class="vs-radio-con">
                                                                    <input class="pRadio" type="radio" name="pRadio"
                                                                        onchange="priceRadioFunction(0)" checked
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
                                                                    <input class="pRadio" type="radio" name="pRadio"
                                                                        onchange="priceRadioFunction(1)" value="1">
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
                                                            <input type="number" class=" price form-control"
                                                                name="price" placeholder="" id=""
                                                                value="" required disabled>

                                                        </div>


                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Sample File</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="sample-file custom-file-input"
                                                                    id="sample-file" name="sample_file" disabled>
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                </div>

                                                <h2 class="" id="episodes-heading" style="display:none">
                                                    Episodes:</h2>
                                                <div class="row episode-append-inputs">

                                                </div>
                                                <div class="col-12" style="text-align: right">

                                                    <button type="submit"
                                                        class="btn btn-primary mr-1 mb-1">Submit</button>

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
    <!-- END: Content-->
@endsection
