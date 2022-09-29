@extends('layouts.app')

@section('content')
    <div class="card w-50 mx-5 my-5">
        <div class="card-header">
            Edit Room Data
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
            <form method="post" action="{{ route('rooms.update', $room->id ) }}">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="typeName">Type :</label>
                    <select id="typeName"  class="form-control" name="type_id">
                        @foreach($types as $type)
                            <option value="{{$type->id}}"
                                    @if($room->type_id == $type->id)
                                    selected="selected"
                                    @endif
                                    class="dropdown-item btn btn-secondary dropdown-toggle" >
                                {{$type->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-outline-primary my-2">Update Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
