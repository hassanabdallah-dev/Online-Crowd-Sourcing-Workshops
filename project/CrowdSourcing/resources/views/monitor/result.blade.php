@extends('layouts.app')
@section('content')
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    .wins{
        background:green;
    }
    </style>
</head>


<body>
<div class="container-fluid" style="margin-top:10px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card " style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                    <div class="card-header">Voting</div>

                    <div class="card-body">
                        <table class='table  table-striped' id="tableResult">

                            <tr>
                                <th>
                                    user id
                                </th>
                                <th>
                                    Idea
                                </th>
                                <th>
                                    score
                                </th>
                                <th>
                                    number of vote
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="nextStage" method="POST" action="groups/authenticate">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
    <script>
    function nextStage(){
        $('#nextStage').submit();
    }
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var result = "";
            var updateInterval = setInterval(function() {
                update();
            }, 5000);
            $.ajax({
                url: "result",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                },
                dataType: "json",
                success: function(data) {
                        console.log(data);
                        for (i = 0; i < data[0].length; i++) {
                            if(i<5)
                                    var j = 1;
                                else j = 0;
                            result += "<tr class='"+j+"'><td>" + data[0][i].name + "</td><td>" + data[0][i].idea + "</td><td>" + data[0][i].score + "</td><td>" + data[0][i].voted + "</td></tr>";
                        }

                    $('#tableResult tr:last').after(result + "");
                },
                error: function(data) {
                    console.log('Error:', data[0]);
                    $('#q').html(data.responseText + "");
                }

            });
            function update() {
                $.ajax({
                    url: "result",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    dataType: "json",
                    success: function(data) {

                        result = "<tr><th>user id</th><th>Idea</th><th>score</th><th>number of vote</th></tr>";
                        if(data[1] == 'true'){
                            clearInterval(updateInterval);
                            /*var rowCount = $('#tableResult tr').length;
                            if(rowCount > 5)
                                rowCount = 5;*/

                            console.log($("tr.1"));
                        }
                        $('#tableResult').empty();
                        $('#tableResult').html(result);
                        result = "";
                            for (i = 0; i < data[0].length; i++) {
                                if(i<5)
                                    var j = 1;
                                else j = 0;
                            result += "<tr class='"+j+"'><td>" + data[0][i].name + "</td><td>" + data[0][i].idea + "</td><td>" + data[0][i].score + "</td><td>" + data[0][i].voted + "</td></tr>";
                            }
                        $('#tableResult tr:last').after(result + "");
                        if(data[1] == 'true'){
                            $('.1').css("background","green");
                            $('.1').css("color","white");
                            setTimeout(function(){
                                nextStage();
                            },1000);
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }

                });
            }


        });
    </script>
</body>

</html>
@endsection
