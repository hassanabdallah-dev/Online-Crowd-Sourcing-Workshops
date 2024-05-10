@extends('layouts.app')
@section('content')
<html>
<body>
@csrf
<div class="container">
<div class="alert alert-warning" role="alert">
  <strong>Please Wait!</strong> The workshop is not active yet.
  <br>You Will be redirected once it is active.
</div>

    </div>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function testactive() {

                $.ajax({
                    url: "testActive",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    dataType:"json",
                    success: function(data) {
                        if(data == 'home'){
                            window.location.replace('/home');
                        }
                        else if(data == 'ideas'){
                            window.location.replace('youridea');
                        }

                    },
                    error: function(data) {
                        console.log('Error:', data);

                    }

                });

            }

            setInterval(function() {
                testactive();
            }, 5000);


        });
    </script>
</body>

</html>
@endsection
