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
<div class="container-fluid" style="margin-top:10px;">
        <div class="row justify-content-center">
    <h1 style="color:white;" class="logo">Status:{{ $active=='true'?'Active':'Not Active' ?? '' }}</h1>
    @if($active && $active == 'false')
    <form class="d-flex align-items-center" action="{{route('monitor.startWorkshop')}}" method="POST">
        @csrf
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-0">
                <button style="color:white; font-size: 20px;" type="submit" name="submit" class="btn btn-link active">
                    Start
                </button>
            </div>
        </div>
    </form>
    @endif
    </div>
    <div class="row justify-content-center">
    <h2 style="cursor:pointer;"  class="logo">Key:<span id="k">{{ $key ?? '' }}</span></h2><button id="key" style="color:white;font-size: 20px;" class="btn btn-link active"  data-clipboard-target="#k">Copy</button>
    </div>
    @if(!$active || $active == 'false')
                <div class="card " style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                    <div class="card-header">Registered users</div>

                    <div class="card-body">
                        <table class="table table-primary table-striped" id="participants">
                            @csrf

                            <thead>
                                <tr>
                                    <th>
                                        User Name
                                    </th>

                                    <th>
                                        Email
                                    </th>

                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div id='q'></div>
    <script>
        $(document).ready(function() {
            var clip = new ClipboardJS('#key');
            clip.on("success", function(e){
                console.info("Copied!");
                e.clearSelection();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var result = "";
            $.ajax({
                url: "workshop",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                },
                dataType: "json",
                success: function(d) {
                    data = d[0];
                    console.log(d);
                    disabled = d[1] ? "disabled='disabled'" : "";
                    for (i = 0; i < data.length; i++) {
                        result += "<tr><td id='usr" + data[i].participant_id + "'>" +
                            data[i].name +
                            "</td>" +
                            "<td>" + data[i].email + "</td>" +
                            "<td><form method='post' action='RemoveUser/" + data[i].participant_id + "'>" +
                            "<input type='hidden' name='_token' value='{{csrf_token()}}'>" +
                            "<button " + disabled + " class='btn btn-danger'>Remove</button></form>" +
                            "</tr>";
                    }
                    $('#participants tr:last').after(result + "");
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#q').html(data.responseText + "");
                }
            });

            function update() {
                $.ajax({
                    url: "workshop",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                    },
                    dataType: "json",
                    success: function(d) {
                        if (d[1]) {
                            clearInterval(interval);
                        }
                        data = d[0];
                        console.log(d);
                        result = "";
                        $('#participants').empty();
                        $('#participants').html(
                            "<thead><tr><th>User Name</th><th>Email</th><th>Action</th></tr></thead>"
                        );
                        for (i = 0; i < data.length; i++) {

                            disabled = d[1] ? "disabled='disabled'" : "";
                            result += "<tr><td id='usr" + data[i].participant_id + "'>" +
                                data[i].name +
                                "</td>" +
                                "<td>" + data[i].email + "</td>" +
                                "<td><form method='post' action='RemoveUser/" + data[i].participant_id + "'>" +
                                "<input type='hidden' name='_token' value='{{csrf_token()}}'>" +
                                "<button " + disabled + " class='btn btn-danger'>Remove</button></form>" +
                                "</tr>";
                        }
                        $('#participants tr:last').after(result + "");
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#q').html(data.responseText + "");
                    }

                });
            }
            var interval = setInterval(function() {
                update();
            }, 5000);

        });
    </script>
</body>

</html>
@endsection
