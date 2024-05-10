<?php

namespace App\Http\Controllers\Participant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ideas;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class IdeaSubmit extends Controller
{

    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'idea' => 'required',
        ]);
        $w = new Ideas();
        $w->setConnection('mysql3');
        if($w->where('id',session('idea_id'))->exists())
            return view('participant.wait');
        $w->participant_id = auth()->user()->id;
        $w->workshop_id = session('workshop_id');
        $w->idea = request()->get('idea');
        $w->score = 0;
        $w->taken = 0;
        $w->save();
        $request->session()->push('users.ideas', $w->id);
        DB::connection('mysql3')->table('idea_participant')
        ->insert([
            'idea_id' => $w->id,
            'participants_id' => $w->participant_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        session([
            'idea_id' => $w->id,
        ]);
        return view('participant.wait');
    }
}
