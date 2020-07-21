<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TaskImport implements WithHeadingRow, WithChunkReading, WithBatchInserts, ToCollection
{
    use Importable;

    private $days = [];
    private $importType;
    private $user_flag;
    private $allData;
    public $rejectedData;
//    public $table;
//    private $class;
    public $tables_data;

    public function __construct($days, $importType)
    {
        $this->importType = $importType;
        $this->tables_data = getTableData($this->importType);
        if ($days) {
            $this->days = explode(',', $days);
            $date_filter = $this->tables_data['date_filter'];
            \DB::table($this->tables_data['table'])->whereIn($date_filter, $this->days)->delete();
        }
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
        $data = $rows->reduce(function ($items, $row) {
//            $formatted_date = $this->transformDate($row['date]);
            $date_filter = $this->tables_data['date_filter'];
            $columns = $this->tables_data['columns'];
            $tableId =$this->tables_data['id'];

            $rowDate = $row[$date_filter];
            if (is_integer($row[$date_filter])) {
                $rowDate = Date::excelToDateTimeObject($row[$date_filter]);
                $rowDate = $rowDate->format('Y-m-d');
            }
            if (!$this->days || in_array($rowDate, $this->days)) {
                $id = $this->tables_data['id'];
                $exists = count($this->allData->where($id, $row[$id]));
                if ($exists) {
                    $this->rejectedData->push($row);
                    return $items;
                } else {
                    $item = [];
                    if (is_integer($row[$tableId])) {
                        $item['task_type'] = 'FTTH';
                    } else {
                        $item['task_type'] = 'FTTB';
                    }
                    array_walk($columns, function ($column, $key) use (&$item, $row, $columns, $date_filter, $rowDate) {
                        if ($key == $date_filter) {
                            $item[$column] = $rowDate;
                            return;
                        }
                        if (isset($row[$key])) {
                            $item[$column] = $row[$key];
                        }
                    });
                    /*
                    $item = [
                        'agent_traitant' => $row["agent_traitant"],
                        'region' => $row["region"],
                        'Prestataire' => $row["prestataire"],
                        'nom_tech' => $row["nom_tech"],
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
            app('App\\Models\\' . $this->tables_data['class'])::insert($data);
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