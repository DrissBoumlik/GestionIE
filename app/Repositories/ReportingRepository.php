<?php


namespace App\Repositories;


use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ReportingRepository
{

    public function getDateNotes(Request $request)
    {
        $instance = \DB::table('instance')
            ->select(
                DB::raw("YEAR(date_de_rendez_vous) as year"),
                DB::raw("MONTH(date_de_rendez_vous) as month"),
                DB::raw("concat('S', WEEKOFYEAR(date_de_rendez_vous)) as week"),
                DB::raw("date_de_rendez_vous as date")
            )
            ->distinct()
            ->whereNull('isNotReady');
        $dates =  \DB::table('en_cours')
            ->select(
                DB::raw("YEAR(date) as year"),
                DB::raw("MONTH(date) as month"),
                DB::raw("concat('S', WEEKOFYEAR(date)) as week"),
                'date'
            )
            ->distinct()
            ->whereNull('isNotReady')
            ->union($instance)
            ->orderBy('date')
            ->get()
            ->groupBy(['year', 'month', 'week', 'date'])
            ->map(function ($year, $index) {
                $_year = new \stdClass();
                $_year->id = $index; // year name
                $_year->text = $index; // year name
                $_year->children = []; // months
                $year->map(function ($month, $index) use (&$_year) {
                    $_month = new \stdClass();
                    $_month->id = $_year->text . '-' . $index; // month name
                    $_month->text = getMonthName((int)$index); // month name
                    $_month->children = []; // months
                    $_year->children[] = $_month;
                    $month->map(function ($week, $index) use (&$_year, &$_month) {
                        $_week = new \stdClass();
                        $_week->id = $_year->id . '-' . $_month->id . '-' . $index; // week name
                        $_week->text = $index; // week name
                        $_week->children = []; // days
                        $_month->children[] = $_week;
                        $week->map(function ($day, $index) use (&$_week) {
                            $_day = new \stdClass();
                            $_day->id = $index; //collect($index)->implode('-'); // day name
                            $_day->text = $index; //collect($index)->implode('-'); // day name
                            $_week->children[] = $_day; // collect($day)->implode('-');
                            return $_week;
                        });
                        return $_month;
                    });
                    return $_year;
                });
                return $_year;
            });

        return $dates->values();
    }

    public function getInstanceData(Request $request){

        $_route = getRoute(Route::current());
        $route = str_replace('/columns', '', $_route);
        list($filter, $queryFilters) = makeFilterSubQuery($request, $route,'zone_region','code_postal','date_de_rendez_vous');

        $instance = \DB::table('instance');

        $instance = $instance->select('agent_traitant','date_de_rendez_vous', 'task_type',\DB::raw('count(numero_de_labonne_reference_client) as count') )
            ->whereNull('isNotReady');

        $instance = applyFilter($instance, $filter,'zone_region','code_postal','date_de_rendez_vous');

        $zone = \DB::table('instance')
            ->select('zone_region')
            ->distinct()
            ->whereNull('isNotReady')
            ->pluck('zone_region');

        $cdp = \DB::table('instance')
            ->select('code_postal')
            ->distinct()
            ->whereNull('isNotReady')
            ->pluck('code_postal');

        $instance = $instance->orderBy('agent_traitant');
        $instance = $instance->groupBy('agent_traitant','date_de_rendez_vous', 'task_type')->get();

        $keys = $instance->groupBy(['task_type'])->keys();

        if(!$keys->contains('FTTH'))
            $keys->push('FTTH');
        if(!$keys->contains('FTTB'))
            $keys->push('FTTB');


        if (!count($instance)) {
            $data = ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $filter->rows_zone,'data' => [], 'cdpFilter'=>$cdp ,'checkedCdpFilter' =>$filter->rows_cdp];
            return $data;
        } else {
            $temp = $instance->groupBy(['task_type']);
            $temp = $temp->map(function ($calls, $index) {
                $totalZone = $calls->reduce(function ($carry, $call) {
                    return $carry + $call->count;
                }, 0);
                return $calls->map(function ($call) use ($index, $totalZone) {
                    $call->$index = $totalZone == 0 ? 0.00 : round($call->count * 100 / $totalZone, 2);
                    return $call;
                });
            });
            $instance = $temp->flatten();

            $instance = $instance->groupBy(['agent_traitant','date_de_rendez_vous']);
            $instance = $instance->map(function ($element) use ($keys) {
                return $element->map(function ($elementCall, $elementIndex) use ($keys) {
                    $elementCall =   $elementCall->map(function ($call,$index) use($keys){
                        $row = new \stdClass();
                        $row->values = [];
                        $row->agent_traitant = $call->agent_traitant;
                        $row->date_de_rendez_vous = $call->date_de_rendez_vous;
                        $keys->map(function ($key,$keyIndex) use(&$row,$call){
                            if(isset($call->$key)){
                                $row->$key =  $call->count ;
                                $row->values[$key] = $call->count;
                                $row->total =  isset($row->total) ? $row->total + $call->count : $call->count;
                            }else{
                                $row->$key =  0 ;
                                $row->values[$key] = 0;
                            }
                        });
                        return $row;
                    });
                    return $elementCall;
                })->flatten();
            })->flatten();
            $instance = $instance->values();

            return ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $filter->rows_zone,'data' => $instance, 'cdpFilter'=>$cdp ,'checkedCdpFilter' =>$filter->rows_cdp];
        }
    }

    public function getEnCoursData(Request $request){

        $_route = getRoute(Route::current());
        $route = str_replace('/columns', '', $_route);
        list($filter, $queryFilters) = makeFilterSubQuery($request, $route,'ville','code_postal','date');

        $en_cours = \DB::table('en_cours');

        $en_cours = $en_cours->select('agent_traitant','date', 'task_type',\DB::raw('count(`as`) as count') )
            ->whereNull('isNotReady');

        $en_cours = applyFilter($en_cours, $filter,'ville','code_postal','date');


        $zone = \DB::table('en_cours')
            ->select('ville')
            ->distinct()
            ->whereNull('isNotReady')
            ->pluck('ville');

        $cdp = \DB::table('en_cours')
            ->select('code_postal')
            ->distinct()
            ->whereNull('isNotReady')
            ->pluck('code_postal');


        $en_cours = $en_cours->orderBy('agent_traitant');
        $en_cours = $en_cours->groupBy('agent_traitant','date', 'task_type')->get();

        $keys = $en_cours->groupBy(['task_type'])->keys();

        if(!$keys->contains('FTTH'))
            $keys->push('FTTH');
        if(!$keys->contains('FTTB'))
            $keys->push('FTTB');


        if (!count($en_cours)) {
            $data = ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' =>$filter->rows_zone ,'data' => [], 'cdpFilter'=>$cdp ,'checkedCdpFilter' =>$filter->rows_cdp];
            return $data;
        } else {
            $temp = $en_cours->groupBy(['task_type']);
            $temp = $temp->map(function ($calls, $index) {
                $totalZone = $calls->reduce(function ($carry, $call) {
                    return $carry + $call->count;
                }, 0);
                return $calls->map(function ($call) use ($index, $totalZone) {
                    $call->$index = $totalZone == 0 ? 0.00 : round($call->count * 100 / $totalZone, 2);
                    return $call;
                });
            });
            $en_cours = $temp->flatten();

            $en_cours = $en_cours->groupBy(['agent_traitant','date']);
            $en_cours = $en_cours->map(function ($element) use ($keys) {
                return $element->map(function ($elementCall, $elementIndex) use ($keys) {
                    $elementCall =   $elementCall->map(function ($call,$index) use($keys){
                          $row = new \stdClass();
                          $row->values = [];
                        $row->agent_traitant = $call->agent_traitant;
                        $row->date = $call->date;
                        $keys->map(function ($key,$keyIndex) use(&$row,$call){
                            if(isset($call->$key)){
                                $row->$key =  $call->count ;
                                $row->values[$key] = $call->count;
                                $row->total =  isset($row->total) ? $row->total + $call->count : $call->count;
                            }else{
                                $row->$key =  0 ;
                                $row->values[$key] = 0;
                            }
                        });
                        return $row;
                    });
                      return $elementCall;
                })->flatten();
            })->flatten();
            $en_cours = $en_cours->values();


            return ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $filter->rows_zone,'data' => $en_cours,  'cdpFilter'=>$cdp ,'checkedCdpFilter' =>$filter->rows_cdp];
        }
    }

    public function getGlobalData(Request $request){

        $_route = getRoute(Route::current());
        $route = str_replace('/columns', '', $_route);
        list($filter, $queryFilters) = makeFilterSubQuery($request, $route,'ville','code_postal','date');

        $instance = \DB::table('instance');

        $instance = $instance->select(\DB::raw('agent_traitant, date_de_rendez_vous as date,task_type,count(numero_de_labonne_reference_client) as count') )
            ->whereNull('isNotReady');
        $instance = applyFilter($instance, $filter,'zone_region','code_postal','date_de_rendez_vous');
        $instance = $instance->groupBy('agent_traitant','date', 'task_type');

        $globalData = \DB::table('en_cours');
        $globalData =$globalData->select(\DB::raw('agent_traitant, date,task_type,count(`as`) as count') )
            ->whereNull('isNotReady');
        $globalData = applyFilter($globalData, $filter,'ville','code_postal','date');
        $globalData
            ->union($instance)
            ->orderBy('agent_traitant');

        $globalData = $globalData->groupBy('agent_traitant','date', 'task_type')->get();

        $keys = $globalData->groupBy(['task_type'])->keys();

        if(!$keys->contains('FTTH'))
            $keys->push('FTTH');
        if(!$keys->contains('FTTB'))
            $keys->push('FTTB');

        $zoneEn_cours = \DB::table('en_cours')
            ->select('ville')
            ->distinct()
            ->whereNull('isNotReady');

        $zone = \DB::table('instance')
            ->select(DB::raw('zone_region as ville'))
            ->distinct()
            ->whereNull('isNotReady')
            ->union($zoneEn_cours)
            ->pluck('ville');

        $cdpInstance = \DB::table('instance')
            ->select('code_postal')
            ->distinct()
            ->whereNull('isNotReady');

        $cdp = \DB::table('en_cours')
            ->select('code_postal')
            ->distinct()
            ->whereNull('isNotReady')
            ->union($cdpInstance)
            ->pluck('code_postal');

        if (!count($globalData)) {
            $data = ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $filter->row_zone,'data' => [],  'cdpFilter'=>$cdp ,'checkedCdpFilter' =>$filter->rows_cdp];
            return $data;
        } else {
            $temp = $globalData->groupBy(['task_type']);
            $temp = $temp->map(function ($calls, $index) {
                $totalZone = $calls->reduce(function ($carry, $call) {
                    return $carry + $call->count;
                }, 0);
                return $calls->map(function ($call) use ($index, $totalZone) {
                    $call->$index = $totalZone == 0 ? 0.00 : round($call->count * 100 / $totalZone, 2);
                    return $call;
                });
            });
            $globalData = $temp->flatten();

            $globalData = $globalData->groupBy(['agent_traitant','date']);
            $globalData = $globalData->map(function ($element) use ($keys) {
                return $element->map(function ($elementCall, $elementIndex) use ($keys) {
                    $elementCall =   $elementCall->map(function ($call,$index) use($keys){
                        $row = new \stdClass();
                        $row->values = [];
                        $row->agent_traitant = $call->agent_traitant;
                        $row->date = $call->date;
                        $keys->map(function ($key,$keyIndex) use(&$row,$call){
                            if(isset($call->$key)){
                                $row->$key =  $call->count ;
                                $row->values[$key] = $call->count;
                                $row->total =  isset($row->total) ? $row->total + $call->count : $call->count;
                            }else{
                                $row->$key =  0 ;
                                $row->values[$key] = 0;
                            }
                        });
                        return $row;
                    });
                    return $elementCall;
                })->flatten();
            })->flatten();

            $globalData = $globalData->values();

            return ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $filter->rows_zone,'data' => $globalData,'cdpFilter'=>$cdp ,'checkedCdpFilter' =>$filter->rows_cdp];
        }
    }
}
