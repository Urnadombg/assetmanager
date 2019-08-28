@extends('layouts.main')
@section('content')
<div class="row">
    <h1>
        Компоненти
    </h1>
</div>
    <b-container fluid>
        {{ $components }}
{{--        <asset-list></asset-list>--}}
        <components-list></components-list>
    </b-container>
@endsection
