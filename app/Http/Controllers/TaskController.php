<?php

namespace App\Http\Controllers;

use App\Models\EnCours;
use App\Models\EnCoursLog;
use App\Models\Instance;
use App\Models\InstanceLog;
use App\Models\User;
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

    public function viewTasksByStatus(Request $request, $status, $type)
    {
//        if ($type === 'encours') {
//            $agents = EnCours::select('agent_traitant', 'id')->get();
//        } else {
//            $agents = Instance::select('agent_traitant', 'id')->get();
//        }
        $agents = User::whereHas('role', function ($query) {
            return $query->where('name', 'agent');
        })->get();
        $params = config('custom_params.tasks_options')[$type]['columns'];
        $params['agent_traitant']['values'] = $agents->pluck('firstname')->all();
        return view('tasks.filter.' . $status . '.' . $type)->with(['data' => $request->all(), 'agents' => $agents, 'params' => $params]);
    }

    public function getTasksbyStatus(Request $request, $status, $type)
    {
        $tasks = [];
        if ($status == 'urgent') {
            $tasks = $this->taskRepository->getPriorityTasks($request, $type);
        } elseif ($status == 'a_traiter') {
            $tasks = $this->taskRepository->getTasksToHandle($request, $type);
        }

        return DataTables::of($tasks)->toJson();
    }

    public function dropTask(Request $request, $type)
    {
        $response = $this->taskRepository->dropTask($request, $type);
        return response()->json($response);
    }

    public function editTask(Request $request, $type)
    {
        $response = $this->taskRepository->editTask($request, $type);
        return response()->json($response);
    }

    public function assignTask(Request $request, $type)
    {
        $response = $this->taskRepository->assignTask($request, $type);
        return response()->json($response);
    }
}
