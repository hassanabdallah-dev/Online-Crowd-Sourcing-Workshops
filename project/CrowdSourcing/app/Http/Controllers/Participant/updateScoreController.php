<?php

namespace App\Http\Controllers\Participant;
use App\Http\Controllers\Controller;
use App\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class updateScoreController extends Controller
{
    public function updatescore(Request $request)
    {
        $validatedData = $request->validate([
            'userScore' => 'required|numeric',
        ]);

        session(['refresh'=>0]);
        $ideas = new Ideas();
        $ideas->setConnection('mysql3');
        $score  = $ideas->where('id', request()->get('key_id'))->value('score') + request()->get('userScore');
        DB::connection('mysql3')->table('ideas')->where('id', request()->get('key_id'))->update(['score' => $score]);
        $ideas->where('id', request()->get('key_id'))->increment('voted');
        return redirect()->route('participant.wait');
    }
}
