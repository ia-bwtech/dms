@component('mail::message')
# {{ucfirst($data->name)}}

Continue signing up for {{ env('APP_NAME') }} by entering the code below:

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Blind Side Bets</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="text-center">
    <div class="d-flex justify-content-center align-items-center">
        @foreach(str_split($data->verification_code) as $char)
            <span class="m-1 p-3 text-xl border border-success font-weight-bolder">{{$char}}</span>
        @endforeach
    </div>
</div>
</body>
</html>

<br>
{{ env('APP_NAME') }}
@endcomponent

