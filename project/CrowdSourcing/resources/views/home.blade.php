@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:30px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-success" style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7; ">
                <div class="card-header ">Success</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
