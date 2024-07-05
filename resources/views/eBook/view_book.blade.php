<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>True ILM</title>
</head>
<style>
    iframe {
        width: 100%;
        height: 100vh;
    }
</style>

<body oncontextmenu="return false">
    @if (auth()->user())
        <iframe src="https://061c-119-155-3-197.ngrok-free.app/epub-viewer/{{ $book_id }}?auth_token={{auth()->user()->_id}}&render={{$render}}" frameborder="0"></iframe>
    @else
        <strong>
            <center>
                UNAUTHORIZED !
            </center>
        </strong>
    @endif
</body>

</html>
<script type="text/javascript"></script>
