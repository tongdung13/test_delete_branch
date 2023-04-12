@extends('admin.layouts.app')
@section('content')
    @php
        $cur_route = Route::current()->parameters();
        // $cur_route = Route::current()->getName(); // get ten route
        // $currenturl = URL::current(); //  get url after
        // $currenturl = URL::previous(); //  get url after
        // $currenturl = URL::full();previous //  get url after
        // $currenturl = Request::url(); // get url

        // dd($currenturl);

        // dd($cur_route);
        // dd($cur_route['id']);
    @endphp

    <div class="modal" id="myModal">
        <a href="" >Text</a>

    </div>
@endsection
