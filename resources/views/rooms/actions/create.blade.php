@extends('layouts.app')

@section('content')
    <div class="card w-50 mx-5 my-5">
        <div class="card-header">
            Add Room
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
            <form method="post" action="{{ route('rooms.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="typeName">Type :</label>
                    <select id="typeName"  class="form-control" name="type_id">
                        @foreach($types as $type)
                            <option value="{{$type->id}}" class="dropdown-item btn btn-secondary dropdown-toggle" >
                                {{$type->name}} </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-primary my-2">Add Room</button>
            </form>
        </div>
    </div>
@endsection
