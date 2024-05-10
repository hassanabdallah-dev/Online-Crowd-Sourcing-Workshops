@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card" style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                <div class="card-header"><b>Edit User {{ $user->name }}<b></div>

                <div class="card-body">
                <form action="{{route('admin.users.update',$user->id)}}" method="post">
                    @csrf
                    {{ method_field('PATCH') }}
                    @foreach($roles as $role)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="{{$role->id}}" name="roles[]" class="custom-control-input" id="{{$role->name}}"
                        @if($user->hasRole($role->name)) checked @endif>
                        <label class="custom-control-label" for="{{$role->name}}">
                            <b>
                                {{$role->name}}
                            </b>
                        </label>
                    </div>
                    @endforeach
                    <div class=" pt-3">
                    <button class="btn btn-primary active">Edit</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
