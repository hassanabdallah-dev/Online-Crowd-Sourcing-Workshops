@extends('layouts.app')
@section('content')
<html>

<head>
</head>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                <div class="card-header"><h3>Group Idea: {{Session::get('current_group')}}</h3></div>

                    @if($active == 'true')
                        <div class="card-body">
                            <form method="POST" action="{{ route('participant.unregister') }}">
                                {{csrf_field()}}
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 ">
                                        <button type='submit' value='Unregister' name='submit' class="btn btn-primary active">
                                            Unregister
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>
</div>



<script>
    function isKicked(){
        $.ajax({
            url:"workonidea",
            type:"POST",
            data:{
                _token:"{{csrf_token()}}",
                group_id:"{{Session::get('group_id')}}",
                user_id:"{{auth()->user()->id}}"
            },
            dataType:"json",
            success:function(data){
                console.log(data);
                if(data == "true"){
                    window.location.replace("chooseGroup");
                }
                else{
                    setTimeout(isKicked, 5000);
                }
            },
            error:function(data){
                console.log(data);
            }
        });
    }
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        isKicked();
    });
</script>
</body>

</html>
@endsection
