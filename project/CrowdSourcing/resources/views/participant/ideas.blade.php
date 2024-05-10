@extends('layouts.app')

@section('content')
<html>

<body>
    <div class="container" style="margin-top:30px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card " style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                    <div class="card-header">Submit Idea</div>

                    <div class="card-body">
                        <form id='form' method="POST" action="{{ route('participant.ideasubmit') }}">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="idea" class="col-md-2 col-form-label text-md-right"> Your idea:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="idea" id='idea' required autofocus>
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
                        <input type="hidden" value="{{auth()->user()->id}}"><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var submited = 0;
            $('#submit').click(function() {
                var val = $('#idea').val();
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
