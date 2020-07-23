<?php


namespace App\Repositories;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskLogRepository
{
    public function getTasksLog(Request $request, $type)
    {
        $classLog = 'App\\Models\\' . $type + 'Log';
        $data = $classLog::with(['user', 'task'])->orderBy('updated_at', 'desc')->get();

        return $data;
    }

    public function getTasksLogByStatus(Request $request, $status, $type, $task = null)
    {
        $tasks = [];
        $classLog = 'App\\Models\\' . $type . 'Log';
        $class = 'App\\Models\\' . $type;
        if (strtolower($type) == 'encours') {
            $colDate = 'date';
        } else {
            $colDate = 'date_de_rendez_vous';
        }
        if ($status == 'urgent') {
            $data = $classLog::with(['user', 'task'])
                ->whereHas('task', function ($query) use ($colDate, $task) {
                    if ($task) {
                        $query = $query->where('id', $task);
                    }
                    return $query->where($colDate, '>=', Carbon::now()->subDays(2)->toDateTimeString());
                })
                ->orderBy('updated_at', 'desc')->get();
        } elseif ($status == 'a_traiter') {
            $data = $classLog::with(['user', 'task'])
                ->whereHas('task', function ($query) use ($colDate, $task) {
                    if ($task) {
                        $query = $query->where('id', $task);
                    }
                    return $query->where($colDate, '<=', Carbon::now()->subDays(2)->toDateTimeString());
                })
                ->orderBy('updated_at', 'desc')->get();
        }
        return $data;
    }
}