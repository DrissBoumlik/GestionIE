<?php

namespace App\Repositories;

use App\Export\tasksExport;
use App\Mail\ActivationRequest;
use App\Mail\SendTraiteMessage;
use App\Models\EnCours;
use App\Models\EnCoursLog;
use App\Models\Instance;
use App\Models\InstanceLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class TaskRepository
{
    public function getTasks(Request $request, $type)
    {
        $class = 'App\\Models\\' . $type;
        return $class::all();
    }

    public function getPriorityTasks(Request $request, $type)
    {
        $class = 'App\\Models\\' . $type;
        $collectionHelper = $type . 'Collection';
        if ($type == 'EnCours') {
            $colDate = 'date';
        } else {
            $colDate = 'date_de_rendez_vous';
        }

        $data = $class::where(function ($query) use($colDate){
            $query->where($colDate, '>=',  Carbon::now()->subDays(2)->toDateTimeString())->orWhere($colDate, '<=',Carbon::now());
        })->where(function ($query){
            $query->where('verified',false);
        })->get();
        $data = $collectionHelper($data);
        return $data;
    }

    public function getTasksToHandle(Request $request, $type)
    {
        $class = 'App\\Models\\' . $type;
        $collectionHelper = $type . 'Collection';
        // TODO: fetch tasks "a traiter"
        if ($type == 'EnCours') {
            $colDate = 'date';
        } else {
            $colDate = 'date_de_rendez_vous';
        }
        $data = $class::where('verified',false)->get();
        $data = $collectionHelper($data);
//        dd(collect($data)[0]);
        return $data;

    }
    public function getTasksWithStatutFinalTraite(Request $request, $type)
    {
        $class = 'App\\Models\\'. $type;
        return $class::where('statut_final','TRAITE')->get();
    }

    public  function getVerifiedTasks(Request $request, $type){
        $class = 'App\\Models\\'. $type;
        return $class::where('verified',true)->get();
    }
    public function dropTask(Request $request, $type)
    {
        $user = User::find($request->user_id);
        if ($type === 'encours') {
            $task = EnCours::find($request->task_id);
            $task->statut_final = null;
            $task->update();
            EnCoursLog::create([
                'user_id' => $request->user_id,
                'en_cours_id' => $request->task_id,
                'agent_traitant' => $user->firstname,
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
                'agent_traitant' => $user->firstname,
                'statut_du_report' => $request->data_row['statut_du_report'],
                'statut_final' => 'A Effectuer'
            ]);
        }

        $response = [
            'message' => 'La tâche a été désaffectée avec succès',
            'success' => true,
            'code' => 200
        ];
        return $response;
    }

    public function editTask(Request $request, $type)
    {
        $task = null;
//        dd($request->all(), $type);
        if ($type === 'encours') {
            $task = EnCours::find($request->task_id);
            $task->statut_final = $request->statut_final;


            $task->cause_du_report = $request->cause_du_report;
            $task->statut_du_report = $request->statut_du_report;
            $task->accord_region = $request->accord_region;

            $task->update();
            EnCoursLog::create([
                'user_id' => $request->user_id,
                'en_cours_id' => $request->task_id,
                'agent_traitant' => $request->agent_traitant,
                'cause_du_report' => $request->cause_du_report,
                'statut_du_report' => $request->statut_du_report,
                'accord_region' => $request->accord_region,
                'statut_final' => $request->statut_final
            ]);
        } else {
            $task = Instance::find($request->task_id);
            $task->statut_final = $request->statut_final;
            $task->statut_du_report = $request->statut_du_report;
            $task->update();
            InstanceLog::create([
                'user_id' => $request->user_id,
                'instance_id' => $request->task_id,
                'agent_traitant' => $request->agent_traitant,
                'statut_du_report' => $request->statut_du_report,
                'statut_final' => $request->statut_final
            ]);
        }
        if($task->statut_final === 'TRAITE'){
            try {
                Mail::to('anass.el-malki@circet.fr')
                    ->send(new SendTraiteMessage($task));
            } catch(\Exception $e) {
                dd($e);
            }
        }
        $response = [
            'message' => 'La tâche a été mise à jour avec succès',
            'success' => true,
            'code' => 200
        ];
        return $response;
    }

    public function assignTask(Request $request, $type)
    {
        $user = User::find($request->user_id);
        if ($type === 'encours') {
            $task = EnCours::find($request->task_id);
            $task->statut_final = 'EN COURS';
            $task->update();
            EnCoursLog::create([
                'user_id' => $request->user_id,
                'en_cours_id' => $request->task_id,
                'agent_traitant' => $user->firstname,
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
                'agent_traitant' => $user->firstname,
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
        return $response;
    }

    public function updateSetOfTasks(Request $request, $type){
        $returnedArray = [];
       $typeList = $request->verifiedTickets;
       foreach ($typeList as $value){
           if($type === 'encours'){
               $task = EnCours::find($value);
               $task->verified = true;
               $task->update();
           }else{
               $task = Instance::find($value);
               $task->verified = true;
               $task->update();
           }
           array_push($returnedArray,$task);
       }
        try {
            Mail::to('aarfa@rc2k.fr')
                ->send(new SendTraiteMessage($returnedArray));
        } catch(\Exception $e) {
            dd($e);
        }
       return $returnedArray;
    }

    public function exportDataCall(Request $request,$type){
        $headers =[
            'Content-Type' => 'application/text',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Cache-Control' => 'post-check=0, pre-check=0, false',
            'Pragma' => 'no-cache',                               ];

        return Excel::download(new tasksExport($request,$type) , $type.' export.xlsx',\Maatwebsite\Excel\Excel::XLSX,$headers);
    }
}
