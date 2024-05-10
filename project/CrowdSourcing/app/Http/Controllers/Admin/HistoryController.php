<?php

namespace App\Http\Controllers\Admin;

use App\Ideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Workshop;
class HistoryController extends Controller
{
    public function index(){
        $workshops = DB::connection('mysql1')->table('adminhistory')
        ->get()->all();
        return view('admin.history',
            [
                'workshops' => $workshops
            ]
            );
    }
}


