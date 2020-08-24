<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class tasksExport implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $request;
    private $taskRepository;
    public $type;

    public function __construct(Request $request,$type)
    {
        $this->request = $request;
        $this->type = $type;
        $this->taskRepository = new TaskRepository();
    }
    /**
     * @inheritDoc
     */
    public function collection()
    {
         return $this->getData();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        if($this->type === 'instance')
        return [
            'Numero de l\'abonne / Référence client',
            'Station de Modulation / Ville',
            'ZONE / Région',
            'STIT',
            'COMMUNE',
            'Code postal',
            'Numero de l\'appel / Référence SFR',
            'LIB_CAP / Typologie Inter',
            'Date de rendez-vous',
            'CODE_MD / Code échec',
            'Agent traitant',
            'Statut du report',
            'Type'
        ];
        else
        return [
            'Agent traitant',
            'Région',
            'Prestataire',
            'Nom Tech',
            'Prénom Tech',
            'Date',
            'Creneaux',
            'Type',
            'Client',
            'AS',
            'Code Postal',
            'Ville',
            'Voie',
            'Rue',
            'Numéro Abo',
            'Nom Abo',
            'Report multiple',
            'Cause du report',
            'Statut du report',
            'Accord région',
            'Type'
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
       if($this->type === 'instance')
        return [
            $row->numero_de_labonne_reference_client,
            $row->station_de_modulation_Ville,
            $row->zone_region,
            $row->stit,
            $row->commune,
            $row->code_postal,
            $row->numero_de_lappel_reference_sfr,
            $row->libcap_typologie_inter,
            $row->date_de_rendez_vous,
            $row->code_md_code_echec,
            $row->agent_traitant,
            $row->statut_du_report,
            $row->task_type,
        ];
        else
            return [
                $row->agent_traitant,
                $row->region,
                $row->Prestataire,
                $row->nom_tech,
                $row->prenom_tech,
                $row->date,
                $row->creneaux,
                $row->type,
                $row->client,
                $row->as,
                $row->code_postal,
                $row->ville,
                $row->voie,
                $row->rue,
                $row->numero_abo,
                $row->nom_abo,
                $row->report_multiple,
                $row->cause_du_report,
                $row->statut_du_report,
                $row->accord_region,
                $row->task_type,
            ];
         return $row;
    }

    private function getData(){
        if($this->type === 'instance'){
            $data =  $this->taskRepository->getTasks($this->request,'Instance');
        }
        else
            $data = $this->taskRepository->getTasks($this->request,'EnCours');
        return $data;
    }
}
