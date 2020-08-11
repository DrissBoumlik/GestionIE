<?php

use App\Models\Filter;
use App\Models\UserFlag;
use Illuminate\Http\Request;

if (!function_exists('EnCoursResource')) {
    function EnCoursResource(\App\Models\EnCours $item)
    {
        $statut_final = [];
        $statut_final['id'] = $item->id;
        $statut_final['text'] = $item->statut_final ? $item->statut_final : 'A effectuer';

        if ($item->statut_final == 'EN COURS') {
            $className = 'badge badge-info';
        } elseif ($item->statut_final == 'TRAITE') {
            $className = 'badge badge-success';
        } else {
            $className = 'badge badge-primary';
        }
        $statut_final['className'] = $className;
        $taskLog = \App\Models\EnCoursLog::where('en_cours_id', $item->id)->orderBy('updated_at', 'desc')->first();
        $user = null;
        if ($taskLog) {
            $user = \App\Models\User::find($taskLog->user_id);
        }
        return [
            'id' => $item->id,
            'agent_traitant' => $item->agent_traitant,
            'region' => $item->region,
            'prestataire' => $item->prestataire,
            'nom_tech' => $item->nom_tech,
            'prenom_tech' => $item->prenom_tech,
            'date' => $item->date,
            'creneaux' => $item->creneaux,
            'type' => $item->type,
            'client' => $item->client,
            'as' => $item->as,
            'code_postal' => $item->code_postal,
            'ville' => $item->ville,
            'voie' => $item->voie,
            'rue' => $item->rue,
            'numero_abo' => $item->numero_abo,
            'nom_abo' => $item->nom_abo,
            'report_multiple' => $item->report_multiple,
            'cause_du_report' => $item->cause_du_report,
            'statut_du_report' => $item->statut_du_report,
            'statut_final' => $statut_final,
            'accord_region' => $item->accord_region,
            'task_type' => $item->task_type,
            'taskLog_id' => $taskLog ? $taskLog->id : null,
            'user' => $user,
            'updated_at' => \Carbon\Carbon::createFromTimeStamp(strtotime($item->updated_at))->diffForHumans()
        ];
    }
}

if (!function_exists('EnCoursCollection')) {
    function EnCoursCollection(\Illuminate\Support\Collection $collection)
    {
        return $collection->map(function ($item) {
            return EnCoursResource($item);
        });

    }
}

if (!function_exists('InstanceResource')) {
    function InstanceResource(\App\Models\Instance $item)
    {
        $statut_final = [];
        $statut_final['id'] = $item->id;
        $statut_final['text'] = $item->statut_final ? $item->statut_final : 'A effectuer';

        if ($item->statut_final == 'EN COURS') {
            $className = 'badge badge-info';
        } elseif ($item->statut_final == 'TRAITE') {
            $className = 'badge badge-success';
        } else {
            $className = 'badge badge-primary';
        }
        $statut_final['className'] = $className;

        $taskLog = \App\Models\InstanceLog::where('instance_id', $item->id)->orderBy('updated_at', 'desc')->first();
        $user = null;
        if ($taskLog) {
            $user = \App\Models\User::find($taskLog->user_id);
        }

        return [
            'id' => $item->id,
            'numero_de_labonne_reference_client' => $item->numero_de_labonne_reference_client,
            'station_de_modulation_Ville' => $item->station_de_modulation_Ville,
            'zone_region' => $item->zone_region,
            'stit' => $item->stit,
            'commune' => $item->commune,
            'code_postal' => $item->code_postal,
            'numero_de_lappel_reference_sfr' => $item->numero_de_lappel_reference_sfr,
            'libcap_typologie_inter' => $item->libcap_typologie_inter,
            'date_de_rendez_vous' => $item->date_de_rendez_vous,
            'code_md_code_echec' => $item->code_md_code_echec,
            'agent_traitant' => $item->agent_traitant,
            'statut_du_report' => $item->statut_du_report,
            'statut_final' => $statut_final,
            'task_type' => $item->task_type,
            'taskLog_id' => $taskLog ? $taskLog->id : null,
            'user' => $user,
            'updated_at' => \Carbon\Carbon::createFromTimeStamp(strtotime($item->updated_at))->diffForHumans()
        ];
    }
}

