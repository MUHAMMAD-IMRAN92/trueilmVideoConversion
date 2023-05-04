<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .body-class {
        background-image: url('../app-assets/images/backgrounds/static-page-image.png');
        height: 98vh;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .btn-color {
        background-color: blue;
        margin-left: 30%;
    }

    .logo {
        position: absolute;
        z-index: 1;
        top: 2rem;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<body class="body-class">
    <div class="logo">
        <img src="{{ asset('app-assets/images/backgrounds/staticlogo.png') }}" alt="">
    </div>
    <div class="row append" style="position: relative;">
        <center>
            <h2 style="color:white">Coming Soon!</h2>
        </center>
        <br><br>
        <form action="{{ url('post') }}" method="POST">
            @csrf
            <div class="mb-3">
                @if (\Session::has('msg'))
                    <span style="color:white;"> {{ \Session::get('msg') }} </span>
                @endif

                <input type="email" required class="form-control " id="exampleFormControlInput1"
                    placeholder="name@example.com" name="email">
            </div>
            <div class="ml-5">
                <button type="submit" id="submit" class="btn btn-primary mt-3 btn-color">Subscribe</button>
            </div>
        </form>
    </div>
    {{-- url('../app-assets/images/backgrounds/trueilm-logo') --}}

</html>
<script>
    $(document).ready(function() {
        // $('form').on('submit', function(e) {
        //     e.preventDefault();
        //     if ($('#exampleFormControlInput1').val() != "") {
        //         var html = `<div class="card">
        //     <div class="card-body">
        //         You Are Subscribed  Successfully!
        //     </div>
        //     </div> `;
        //         $('.append').html(html);
        //     } else {
        //         $('span').css('display', 'block');
        //     }

        // })
    });
</script>
