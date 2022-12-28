@component('mail::message')
# The Hunch ATL

Welcome to the Hunch ATL! The premium sports betting platform!

Click below to get started!

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome - The Hunch ATL</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div class="text-center">
            <a class="btn btn-primary text-light" target="_blank" href="{{ route('user.my-ranking') }}">My Rankings</a>
        </div>
    </body>
</html>

<br>
{{ env('APP_NAME') }}
@endcomponent