<?php

namespace App\Http\Controllers\Participant;

use App\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Workshop;
class ContinueController extends Controller
{
    public function continue(){
        if(session('stage') == 1){
            return redirect()->route('participant.chooseGroup');
        }
        else{
            return redirect()->route('participant.wait');
        }
    }
}


