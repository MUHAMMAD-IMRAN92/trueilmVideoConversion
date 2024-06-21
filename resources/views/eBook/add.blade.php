@extends('layouts.default_layout')

@section('content')
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/resumablejs/resumable.js"></script>

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
                                                            <label class="required" for="">Title</label>
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
                                                    <div class="col-12">
                                                        <label for="">What's Inside</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="inside"></textarea>
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
                                                        {{-- <fieldset class="form-group">
                                                                <label for="basicInputFile" class="required">Content</label>
                                                                <div class="custom-file">
                                                                    <input type="file"
                                                                        class="file-input custom-file-input episode-custom-file-input"
                                                                        id="inputGroupFile01" name="file[]"
                                                                        {{ $validation }} multiple>

                                                                    <label class="custom-file-label"
                                                                        for="inputGroupFile01">Choose
                                                                        file</label>
                                                                </div>
                                                            </fieldset> --}}
                                                        <div class="col-md-6">
                                                            <input type="hidden" class="file-input "
                                                                id="file-names-from-s3" name="file[]">

                                                            <fieldset class="form-group">
                                                                <label for="basicInputFile" class="required">Content</label>
                                                                <div class="custom-file">
                                                                    <input type="file" id="file-upload-input"
                                                                        class="file-input custom-file-input episode-custom-file-input"
                                                                        id="inputGroupFile01" {{ $validation }} multiple>

                                                                    <label class="custom-file-label"
                                                                        for="inputGroupFile01">Choose
                                                                        file</label>
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
                                                    @endif
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile" class="required">Cover Image</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="inputGroupFile01" name="cover" accept="image/*"
                                                                    required>
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    {{-- <div class="col-md-6">
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
                                                    </div> --}}

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
                                                                <label for="basicInputFile" class="required">Serial
                                                                    Number</label>
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
                                                                <label for="basicInputFile" class="required">Book
                                                                    Pages</label>
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
                                                    <div class="col-6">

                                                        <label for="">Author</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="author_id"
                                                                id="">
                                                                <option disabled selected>Select Author</option>
                                                                @foreach ($author as $auth)
                                                                    <option value="{{ $auth->_id }}">
                                                                        {{ $auth->name }}</option>
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

                                                        <label for="">Language</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="lang_id"
                                                                id="">
                                                                <option disabled selected>Select Language</option>
                                                                @foreach ($languages as $lang)
                                                                    <option value="{{ $lang->_id }}">
                                                                        {{ $lang->title }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
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
                                                                        onchange="priceRadioFunction(0)" value="0"
                                                                        {{ $type == 7 ? 'checked' : '' }}>
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
                                                                        onchange="priceRadioFunction(1)" value="1"
                                                                        {{ $type != 7 ? 'checked' : '' }}>
                                                                    <span class="vs-radio">
                                                                        <span class="vs-radio--border"></span>
                                                                        <span class="vs-radio--circle"></span>
                                                                    </span>
                                                                    <span class="">Premium</span>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        {{-- <li class="d-inline-block mr-2">
                                                            <fieldset>
                                                                <div class="vs-radio-con">
                                                                    <input class="pRadio" type="radio" name="pRadio"
                                                                        onchange="priceRadioFunction(2)" value="2">
                                                                    <span class="vs-radio">
                                                                        <span class="vs-radio--border"></span>
                                                                        <span class="vs-radio--circle"></span>
                                                                    </span>
                                                                    <span class="">Executive</span>
                                                                </div>
                                                            </fieldset>
                                                        </li> --}}
                                                    </div>
                                                    <div class="col-md-6 price"
                                                        style="display:{{ $type == 7 ? 'none' : '' }}" class="">

                                                        <div class="form-group">
                                                            <label for="">Price</label>
                                                            <input type="number" class=" form-control" name="price"
                                                                placeholder="" id="" value="">

                                                        </div>


                                                    </div>
                                                    <div class="col-md-6 sample-file"
                                                        style="display:{{ $type == 7 ? 'none' : '' }}" class="">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Sample File</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="" name="sample_file">
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h2>
                                                            Show In Section
                                                        </h2>
                                                    </div>
                                                    <div class="col-12">
                                                        <table class="table table-bordered ">
                                                            <thead>
                                                                <tr>
                                                                    <th>App Section</th>
                                                                    <th>Content</th>
                                                                    <th>Order No</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($section as $s)
                                                                    <tr>
                                                                        <td>
                                                                            <li class="d-inline-block mr-2">
                                                                                <fieldset>
                                                                                    <div
                                                                                        class="vs-checkbox-con vs-checkbox-primary">
                                                                                        <input type="checkbox"
                                                                                            value="{{ $s->_id }}"
                                                                                            name="section[]"
                                                                                            class="section-checkbox"
                                                                                            data-group=""
                                                                                            id="checkbox{{ $s->_id }}">
                                                                                        <span class="vs-checkbox">
                                                                                            <span
                                                                                                class="vs-checkbox--check">
                                                                                                <i
                                                                                                    class="vs-icon feather icon-check"></i>
                                                                                            </span>
                                                                                        </span>
                                                                                        <span>{{ $s->title }}</span>
                                                                                    </div>
                                                                                </fieldset>
                                                                            </li>
                                                                        </td>
                                                                        <td>
                                                                            <span>eBook : </span> <b>
                                                                                {{ count($s->eBook) }}</b> <br>
                                                                            <span>Audio Book : </span> <b>
                                                                                {{ count($s->audioBook) }}</b> <br>
                                                                            <span>Podcast : </span> <b>
                                                                                {{ count($s->podcast) }}</b> <br>
                                                                            <span>Course : </span> <b>
                                                                                {{ count($s->course) }}</b> <br>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <label
                                                                                    for="sequence{{ $s->_id }}"></label>
                                                                                <div class="position-relative">
                                                                                    <input type="text"
                                                                                        id="sequence{{ $s->_id }}"
                                                                                        class="form-control"
                                                                                        name="{{ $s->_id }}"
                                                                                        placeholder="" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td></td>
                                                                        <td style="text-align: center">Not Section Added
                                                                            Yet !</td>
                                                                        <td></td>

                                                                    </tr>
                                                                @endforelse

                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h2>
                                                            Reference
                                                        </h2>
                                                    </div>
                                                    <div class="col-6"><label for="">Select Book Type</label>
                                                        <fieldset class="form-group">
                                                            <select class="selct2 form-control reference-select"
                                                                onchange="getFilesAjax('0')" name="reference_type"
                                                                id="reference-new-lang-select-0">
                                                                <option value="" selected>Please Select Reference
                                                                </option>
                                                                <option value="1">eBook</option>
                                                                <option value="2">Audio</option>
                                                                {{-- <option value="3">Paper</option> --}}
                                                            </select>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="">Select Book</label>
                                                        <div class="form-label-group">
                                                            <fieldset class="form-group">
                                                                <select class="select2 form-control" name="reference_file"
                                                                    id="file-new-lang-select-0">
                                                                    <option value="" selected>Please Select File
                                                                    </option>

                                                                </select>
                                                            </fieldset>
                                                        </div>
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
