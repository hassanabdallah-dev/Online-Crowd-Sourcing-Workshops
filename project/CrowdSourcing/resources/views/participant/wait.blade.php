@extends('layouts.app')

@section('content')
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--<script src="project/resources/js/jquery.js"></script>-->
    <style>
    .rate {
	text-align: center;
	width: 200px;
}
.emoji {
	font-size: 50px;
	height: 45px;
	line-height: 45px;
}

input {
	cursor: ew-resize;
}
        #divVote {
            display: none;
        }

        html,
        body,
        #app {
            height: 100%;
        }

        main.py-4,
        .con {
            flex-direction: column;
            display: flex;
            align-items: center;
            justify-content: center;
            /*height: 100%;*/
        }

        .lds-ripple {
            display: inline-block;
            position: relative;
            width: 380px;
            height: 380px;
        }

        .lds-ripple div {
            position: absolute;
            border: 13px solid #fffffa;
            opacity: 1;
            border-radius: 50%;
            animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }

        .lds-ripple div:nth-child(2) {
            animation-delay: -0.5s;
        }

        @keyframes lds-ripple {
            0% {
                top: 144px;
                left: 144px;
                width: 0;
                height: 0;
                opacity: 1;
            }

            100% {
                top: 0px;
                left: 0px;
                width: 288px;
                height: 288px;
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container con">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
        <div id='divVote' class="w-100 h-100">

            <div class="container" style="margin-top:30px;">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card " style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                            <div class="card-header">Submit your score</div>

                            <div class="card-body con">
                                <form class="from-group con" method='post' action="{{ route('participant.updateScore') }}" id='userVote'>
                                    {{csrf_field()}}
                                    <label id='vote' name='idea'>
                                    </label>
                                    <label id='current_vote' value="75%" name='current_vote'>
                                    </label>
                                    <div style="height:15px;width:200px;" class="progress">
                                        <div id='vote_prog' class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                                    </div>
                                    <div class="pt-5 d-flex flex-direction-row justify-content-space-between">
                                    <input type='number' name='userScore' id='userScore'>
                                    </div>
                                    <input type='hidden' name='key_id' id='key_id' />
                                    <input type='hidden' value = "{{ session('recovery') ?? 'norecovery' }}" name='recovery' id='recovery' />
                                    <input type='hidden' name='SessionIndex' id='SessionIndex' value="{{session('i')}}" />
                                </form>
                                <button style="margin-top:10px;" class="btn btn-primary active"name='submit' id='submit'>Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var submited = 0;
                var recovery = $('#recovery').val();
                $('#submit').click(function() {
                    var val = $('#userScore').val();
                    if (!submited && val && val != "" && val >= 1 && val <= 5) {

                        submited = 1;
                        $('#userVote').submit();
                    }
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // $("#divVote").hide();
                i = $("#SessionIndex").val();

                if(recovery == "recovery"){
                    notification(i, 2);
                }

                else if (i == 1) {
                    notification(i, -1);
                } else {
                    testNextStep(0);
                }


                function testNextStep(isLastRound) {
                    setTimeout(function() {
                        $.ajax({
                            url: "testStep",
                            type: "POST",
                            data: {
                                isLastRound:isLastRound,
                                taken: i - 2
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                if (data[0] == "true") {
                                    anotherNotification(data[1]);
                                } else if (data[0] == "false") {
                                    testNextStep(0);
                                } else if (data[0] == "retry") {
                                    notification(i, 1);
                                }

                            },
                            error: function(data) {
                                console.log('Error:', data);

                            }

                        });
                    }, 5000);
                }

                function chooseGroup() {
                    $.ajax({
                        url: "chooseGroup",
                        type: "GET",
                        data: {},
                        success: function(data) {


                        },
                        error: function(data) {
                            console.log('Error:', data);

                        }

                    });
                }

                function anotherNotification(total) {
                    setTimeout(function() {

                        console.log("i = " + i);
                        console.log("total = " + total);
                        if (i < total) {
                            notification(i, 0);
                        }
                        else {
                            //alert('calling chooseGroup , i = '+i+', total = '+total);
                            window.location.replace("nextstage");

                            //chooseGroup();
                        }
                    }, 5000);
                }




                function notification(taken, flag) {
                    setTimeout(function() {
                        $.ajax({
                            url: "notify",
                            type: "POST",
                            data: {
                                _token: "{{csrf_token()}}",
                                taken: taken,
                                flag: flag
                            },
                            dataType: "json",
                            success: function(data) {
                                console.log(data);
                                if(data == "groups"){
                                    window.location.replace("nextstage");
                                }
                                else if (data == "") {
                                    notification(taken, 0);
                                } else if (data == "-1") {
                                    notification(i, -1);
                                } else {


                                    $("#vote").html('Idea: '+data[0]);
                                    $("#key_id").val(data[1]);
                                    $("#SessionIndex").val(data[2]);
                                    $('#current_vote').html(Math.floor(data[4])+'%');
                                    var wid = data[4]?data[4]:1;
                                    $('#vote_prog').css({
                                        width: wid + '%'
                                    });
                                    if (data[3] == false || (data.length == 6 && data[5] == "1")) {
                                        $('.lds-ripple').hide();
                                        $("#divVote").fadeIn();
                                    } else
                                        notification(taken, 1);
                                }
                            },
                            error: function(data) {
                                console.log('Error:', data);

                            }

                        });
                    }, 5000);
                }
            });
        </script>
</body>

</html>
@endsection
