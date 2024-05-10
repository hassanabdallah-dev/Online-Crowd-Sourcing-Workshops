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
                    <div class="card-header">Create Workshop</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('monitor.creation') }}">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name of Workshop</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="location" class="col-md-4 col-form-label text-md-right">Address</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="location" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nb" class="col-md-4 col-form-label text-md-right">Number of participents</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="nbparticipants" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" name="submit" class="btn btn-primary active">
                                        Create
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
@endsection
