<?php
namespace App\Http\Controllers\Participant;
use App\Http\Controllers\Controller;
use App\Ideas;
use App\Preferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class testStepController extends Controller
{
    public function testStep()
    {
        if(session('refresh') == 1){
            echo json_encode(['retry',0]);
        }
        else{
        $ideas = new Ideas();
        $ideas->setConnection('mysql3');
        $voted =$ideas->where('workshop_id',session('workshop_id'))
        ->where('voted',request()->get('taken'))->exists();
        $non_voted =  $ideas->where('workshop_id',session('workshop_id'))
        ->where('taken', '=', request()->get('taken'))
        ->exists();
        $total = 0;

        if ($voted || $non_voted) {
            $var = 'false';
        } else{
            $var = 'true';
            session([
                'refresh' => 1
            ]);
            $total=$ideas->where('workshop_id',session('workshop_id'))
            ->count();
            $preferences = new Preferences();
            $preferences->setConnection('mysql3');
            $pref = $preferences->where('name','rounds-number')->get()->first();
            if($pref->enable){
                $total = $total < $pref->value?$total:$pref->value+1;
            }
            $my_idea = $ideas->where('id', session('idea_id'))
            ->get()->first();
            $my_idea->flag = false;
            Session::push('users.ideas', $my_idea->id);
            $my_idea->save();
        }
        $all = array($var, $total);
        echo json_encode($all);
    }
    }
}
