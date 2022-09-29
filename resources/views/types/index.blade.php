@extends('layouts.app')

@section('content')
    <div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br/>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->admin == true)
        <div class="text-end mx-5">
            <a href="{{route('types.create')}}" class="btn btn-info my-2 text-white">Create Type</a>
        </div>
        @endif
        @if(isset($types[0]))
            <div class="container row my-5">

            @foreach($types as $type)
                <div class="col-2  mx-lg-5 row my-2">
                    <a href="{{route('types.show', $type->id)}}" class="card
                    text-decoration-none  bg-{{$colors[$type->id - 1] ?: rand($colors)}}">
                        <h4 class="card-title text-light my-2">
                            {{$type->name}}
                        </h4>
                        <h5 class="card-body text-light ">
                            {{$type->rooms_count}}
                        </h5>
                    </a>
                </div>
            @endforeach
        </div>
        @endif
    <div>
@endsection
