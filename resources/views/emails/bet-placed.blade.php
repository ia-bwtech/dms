@component('mail::message')
# The Hunch ATL

A new bet has successfully been placed.

Bet Details:

Bet on: {{ $data->wagered_team == 'home_team' ? $data->home_team : $data->away_team }} <br>
Bet: {{ $data->odd_name }} <br>
Market: {{ $data->market_name }} <br>
League: {{ $data->league }} <br>
Sport: {{ $data->sport }} <br>
Odds: {{ $data->odds }} <br>
Risk: {{ $data->risk }}<br>
To Win: {{ $data->to_win }}<br>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bet Placed - The Hunch ATL</title>
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