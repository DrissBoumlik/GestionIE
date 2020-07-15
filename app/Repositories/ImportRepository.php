<?php

namespace App\Repositories;


use App\Imports\TaskImport;
use App\Models\Filter;
use App\Models\UserFlag;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportRepository
{

    public function import(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $stored = \Storage::disk('public')->put('storage/data_source/' . $fileName, file_get_contents($file));

        $taskImport = new TaskImport($request->days, $request->type);
        Excel::import($taskImport, $request->file('file'));
        $user_flag = getImportedData(false);
        $user_flag->flags = [
            'imported_data' => $user_flag->flags['imported_data'],
            'is_importing' => 2
        ];
        $user_flag->update();
        \DB::table($taskImport->tables_data['table'])
            ->whereNotNull('isNotReady')
            ->update(['isNotReady' => null]);
        return [
            'success' => true,
            'message' => 'Le fichier a été importé avec succès',
            'rejected' => $taskImport->rejectedData,
            'columns' => $taskImport->tables_data['data_columns']
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