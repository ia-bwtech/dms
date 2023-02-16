@component('mail::message')
# Blind Side Bets


<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome - Blind Side Bets</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div class="text-center">
            User Email: {{ $data["email"] }}<br><br> Name:{{ $data["name"] }}<br><br> Subject:{{ $data["subject"] }}<br><br> Complain:{{ $data["complain"] }}
        </div>
    </body>
</html>

<br>
{{ env('APP_NAME') }}
@endcomponent
