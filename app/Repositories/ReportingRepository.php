<?php


namespace App\Repositories;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ReportingRepository
{
    public function getDateNotes(Request $request,$table)
    {
        $selectedColumn = ($table === 'instance') ? 'date_de_rendez_vous' : 'date';
        $dates = \DB::table($table)
            ->select(
                DB::raw("YEAR(".$selectedColumn.") as year"),
                DB::raw("MONTH(".$selectedColumn.") as month"),
                DB::raw("concat('S', WEEKOFYEAR(".$selectedColumn.")) as week"),
                $selectedColumn
            )
            ->distinct()
            ->whereNull('isNotReady')
            ->orderBy($selectedColumn)
            ->get()
            ->groupBy(['year', 'month', 'week', $selectedColumn])
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
        list($filter, $queryFilters) = makeFilterSubQuery($request, $route,'zone_region','date_de_rendez_vous');

        $instance = \DB::table('instance');

        $instance = $instance->select('agent_traitant','numero_de_labonne_reference_client','date_de_rendez_vous', 'task_type',\DB::raw('count(numero_de_labonne_reference_client) as count') )
            ->whereNull('isNotReady');

        $instance = applyFilter($instance, $filter,'zone_region','date_de_rendez_vous');

        $zone = \DB::table('instance')
            ->select('zone_region')
            ->distinct()
            ->whereNull('isNotReady')
            ->pluck('zone_region');


        $instance = $instance->orderBy('agent_traitant');
        $instance = $instance->groupBy('agent_traitant','numero_de_labonne_reference_client','date_de_rendez_vous', 'task_type')->get();

        $keys = $instance->groupBy(['task_type'])->keys();

        if(!$keys->contains('FTTH'))
            $keys->push('FTTH');
        if(!$keys->contains('FTTB'))
            $keys->push('FTTB');


        if (!count($instance)) {
            $data = ['data' => []];
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

            $instance = $instance->groupBy('numero_de_labonne_reference_client');
            $instance = $instance->map(function ($element) use ($keys) {
                $row = new \stdClass();
                $row->values = [];

                $col_arr = $keys->all();
                $items = $element->map(function ($call, $index) use (&$row, &$col_arr) {
                    $row->agent_traitant = $call->agent_traitant;
                    $row->numero_de_labonne_reference_client = $call->numero_de_labonne_reference_client;
                    $row->date_de_rendez_vous = $call->date_de_rendez_vous;
                    $task_type = $call->task_type;
                    $row->$task_type = $call->count;
                    $row->values[$task_type] = $call->count;
                    $row->total =  isset($row->total) ? $row->total + $call->count : $call->count;
                    $col_arr = array_diff($col_arr, [$task_type]);
                    return $row;
                });

                $_item = $items->last();

                foreach ($col_arr as $col) {
                    $_item->values[$col] = 0;
                    $_item->$col = '0';
                }
                ksort($_item->values);

                $_item->values = collect($_item->values)->values();
                return $_item;
            });
            $instance = $instance->values();

            return ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $filter->rows_filter,'data' => $instance];
        }
    }

    public function getEnCoursData(Request $request){

        $_route = getRoute(Route::current());
        $route = str_replace('/columns', '', $_route);
        list($filter, $queryFilters) = makeFilterSubQuery($request, $route,'ville','date');

        $en_cours = \DB::table('en_cours');

        $en_cours = $en_cours->select('agent_traitant','as','date', 'task_type',\DB::raw('count(`as`) as count') )
            ->whereNull('isNotReady');

        $en_cours = applyFilter($en_cours, $filter,'ville','date');


        $zone = \DB::table('en_cours')
            ->select('ville')
            ->distinct()
            ->whereNull('isNotReady')
            ->pluck('ville');


        $en_cours = $en_cours->orderBy('agent_traitant');
        $en_cours = $en_cours->groupBy('agent_traitant','as','date', 'task_type')->get();

        $keys = $en_cours->groupBy(['task_type'])->keys();

        if(!$keys->contains('FTTH'))
            $keys->push('FTTH');
        if(!$keys->contains('FTTB'))
            $keys->push('FTTB');


        if (!count($en_cours)) {
            $data = ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $request->get('rowFilter'),'data' => []];
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

            $en_cours = $en_cours->groupBy('as','date');
            $en_cours = $en_cours->map(function ($element) use ($keys) {
                $row = new \stdClass();
                $row->values = [];

                $col_arr = $keys->all();
                $items = $element->map(function ($call, $index) use (&$row, &$col_arr) {
                    $row->agent_traitant = $call->agent_traitant;
                    $row->as = $call->as;
                    $row->date = $call->date;
                    $task_type = $call->task_type;
                    $row->$task_type = $call->count;
                    $row->values[$task_type] = $call->count;
                    $row->total =  isset($row->total) ? $row->total + $call->count : $call->count;
                    $col_arr = array_diff($col_arr, [$task_type]);
                    return $row;
                });

                $_item = $items->last();

                foreach ($col_arr as $col) {
                    $_item->values[$col] = 0;
                    $_item->$col = '0';
                }
                ksort($_item->values);

                $_item->values = collect($_item->values)->values();
                return $_item;
            });
            $en_cours = $en_cours->values();

            return ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $filter->rows_filter,'data' => $en_cours];
        }
    }

    public function getGlobalData(Request $request){

        $_route = getRoute(Route::current());
        $route = str_replace('/columns', '', $_route);
        list($filter, $queryFilters) = makeFilterSubQuery($request, $route,'ville','date');

        $instance = \DB::table('instance');

        $instance = $instance->select(\DB::raw('agent_traitant, numero_de_labonne_reference_client as identifiant, date_de_rendez_vous as date,task_type,count(numero_de_labonne_reference_client) as count') )
            ->whereNull('isNotReady')->whereNotNull('agent_traitant');
        $instance = applyFilter($instance, $filter,'zone_region','date_de_rendez_vous');

        $en_cours = \DB::table('en_cours');
        $en_cours = $en_cours->select(\DB::raw('agent_traitant, `as` as identifiant ,date,task_type,count(`as`) as count') )
            ->whereNull('isNotReady')->whereNotNull('agent_traitant');
        $en_cours = applyFilter($en_cours, $filter,'ville','date');


        $zone = \DB::table('en_cours')
            ->select('ville')
            ->distinct()
            ->whereNull('isNotReady')
            ->pluck('ville');

        $instance = $instance->orderBy('agent_traitant');
        $instance = $instance->groupBy('agent_traitant','identifiant','date_de_rendez_vous', 'task_type')->get();

        $en_cours = $en_cours->orderBy('agent_traitant');
        $en_cours = $en_cours->groupBy('agent_traitant','identifiant','date', 'task_type')->get();

        $globalData = $instance->merge($en_cours);

        $keys = $globalData->groupBy(['task_type'])->keys();

        if(!$keys->contains('FTTH'))
            $keys->push('FTTH');
        if(!$keys->contains('FTTB'))
            $keys->push('FTTB');


        if (!count($globalData)) {
            $data = ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $request->get('rowFilter'),'data' => []];
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

            $globalData = $globalData->groupBy(['identifiant']);
            $globalData = $globalData->map(function ($element) use ($keys) {
                $row = new \stdClass();
                $row->values = [];

                $col_arr = $keys->all();
                $items = $element->map(function ($call, $index) use (&$row, &$col_arr) {
                    $row->agent_traitant = $call->agent_traitant;
                    $row->identifiant = $call->identifiant;
                    $row->date = $call->date;
                    $task_type = $call->task_type;
                    $row->$task_type = $call->count;
                    $row->values[$task_type] = $call->count;
                    $row->total =  isset($row->total) ? $row->total + $call->count : $call->count;
                    $col_arr = array_diff($col_arr, [$task_type]);
                    return $row;
                });
                $_item = $items->last();

                foreach ($col_arr as $col) {
                    $_item->values[$col] = 0;
                    $_item->$col = '0';
                }
                ksort($_item->values);

                $_item->values = collect($_item->values)->values();
                return $_item;
            });
            $globalData = $globalData->values();

            return ['filter' => $filter,'zoneFilter' => $zone,'checkedZoneFilter' => $filter->rows_filter,'data' => $globalData];
        }
    }
}
