<?php

namespace App\Repositories;


use App\Models\EnCours;
use Illuminate\Http\Request;

class TaskRepository
{
    public function getTasks(Request $request, $type)
    {
//        dd($type);
        $class = 'App\\Models\\' . $type;
        return $class::all();
    }
}