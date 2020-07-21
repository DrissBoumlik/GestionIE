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
        return view('tasks.filter.' . $status . '.' . $type)->with(['data' => $request->all(), 'agents' => $agents]);
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
//        dd($request->all(), $type);
        if ($type === 'encours') {
            $task = EnCours::find($request->task_id);
            $task->statut_final = null;
            $task->update();
            EnCoursLog::create([
                'user_id' => $request->user_id,
                'en_cours_id' => $request->task_id,
                'cause_du_report' => $request->data_row['cause_du_report'],
                'statut_du_report' => $request->data_row['statut_du_report'],
                'accord_region' => $request->data_row['accord_region'],
                'statut_final' => 'A Effectuer'
            ]);
        } else {
            $task = Instance::find($request->task_id);
            $task->statut_final = null;
            $task->update();
            InstanceLog::create([
                'user_id' => $request->user_id,
                'instance_id' => $request->task_id,
                'statut_du_report' => $request->data_row['statut_du_report'],
                'statut_final' => 'A Effectuer'
            ]);
        }

        $response = [
            'message' => 'La tâche a été désaffectée avec succès',
            'success' => true,
            'code' => 200
        ];
        return response()->json($response);
    }

    public function assignTask(Request $request, $type)
    {
//        dd($request->all(), $type);
        if ($type === 'encours') {
            $task = EnCours::find($request->task_id);
            $task->statut_final = 'EN COURS';
            $task->update();
            EnCoursLog::create([
                'user_id' => $request->user_id,
                'en_cours_id' => $request->task_id,
                'cause_du_report' => $request->data_row['cause_du_report'],
                'statut_du_report' => $request->data_row['statut_du_report'],
                'accord_region' => $request->data_row['accord_region'],
                'statut_final' => 'EN COURS'
            ]);
        } else {
            $task = Instance::find($request->task_id);
            $task->statut_final = 'EN COURS';
            $task->update();
            InstanceLog::create([
                'user_id' => $request->user_id,
                'instance_id' => $request->task_id,
                'statut_du_report' => $request->data_row['statut_du_report'],
                'statut_final' => 'EN COURS'
            ]);
        }
        $user = User::find($request->user_id);
        $response = [
            'message' => 'La tâche a été affectée au ' . $user->firstname . ' avec succès',
            'success' => true,
            'code' => 200
        ];
        return response()->json($response);
    }
}
