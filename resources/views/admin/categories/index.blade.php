@extends('admin.layouts.app')

@section('content')
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1>Category List</h1>
            </div>
            <div class="col-6">
                <form action="{{ route('categories.index') }}" method="get">
                    <div style="float: right;">
                        <div class="form-group">
                            <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                                placeholder="Name" style="width: 200px;">
                        </div>
                        <button type="submit" class="btn btn-success">Loc</button>
                        <a href="{{ route('categories.sendMail') }}" class="btn btn-secondary">Send</a>
                        <a href="{{ route('categories.export', [
                            'name' => request('name')
                        ]) }}" class="btn btn-primary">Export</a>
                    </div>


                </form>

            </div>
        </div>
    </div>
@endsection
