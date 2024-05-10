<?php

namespace App\Http\Controllers\Participant;

use App\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Workshop;
class exitController extends Controller
{
    public function exit(){
        session()->forget('workshop_id');
        session()->forget('i');
        session()->forget('users');
        session()->forget('refresh');
        session()->forget('idea_id');
        session()->forget('current_group');
        session()->forget('group_id');
        return redirect()->route('home');
    }
}


