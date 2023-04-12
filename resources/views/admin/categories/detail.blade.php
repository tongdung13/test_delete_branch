@extends('admin.layouts.app')
@section('content')
    @php
        $cur_route = Route::current()->parameters();

dd($cur_route['id']);
    @endphp
@endsection
