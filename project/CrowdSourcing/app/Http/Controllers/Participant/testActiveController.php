<?php
namespace App\Http\Controllers\Participant;
use App\Http\Controllers\Controller;
use App\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class testActiveController extends Controller
{
    public function testActive(){
        if(session('workshop_id')){
            $wor = new Workshop();
            $wor->setConnection('mysql3');
            $workshop = $wor->where('id', session('workshop_id'))->first();
            if($workshop && DB::connection('mysql3')->table('participant_workshop')
                ->where('workshop_id',session('workshop_id'))
                ->where('participant_id',auth()->user()->id)
                ->exists() ){
                if($workshop->active == true)
                    echo json_encode('ideas');
                }
                else{
                    echo json_encode('home');
                }

        }
        else
            echo json_encode('home');
    }
}
