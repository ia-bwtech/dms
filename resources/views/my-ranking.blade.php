@extends('layouts.front.app')
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/my-ranking-style.css') }}">
@endsection

@section('content')
<div id="app" class="my-ranking-page">

<!-- Net Units -->
<odds-component></odds-component>
@if(request()->input('league'))
<odds-component :auth='@json(Auth::user())' :league_prop='@json(request()->input('league'))' :sport_prop='@json(request()->input('sport'))'></odds-component>
@else
<odds-component :auth='@json(Auth::user())' :league_prop='@json('MLB')' :sport_prop='@json('baseball')'></odds-component>
@endif
<!-- Net Units -->

</div>
@endsection
