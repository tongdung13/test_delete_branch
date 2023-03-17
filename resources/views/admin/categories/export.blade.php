@extends('admin.layouts.app')

@section('content')
    <div class="container">
       <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Cid</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->cid }}</td>
                    </tr>
                @endforeach
            </tbody>
       </table>
    </div>
@endsection
