@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="color:white; font-weight:bold; background-color:#00b0dc; opacity:0.7;">
                <div class="card-header"><b>Preferences<b></div>

                <div class="card-body">
                    <form action="{{route('admin.preferences.change')}}" method="post">
                        @csrf
                        <?php $pos = 1;?>
                        @foreach($preferences as $preference)
                        <div class="custom-control custom-checkbox">
                            <input @if($preference->name == "rounds-number")id='rounds-number' @endif type="checkbox" value="{{$preference->id}}" name="prefs[]" class="settings custom-control-input {{$pos}}" id="{{ $preference->name }}"
                            @if($preference->enable) checked @endif>
                            <label class="custom-control-label" for="{{ $preference->name }}">
                                <b>
                                    {{ $preference->descripton }}
                                </b>
                            </label>
                            @if($preference->name == "rounds-number")
                            <input type="number" value='{{$preference->value}}' id='nbrounds' name="rounds">
                            @endif
                        </div>
                        <?php $pos++;?>
                        @endforeach
                        <div class=" pt-3">
                            <input id="save" value="Save" type="submit" class="btn btn-primary active" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
$(document).ready(function(){
    var rounds = $('#nbrounds').val();
    $("#nbrounds").bind('keyup mouseup', function () {
        if($('#nbrounds').val() !="" && $('#nbrounds').val() != rounds){
            $('#save').prop('disabled', false);
        }
        else{
            $('#save').prop('disabled', true);
        }
    });
    if($('#rounds-number').is(":checked")){
        $("#nbrounds").prop('required',true);
        $('#nbrounds').show();
    }
    else{
        $("#nbrounds").prop('required',false);
        $('#nbrounds').hide();
    }
    $('#rounds-number').click(function(){
        if($(this).is(":checked")){
            $("#nbrounds").prop('required',true);
            $('#nbrounds').show();
        }
        else{
            $("#nbrounds").prop('required',false);
            $('#nbrounds').hide();
        }
    });
    var array = [];
    var changed = 0;
    $(".settings").each(function(i, v) {
                array.push($(v).prop("checked")?1:0);
                $(v).click(function(){
                    if(array[i] == ($(v).prop("checked")?1:0)){
                        changed--;
                    }
                    else
                        changed++;
                    if(changed == 0){
                        $('#save').prop('disabled', true);
                    }
                    else{
                        $('#save').prop('disabled', false);
                    }
                });

    });
});
</script>
@endsection
