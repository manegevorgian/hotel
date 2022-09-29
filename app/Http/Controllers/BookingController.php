<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Room;
use App\Models\UserRoom;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($id)
    {
        $room = Room::findOrFail($id);
        $bookings = UserRoom::where(['user_id'=>Auth::id(), 'status'=>'Booked'])->get();
        return view('rooms.actions.book', compact('room', 'bookings'));
    }

    /**
     * @param StoreBookingRequest $request
     */
    public function store(StoreBookingRequest $request)
    {
        $request->validated();
        $data = [
            'room_id' => $request->post('room_id'),
            'user_id' => Auth::id(),
            'date' => $request->post('date'),
        ];

        if(!UserRoom::query()->where($data)->first()){
            UserRoom::query()->create($data);
            return redirect('/rooms')->with('success', 'Room is successfully booked');
        }
        return back()->with('warning', 'You still booked for that date');
    }

    /**
     * @param $id
     * @param StoreBookingRequest $request
     */
    public function destroy($id)
    {
        $book = UserRoom::where('id',$id)->first();
        $book->status = 'Cancelled';
        $book->update();

        return redirect('/rooms')->with('success', 'Your booking was cancelled');
    }

    /**
     * @param UpdateRoomRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StoreBookingRequest $request, $id)
    {
        $request->validated();
        $data = [
            'room_id' => $request->post('room_id'),
            'user_id' => Auth::id(),
            'date' => $request->post('date'),
        ];
        if(!UserRoom::query()->where($data)->where('id','!=', $id)->get()){
            UserRoom::query()->where('id', $id)->update($data);
            return redirect('/rooms')->with('success', 'Booking is successfully updated');
        }
        return back()->with('warning', 'You still booked for that date');

    }

}
