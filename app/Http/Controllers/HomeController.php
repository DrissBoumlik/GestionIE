<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $AgentName = $request->agent_name;
        $data = ['agent' => $AgentName];
        return view('tasks.dashboard')->with($data);
    }

}
