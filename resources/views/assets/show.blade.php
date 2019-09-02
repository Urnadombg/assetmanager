@extends('layouts.main')
@section('content')
    {{ \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('asset',$asset) }}
    <b-container fluid>
        <asset-details :id="{{ $asset->id }}"></asset-details>
    </b-container>
@endsection
