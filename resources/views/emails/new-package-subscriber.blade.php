@component('mail::message')
# The Hunch ATL

You have a new subscriber to one of your packages!

# Package and User Details:

Subscriber: {{ $data->subscriber->name }} <br>
Package Name: {{ $data->package->name }} <br>
Price: {{ $data->package->price }} <br>
Duration: {{ $data->package->duration }} <br>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Package Subscribed - The Hunch ATL</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div class="text-center">
            <a class="btn btn-primary text-light" target="_blank" href="/user/packages">My Subscriptions</a>
        </div>
    </body>
</html>

<br>
{{ env('APP_NAME') }}
@endcomponent