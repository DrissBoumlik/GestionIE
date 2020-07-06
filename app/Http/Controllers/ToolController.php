<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use App\Models\User;
use Illuminate\Http\Request;

class ToolController extends Controller
{

    public function __construct()
    {
    }

    public function unauthorized()
    {
        return view('tools.unauthorized');
    }

    public function home(Request $request)
    {
        $agenceCode = $request->agence_code;
        $AgentName = $request->agent_name;
        $data = ['agence' => $agenceCode, 'agent' => $AgentName];
        return view('tasks.dashboard')->with($data);
    }

    public function importView()
    {
        return view('tasks.import');
    }

    public function import(Request $request)
    {

    }

    public function editImportingStatus($flag)
    {
        $user_flag = UserFlag::firstOrCreate([
            'user_id' => getAuthUser()->id
        ]);
        $user_flag->flags = [
            'imported_data' => 0,
            'is_importing' => (int)$flag
        ];
        $user_flag->save();
        return [
            'flags' => $user_flag->flags
        ];
    }

    public function getInsertedData()
    {
        $flags = getImportedData(true);
        if ($flags['is_importing'] == 0 ||
            ($flags['is_importing'] == 1 && $flags['imported_data'] == 0)) {
            $flags = null;
        }
        return [
            'flags' => $flags
        ];
    }

    public function getFilterAllStats()
    {
        $allStatsFilter = Filter::where(['user_id' => getAuthUser()->id, 'isGlobal' => 2])->first();
        return ['allStatsFilter' => $allStatsFilter];
    }
}
