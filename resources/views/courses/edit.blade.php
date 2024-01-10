@extends('layouts.default_layout')

@section('content')
    <!-- BEGIN: Content-->
    <style>
        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }
    </style>
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
                                        <form class="form form-vertical" id="disable-btn-submit"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row append-inputs">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Name</label>
                                                            <div class="position-relative">
                                                                <input type="hidden" id="" class="form-control"
                                                                    name="id" placeholder=""
                                                                    value="{{ $course->_id }}" required>
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" placeholder=""
                                                                    value="{{ $course->title }}" disabled required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description" disabled>{{ $course->description }}</textarea>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Image</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="inputGroupFile01" name="image" accept="image/*"
                                                                    disabled>
                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-2 ">
                                                        <img src="{{ $course->image }}" alt="course image"
                                                            style="width:150px; height:120px">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="">Introduction Video</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="" name="intro_video" accept="video/*"
                                                                    disabled>
                                                                <label class="custom-file-label" for="">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <label for="">Module Overview</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="" name="module_overview" disabled>
                                                                <label class="custom-file-label" for="">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="form-group col-6 ">
                                                        <label for="basicInputFile">Tags</label>

                                                        <select class="select2 multiple-select form-control"
                                                            multiple="multiple" name="tags[]" disabled>
                                                            @foreach ($tags as $tag)
                                                                <option value="{{ $tag->title }}"
                                                                    {{ $contentTags->contains('tag_id', $tag->id) == true ? 'selected' : '' }}>
                                                                    {{ $tag->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">

                                                        <label for="">Author</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="author_id"
                                                                id="" disabled>
                                                                <option disabled selected>Select Author</option>
                                                                @foreach ($author as $auth)
                                                                    <option
                                                                        {{ $course->author_id == $auth->_id ? 'selected' : '' }}
                                                                        value="{{ $auth->_id }}">
                                                                        {{ $auth->name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    {{-- <div class="col-6">

                                                        <label for="">Category</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="category"
                                                                id="basicSelect">
                                                                <option disabled selected>Select Category</option>
                                                                @foreach ($categories as $category)
                                                                    <option
                                                                        {{ $course->category_id == $category->_id ? 'selected' : '' }}
                                                                        value="{{ $category->_id }}">
                                                                        {{ $category->title }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div> --}}
                                                    <div class="col-6  text-md-left">
                                                        <label for="">
                                                            Category</label>
                                                        <div class="form-label-group">
                                                            <select class="select2 form-control" name="category_id"
                                                                id="create-product-category-attribute" disabled>
                                                                <option selected>Select
                                                                    Category
                                                                </option>
                                                                {!! getCategorydropdown(0, 0, $course->category_id, 6) !!}

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="">Max Age</label>
                                                            <div class="position-relative">
                                                                <input type="number" id="" class="form-control"
                                                                    name="age" placeholder=""
                                                                    value="{{ $course->age }}" disabled>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 mt-2">
                                                        <li class="d-inline-block mr-2">
                                                            <fieldset>
                                                                <div class="vs-radio-con">
                                                                    <input class="pRadio" type="radio" name="pRadio"
                                                                        onchange="priceRadioFunction(0)" checked
                                                                        value="0" disabled
                                                                        {{ $course->p_type == 0 ? 'checked' : '' }}>
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
                                                                        disabled
                                                                        {{ $course->p_type == 1 ? 'checked' : '' }}>
                                                                    <span class="vs-radio">
                                                                        <span class="vs-radio--border"></span>
                                                                        <span class="vs-radio--circle"></span>
                                                                    </span>
                                                                    <span class="">Premium</span>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </div>
                                                    <div class="col-md-6  price"
                                                        style="display: {{ $course->p_type == 0 ? 'none' : '' }}">

                                                        <div class="form-group">
                                                            <label for="">Price</label>
                                                            <input type="number" class=" price form-control"
                                                                name="price" placeholder="" id=""
                                                                value="{{ $course->price }}">

                                                        </div>


                                                    </div>

                                                </div>


                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="card">

                                        <div class="card-content">
                                            <div class="card-body">

                                                <ul class="nav nav-pills nav-fill">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="home-tab-fill" data-toggle="pill"
                                                            href="#home-fill" aria-expanded="true">Lessons</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="quiz-tab-fill" data-toggle="pill"
                                                            href="#quiz-fill" aria-expanded="true">Quiz</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home-fill"
                                    aria-labelledby="home-tab-fill" aria-expanded="true">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-10">
                                                    <h2 class="">
                                                        Lessons:</h2>
                                                </div>
                                                <div class="col-2">
                                                    <span class="btn btn-primary" data-toggle="modal"
                                                        data-target="#add-episode">Add Lesson</span>
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
                                                                <th class="description-td">Description</th>
                                                                {{-- <th>Module Overview</th> --}}
                                                                {{-- <th>KWL Worksheet</th> --}}
                                                                <th>Lesson Notes</th>
                                                                <th>Content</th>
                                                                {{-- <th>Quiz</th> --}}
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($course->lessons as $key=> $les)
                                                                <tr> <input type="hidden" name=""
                                                                        id="episode_id{{ $key }}"
                                                                        value="{{ $course->_id }}">
                                                                    <input type="hidden" name=""
                                                                        id="les_id{{ $key }}"
                                                                        value="{{ $les->_id }}">
                                                                    <td id="title{{ $key }}">{{ $les->title }}
                                                                    </td>
                                                                    <td id="description{{ $key }}">
                                                                        {{ $les->description }}</td>



                                                                    {{-- <td>
                                                                        @if ($les->module_overview)
                                                                            <a target="blank"
                                                                                href="{{ $les->module_overview }}">
                                                                                <i class="fa fa-eye"
                                                                                    style="font-size:20px !important"></i>
                                                                            </a>
                                                                        @else
                                                                            <span>NA</span>
                                                                        @endif
                                                                    </td> --}}
                                                                    {{-- <td>

                                                                        @if ($les->kwl_worksheet)
                                                                            <a target="blank"
                                                                                href="{{ $les->kwl_worksheet }}">
                                                                                <i class="fa fa-eye"
                                                                                    style="font-size:20px !important"></i></a>
                                                                        @else
                                                                            <span>NA</span>
                                                                        @endif
                                                                    </td> --}}
                                                                    <td>
                                                                        @if ($les->lesson_notes)
                                                                            <a target="blank"
                                                                                href="{{ $les->lesson_notes }}">
                                                                                <i class="fa fa-eye"
                                                                                    style="font-size:20px !important"></i></a>
                                                                        @else
                                                                            <span>NA</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($les->type == 1)
                                                                            <audio src="{{ $les->video }}"
                                                                                style="" controls></audio>
                                                                        @else
                                                                            <video style="width:300px;"
                                                                                src="{{ $les->video }}"
                                                                                controls></video>
                                                                        @endif
                                                                    </td>
                                                                    {{-- @if ($les->quiz == 0)
                                                                <td> <a class="btn btn-primary"
                                                                        href="{{ url('lesson/quiz/add/' . $course->_id . '/' . $les->_id) }}">Add
                                                                        Quiz</a> </td>
                                                            @else
                                                                <td> <a class="btn btn-primary"
                                                                        href="{{ url('lesson/quiz/edit/' . $course->_id . '/' . $les->_id) }}">
                                                                        Edit
                                                                        Quiz</a> </td>
                                                            @endif --}}
                                                                    <td> <i class="fa fa-pencil pointer"
                                                                            onclick="editLessonModal({{ $key }})"></i>
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
                                </div>
                                <div role="tabpanel" class="tab-pane " id="quiz-fill" aria-labelledby="quiz-tab-fill"
                                    aria-expanded="true">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-10">
                                                    <h2 class="">
                                                        Quiz:</h2>
                                                </div>
                                                <div class="col-2">
                                                    <a class="btn btn-primary"
                                                        href=" {{ url('lesson/quiz/add/' . $course->_id) }}">Add
                                                        Quiz</a>
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
                                                                <th class="description-td">Description</th>

                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($course->lessons->where('quiz' , 1) as $key=> $les)
                                                                <tr> <input type="hidden" name=""
                                                                        id="episode_id{{ $key }}"
                                                                        value="{{ $course->_id }}">
                                                                    <input type="hidden" name=""
                                                                        id="les_id{{ $key }}"
                                                                        value="{{ $les->_id }}">
                                                                    <td id="title{{ $key }}">{{ $les->title }}
                                                                    </td>
                                                                    <td id="description{{ $key }}">
                                                                        {{ $les->description }}</td>




                                                                    @if ($les->quiz == 0)
                                                                        <td> <a class="btn btn-primary"
                                                                                href="{{ url('lesson/quiz/add/' . $course->_id . '/' . $les->_id) }}">Add
                                                                                Quiz</a> </td>
                                                                    @else
                                                                        <td> <a class="btn btn-primary"
                                                                                href="{{ url('lesson/quiz/edit/' . $course->_id . '/' . $les->_id) }}">
                                                                                Edit
                                                                                Quiz</a>
                                                                            <a class="btn btn-primary"
                                                                                href="{{ url('lesson/quiz/results/' . $course->_id . '/' . $les->_id) }}">
                                                                                Results</a>
                                                                        </td>
                                                                    @endif


                                                                </tr>

                                                            @empty
                                                                <tr>
                                                                    <center><b>No Quiz Added Yet !</b></center>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade bd-example-modal-lg" id="author-lang" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form action="{{ route('course.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="form-body">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Content
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-body">
                                                        <div class="row append-inputs">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="">Name</label>
                                                                    <div class="position-relative">
                                                                        <input type="hidden" id=""
                                                                            class="form-control" name="id"
                                                                            placeholder="" value="{{ $course->_id }}"
                                                                            required>
                                                                        <input type="text" id=""
                                                                            class="form-control" name="title"
                                                                            placeholder="" value="{{ $course->title }}"
                                                                            required>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label for="">Description</label>
                                                                <fieldset class="form-group">
                                                                    <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description">{{ $course->description }}</textarea>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <fieldset class="form-group">
                                                                    <label for="basicInputFile">Image</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="inputGroupFile01" name="image"
                                                                            accept="image/*">
                                                                        <label class="custom-file-label"
                                                                            for="inputGroupFile01">Choose
                                                                            file</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <fieldset class="form-group">
                                                                    <label for="">Introduction Video</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="" name="intro_video"
                                                                            accept="video/*">
                                                                        <label class="custom-file-label"
                                                                            for="">Choose
                                                                            file</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <fieldset class="form-group">
                                                                    <label for="">Module Overview</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="" name="module_overview">
                                                                        <label class="custom-file-label"
                                                                            for="">Choose
                                                                            file</label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="form-group col-6 ">
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

                                                                <label for="">Author</label>
                                                                <fieldset class="form-group">
                                                                    <select class="select2 form-control" name="author_id"
                                                                        id="">
                                                                        <option disabled selected>Select Author</option>
                                                                        @foreach ($author as $auth)
                                                                            <option
                                                                                {{ $course->author_id == $auth->_id ? 'selected' : '' }}
                                                                                value="{{ $auth->_id }}">
                                                                                {{ $auth->name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            {{-- <div class="col-6">

                                                                <label for="">Category</label>
                                                                <fieldset class="form-group">
                                                                    <select class="select2 form-control" name="category"
                                                                        id="basicSelect">
                                                                        <option  selected>Select Category</option>
                                                                        @foreach ($categories as $category)
                                                                            <option
                                                                                {{ $course->category_id == $category->_id ? 'selected' : '' }}
                                                                                value="{{ $category->_id }}">
                                                                                {{ $category->title }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </fieldset>
                                                            </div> --}}
                                                            <div class="col-6  text-md-left">
                                                                <label for="">
                                                                    Category</label>
                                                                <div class="form-label-group">
                                                                    <select class="select2 form-control"
                                                                        name="category_id"
                                                                        id="create-product-category-attribute">
                                                                        <option selected>Select
                                                                            Category
                                                                        </option>
                                                                        {!! getCategorydropdown(0, 0, $course->category_id, 6) !!}

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="">Max Age</label>
                                                                    <div class="position-relative">
                                                                        <input type="number" id=""
                                                                            class="form-control" name="age"
                                                                            placeholder="" value="{{ $course->age }}">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6 mt-2">
                                                                <li class="d-inline-block mr-2">
                                                                    <fieldset>
                                                                        <div class="vs-radio-con">
                                                                            <input class="pRadio" type="radio"
                                                                                name="pRadio"
                                                                                onchange="priceRadioFunction(0)" checked
                                                                                value="0"
                                                                                {{ $course->p_type == 0 ? 'checked' : '' }}>
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
                                                                                {{ $course->p_type == 1 ? 'checked' : '' }}>
                                                                            <span class="vs-radio">
                                                                                <span class="vs-radio--border"></span>
                                                                                <span class="vs-radio--circle"></span>
                                                                            </span>
                                                                            <span class="">Premium</span>
                                                                        </div>
                                                                    </fieldset>
                                                                </li>
                                                            </div>
                                                            <div class="col-md-6 price"
                                                                style="display: {{ $course->p_type == 0 ? 'none' : '' }}">

                                                                <div class="form-group">
                                                                    <label for="">Price</label>
                                                                    <input type="number" class=" price form-control"
                                                                        name="price" placeholder="" id=""
                                                                        value="{{ $course->price }}">

                                                                </div>


                                                            </div>
                                                            <div class="col-12 " id="lesson-heading"
                                                                style="display:none">
                                                                <h2>New Lessons:</h2>
                                                            </div>
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
                                    <form action="{{ url('course/lessons') }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="form-body">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Lesson
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
                                                                        class="form-control" name="course_id"
                                                                        placeholder="" value={{ $course->_id }}>
                                                                    <input type="text" id=""
                                                                        class="form-control" name="lesson_title"
                                                                        placeholder="" required>

                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description"></textarea>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Thumbnail
                                                            </label>
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input  episode-custom-file-input"
                                                                    id="fileinput" name="thumbnail" required>

                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Content</label>
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="file-input custom-file-input  episode-custom-file-input"
                                                                    id="fileinput-0" onchange="multiduration(0)"
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
                                                    {{-- <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Module Overview
                                                            </label>
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input  episode-custom-file-input"
                                                                    id="fileinput" name="module_overview" required>

                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div> --}}
                                                    {{-- <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">KWL Worksheet

                                                            </label>
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input  episode-custom-file-input"
                                                                    id="fileinput" name="kwl_worksheet" required>

                                                                <label class="custom-file-label"
                                                                    for="inputGroupFile01">Choose
                                                                    file</label>
                                                            </div>
                                                        </fieldset>
                                                    </div> --}}
                                                    <div class="col-md-12">
                                                        <fieldset class="form-group">
                                                            <label for="basicInputFile">Lesson notes
                                                            </label>
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input  episode-custom-file-input"
                                                                    id="fileinput" name="lesson_notes" required>

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
                                </form>
                            </div>
                        </div>
                        <div class="modal fade bd-example-modal-lg" id="edit-episode" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <form action="{{ url('course/lessons') }}" method="POST" enctype="multipart/form-data">
                                    <div class="form-body">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Lesson
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
                                                                <input type="hidden" id="course_id" class="form-control"
                                                                    name="course_id" placeholder=""
                                                                    value="{{ $course->_id }}">
                                                                <input type="hidden" id="les_id" class="form-control"
                                                                    name="les_id" placeholder="">
                                                                <input type="text" class="form-control"
                                                                    id="modal-lesson-title" name="lesson_title"
                                                                    placeholder="" required>

                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <div class="col-12">
                                                    <label for="">Description</label>
                                                    <fieldset class="form-group">
                                                        <textarea class="form-control" id="modal_lesson_description" rows="3" placeholder="" name="description"></textarea>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12">
                                                    <fieldset class="form-group">
                                                        <label for="basicInputFile">Thumbnail
                                                        </label>
                                                        <div class="custom-file">
                                                            <input type="file"
                                                                class="custom-file-input  episode-custom-file-input"
                                                                id="fileinput" name="thumbnail" >

                                                            <label class="custom-file-label" for="inputGroupFile01">Choose
                                                                file</label>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12">
                                                    <fieldset class="form-group">
                                                        <label for="basicInputFile">Content</label>
                                                        <div class="custom-file">
                                                            <input type="file"
                                                                class="file-input custom-file-input  episode-custom-file-input"
                                                                id="fileinput-0" onchange="multiduration(0)"
                                                                name="podcast_file">
                                                            <input type="hidden" name="duration[]"
                                                                id="input-duration-0" />
                                                            <span id="duration-info-0"></span>
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose
                                                                file</label>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                {{-- <div class="col-md-12">
                                                    <fieldset class="form-group">
                                                        <label for="basicInputFile">Module Overview
                                                        </label>
                                                        <div class="custom-file">
                                                            <input type="file"
                                                                class="custom-file-input  episode-custom-file-input"
                                                                id="fileinput" name="module_overview">

                                                            <label class="custom-file-label" for="inputGroupFile01">Choose
                                                                file</label>
                                                        </div>
                                                    </fieldset>
                                                </div> --}}
                                                {{-- <div class="col-md-12">
                                                    <fieldset class="form-group">
                                                        <label for="basicInputFile">KWL Worksheet

                                                        </label>
                                                        <div class="custom-file">
                                                            <input type="file"
                                                                class="custom-file-input  episode-custom-file-input"
                                                                id="fileinput" name="kwl_worksheet">

                                                            <label class="custom-file-label" for="inputGroupFile01">Choose
                                                                file</label>
                                                        </div>
                                                    </fieldset>
                                                </div> --}}
                                                <div class="col-md-12">
                                                    <fieldset class="form-group">
                                                        <label for="basicInputFile">Lesson notes
                                                        </label>
                                                        <div class="custom-file">
                                                            <input type="file"
                                                                class="custom-file-input  episode-custom-file-input"
                                                                id="fileinput" name="lesson_notes">

                                                            <label class="custom-file-label" for="inputGroupFile01">Choose
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

            </section>
            <!-- // Basic Vertical form layout section end -->

        </div>
    </div>
    </div>

    <!-- END: Content-->
@endsection
