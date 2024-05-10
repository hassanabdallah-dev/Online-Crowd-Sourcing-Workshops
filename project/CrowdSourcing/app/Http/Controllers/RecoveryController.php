<?php

namespace App\Http\Controllers;

use App\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RecoveryController extends Controller
{
    public function recover(){
        if(auth()->user()->hasRole("admin"))
            return redirect()->route('home');;
        if(!session('workshop_id')){
            $workshopid = 0;
            $work = new Workshop();
            if(auth()->user()->hasRole("monitor"))
            {
                $work->setConnection('mysql2');
                $conn = 'mysql2';
                $workshop = $work->where('monitor_id',auth()->user()->id)->first();
                if($workshop && ($workshop->active == true ||!DB::connection($conn)->table('ideas')->where('workshop_id',$workshop->id)->exists())){
                    $workshopid = $workshop->id;
                }
            }
            else if(auth()->user()->hasRole("participant")){
                $conn = 'mysql3';
                $work->setConnection('mysql3');
                $workshopid = $work->
                    join('participant_workshop','participant_workshop.workshop_id','=','workshop.id')
                    ->where('active',true)->first();
                    if($workshopid){
                        $workshopid = $workshopkey->id;
                    }
            }
            if($workshopid){
                session([
                    'workshop_id' => $workshopid
                ]);
                session(['recovery' => "recovery"]);
            }
        }
        else{
            $conn = auth()->user()->hasRole("monitor")?'mysql2':'mysql3';
        }
        if(DB::connection($conn)->table('group')->where('workshop_id', session('workshop_id'))->exists())
            session(['stage' => 1]);
        else
            session(['stage' => 0]);
        return redirect()->route('home');
    }
}
