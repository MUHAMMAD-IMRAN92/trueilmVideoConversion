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
                            <h2 class="content-header-title float-left mb-0">Edit Book</h2>
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
                                        <form class="form form-vertical" action="{{ route('book_for_sale.update') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Name</label>
                                                            <div class="position-relative">

                                                                <input type="hidden" id="book_for_sale_id"
                                                                    class="form-control" name="id" placeholder=""
                                                                    value="{{ $book->_id }}" required>
                                                                <input type="text" id="" class="form-control"
                                                                    name="title" placeholder=""
                                                                    value="{{ $book->title }}" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" name="description">{{ $book->description }}</textarea>
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

                                                    <div class="col-6">
                                                        <fieldset class="form-group" style="">
                                                            <label for="category">Category</label>
                                                            <select class="select2 form-control" name="category"
                                                                id="category">
                                                                <option disabled selected>Select Category</option>
                                                                @foreach ($categories as $category)
                                                                    <option
                                                                        {{ $book->category_id == $category->_id ? 'selected' : '' }}
                                                                        value="{{ $category->_id }}">
                                                                        {{ $category->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Author</label>
                                                            <input type="text" id="" class="form-control"
                                                                name="author" placeholder="" value="{{ $book->author }}"
                                                                required>

                                                        </div>
                                                    </div>




                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Serial Number</label>
                                                            <input type="text" id="" class="form-control"
                                                                name="sr_no" placeholder="" value="{{ $book->serial_no }}"
                                                                required>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="">Price</label>
                                                            <input type="text" id="" class="form-control"
                                                                name="price" placeholder=""
                                                                value="{{ $book->price }}" required>

                                                        </div>


                                                    </div>
                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label for="">Quantity</label>
                                                            <input type="number" id="" class="form-control"
                                                                name="quantity" placeholder=""
                                                                value="{{ @$book->inventory->quantity }}" required>

                                                        </div>


                                                    </div>

                                                    <div class="col-6">

                                                        <label for="">Countries</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="countries[]"
                                                                id="countries" multiple>

                                                                @foreach ($countries as $country)
                                                                    <option
                                                                        @if ($oldCountries) {{ in_array($country, $oldCountries) ? 'selected' : '' }} @endif
                                                                        value="{{ $country }}">
                                                                        {{ $country }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">

                                                        <label for="">Cities</label>
                                                        <fieldset class="form-group">
                                                            <select class="select2 form-control" name="cities[]"
                                                                id="cities" multiple>

                                                                @foreach ($oldCities as $city)
                                                                    <option selected value="{{ $city }}">
                                                                        {{ $city }}</option>
                                                                @endforeach

                                                            </select>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">


                                                    </div>
                                                    <div class="col-6">

                                                        @foreach ($oldCities as $city)
                                                           <h4> <span class="badge badge-secondary">{{ $city }}</span></h4>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-12">
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
