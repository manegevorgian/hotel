<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Type;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\UserRoom;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except('index', 'show');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $types = Type::query()->withCount('rooms')->get();
        $colors = ['success','danger','warning','info','primary', 'secondary'];
        return view('types.index',compact('types', 'colors'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('types.actions.create');
    }

    /**
     * @param StoreTypeRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreTypeRequest $request)
    {
        $request->validated();
        Type::create($request->all());
        return redirect('/types')->with('success', 'Type is successfully saved');

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $rooms = Room::query()->where('type_id', $id)->with('type')->paginate(8);;
        $userBooked = UserRoom::query()->select('room_id')->where(['user_id'=> Auth::id(), 'status'=>'Booked'])->pluck('room_id')->toArray();
        return view('types.actions.show',compact('rooms','userBooked','id'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $type = Type::findOrFail($id);

        return view('types.actions.update', compact('type'));
    }

    /**
     * @param UpdateTypeRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateTypeRequest $request, $id)
    {
        $request->validated();
        $type = Type::find($id);
        $type->name = $request->name;
        $type->update();

        return redirect('/types')->with('success', 'Type Data is successfully updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return redirect('/types')->with('success', 'Type Data is successfully deleted');
    }
}
