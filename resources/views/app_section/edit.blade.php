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
                            <h2 class="content-header-title float-left mb-0">Edit Section</h2>
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
                                        <form class="form form-vertical" action="{{ route('app-section.update') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="form-body">
                                                    <div class="row ">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">Title</label>
                                                                <div class="position-relative"> <input type="hidden"
                                                                        id="" class="form-control" name="id"
                                                                        placeholder="" value="{{ $section->_id }}" required>
                                                                    <input type="text" id=""
                                                                        class="form-control" name="title" placeholder=""
                                                                        value="{{ $section->title }}" required>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">Sub Title</label>
                                                                <div class="position-relative">
                                                                    <input type="text" id=""
                                                                        class="form-control" name="sub_title"
                                                                        value="{{ $section->sub_title }}" placeholder="">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">Sequence</label>
                                                                <div class="position-relative">
                                                                    <input type="number" id=""
                                                                        value="{{ $section->sequence }}"
                                                                        class="form-control" name="sequence" placeholder="">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12" style="text-align: right">
                                                        <button type="submit"
                                                            class="btn btn-primary mr-1 mb-1">Submit</button>

                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Basic Tables start -->
                            <div class="row" id="basic-table">
                                <div class="col-12">

                                    <div class="card">

                                        <div class="card-content">
                                            <div class="card-body">

                                                <ul class="nav nav-pills nav-fill">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="books-tab-fill" data-toggle="pill"
                                                            href="#books-fill" aria-expanded="true">Books & Podcasts {{'('.count($section->ebook)+count($section->audioBook)+count($section->podcast).')'}}</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="course-tab-fill" data-toggle="pill"
                                                            href="#course-fill" aria-expanded="true">Courses {{'('.count($section->course).')'}}</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="books-fill"
                                            aria-labelledby="books-tab-fill" aria-expanded="true">
                                            <div class="card">

                                                <div class="card-content">
                                                    <div class="card-body">

                                                        <!-- Table with outer spacing -->
                                                        <div class="table-responsive">
                                                            <table class="table w-100" id="">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="">Title</th>
                                                                        <th class="">Category</th>
                                                                        <th class="">Author</th>
                                                                        <th class="">Type</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse ($books as $book)
                                                                        <tr>
                                                                            <td>{{ $book->title }}</td>
                                                                            <td>{{ $book->category->title }}</td>
                                                                            <td>{{ $book->author->name }}</td>
                                                                            @if ($book->type == 1)
                                                                                <td>Ebook</td>
                                                                            @elseif($book->type == 2)
                                                                                <td>Audio</td>
                                                                            @elseif($book->type == 7)
                                                                                <td>Podcast</td>
                                                                            @endif
                                                                        </tr>
                                                                    @empty
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Table with no outer spacing -->

                                                </div>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="course-fill"
                                            aria-labelledby="course-tab-fill" aria-expanded="true">
                                            <div class="card">

                                                <div class="card-content">
                                                    <div class="card-body">

                                                        <!-- Table with outer spacing -->
                                                        <div class="table-responsive">
                                                            <table class="table w-100" id="">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="">Title</th>
                                                                        <th class="">Category</th>
                                                                        <th class="">Author</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse ($course as $c)
                                                                        <td>{{ $c->title }}</td>
                                                                        <td>{{ $c->category->title }}</td>
                                                                        <td>{{ $c->author }}</td>

                                                                    @empty
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- Table with no outer spacing -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Basic Tables end -->
                        </div>
                    </div>
                </section>
                <!-- // Basic Vertical form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
