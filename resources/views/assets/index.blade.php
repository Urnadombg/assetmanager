@extends('layouts.main')
@section('content')
@include('assets.breads')
    <div class="d">
    <h1 style="font-size: 72px">
        Активи
    </h1>
</div>
<a href="/assets/create" class="btn btn-dark">Добави</a>
<br>
<br>
    <b-container fluid>
        <asset-list></asset-list>
    </b-container>
@endsection
