<?php

namespace App\Http\Controllers\Monitor;
use App\Http\Controllers\Controller;
use App\Ideas;
use App\Workshop;
use App\Preferences;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class resultController extends Controller
{
    public function result()
    {
        $work = new Workshop();
        $prefer = new Preferences();
        $ideas = new Ideas();
        $work->setConnection('mysql2');
        $prefer->setConnection('mysql2');
        $ideas->setConnection('mysql2');
        if(!session('workshop_id')){
            session(
                [
                    'workshop_id'=>$work->where('monitor_id',auth()->user()->id)
                        ->where('created_at',
                            $work->selectRaw('MAX(created_at) as max')
                            ->where('monitor_id',auth()->user()->id)
                            ->get()->first()->max)
                            ->get()->first()->id
                ]
        );
        }
        if(!session('current_participants')){
            $workshop_id = $work->
            select('id')
            ->where('id', session('workshop_id'))
            ->first()->id;
            session([
                'current_participants' => DB::connection('mysql2')->table('participant_workshop')
                ->where('workshop_id', $workshop_id)
                ->get()->count()
            ]);
        }
        $count = $ideas->where('workshop_id',session('workshop_id'))->count();
        $rounds = $count - 1;
        $pref = $prefer->where('name', 'rounds-number')->first();
        if($pref && $pref->enable){
            $rounds = $rounds < $pref->value?$rounds:$pref->value;
        }
        $ended = ($count
            == $work->where('id',session('workshop_id'))->get()->first()->nbparticipants &&
                !$ideas->where('voted','<',$rounds)
            ->where('workshop_id',session('workshop_id'))
            ->exists())?'true':'false';
            if($ended == 'true'){
                session(['exit' => 1]);
            }
            echo json_encode([
                $ideas->join('idea_participant','idea_participant.idea_id','=','ideas.id')
                ->join('users','users.id','=','idea_participant.participants_id')
                ->select('ideas.idea', 'ideas.voted', 'ideas.score','users.name')
                ->where('ideas.workshop_id',session('workshop_id'))
                ->orderBy('score','DESC')->get()->all() ,
                        $ended,session('created')?session('created'):0
            ]);
    }
}


