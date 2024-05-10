<?php

namespace App\Http\Controllers\Participant;
use App\Http\Controllers\Controller;
use App\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Workshop;
use App\Preferences;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class notifyController extends Controller
{
    /*public function testidea(){

        }*/
    public function notify()
    {
        $flag1 = false;
        $array = array();
        if(!session('stage')){
            session(['stage' => 0]);
        }
        $iddd = new Ideas();
        $iddd->setConnection('mysql3');
        $total=$iddd->where('workshop_id',session('workshop_id'))
        ->count();
        $flag = request()->get('flag');
        if($flag == 2){
            $flag1 = true;
            $i = $iddd->selectRaw('MIN(voted) as i')
                ->where('workshop_id',session('workshop_id'))->first()->i +1;
            session(['i' => $i]);
            $my_id = DB::connection('mysql3')->table('idea_participant')
                        ->join('ideas', 'ideas.id', '=', 'idea_participant.idea_id')
                        ->where('ideas.workshop_id', session('workshop_id'))
                        ->where('participants_id',auth()->user()->id)->first();
            if($my_id){
                $my_id = $my_id->idea_id;
                session(['idea_id' => $my_id]);
            }
                $taken = DB::connection('mysql3')->table('participant_idea_original')
                ->join('ideas', 'ideas.id', '=', 'id_idea')
                ->select('id_idea')
                ->where('id_participant',auth()->user()->id)
                ->where('ideas.workshop_id',session('workshop_id'))
                ->orderBy('created_at', 'DESC')
                ->get()->pluck('id_idea')->all();
                $all_ideas = $iddd->select('id')
                ->where('workshop_id',session('workshop_id'))
                ->whereNotIn('id', $taken)
                ->get()->pluck('id')->all();
                sort($all_ideas);
                $all_ideas_length = count($all_ideas);
                $start = array_search($my_id, $all_ideas);
                $start = ($start+1)%($all_ideas_length);
                $my_ideas = array();
                $j=0;
                for($i = $start;$j<$all_ideas_length && $all_ideas[$i] != $my_id;$i = ($i+1)%($all_ideas_length)){
                    $my_ideas[$j] = $all_ideas[$i];
                    $j++;
                }
                session([
                    'users.ideass' => $my_ideas
                    ]);
                $flag = 0;
                session(['refresh'=>1]);
                $next_idea = $taken[0];

        }
        if($flag == -1){
            $work = new Workshop();
            $work->setConnection('mysql3');
            $all_submit = (($total) == (
                $active = $work->select('nbparticipants')
                ->where('id',session('workshop_id'))->get()->first()->nbparticipants)
            );
            if(!$all_submit)
                echo json_encode("-1");
            else
            {

                $my_id = session('idea_id');
                $all_ideas = $iddd->select('id')->where('workshop_id',session('workshop_id'))
                ->get()->pluck('id')->all();
                sort($all_ideas);
                $all_ideas_length = count($all_ideas);
                $start = array_search($my_id, $all_ideas);
                $start = ($start+1)%($all_ideas_length);
                $my_ideas = array();
                $j=0;
                for($i = $start;$j<$all_ideas_length && $all_ideas[$i] != $my_id;$i = ($i+1)%($all_ideas_length)){
                    $my_ideas[$j] = $all_ideas[$i];
                    $j++;
                }
                session([
                    'users.ideass' => $my_ideas
                    ]);
                $flag = 0;
                session(['refresh'=>1]);
            }
        }
        $preferences = new Preferences();
        $preferences->setConnection('mysql3');
        if ($flag == 1 ){
            $idea = $iddd->where('id', session('idea_id'))
            ->get()->first();
            $idea->flag = true;
            $idea->save();
            $array[0] = $idea->idea;
            $array[1] = $idea->id;
            $array[2] = session('i');
            $array[3] = $iddd->where('workshop_id',session('workshop_id'))
                ->where('flag', false)->exists();
            $total=$iddd->where('workshop_id',session('workshop_id'))
                ->count()-1;
            $pref = $preferences->where('name','rounds-number')->first();
            if($pref->enable){
                $total = $total < $pref->value?$total:$pref->value;
            }
            $total = ($idea->score/($total * 5))*100;
            $array[4]=$total;
            echo json_encode($array);
        }
        if($flag == 0){
            if($flag1 == false){$array = array();
            $my_ideas = session('users.ideass');
            $next_idea = array_shift($my_ideas);
            DB::connection('mysql3')->table('participant_idea_original')
            ->insert([
                'id_participant' => auth()->user()->id,
                'id_idea' => $next_idea,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ]);
            session([
                'users.ideass' => $my_ideas,
            ]);
            }
            DB::connection('mysql3')->transaction(function () use ($array,$next_idea, $iddd, $preferences) {
                $idea = $iddd->where('id', $next_idea)
                ->first();
                session([
                    'idea_id' => $next_idea,
                ]);
                $idea->participant_id = auth()->user()->id;
                $idea->flag = true;
                $idea->taken++;
                $idea->save();
                $i = session('i');
                $i += 1;
                session(['i' =>  $i]);
                $array[0] = $idea->idea;
                $array[1] = $idea->id;
                $array[2] = $i;
                $all_ideas = $iddd->where('workshop_id',session('workshop_id'))
                    ->where('flag', false)->exists();
                $array[3]=$all_ideas;
                $total=$iddd->where('workshop_id',session('workshop_id'))
                ->count()-1;
                $pref = $preferences->where('name','rounds-number')->first();
                if($pref->enable){
                $total = $total < $pref->value?$total:$pref->value;
                }
                $total = ($idea->score/($total * 5))*100;
                $array[4]=$total;
                if(session('recovery')){
                    $array[5] = "1";
                }
                if(!$all_ideas){
                    session(['refresh'=>1]);
                }
                echo json_encode($array);
            },100);
        }
        session()->forget('recovery');
    }
}

