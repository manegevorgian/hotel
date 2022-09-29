<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Type;
use App\Models\UserRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except('index', 'filter');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $rooms = Room::with('type')->paginate(8);
        $userBooked = UserRoom::query()->select('room_id')->where(['user_id'=> Auth::id(), 'status'=>'Booked'])->pluck('room_id')->toArray();
        $types = Type::all();

        return view('rooms.index',compact('rooms', 'userBooked','types'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $types = Type::all();
        return view('rooms.actions.create', compact('types'));
    }

    /**
     * @param StoreRoomRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreRoomRequest $request)
    {
        $request->validated();
        Room::create($request->all());
        return redirect('/rooms')->with('success', 'Room is successfully saved');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show()
    {
        return view('types');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $types = Type::all();
        return view('rooms.actions.update', compact('room', 'types'));
    }

    /**
     * @param UpdateRoomRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateRoomRequest $request, $id)
    {
        $request->validated();
        $room = Room::find($id);
        $room->type_id = $request->type_id;
        $room->update();

        return redirect('/rooms')->with('success', 'Room Data is successfully updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect('/rooms')->with('success', 'Room Data is successfully deleted');
    }
    public function filter(Request $request)
    {
        $data = [
            'rooms' => Room::where('type_id', $request->type_id)->with('type')->paginate(8,['*'], 'page', $request->page),
            'userBooked' => UserRoom::query()->select('room_id')->where(['user_id'=> Auth::id(), 'status'=>'Booked'])->pluck('room_id')->toArray(),
            'admin' => Auth::user()->admin
        ];
        return response()->json($data);
    }
}
