<?php

namespace App\Http\Controllers\Monitor;

use App\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Workshop;
class exitController extends Controller
{
    public function exit(){
        session()->forget('exit');
        session()->forget('workshop_id');
        session()->forget('current_participants');
        return redirect()->route('home');
    }
    public function end(){
        session()->forget('exit');
        session()->forget('workshop_id');
        session()->forget('current_participants');
        $work = new Workshop();
        $work->setConnection('mysql2');
        $work->where('monitor_id', auth()->user()->id)->update(['active' => false]);
        return redirect()->route('home');
    }
}


