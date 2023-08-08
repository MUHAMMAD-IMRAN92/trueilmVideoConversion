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
        <iframe src="https://app.trueilm.com/epub-viewer?book_id={{ $book_id }}&user_id={{ $user_id }}"
            frameborder="0"></iframe>
    @else
        <strong>
            <center>
                UNAUTHORIZED !
            </center>
        </strong>
    @endif
</body>

</html>
<script type="text/javascript">

</script>
