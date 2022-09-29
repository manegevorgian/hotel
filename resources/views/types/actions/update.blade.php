@extends('layouts.app')

@section('content')
    <div class="card w-50 mx-5 my-5">
        <div class="card-header">
            Edit Type Data
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
            <form method="post" action="{{ route('types.update', $type->id ) }}">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="name">Type Name:</label>
                    <input type="text" id="name" class="form-control" name="name" value="{{ $type->name }}"/>
                </div>
                <div class="text-end">
                <button type="submit" class="btn btn-outline-primary my-2 ">Update Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