if (!function_exists('InstanceCollection')) {
    function InstanceCollection(\Illuminate\Support\Collection $collection)
    {
        return $collection->map(function ($item) {
            return InstanceResource($item);
        });

    }
}

if (!function_exists('getTableData')) {
    function getTableData($index = null)
    {
        if ($index !== null) {
            return config('custom_params.tables_data')[$index];
        }
        return config('custom_params.tables_data');
    }
}

if (!function_exists('sortGroupementColumnsPreserveKeys')) {
    function sortGroupementColumnsPreserveKeys($columns)
    {
        $sortWith = config('custom_params.groupement');
        $columns = $columns->sortBy(function ($item, $key) use ($sortWith) {
            return array_flip($sortWith)[$key];
        });
        return $columns;
    }
}

if (!function_exists('sortGroupementColumns')) {
    function sortGroupementColumns($columns)
    {
        $columns = $columns->all();
        $sortWith = config('custom_params.groupement');
        $columns = collect(array_intersect($sortWith, $columns));
        return $columns;
    }
}

if (!function_exists('getImportedData')) {
    function getImportedData($wantValue = false)
    {
        $user_flag = UserFlag::where('user_id', getAuthUser()->id)->first();
        $result = $user_flag ? ($wantValue ? $user_flag->flags : $user_flag) : -1;
        return $result;
//        return $wantValue ? ($user_flag ? $user_flag->flags['imported_data'] : 0) : $user_flag;
    }
}

if (!function_exists('getMonthName')) {
    function getMonthName($index)
    {
        $Months = [
            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre'
        ];
        return $Months[$index];
    }
}

if (!function_exists('makeFilterSubQuery')) {
    function makeFilterSubQuery(Request $request, $route, $columnZone = null,$columnCdp = null,$columnVille = null,$columnType = null,$dateColumn = null)
    {
        $user = getAuthUser();
        $filters = ['route' => $route, 'user_id' => $user->id, 'agent_name' => $user->lastname, 'isGlobal' => null];


        $dates = $request->get('dates');
        $rowsZOne = $request->get('rowzone');
        $rowsCdp = $request->get('rowcdp');
        $rowsCity = $request->get('rowcity');
        $rowsType = $request->get('rowtype');
        $currentMonth = date('Y-m') . '%';
        $filter = Filter::firstOrCreate($filters);
        $queryFilters = null;
        $filterSaved = false;
        if ($request->get('refreshMode') === 'true') {
            if (!is_array($dates)) {
                $dates = explode(',', $dates);
            }
            $dates = $dates ? array_values($dates) : null;
            $rowsZOne = $rowsZOne ? array_values($rowsZOne) : null;
            $rowsCdp = $rowsCdp ? array_values($rowsCdp) : null;
            $filter->date_filter = $dates;
            $filter->rows_zone = $rowsZOne;
            $filter->rows_cdp = $rowsCdp;
            $filter->rows_city = $rowsCity;
            $filter->rows_type = $rowsType;
            if ($dates || $rowsZOne || $rowsCdp || $rowsCity || $rowsType) {
                $filterSaved = true;
                $filter->save();
            } else {
                $filter->forceDelete();
                $filter = null;
            }
        } else {
            $globalFilter = Filter::where(['user_id' => $user->id, 'isGlobal' => true])->first();
            if ($globalFilter) {
                $filter->date_filter = $globalFilter->date_filter;
                $filter->save();
                $filterSaved = true;
            }
        }

        if($filter){
            $filter->rows_zone = is_array($filter->rows_zone) ? $filter->rows_zone : json_decode($filter->rows_zone);
            $filter->rows_cdp  = is_array($filter->rows_cdp)  ? $filter->rows_cdp  : json_decode($filter->rows_cdp) ;
            $filter->rows_city = is_array($filter->rows_city) ? $filter->rows_city : json_decode($filter->rows_city) ;
            $filter->rows_type = is_array($filter->rows_type) ? $filter->rows_type : json_decode($filter->rows_type) ;
            if ($filter && $filter->date_filter) {
                $queryFilters[] = $dateColumn .' in ("' . join('","', $filter->date_filter) . '")';
            } else {
                $queryFilters[] = $dateColumn .' like "' . $currentMonth . '"';
            }
            if ($columnZone && $filter && $filter->rows_zone) {
                $queryFilters[] = $columnZone . ' in ("' . join('","', $filter->rows_zone) . '")';
            }
            if ($columnCdp && $filter && $filter->rows_cdp) {
                $queryFilters[] = $columnCdp . ' in ("' . join('","', $filter->rows_cdp) . '")';
            }
            if ($columnVille && $filter && $filter->rows_city) {
                $queryFilters[] = $columnVille . ' in ("' . join('","', $filter->rows_city) . '")';
            }
            if ($columnVille && $filter && $filter->rows_type) {
                $queryFilters[] = $columnType . ' in ("' . join('","', $filter->rows_type) . '")';
            }
        }
        $queryFilters = join(' and ', $queryFilters);


        if ($filter && !$filter->exists && !$filterSaved) {
            $filter = null;
        }
        return [$filter, $queryFilters];
    }
}

