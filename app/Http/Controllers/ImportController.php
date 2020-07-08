<?php

namespace App\Http\Controllers;

use App\Imports\TaskImport;
use App\Models\Filter;
use App\Models\UserFlag;
use App\Repositories\ImportRepository;
use Illuminate\Http\Request;
use App\Imports\Task;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    private $importRepository;

    public function __construct(ImportRepository $importRepository)
    {
        $this->importRepository = $importRepository;
    }

    public function import(Request $request)
    {
        return $this->importRepository->import($request);
    }


    public function editImportingStatus($flag)
    {
        return $this->importRepository->editImportingStatus($flag);
    }

    public function getInsertedData()
    {
        return $this->importRepository->getInsertedData();
    }

    public function getFilterAllStats()
    {
        return $this->importRepository->getFilterAllStats();
    }
}
