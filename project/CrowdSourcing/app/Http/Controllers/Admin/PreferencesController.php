<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Preferences;
use App\User;
class PreferencesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $pref = new Preferences();
        $pref->setConnection('mysql1');
        $preferences = $pref->all();
        return view('admin.preferences.index',compact('preferences'));
    }
    public function change(Request $request){
        if(!($prefsOn = $request->prefs))
            $prefsOn = array();
        $array = array();
        $pref = new Preferences();
        $pref->setConnection('mysql1');
        foreach($prefsOn as $k => $v){
            $u = $pref->where('id',$v)->get()->first();
            $u->enable = true;
            if($u->name == "rounds-number"){
                if($request->rounds && $request->rounds > 0){
                    $u->value = $request->rounds;
                }
                else{
                    $u->enable = false;
                }
            }
            $u->save();
            array_push($array, $v);
        }
        $preferences = $pref->whereNotIn('id', $array)->get();
        $preferences = $preferences->all();
        $usr = new User();
        $usr->setConnection('mysql1');
        foreach ($preferences as $key => $pref) {
            if($pref->name == "email-verification"){
                $unverified = $usr->where('email_verified_at',NULL)->update([
                    'email_verified_at' => now()
                ]);
            }
            $pref->enable = false;
            $pref->save();
        }
        $valid = $pref->where('name', 'validation')->get()->first();
        if(!$valid->enable){
            $not_active = $usr->where('activated',false)->get()->all();
            foreach($not_active as $notactive){
                $notactive->activated = true;
                $notactive->save();
            }
        }
        return redirect()->route('admin.preferences.index');
    }
}
