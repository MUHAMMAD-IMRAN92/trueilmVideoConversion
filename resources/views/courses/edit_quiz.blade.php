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
                            <h2 class="content-header-title float-left mb-0">Edit Quiz </h2>
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


                            <form class="form form-vertical" id="disable-btn-submit" method="POST"
                                action="{{ route('quiz.update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->_id }}" id="">
                                <div class="input_append">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">

                                                    <h4>Select Lesson</h4>

                                                    <div class="form-label-group">
                                                        <select class="select2 form-control"name="lesson_id"
                                                            id="create-product-category-attribute">
                                                            {{-- <option selected disabled>Select
                                                                Lesson
                                                            </option> --}}
                                                            @foreach ($courseLesson as $clesson)
                                                                <option {{ $lesson_id == $clesson->_id ? 'selected' : '' }}
                                                                    value=" {{ $clesson->_id }}">
                                                                    {{ $clesson->title }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($question as $key => $q)
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="form-body">
                                                        <div class="row append-inputs">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <h6>Question :</h6>


                                                                    <div class="position-relative">
                                                                        <input type="text" id="question"
                                                                            class="form-control" name="question[]" required
                                                                            placeholder="" value="{{ $q->question }}">
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <h6>Correct Options:</h6>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <h6>Incorrect Options:</h6>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row col-12 m-0 p-0">
                                                                        <div class="col-6 d-flex m-0 p-0">
                                                                            <div class="col-6 m-0 p-0">
                                                                                <input type="hidden" id=""
                                                                                    class="form-control" name="lesson_id"
                                                                                    required placeholder=""
                                                                                    value="{{ $lesson_id }}">
                                                                                <input type="hidden" id=""
                                                                                    class="form-control" name="course_id"
                                                                                    required placeholder=""
                                                                                    value="{{ $course->_id }}">
                                                                                <input type="text"
                                                                                    class="question form-control"
                                                                                    name="correct-{{ $key }}[]"
                                                                                    placeholder=""
                                                                                    value="{{ @$q->options[0]->option }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <input type="text" id="question"
                                                                                    class="form-control"
                                                                                    name="correct-{{ $key }}[]"
                                                                                    required placeholder=""
                                                                                    value="{{ @$q->options[1]->option }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-6 m-0 p-0">

                                                                            <div class="col-12  d-flex m-0 p-0">
                                                                                <div class="col-6 ">
                                                                                    <input type="text" id="question"
                                                                                        class="form-control"
                                                                                        name="incorrect-{{ $key }}[]"
                                                                                        required placeholder=""
                                                                                        value="{{ @$q->options[2]->option }}">
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <input type="text" id="question"
                                                                                        class="form-control"
                                                                                        name="incorrect-{{ $key }}[]"
                                                                                        required placeholder=""
                                                                                        value="{{ @$q->options[3]->option }}">
                                                                                </div>


                                                                            </div>
                                                                            <br>
                                                                            <div class="col-12  d-flex m-0 p-0">
                                                                                <div class="col-6 ">
                                                                                    <input type="text" id="question"
                                                                                        class="form-control"
                                                                                        name="incorrect-{{ $key }}[]"
                                                                                        required placeholder=""
                                                                                        value="{{ @$q->options[4]->option }}">
                                                                                </div>
                                                                                <div class="col-6 ">
                                                                                    <input type="text" id="question"
                                                                                        class="form-control"
                                                                                        name="incorrect-{{ $key }}[]"
                                                                                        required placeholder=""
                                                                                        value="{{ @$q->options[5]->option }}">
                                                                                </div>


                                                                            </div> <br>

                                                                            <div class="col-12  d-flex m-0 p-0">
                                                                                <div class="col-6 ">
                                                                                    <input type="text" id="question"
                                                                                        class="form-control"
                                                                                        name="incorrect-{{ $key }}[]"
                                                                                        required placeholder=""
                                                                                        value="{{ @$q->options[6]->option }}">
                                                                                </div>
                                                                                <div class="col-6 ">
                                                                                    <input type="text" id="question"
                                                                                        class="form-control"
                                                                                        name="incorrect-{{ $key }}[]"
                                                                                        required placeholder=""
                                                                                        value="{{ @$q->options[7]->option }}">
                                                                                </div>


                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-12" style="text-align: right">
                                    <span type="" onclick="addQuestion()" class="btn btn-primary mr-1 mb-1"
                                        id="submit-btn">Add
                                        Question</span>
                                    <button type="submit" class="btn btn-primary mr-1 mb-1"
                                        id="submit-btn">Submit</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </section>
                <!-- // Basic Vertical form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
