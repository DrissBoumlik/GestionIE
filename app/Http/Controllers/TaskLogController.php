<?php

namespace App\Http\Controllers;

use App\Models\EnCours;
use App\Models\EnCoursLog;
use App\Models\InstanceLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskLogController extends Controller
{
    public function getTasksLog(Request $request, $type)
    {
        dd(1);
        $classLog = 'App\\Models\\' . $type + 'Log';
        $data = $classLog::with(['user', 'task'])->orderBy('updated_at', 'desc')->get();

        return DataTables::of($data)->toJson();
    }

    public function getTasksLogByStatus(Request $request, $status, $type)
    {
        $tasks = [];
        $classLog = 'App\\Models\\' . $type . 'Log';
        $class = 'App\\Models\\' . $type;
        if (strtolower($type) == 'encours') {
            $colDate = 'date';
            $table = 'en_cours';
        } else {
            $colDate = 'date_de_rendez_vous';
            $table = 'instance';
        }
        if ($status == 'urgent') {
            $data = $classLog::with(['user', 'task'])
                ->whereHas('task', function ($query) use ($colDate) {
                    return $query->where($colDate, '>=', Carbon::now()->subDays(2)->toDateTimeString());
                })
                ->orderBy('updated_at', 'desc')->get();
        } elseif ($status == 'a_traiter') {
            $data = $classLog::with(['user', 'task'])
                ->whereHas('task', function ($query) use ($colDate) {
                    return $query->where($colDate, '<=', Carbon::now()->subDays(2)->toDateTimeString());
                })
                ->orderBy('updated_at', 'desc')->get();
        }

        return DataTables::of($data)->toJson();
    }
}
