@extends('layouts.main')
@section('content')
    <div>
        <customers-list :clist="{{ $customers }}"></customers-list>
    </div>
@endsection
