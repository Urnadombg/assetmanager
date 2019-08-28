@extends('layouts.main')
@section('content')
    <b-container fluid>
        <b-card bg-variant="primary"
                header-text-variant="white"
                body-bg-variant="white"
                text-variant="black"
                text-variant="white">
            <div slot="header">
                <h1>
                    Редакция на {{ $asset->title . ' ' . $asset->model }}
                </h1>
            </div>
            <b-card-body>

            </b-card-body>
        </b-card>
{{--        <asset-details :id="{{ $id }}"></asset-details>--}}
    </b-container>
@endsection
