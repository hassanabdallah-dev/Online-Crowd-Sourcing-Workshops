<?php

namespace App\Http\Controllers\Monitor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Workshop;
use Illuminate\Support\Facades\DB;
use App\Ideas;
class groups extends Controller
{
    public function authenticate(){
        $work = new Workshop();
        $work->setConnection('mysql2');
        if($work->where('id',session('workshop_id'))->where('monitor_id',auth()->user()->id)->exists()){
            session(['stage'=>1]);
            return redirect()->route('monitor.groups');
        }
        return redirect()->back();
    }
    public function index(){
        return view('monitor.groups');
    }
    public function update(){
        $groups_users = DB::connection('mysql2')->table('users_group')
            ->join('group','group.id','=','group_id')
            ->join('ideas','group.idea_id','=','ideas.id')
            ->join('users','user_id','=','users.id')
            ->select('group.full','group_id','user_id', 'ideas.idea','users.name')
            ->where('group.workshop_id',session('workshop_id'))
            ->get()->all();
            $work = new Workshop();
        $work->setConnection('mysql2');
            $w = $work->where('id', session('workshop_id'))->first();
            if($w){
                $active = $w->active?'true':'false';
            }
            else{
                $active = 'error';
            }

        echo json_encode(array(0=>$groups_users,1=>$active));
    }
    public function kick($group,$user){
        DB::connection('mysql2')->table('users_group')
        ->where('group_id',$group)
        ->where('user_id', $user)
        ->delete();
        return redirect()->route('monitor.groups');
    }
}



