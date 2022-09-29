@extends('layouts.app')

@section('content')
    <div class="container mw-50">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->admin == true)
            <div class="my-2 flex-row align-content-lg-end">
                <table>
                    <tr>
                        <td><a href="{{ route('types.edit', $id)}}" class="btn btn-outline-primary my-2">Edit</a></td>
                        <td> <form action="{{ route('types.destroy', $id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" type="submit">Delete</button>
                            </form></td>
                    </tr>
                </table>
            </div>
        @endif
        <table class="table w-75">
            <thead>
            <tr>
                <td>Number</td>
                <td>Room Type</td>
                @if(\Illuminate\Support\Facades\Auth::user()->admin == true)
                <td colspan="2">Action</td>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)
                <tr @if(in_array($room->id, $userBooked)) class="table-info" @endif>
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
    <div>
    {{ $rooms->links() }}

@endsection
