<?php

namespace App\Http\Controllers\Monitor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Workshop;
class WorkshopHome extends Controller
{
    private function getkey(){
        $wor = new Workshop();
        $wor->setConnection('mysql2');
        if(!session('workshop_id')){
            $workshop = $wor->where('monitor_id',auth()->user()->id)
            ->where('created_at',
            $wor->selectRaw('MAX(created_at) as max')
                ->where('monitor_id',auth()->user()->id)
                    ->get()
                        ->first()
                            ->max
        );
        if($workshop)
            session(
                [
                    'workshop_id'=> $workshop->id
                ]
        );
        }
    }
    public function RemoveUser($user){
        $wor = new Workshop();
        $wor->setConnection('mysql2');
        $active = $wor->where('id', session('workshop_id'))
            ->where('active',true)
            ->exists();
            if(!$active){
                $workshop = $wor->select('nbparticipants')
                    ->where('id',session('workshop_id'))->get()->first();
                DB::connection('mysql2')->table('participant_workshop')
                    ->where('workshop_id',session('workshop_id'))
                    ->where('participant_id',$user)
                    ->delete();
            }
            return redirect()->route('monitor.workshops');
    }
    public function start(){
        $wor = new Workshop();
        $wor->setConnection('mysql2');
        if($wor->join('participant_workshop', 'participant_workshop.workshop_id','=','workshop.id')
                ->where('workshop.id',session('workshop_id'))->count() == 0)
                return redirect()->route('monitor.Workshop');
        session(['stage' => 0]);
        $this->getkey();
        $wor->where('id', session('workshop_id'))->update([
            'active' => true,
            ]);
            session([
                'current_participants' => DB::connection('mysql2')->table('participant_workshop')
                ->where('workshop_id', session('workshop_id'))
                ->get()->count()
            ]);
        return redirect()->route('monitor.result');
    }
    public function update(){
        $wor = new Workshop();
        $wor->setConnection('mysql2');
        $this->getkey();
        $workshop = $wor->where('id', session('workshop_id'))->first();
        $key = NULL;
        if($workshop){
            $key = $workshop->key;
            $active = $workshop->active;
        }
        $active = $active ?'true':'false';
        $workshop_id = session('workshop_id');
        return view('monitor.workshop', compact('active','key'));
    }
    public function index(){
        $wor = new Workshop();
        $wor->setConnection('mysql2');
        $this->getkey();
        $data = DB::connection('mysql2')->table('participant_workshop')
        ->join('users','users.id','=','participant_workshop.participant_id')
        ->select('participant_workshop.participant_id','users.name','users.email')
        ->where('workshop_id',session('workshop_id'))->get()->all();
        $active = $wor->where('id', session('workshop_id'))
            ->where('active',true)
            ->exists();
        echo json_encode([$data,$active]);
    }
}

