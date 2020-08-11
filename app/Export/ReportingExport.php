<?php


namespace App\Export;


use App\Models\Instance;
use App\Repositories\ReportingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportingExport implements FromCollection,WithHeadings,WithMapping
{
    public $request;
    public $entity;
    private $reportingRepository;

    public function __construct(Request $request,$entity)
    {
        $this->request = $request;
        $this->entity = $entity;
        $this->reportingRepository = new ReportingRepository();
    }

    /**
     * @inheritDoc
     */
    public function collection()
    {
        $array = [];
        $data = collect($this->getData());
        $data->map(function ($elements) use(&$array){
            collect($elements)->map(function ($element) use(&$array){
                unset($element->values);
                array_push($array, $element);
            });
        });
         return collect($data['data']);
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Resource',
            'FTTH',
            'FTTB',
            'Total'
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        return [
            $row->agent_traitant,
            $row->FTTH,
            $row->FTTB,
            $row->total
        ];
    }

    private function getData(){
        if($this->entity === 'instance')
            $data =  $this->reportingRepository->getInstanceData($this->request);
        elseif ($this->entity === 'en_cours')
            $data = $this->reportingRepository->getEnCoursData($this->request);
        else
            $data = $this->reportingRepository->getGlobalData($this->request);
        return $data;
    }
}
