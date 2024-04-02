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
                                        <form class="form form-vertical" action="{{ route('file.upload') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">

                                                <div class="col-md-12">
                                                    <fieldset class="form-group">
                                                        <label for="basicInputFile">Book</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="inputGroupFile01" name="file">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose
                                                                file</label>
                                                        </div>
                                                    </fieldset>
                                                </div>


                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>

                                                </div>
                                            </div>
                                        </form>

                                        {{-- <video width="352" height="198" controls>
                                            <source
                                                src="https://trueilm.s3.eu-north-1.amazonaws.com/test_files/video_OOw5HJJiAEYmaIp.m3u8"
                                                type="application/x-mpegURL">
                                        </video> --}}
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
<!-- CSS  -->
{{-- <link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet">

<h1>Video</h1>

<video id="my_video_1" class="video-js vjs-default-skin" controls preload="auto" width="640" height="268"
data-setup='{}'>
  <source src="http://iphone-streaming.ustream.tv/uhls/3064708/streams/live/iphone/playlist.m3u8" type='application/x-mpegURL'>
</video>

<script>
var player = videojs('my_video_1');
</script> --}}