if (!function_exists('applyFilter')) {
    function applyFilter($results, $filter, $columnZone = null, $columnCdp = null,$columnVille = null,$columnType = null,$dateColumn = null)
    {
        $currentMonth = date('Y-m') . '%';
        if ($columnZone && $filter && $filter->rows_zone) {
            $results = $results->whereIn( $columnZone, $filter->rows_zone);
        }
        if ($columnCdp && $filter && $filter->rows_cdp) {
            $results = $results->whereIn( $columnCdp, $filter->rows_cdp);
        }
        if ($columnVille && $filter && $filter->rows_city) {
            $results = $results->whereIn( $columnVille, $filter->rows_city);
        }
        if ($columnType && $filter && $filter->rows_type) {
            $results = $results->whereIn( $columnType, $filter->rows_type);
        }
        if ($filter && $filter->date_filter) {
            $results = $results->whereIn($dateColumn, $filter->date_filter);
        } else {
            $results = $results->where($dateColumn, 'like', $currentMonth);
        }
        return $results;
    }
}

if (!function_exists('sortWeeksDates')) {
    function sortWeeksDates($dates, $desc = false)
    {
        uksort($dates, function ($item1, $item2) use ($desc) {
            $date1 = explode('_', $item1);
            $date2 = explode('_', $item2);
            $year1 = $date1[1];
            $year2 = $date2[1];
            if ($year1 != $year2) {
                return ($year1 == $year2) ? 0 :
                    ($desc ? ($year1 < $year2 ? -1 : 1)
                        : ($year1 > $year2 ? -1 : 1));
            } else {
                $week1 = $date1[0];
                $week2 = $date2[0];
                return ($week1 == $week2) ? 0 :
                    ($desc ? ($week1 < $week2 ? -1 : 1)
                        : ($week1 > $week2 ? -1 : 1));
            }
        });
        return $dates;
    }
}

if (!function_exists('sortColumns')) {
    function sortColumns($columns, $desc = false)
    {
        usort($columns, function ($item1, $item2) use ($desc) {
            return ($item1->data == $item2->data) ? 0 :
                ($desc ? ($item1->data > $item2->data ? -1 : 1)
                    : ($item1->data < $item2->data ? -1 : 1));
        });
    }
}

if (!function_exists('getRoute')) {
    function getRoute($route)
    {
        $routeURI = $route->uri;
        $_index = 0;
        return collect($route->parameters)->reduce(function ($carry, $value) use (&$routeURI, &$_index, $route) {
            return $routeURI = str_replace('{' . $route->parameterNames[$_index++] . '}', $value, $routeURI);
        }, $routeURI);
    }
}

