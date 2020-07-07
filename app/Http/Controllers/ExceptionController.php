<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExceptionController extends Controller
{
    public function unauthorized()
    {
        return view('tools.unauthorized');
    }
}
