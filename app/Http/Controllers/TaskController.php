<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function allData(Request $request, $type = null)
    {
        if ($type) {
            return view('tasks.all-data.' . $type)->with(['data' => $request->all()]);
        }
        return view('tasks.all-data')->with(['data' => $request->all()]);
    }

    public function getTasks(Request $request, $type)
    {
        $tasks = $this->taskRepository->getTasks($request, $type);
        return DataTables::of($tasks)->toJson();
    }

    public function allPriorityTasks(Request $request, $type = null)
    {
        if ($type) {
            return view('tasks.filter.' . $type)->with(['data' => $request->all()]);
        }
//        return view('tasks.filter')->with(['data' => $request->all()]);
    }

    public function getallPriorityTasks(Request $request, $type)
    {
        $tasks = $this->taskRepository->getPriorityTasks($request, $type);
        return DataTables::of($tasks)->toJson();
    }
}
