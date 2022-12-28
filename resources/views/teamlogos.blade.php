<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($data as $team)
        <h2>{{ $team->team_name }}</h2>
        <img width="100px" height="100px" src="{{ asset("images/teams/" . $team->team_name . ".png") }}" alt="">
    @endforeach
</body>
</html>