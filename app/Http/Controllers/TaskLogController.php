<?php

namespace App\Http\Controllers;

use App\Models\EnCours;
use App\Models\EnCoursLog;
use App\Models\InstanceLog;
use App\Repositories\TaskLogRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskLogController extends Controller
{
    private  $taskLogRepository;

    public function __construct(TaskLogRepository $taskLogRepository)
    {
        $this->taskLogRepository = $taskLogRepository;
    }

    public function getTasksLog(Request $request, $type)
    {
        $data = $this->taskLogRepository->getTasksLog($request, $type);
        DataTables::of($data)->toJson();
    }

    public function getTasksLogByStatus(Request $request, $status, $type)
    {
        $data = $this->taskLogRepository->getTasksLogByStatus($request, $status, $type);
        return DataTables::of($data)->toJson();
    }
}
