<?php

namespace App\Http\Controllers;

use App\Repositories\ReportingRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportingController extends Controller
{

    private $reportingRepository;

    public function __construct(ReportingRepository $reportingRepository)
    {
        $this->reportingRepository = $reportingRepository;
    }

    public function index(Request $request){
        return view('reporting.reporting');
    }

    public function getDates(Request $request)
    {
        $dates = $this->reportingRepository->getDateNotes($request);
        return ['dates' => $dates];
    }

    public function getInstance(Request $request){
        $data = $this->reportingRepository->getInstanceData($request);
        return DataTables::of($data['data'])->with('filter',$data['filter'])
            ->with('zoneFilter',$data['zoneFilter'])->with('checkedZoneFilter',$data['checkedZoneFilter'])->toJson();
    }

    public function getEnCours(Request $request){
        $data = $this->reportingRepository->getEnCoursData($request);
        return DataTables::of($data['data'])->with('filter',$data['filter'])
            ->with('zoneFilter',$data['zoneFilter'])->with('checkedZoneFilter',$data['checkedZoneFilter'])->toJson();
    }

    public function getGlobalData(Request $request){
        $data = $this->reportingRepository->getGlobalData($request);
        return DataTables::of($data['data'])->with('filter',$data['filter'])
            ->with('zoneFilter',$data['zoneFilter'])->with('checkedZoneFilter',$data['checkedZoneFilter'])->toJson();
    }


}
