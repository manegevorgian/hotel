@extends('layouts.app')

@section('content')
    @if(\Illuminate\Support\Facades\Auth::user()->admin == true)
        <div class="text-end mx-5">
            <a href="{{route('rooms.create')}}" class="btn btn-primary my-2 text-white">Create Room</a>
        </div>
    @endif
    <div class="container mw-50">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        @if(isset($rooms[0]))
        <table class="table w-75">
            <thead>
            <tr>
                <th>Number</th>
                <th>Room Type</th>
                @if(\Illuminate\Support\Facades\Auth::user()->admin == true)
                <th colspan="3" class="text-center">Actions</th>
                @endif
                <th>
                    <label for="typeFilter" class="form-label"></label>
                </th>
                <th>
                    <select name="typeFilter" id="typeFilter" class="form-select w-50">
                    <option value="" selected="selected">Select Type</option>
                    @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)
                <tr @if(in_array($room->id, $userBooked)) class="table-info" @endif data-type="type-{{$room->type->id}}">
                    <td>{{$room->id}}</td>
                    <td >{{$room->type->name}}</td>
                    <td><a href="{{ route('booking.create', $room->id)}}" class="btn btn-outline-primary px-5">Book</a></td>
                    @if(\Illuminate\Support\Facades\Auth::user()->admin == true)
                    <td><a href="{{ route('rooms.edit', $room->id)}}" class="btn btn-outline-secondary px-5">Edit</a></td>
                    <td>
                        <form action="{{ route('rooms.destroy', $room->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $rooms->links() }}
        @endif
    <div>

@endsection
