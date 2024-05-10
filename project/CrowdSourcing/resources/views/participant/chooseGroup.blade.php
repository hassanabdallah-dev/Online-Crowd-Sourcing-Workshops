@extends('layouts.app')
@section('content')
<html>
<body>
    @csrf
    <div class="container" style="margin-top:30px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card " style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                    <div class="card-header">Group Registration</div>

                    <div class="card-body">
                        <table class="table  table-striped" id="groups">
                            <thead>
                                <tr>
                                    <th>
                                        Group Idea
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function testGroup() {
                setTimeout(function() {
                    $.ajax({
                        url: "testGroup",
                        type: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            for (i = 0; i < data.length; i++) {
                                if (!$('#' + data[i].id).length) {
                                    var line = "<tr id='" + data[i].id + "'>" +
                                        "<td>" + data[i].idea + "</td><td>" +
                                        '<form method="post" action="ChooseGroup">@csrf' +
                                        '<input type="hidden" name="grpId" value="' + data[i].id + '">' +
                                        '<input id="c' + data[i].id + '"class="btn btn-primary active" type="submit" name="submit" value="Register"></form></td></tr>';
                                    $('#groups tr:last').after(line);
                                }
                                if (data[i].full == true) {
                                    $('#' + data[i].id).css("background", "red");
                                    $('#c' + data[i].id).attr("disabled", true)
                                } else {
                                    $('#' + data[i].id).css("background", "");
                                    $('#c' + data[i].id).attr("disabled", false)
                                }
                            }

                        },
                        error: function(data) {
                            console.log('Error:', data);

                        }

                    });

                }, 3000)
            }
            setInterval(testGroup, 5000);
        });
    </script>
</body>

</html>
@endsection
