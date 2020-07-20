<?php

namespace App\Repositories;


use App\Models\EnCours;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        if ($type == 'EnCours') {
            $colDate = 'date';
        } else {
            $colDate = 'date_de_rendez_vous';
        }

        $data = $class::where($colDate, '>=',  Carbon::now()->subDays(2)->toDateTimeString())->get();
        return $data;
    }
}