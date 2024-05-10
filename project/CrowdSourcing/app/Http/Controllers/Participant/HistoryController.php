<?php

namespace App\Http\Controllers\Participant;

use App\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Workshop;
class HistoryController extends Controller
{
    public function index(){
        $workshops = DB::connection('mysql3')->table('userhistory')
        ->select('name', 'location','created_at')
        ->where('participant_id',auth()->user()->id)->get()->all();
        return view('participant.history',
            [
                'workshops' => $workshops
            ]
            );
    }
}


