@component('mail::message')
# Blind Side Bets

Unfortuantely you have lost a bet on Blind Side Bets

Bet Details:

Bet on: {{ $item->wagered_team == 'home_team' ? $item->home_team : $item->away_team }} <br>
Bet: {{ $item->odd_name }} <br>
Market: {{ $item->market_name }} <br>
League: {{ $item->league }} <br>
Sport: {{ $item->sport }} <br>
Odds: {{ $item->odds }} <br>
Risk: {{ $item->risk }}<br>
To Win: {{ $item->to_win }}<br>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bet Lost - Blind Side Bets</title>
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
