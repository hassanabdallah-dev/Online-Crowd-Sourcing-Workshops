@extends('layouts.app')
@section('content')
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<body>
<div class="container-fluid" style="margin-top:10px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card " style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                    <div class="card-header">Group Registration</div>

                    <div class="card-body">
                            <table id="grouping" class='table  table-striped' id="tableResult">

                                <tr>
                                    <th>
                                        User Name
                                    </th>
                                    <th>
                                        Group Idea
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                    <th>
                                </tr>

                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
                function disable(){
                $(':button').prop('disabled', true);
            }
    function getData(){
        var result = "";
        $.ajax({
                url:"groups",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}"
                },
                dataType:"json",
                success:function(data){
                    console.log(data);
                    if(data.length){

                    result = "<tr><th>User Id</th><th>Group Id</th><th>Actions</th><th></tr>";
                    $('#grouping').empty();
                    $('#grouping').html(result);
                    result = "";
                    tok = '<input type="hidden" name="_token" value="{{csrf_token()}}">';
                    for(i = 0;i<data[0].length;i++){
                        //full group_id user_id
                        var gid = data[0][i].group_id;
                        var uname = data[0][i].name;
                        var gname = data[0][i].idea;
                        var uid = data[0][i].user_id;
                        background = data[0][i].full?"style='background-color:red;'":"";
                        result += "<tr "+background+"><td>"+uname+"</td><td>"+gname+"</td><td>"+
                        "<form onsubmit='disable();' method='POST' action='"+window.location.href+"/kick/"+gid+"/"+uid+"'>"+
                        "<button class='btn btn-primary active'>Kick</button>"+tok;
                    }
                    $('#grouping tr:last').after(result + "");
                    if(data[1] == 'false'){
                        setTimeout(function(){
                            window.location.replace("home");
                        },5000)
                    }
                    }
                    result= "";
                    setTimeout(() => {
                        getData();
                    }, 8000);
                },
                error:function(data){
                    window.location.replace('home');
                    /*console.log(data);
                    setTimeout(function(){
                        getData();
                    },5000);*/
                }
            });
    }
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                getData();
        });
    </script>
</body>

</html>
@endsection
