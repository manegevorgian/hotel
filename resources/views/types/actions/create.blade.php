@extends('layouts.app')

@section('content')
    <div class="card  w-50 mx-5 my-5">
        <div class="card-header">
            Add Type
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('types.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="typeName">Name :</label>
                    <input id="typeName" type="text" class="form-control" name="name"/>
                </div>
                <button type="submit" class="btn btn-outline-primary my-2">Add Type</button>
            </form>
        </div>
    </div>
@endsection
