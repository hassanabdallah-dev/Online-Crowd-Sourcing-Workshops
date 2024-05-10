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
                    <div class="card-header">Participate in Workshop</div>

                    <div class="card-body">
                        <form id='form' method="POST" action="{{ route('participant.userkey') }}">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="key" class="col-md-2 col-form-label text-md-right"> Key:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="key" id='userkey' required autofocus>
                                </div>
                            </div>
                        </form>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" id='submit' name="submit" class="btn btn-primary active">
                                    Submit
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var submited = 0;
            $('#submit').click(function() {
                var val = $('#userkey').val();
                if (!submited && val && val != "") {
                    submited = 1;
                    $('#form').submit();
                }
            });
        });
    </script>
</body>

</html>
@endsection
