@extends('layouts.app')

@section('content')
    <div class="w-50 mx-5">
        @if(session()->get('warning'))
            <div class="alert alert-warning">
                {{ session()->get('warning') }}
            </div><br/>
        @endif
    </div>

    <div class="card w-50 mx-5">
        <div class="card-header">
            Book a Room
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br/>
            @endif
            <form method="post" action="{{ route('booking.store') }}">
                @csrf
                <div class="form-group">
                    <label for="roomName">Room Number : </label>
                    <input type="text" class="form-control" name="room_id" value="{{ $room->id }}" readonly>
                </div>
                <div class="form-group">
                    <label for="date">Select Date :</label>
                    <input class="form-control" id="date" name="date" type="date" min="{{date('Y-m-d')}}">
                </div>
                <div class="form-group my-3 text-end">
                    <button type="submit" class="btn btn-outline-primary">Book the Room</button>
                </div>


            </form>
        </div>
    </div>
    <hr class="my-5">
    @if(isset($bookings[0]))
    <h4 class="mx-5 card-header">ALREADY BOOKED</h4>
    <div class="row">
        @foreach($bookings as $booking)
            <div class="card mx-5 my-5 w-25">
                <div class="card-header text-end bg-white">
                    <form  action="{{ route('booking.destroy', $booking->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit"  title="Cancel Booking">X</button>
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div><br/>
                        @endif
                        <div class="row">
                            <form method="post" action="{{ route('booking.update',$booking->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="roomName">Room Number : </label>
                                    <input type="text" class="form-control" name="room_id" value="{{ $room->id }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="date">Select Date :</label>
                                    <input class="form-control" id="date" name="date" value="{{$booking->date}}" type="date"
                                           min="{{date('Y-m-d')}}">
                                </div>
                                <div class="form-group my-3  text-end">
                                    <button type="submit" class="btn btn-outline-primary">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
    @endif
@endsection
