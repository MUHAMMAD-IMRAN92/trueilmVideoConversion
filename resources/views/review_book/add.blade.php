@extends('layouts.default_layout')

@section('content')
    <style>
        /* body {
          margin: 40px;
        } */

        .rating {
            margin-top: 40px;
            border: none;
            float: left;
        }

        .rating>label {
            color: #90A0A3;
            float: right;
        }

        .rating>label:before {
            margin: 5px;
            font-size: 2em;
            font-family: FontAwesome;
            content: "\f005";
            display: inline-block;
        }

        .rating>input {
            display: none;
        }

        .rating>input:checked~label,
        .rating:not(:checked)>label:hover,
        .rating:not(:checked)>label:hover~label {
            color: #F79426;
        }

        .rating>input:checked+label:hover,
        .rating>input:checked~label:hover,
        .rating>label:hover~input:checked~label,
        .rating>input:checked~label:hover~label {
            color: #FECE31;
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
                            <h2 class="content-header-title float-left mb-0">Add Review</h2>
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
                                        <form class="form form-vertical" action="{{ route('review.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <input type="hidden" id="" name="id"
                                                        value="{{ $reviewBook->_id }}" />
                                                    <div class="col-12">
                                                        <label for="">Description</label>
                                                        <fieldset class="form-group">
                                                            <textarea class="form-control" id="basicTextarea" rows="3" placeholder="" value=""
                                                                name="review_description">{{ $reviewBook->review_description }}</textarea>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-12">

                                                        <div class="rating">

                                                            <input type="radio" id="star5" name="rating"
                                                                value="5"
                                                                {{ $reviewBook->rating == 5 ? 'checked' : '' }} />
                                                            <label class="star" for="star5" title="Awesome"
                                                                aria-hidden="true"></label>
                                                            <input type="radio" id="star4" name="rating"
                                                                value="4"
                                                                {{ $reviewBook->rating == 4 ? 'checked' : '' }} />
                                                            <label class="star" for="star4" title="Great"
                                                                aria-hidden="true"></label>
                                                            <input type="radio" id="star3" name="rating"
                                                                value="3"
                                                                {{ $reviewBook->rating == 3 ? 'checked' : '' }} />
                                                            <label class="star" for="star3" title="Very good"
                                                                aria-hidden="true"></label>
                                                            <input type="radio" id="star2" name="rating"
                                                                value="2"
                                                                {{ $reviewBook->rating == 2 ? 'checked' : '' }} />
                                                            <label class="star" for="star2" title="Good"
                                                                aria-hidden="true"></label>
                                                            <input type="radio" id="star1" name="rating"
                                                                value="1"
                                                                {{ $reviewBook->rating == 1 ? 'checked' : '' }} />
                                                            <label class="star" for="star1" title="Bad"
                                                                aria-hidden="true"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>

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
