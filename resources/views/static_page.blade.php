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
        height: 97.8vh;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn-color {
        background-color: blue;
        margin-left: 30%;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<body class="body-class">
    <div class="row append">
        @csrf
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" class="form-control " id="exampleFormControlInput1" placeholder="name@example.com"
                name="email">
        </div>
        <div class="ml-5">
            <button type="submit" id="submit" class="btn btn-primary mt-3 btn-color">Subscribe</button>
        </div>
    </div>

</html>
<script>
    $(document).ready(function() {
        $('#submit').on('click', function() {
            var html = `<div class="card">
            <div class="card-body">
                You Are Subscribed  Successfully!
            </div>
            </div> `;
            $('.append').html(html);
        })
    });
</script>
