<?php

namespace App\Http\Controllers\Participant;
use App\Http\Controllers\Controller;

use App\Workshop;
use Illuminate\Http\Request;
use App\Ideas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Carbon;
class Userkey extends Controller
{
    public function testKey(Request $request)
    {
        $validatedData = $request->validate([
            'key' => 'required',
        ]);
        $work = new Workshop();
        $work->setConnection('mysql3');
        $requested_workshop = $work->where('key', '=', request()->get('key'))->get()->first();
        if ($requested_workshop &&
            $requested_workshop->nbparticipants < $requested_workshop->nbparticipantsmax) {
            session(['workshop_id' =>  $requested_workshop->id]);
            session(['i' =>  1]);
            $id = auth()->user()->id;
            DB::connection('mysql3')->table('participant_workshop')
            ->insert(
                [
                    'participant_id' => $id,
                    'workshop_id' => $work->select('id')
                    ->where('key',request()->get('key'))
                    ->get()->first()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
            session([ 'stage' => 0 ]);
            return redirect()->route('participant.workshop');
        }
        else {
            return redirect()->to('/userMakekey');
        }
    }
}
