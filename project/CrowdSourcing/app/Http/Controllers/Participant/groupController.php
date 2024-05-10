<?php

namespace App\Http\Controllers\Participant;

use App\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Workshop;
class groupController extends Controller
{
    public function index(){
        if(

            ($group = DB::connection('mysql3')->table('users_group')
            ->join('group', 'group.id', '=', 'users_group.group_id')
            ->where('user_id', auth()->user()->id)
            ->where('group.workshop_id', session('workshop_id'))
            ->first())
        ){
            if(!session('current_group')){
                $i = new Ideas();
                $i->setConnection('mysql3');
                $idea = $i->join('group', 'group.idea_id', '=', 'ideas.id')
                ->where('group.id', $request->grpId)
                ->select('idea')->first()->idea;
                session([
                    'current_group' => $idea,
                    'group_id' => $request->grpId
                ]);
            }
            return redirect()->route('participant.workon');
        }
        session(['stage' => 1]);
        $ideas = $this->testGroup(request());
        return view('participant.chooseGroup')->with('ideas');
    }
    public function nextStage(){
        session(['stage' => 1]);
        return redirect()->route('participant.chooseGroup');
    }
    public function insertInGroup(Request $request)
    {
        if(
            DB::connection('mysql3')->table('group')
            ->where('id', $request->grpId)
            ->where('full', false)
            ->exists()
        ){
            DB::connection('mysql3')->table('users_group')
                ->insert([
                    'user_id' => auth()->user()->id,
                    'group_id' => $request->grpId,
                ]);
                $i = new Ideas();
                $i->setConnection('mysql3');
                $idea = $i->join('group', 'group.idea_id', '=', 'ideas.id')
                    ->where('group.id', $request->grpId)
                    ->select('idea')->first()->idea;
                    session([
                        'current_group' => $idea,
                        'group_id' => $request->grpId
                    ]);
        }
        return redirect()->route('participant.chooseGroup') ;

    }

    public function testGroup(Request $request)
    {
        $i = new Ideas();
        $i->setConnection('mysql3');
        $k = $i->join('group','group.idea_id','=','ideas.id')
        ->select('group.id','group.idea_id','group.full', 'ideas.idea')
        ->where('group.workshop_id',session('workshop_id'))
        ->get()->all();
       return response()->json($k);
    }
    public function workon(){
        if(
            !DB::connection('mysql3')->table('users_group')
            ->join('group', 'group.id', '=', 'users_group.group_id')
            ->where('user_id', auth()->user()->id)
            ->where('group.workshop_id', session('workshop_id'))
            ->exists()
        ){
            return redirect()->route('participant.chooseGroup');
        }
        else{
            $i = new Workshop();
            $i->setConnection('mysql3');
            $active = $i->where('id', session('workshop_id'))
            ->where('active', true)->exists()?'true':'false';
            return view('participant.workon')->with('active', $active);
        }
    }
    public function isKicked(Request $request)
    {
        $group_id = $request->group_id;
        $user_id = $request->user_id;
        $iskicked = !DB::connection('mysql3')->table('users_group')
                        ->where('group_id',$group_id)
                        ->where('user_id', $user_id)
                        ->exists()?'true':'false';

        echo json_encode($iskicked);
    }
    public function unregister(){
        $i = new Workshop();
        $i->setConnection('mysql3');
        if($i->where('id', session('workshop_id'))
        ->where('active', true)->exists()){
        DB::connection('mysql3')->transaction(function () {
        DB::connection('mysql3')->table('users_group')
        ->where('user_id',auth()->user()->id)
        ->delete();
    });
    session()->forget('current_group');
    session()->forget('group_id');
}
    return redirect()->route('participant.chooseGroup');
    }
}