if (!function_exists('getRadicalRoute')) {
    function getRadicalRoute($route)
    {
        $radicalRoute = explode('/', getRoute($route));
        if (count($radicalRoute)) {
            return $radicalRoute[0];
        } else {
            return null;
        }
    }
}

if (!function_exists('getPicture')) {
    function getPicture($user = null)
    {
        $user = $user ?? auth()->user();
        $picturePath = Str::contains($user->picture, 'http') ? $user->picture : URL::to('/') . $user->picture;
        return $user->picture ? $picturePath : ($user->gender == 'male' ? '/storage/users/male.png' : '/storage/users/female.png');
    }
}

if (!function_exists('fullName')) {
    function fullName($user, $char_slicer)
    {
        return ucfirst($user->firstname) . $char_slicer . ucfirst($user->lastname);
    }
}

if (!function_exists('fullImageUrl')) {
    function fullImageUrl($path)
    {
        return strpos($path, '//') ? $path : URL::to('/') . '/' . $path;
    }
}

if (!function_exists('pictures')) {
    function pictures()
    {
        return ['https://images2.imgbox.com/ae/76/pS8iBmkr_o.png',
            'https://images2.imgbox.com/7f/13/gFRcrjpl_o.png',
            'https://images2.imgbox.com/9a/a9/kCaSnMi1_o.png',
            'https://images2.imgbox.com/29/c1/P6QuLCTm_o.png',
            'https://images2.imgbox.com/af/db/FZVnDGxz_o.png',
            'https://images2.imgbox.com/78/a1/96M3aKXq_o.png',
            'https://images2.imgbox.com/46/e2/1RIG27Zs_o.png',
            'https://images2.imgbox.com/ae/fa/Cx2Oah56_o.png',
            'https://images2.imgbox.com/85/41/AQpTk0D0_o.png',
            'https://images2.imgbox.com/13/a2/aG2rQ4tK_o.png',
            'https://images2.imgbox.com/05/bc/YxQjPbDx_o.png',
            'https://images2.imgbox.com/c7/fa/Sfw0jxLd_o.png',
            'https://images2.imgbox.com/ba/44/2peQ5dpk_o.png',
            'https://images2.imgbox.com/89/db/qQ4XqwvC_o.png',
            'https://images2.imgbox.com/68/0f/TbhhmjH5_o.png',
            'https://images2.imgbox.com/57/77/2bWU44yq_o.png',
            'https://images2.imgbox.com/f7/ae/3hvnZvVg_o.png',
            'https://images2.imgbox.com/bd/39/l8fusalV_o.png',
            'https://images2.imgbox.com/18/b3/pAvfWo0O_o.png',
            'https://images2.imgbox.com/d1/ca/CMc9oKb4_o.png',
            'https://images2.imgbox.com/86/80/K8kAIYYm_o.png',
            'https://images2.imgbox.com/c4/52/cL99gk5E_o.png',
            'https://images2.imgbox.com/6f/05/El4zVDnh_o.png',
            'https://images2.imgbox.com/29/6a/x6DY12NI_o.png',
            'https://images2.imgbox.com/11/13/OusuH1QY_o.png',
            'https://images2.imgbox.com/18/a9/GKvX59i0_o.png',
            'https://images2.imgbox.com/25/3c/gNH2dITI_o.png',
            'https://images2.imgbox.com/7f/56/DKpDpzfU_o.png',
            'https://images2.imgbox.com/e8/1f/2MbvZCVX_o.png',
            'https://images2.imgbox.com/d6/e9/1X2FzL3z_o.png',
            'https://images2.imgbox.com/ee/87/aYEM6cg9_o.png',
            'https://images2.imgbox.com/d1/9c/HpCSwTUr_o.png',
            'https://images2.imgbox.com/a2/1c/a2GLIjnH_o.png',
            'https://images2.imgbox.com/2b/34/LRs2jOYx_o.png',
            'https://images2.imgbox.com/e8/a0/8DQUTkkn_o.png',
            'https://images2.imgbox.com/23/7e/0hxQRWE2_o.png',
            'https://images2.imgbox.com/f5/9d/9LLBsXzm_o.png',
            'https://images2.imgbox.com/3d/52/6QrNUhnL_o.png',
            'https://images2.imgbox.com/f0/67/M1FbDgqz_o.png',
            'https://images2.imgbox.com/94/ad/7X7paVBw_o.png',
            'https://images2.imgbox.com/96/aa/JzotNivF_o.png',
            'https://images2.imgbox.com/7b/92/VlguVA2h_o.png',
            'https://images2.imgbox.com/7c/46/OLEF6gZ3_o.png',
            'https://images2.imgbox.com/c2/3a/UOg8Ae2F_o.png',
            'https://images2.imgbox.com/f8/c7/pXDXrLwk_o.png',
            'https://images2.imgbox.com/4f/16/Ew3crQwp_o.png',
            'https://images2.imgbox.com/24/90/LEzYHLal_o.png',
            'https://images2.imgbox.com/7e/bb/PAIHBMe8_o.png',
            'https://images2.imgbox.com/64/7a/GswUJQ4p_o.png',
            'https://images2.imgbox.com/af/ca/yrvfCxbX_o.png',
            'https://images2.imgbox.com/6e/45/xLJ4y3ZH_o.png',
            'https://images2.imgbox.com/63/bf/FMCAouwq_o.png',
            'https://images2.imgbox.com/fa/62/wFzSfT01_o.png',
            'https://images2.imgbox.com/3f/4d/lb6MGvcZ_o.png',
            'https://images2.imgbox.com/97/78/vlNYBZoj_o.png',
            'https://images2.imgbox.com/2b/e0/PfDPEqCR_o.png',
            'https://images2.imgbox.com/0d/fa/tdM5gSOY_o.png',
            'https://images2.imgbox.com/b7/93/8VV0tQlQ_o.png',
            'https://images2.imgbox.com/72/9b/Oafp3NTu_o.png',
            'https://images2.imgbox.com/ad/d0/ejSkM41c_o.png',
            'https://images2.imgbox.com/f7/62/9decgZn4_o.png',
            'https://images2.imgbox.com/89/7b/QuYEJ1lH_o.png',
            'https://images2.imgbox.com/bc/df/6YNhcC3I_o.png',
            'https://images2.imgbox.com/51/25/cuMFYJkQ_o.png',
            'https://images2.imgbox.com/37/30/xAcqI2ll_o.png',
            'https://images2.imgbox.com/81/88/VEaPEhqB_o.png',
            'https://images2.imgbox.com/0a/29/70VRrU7x_o.png',
            'https://images2.imgbox.com/b0/2a/3DK9QhKq_o.png',
            'https://images2.imgbox.com/27/5b/1NSDhN2s_o.png',
            'https://images2.imgbox.com/61/44/cP70vInn_o.png',
            'https://images2.imgbox.com/79/77/5SnT7bsr_o.png',
            'https://images2.imgbox.com/f4/0a/4mJxpJGP_o.png',
            'https://images2.imgbox.com/4b/49/e2vySEN0_o.png',
            'https://images2.imgbox.com/c5/91/IjQjGrJ0_o.png',
            'https://images2.imgbox.com/a1/85/BvWh7coO_o.png',
            'https://images2.imgbox.com/35/91/mNWwVUN9_o.png',
            'https://images2.imgbox.com/d0/58/EWaZtdzg_o.png',
            'https://images2.imgbox.com/c8/77/6z9Z8Uj7_o.png',
            'https://images2.imgbox.com/5e/22/JJPkz4AS_o.png',
            'https://images2.imgbox.com/18/9e/Ya3XQsW8_o.png',
            'https://images2.imgbox.com/54/3f/JELDFqyq_o.png',
            'https://images2.imgbox.com/cd/a2/tyahzbTO_o.png',
            'https://images2.imgbox.com/60/f1/0G8Hc8Aq_o.png',
            'https://images2.imgbox.com/d9/0c/G5Wash7V_o.png',
            'https://images2.imgbox.com/2b/be/VrvLPRBd_o.png',
            'https://images2.imgbox.com/75/b0/NyZk9Glf_o.png',
            'https://images2.imgbox.com/9a/55/meQbi4rp_o.png',
            'https://images2.imgbox.com/d9/a0/DUpccg32_o.png',
            'https://images2.imgbox.com/db/02/f8zM7Gp0_o.png',
            'https://images2.imgbox.com/b2/27/hPH0rXdJ_o.png',
            'https://images2.imgbox.com/30/c3/jUcUKUfz_o.png',
            'https://images2.imgbox.com/66/c0/aBYN9M1K_o.png',
            'https://images2.imgbox.com/6e/ad/eA2c7fsT_o.png',
            'https://images2.imgbox.com/3a/0b/lT70yYvI_o.png',
            'https://images2.imgbox.com/b0/0c/15nNJq8h_o.png',
            'https://images2.imgbox.com/0a/21/cbxTPMj3_o.png',
            'https://images2.imgbox.com/90/85/lm2Tmmqd_o.png',
            'https://images2.imgbox.com/29/8b/xCpK19mP_o.png',
            'https://images2.imgbox.com/8e/a5/ItFSmNSV_o.png',
            'https://images2.imgbox.com/92/8c/s0VZjlwI_o.png',
            'https://images2.imgbox.com/5e/4b/41HTmKCj_o.png',
            'https://images2.imgbox.com/40/33/M1gjtGAT_o.png',
            'https://images2.imgbox.com/8e/dc/x6kfnPmN_o.png',
            'https://images2.imgbox.com/68/2a/XpaUWINA_o.png',
            'https://images2.imgbox.com/93/3a/DEPvYe1x_o.png',
            'https://images2.imgbox.com/82/91/uNtwQVfJ_o.png',
            'https://images2.imgbox.com/46/05/k612n6eq_o.png',
            'https://images2.imgbox.com/e9/50/pAbfe5hW_o.png',
            'https://images2.imgbox.com/a9/9d/fWXdDTt4_o.png',
            'https://images2.imgbox.com/79/7f/wXtXk1J4_o.png',
            'https://images2.imgbox.com/1d/c3/rPt7ZJKe_o.png',
            'https://images2.imgbox.com/56/10/58FPBaZ9_o.png',
            'https://images2.imgbox.com/4c/80/RCih5oQP_o.png',
            'https://images2.imgbox.com/87/ee/sPhOO4Dd_o.png',
            'https://images2.imgbox.com/5c/9d/9suZzZPZ_o.png',
            'https://images2.imgbox.com/74/13/xyFZub2q_o.png',
            'https://images2.imgbox.com/b8/8c/QXJtUa1O_o.png',
            'https://images2.imgbox.com/fa/9a/da1CMOLA_o.png',
            'https://images2.imgbox.com/e5/8b/v5tZ6xe0_o.png',
            'https://images2.imgbox.com/be/34/txTJhwkk_o.png',
            'https://images2.imgbox.com/b3/73/dFLIHgJd_o.png',
            'https://images2.imgbox.com/13/98/s5emY8bR_o.png',
            'https://images2.imgbox.com/e5/44/Gb5OKzHx_o.png',
            'https://images2.imgbox.com/6b/c5/6wz9tnBF_o.png',
            'https://images2.imgbox.com/0a/c3/kORBpI8n_o.png',
            'https://images2.imgbox.com/e7/19/krVAAMjd_o.png',
            'https://images2.imgbox.com/1e/65/suComlWL_o.png',
            'https://images2.imgbox.com/2a/d2/WXT1ILdE_o.png',
            'https://images2.imgbox.com/61/d2/6E4EvA5K_o.png',
            'https://images2.imgbox.com/6a/d0/2Croa9dw_o.png',
            'https://images2.imgbox.com/16/97/nibg2lOh_o.png',
            'https://images2.imgbox.com/89/3f/jtUdM6fm_o.png',
            'https://images2.imgbox.com/7d/b0/GDA8VUq3_o.png',
            'https://images2.imgbox.com/de/26/hVe8EO3B_o.png',
            'https://images2.imgbox.com/dc/ed/sZeUhGL3_o.png',
            'https://images2.imgbox.com/43/7f/8QLPjyma_o.png',
            'https://images2.imgbox.com/83/a7/X9RxTc9M_o.png',
            'https://images2.imgbox.com/c6/03/i6Fz35CD_o.png',
            'https://images2.imgbox.com/c3/ce/hOKZGRq4_o.png',
            'https://images2.imgbox.com/bc/90/zDa2iVpJ_o.png',
            'https://images2.imgbox.com/f1/13/DjWxgWmv_o.png',
            'https://images2.imgbox.com/b9/2e/TPjcPNXQ_o.png',
            'https://images2.imgbox.com/d5/ed/7tPXGYT5_o.png',
            'https://images2.imgbox.com/1f/48/HfYSpBtR_o.png',
            'https://images2.imgbox.com/8c/0a/pii9SYv9_o.png',
            'https://images2.imgbox.com/89/a9/SHO4Ygga_o.png',
            'https://images2.imgbox.com/7b/15/V1LlZ48o_o.png',
            'https://images2.imgbox.com/52/56/cke7i0zW_o.png',
            'https://images2.imgbox.com/ca/ac/jrCVc5ZG_o.png',
            'https://images2.imgbox.com/c2/96/uOEsSvxD_o.png',
            'https://images2.imgbox.com/17/e0/UU0DB6TK_o.png',
            'https://images2.imgbox.com/ab/98/7kHG15az_o.png',
            'https://images2.imgbox.com/6d/8a/Fl4jxtUI_o.png',
            'https://images2.imgbox.com/4d/a5/vBrlA3ne_o.png',
            'https://images2.imgbox.com/d9/49/NeYkUVvl_o.png',
            'https://images2.imgbox.com/61/ae/E0QdqwTd_o.png',
            'https://images2.imgbox.com/98/e5/TmLoqrCU_o.png',
            'https://images2.imgbox.com/b2/1a/jZuWb0LI_o.png',
            'https://images2.imgbox.com/59/10/5fQoLTxD_o.png',
            'https://images2.imgbox.com/67/85/kV3Gd3Lq_o.png',
            'https://images2.imgbox.com/47/91/Uk42H3V2_o.png',
            'https://images2.imgbox.com/bc/ce/JmXfKOi3_o.png',
            'https://images2.imgbox.com/53/bf/0MmUJVPA_o.png',
            'https://images2.imgbox.com/9c/5e/F8JZCJLn_o.png',
            'https://images2.imgbox.com/6c/89/E2lerhza_o.png',
            'https://images2.imgbox.com/6e/f6/af3HRf8l_o.png',];
    }
}

