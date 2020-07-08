<?php

namespace App\Imports;


use App\Models\EnCours;
use Illuminate\Support\LazyCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class TaskImport implements WithHeadingRow, WithChunkReading, WithBatchInserts, ToCollection
{
    use Importable;

    private $days = [];
    private $importType;
    private $user_flag;
    private $allData;
    public $rejectedData;

    public function __construct($days, $importType)
    {
        $this->importType = $importType;
//        if ($days) {
//            $this->days = explode(',', $days);
//            \DB::table('encours')->whereIn('date_note', $this->days)->delete();
//        }
        $this->user_flag = getImportedData(false);
        $this->user_flag->flags = [
            'imported_data' => 0,
            'is_importing' => 1
        ];
        $this->user_flag->update();
        $this->allData = new Collection();
        $this->rejectedData = new Collection();
    }

    public function collection(Collection $rows)
    {
        $columns = config('custom_params.db_table_columns')[$this->importType];
        $items = [];
        $data = $rows->reduce(function ($items, $row) use ($columns) {
//            $formatted_date = $this->transformDate($row['date]);
            if (!$this->days || in_array($row['date'], $this->days)) {
                $exists = count($this->allData->where('as', $row['as']));
                if ($exists) {
                    $this->rejectedData->push($row);
                    return $items;
                } else {
                    $item = [];
                    array_map(function ($column) use (&$item, $row) {
                        $item [$column] = $row[$column];
                    }, $columns);
                    /*
                    $item = [
                        'agent_traitant' => $row["agent_traitant"],
                        'region' => $row["region"],
                        'Prestataire' => $row["prestataire"],
                        'nome_tech' => $row["nom_tech"],
                        'prenom_tech' => $row["prenom_tech"],
                        'date' => $row["date"],
                        'creneaux' => $row["creneaux"],
                        'type' => $row["type"],
                        'client' => $row["client"],
                        'as' => $row["as"],
                        'code_postal' => $row["code_postal"],
                        'ville' => $row["ville"],
                        'voie' => $row["voie"],
                        'rue' => $row["rue"],
                        'numero_abo' => $row["numero_abo"],
                        'nom_abo' => $row["nom_abo"],
                        'report_multiple' => $row["report_multiple"],
                        'cause_report' => $row["cause_du_report"],
                        'statut_report' => $row["statut_du_report"],
                        'accord_region' => $row["accord_region"],
                        'isNotReady' => true,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    */
                    $this->allData->push($item);
                    $items[] = $item;
                    return $items;
                }
            }
        }, []);
//        dd($data);
        if ($data && count($data)) {
            EnCours::insert($data);
            if ($this->user_flag) {
                $imported_data = $this->user_flag->flags['imported_data'];
                $this->user_flag->flags = [
                    'imported_data' => $imported_data + count($data),
                    'is_importing' => 1
                ];
                $this->user_flag->save();
            }
        }
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}