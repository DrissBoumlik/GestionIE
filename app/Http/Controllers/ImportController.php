<?php

namespace App\Http\Controllers;

use App\Imports\TaskImport;
use App\Models\Filter;
use App\Models\UserFlag;
use Illuminate\Http\Request;
use App\Imports\Task;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importView()
    {
        return view('tasks.import');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $stored = \Storage::disk('public')->put('storage/data_source/' . $fileName, file_get_contents($file));

        $taskImport = new TaskImport($request->days);
        Excel::import($taskImport, $request->file('file'));
        $user_flag = getImportedData(false);
        $user_flag->flags = [
            'imported_data' => $user_flag->flags['imported_data'],
            'is_importing' => 2
        ];
        $user_flag->update();
        \DB::table('en_cours')
            ->whereNotNull('isNotReady')
            ->update(['isNotReady' => null]);
        return [
            'success' => true,
            'message' => 'Le fichier a été importé avec succès'
        ];
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
