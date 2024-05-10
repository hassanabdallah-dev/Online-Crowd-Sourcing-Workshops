@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
        <div class="card" style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                <div class="card-header"><b>Users<b></div>

                <div class="card-body">
                <table id="users_table" class="table  table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Actions</th>
                        <th scope="col">Activation</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                    <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ implode(" | ",$user->roles()->get()->pluck('name')->toArray()) }}</td>
                        <td class="d-flex flex-direction-column">
                            <a class="pr-3" href="{{ route('admin.users.edit',$user->id) }}"><button class="btn btn-primary active">Edit</button></a>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="post">
                            @csrf
                            {{method_field('DELETE')}}
                                <button type="submit" class="btn btn-danger"
                                @if($user->hasRole('admin') && !$delete_admin) disabled @endif>Delete</button>
                            </form>
                        </td>
                        <td>
                        @if($valid_pref && !$user->activated)
                            <a href="{{ route('admin.users.activate', $user->id) }}">
                            <button class="btn btn-primary active active">Activate</button></a>
                        @else
                            @if($user->activated)
                                <div title="Active" class="alert alert-success p-2 m-0 text-center" role="alert">
                                    @if(!$user->hasRole('admin') || $deac_admin)
                                    <a style="color:inherit;"
                                    title="Deactivate"
                                    href="{{ route('admin.users.deactivate', $user->id) }}">
                                    @endif
                                        <strong>Active</strong>
                                        @if(!$user->hasRole('admin') || $deac_admin)</a>@endif
                                </div>
                            @else
                                <div class="alert alert-danger p-2 m-0 text-center" role="alert">
                                    <a style="color:inherit;text-decoration:none;" title="Activate" href="{{ route('admin.users.activate', $user->id) }}">
                                        <strong>Not Active</strong>
                                    </a>
                                </div>
                            @endif
                        @endif
                        </td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
