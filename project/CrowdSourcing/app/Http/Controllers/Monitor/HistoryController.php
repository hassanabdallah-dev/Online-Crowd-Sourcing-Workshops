<?php

namespace App\Http\Controllers\Monitor;

use App\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Workshop;
class HistoryController extends Controller
{
    public function index(){
        $workshops = DB::connection('mysql2')->table('monitorhistory')
        ->select('nbparticipants', 'name', 'location', 'created_at')
        ->where('monitor_id',auth()->user()->id)->get()->all();
        return view('monitor.history',
            [
                'workshops' => $workshops
            ]
            );
    }
}


