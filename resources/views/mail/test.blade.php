@extends('admin.layouts.app')

@section('content')
<style>
    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th, td {
        border: 1px solid black;
        text-align:center;
    }
</style>
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
                @foreach ($content as $key => $item)
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
