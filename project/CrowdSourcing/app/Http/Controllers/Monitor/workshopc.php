<?php

namespace App\Http\Controllers\Monitor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Workshop;

class workshopc extends Controller
{
    public function workkey($length_of_string)
    {
        return substr(md5(time()), 0, $length_of_string);
    }

    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'location' => 'required',
            'nbparticipants' => 'required|numeric'
        ]);

        $name = request()->get('name');
        $location = request()->get('location');
        $nb = (int) request()->get('nbparticipants');
        $key = $this->workkey(rand(14,18));

        $w = new Workshop();
        $w->setConnection('mysql2');
        $w->name = $name;
        $w->key = $key;
        $w->location = $location;
        $w->nbparticipantsmax = $nb;
        $w->monitor_id = auth()->user()->id;
        $w->save();
        session(
            [
                'workshop_id' => $w->id
            ]
        );
        return redirect()->route('monitor.Workshop');
    }
}
