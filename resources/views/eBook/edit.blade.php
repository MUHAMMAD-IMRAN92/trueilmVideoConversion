@extends('layouts.default_layout')

@section('content')
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Edit Content</h2>
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
                                        <form class="form form-vertical" action="{{ route('book.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="" class="required">Title</label>
                                                            <div class="position-relative">
                                                                <input type="hidden" id=""
                                                                    value="{{ $type }}" class="form-control"
                                                                    name="type" placeholder="" required>
                                                                <input type="hidden" id="" class="form-control"
                                                                    name="id" placeholder=""
                                                                    value="{{ $book->_id }}" required>
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" placeholder=""
                                                                    value="{{ $book->title }}" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description">{{ $book->description }}</textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile" class="required">Content</label>
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="file-input custom-file-input episode-custom-file-input"
                                                                    id="inputGroupFile01" name="file[]"
                                                                    onchange="multiduration()" multiple required>
                                                                <input type="hidden" name="duration[]"
                                                                    id="input-duration-0" required />
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
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
                                                    {{-- <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Author</label>
                                                            <div class="custom-file">
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="author"
                                                                        value="{{ $book->author }}" placeholder="" required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div> --}}

                                                    <div class="col-6  text-md-left">
                                                        <label for="">
                                                            Category</label>
                                                        <div class="form-label-group">
                                                            <select class="select2 form-control" name="category_id"
                                                                id="create-product-category-attribute"
                                                                value="{{ $book->category_id }}">
                                                                <option selected disabled>Select
                                                                    Category
                                                                </option>
                                                                {!! getCategorydropdown(0, 0, $book->category_id, $type) !!}

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
                                                                            placeholder="" value="{{ $book->serial_no }}"
                                                                            required>

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
                                                                            placeholder="" value="{{ $book->book_pages }}"
                                                                            required>

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
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Max Age</label>
                                                            <div class="position-relative">
                                                                <input type="number" id="" class="form-control"
                                                                    name="age" placeholder=""
                                                                    value="{{ $book->age }}">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 mt-2">
                                                        <li class="d-inline-block mr-2">
                                                            <fieldset>
                                                                <div class="vs-radio-con">
                                                                    <input class="pRadio" type="radio" name="pRadio"
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
                                                                    <input class="pRadio" type="radio" name="pRadio"
                                                                        onchange="priceRadioFunction(1)" value="1"
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
                                                            <input type="number" class="price form-control"
                                                                name="price" placeholder="" id="price" required
                                                                value="{{ $book->price }}"
                                                                {{ $book->p_type == 0 ? 'disabled' : '' }}>

                                                        </div>


                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Sample File</label>
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="sample-file custom-file-input"
                                                                    class="sample-file" name="sample_file"
                                                                    {{ $book->p_type == 0 ? 'disabled' : '' }}>
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
                                                                <option value="3">Paper</option>
                                                            </select>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="">Select Book</label>
                                                        <div class="form-label-group">
                                                            <fieldset class="form-group">
                                                                <select class="selct2 form-control" name="reference_file"
                                                                    id="file-new-lang-select-0">
                                                                    <option value="" selected>Please Select File
                                                                    </option>

                                                                </select>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h2 id="episodes-heading" style="display:none">
                                                    Episodes:</h2>
                                                <div class="row episode-append-inputs">

                                                </div>
                                                @if ($type == 7)
                                                    <h2 class="">
                                                        Previous Episodes:</h2>
                                                    <div class="row">


                                                        @foreach ($book->content as $con)
                                                            <div class="col-md-4">
                                                                @if ($con->type == 1)
                                                                    <audio src="{{ $con->file }}"
                                                                        style="width:300px ; height:172px"
                                                                        controls></audio>
                                                                @else
                                                                    <video style="width:300px ; height:172px"
                                                                        src="{{ $con->file }}" controls></video>
                                                                @endif
                                                                <br>
                                                                <div class="d-flex ml-2"><b>Title:</b>

                                                                    <p class="ml-1">{{ $con->title }}</p>
                                                                </div>
                                                                <div class="d-flex ml-2">
                                                                    <b>Host:</b>
                                                                    <p class="ml-1">{{ $con->host }}</p>

                                                                    <b class="ml-2">Guest:</b>
                                                                    <p class="ml-1">{{ $con->guest }}</p>
                                                                </div>

                                                                {{--  <a
                                                                    href="{{ url('lesson/delete/' . $lesson->id) }}"
                                                                    class="btn btn-danger">Delete</a> --}}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <br>
                                                @endif

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

                                                <div class="col-12" style="text-align: right">
                                                    @if ($type == 7)
                                                        <span id="add-podcast-episode"
                                                            class="btn btn-primary mr-1 mb-1">Add
                                                            Episode</span>
                                                    @endif
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