if (!function_exists('clean')) {
    function clean($string)
    {
        $string = str_replace([' ', '/'], '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}


if (!function_exists('replaceAccentedCharacter')) {
    function replaceAccentedCharacter($str)
    {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
        return str_replace($a, $b, $str);
    }
}

if (!function_exists('getAuthUser')) {
    function getAuthUser()
    {
        return auth()->user();
    }
}

if (!function_exists('isInAdminGroup')) {
    function isInAdminGroup($user = null)
    {
        $roleName = ($user ?? auth()->user())->role->name;
        return $roleName == 'superAdmin' || $roleName == 'admin';
    }
}

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin($user = null)
    {
        return ($user ?? auth()->user())->role->name == 'superAdmin';
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin($user = null)
    {
        return ($user ?? auth()->user())->role->name == 'admin';
    }
}

if (!function_exists('isAgent')) {
    function isAgent()
    {
        return ($user ?? auth()->user())->role->name == 'agent';
    }
}

if (!function_exists('isB2bSfr')) {
    function isB2bSfrGroup()
    {
        $roleName = ($user ?? auth()->user())->role->name;
        return $roleName == 'B2bSfr' || $roleName == 'B2bSfrAdmin';
    }

    function isB2bSfrAdmin()
    {
        return ($user ?? auth()->user())->role->name == 'B2bSfrAdmin';
    }
}
