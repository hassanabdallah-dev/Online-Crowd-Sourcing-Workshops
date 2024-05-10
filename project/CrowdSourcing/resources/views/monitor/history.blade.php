@extends('layouts.app')
@section('content')
<html>

<head>
</head>

<body>
    <div class="container" style="margin-top:30px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card " style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                    <div class="card-header">Workshops Histroy</div>

                    <div class="card-body">
                        <table class="table ">
                        <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Number of Participants</th>
                        <th>Date of Creation</th>
                        </tr>
                        @foreach($workshops as $w)
                            <tr><td>{{$w->name}}</td><td>{{$w->location}}</td><td>{{$w->nbparticipants}}</td><td>{{$w->created_at}}</td></tr>
                        @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
@endsection
