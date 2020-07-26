<?php


namespace App\Repositories;


use App\Models\Tickets;
use App\Models\TicketsLog;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTicketRequest;
use Yajra\DataTables\DataTables;

class TicketsRepository
{
    public function index(Request $request,$status){

        $tickets =$this->getTicketsQuery($request,$status);
        $tickets = $tickets->paginate(10);
        return $tickets;
    }

    private function getTicketsQuery(Request $request,$status){
            return Tickets::where(function($query) use ($request,$status){
                $query->where('statut_ticket', '=', $status);

                if(isset($request['type_intervention']) && !empty($request['type_intervention'])) {
                    $type_intervention = $request['type_intervention'];
                    $query->where('type_intervention', $type_intervention);
                }

                if(isset($request['statut_finale']) && !empty($request['statut_finale'])) {
                    $statut_finale = $request['statut_finale'];
                    $query->where('statut_finale', $statut_finale);
                }

                if(isset($request['motif_ko']) && !empty($request['motif_ko'])) {
                    $motif_ko = $request['motif_ko'];
                    $query->where('motif_ko', $motif_ko);
                }

                if(isset($request['motif_report']) && !empty($request['motif_report'])) {
                    $motif_report = $request['motif_report'];
                    $query->where('motif_report', $motif_report);
                }

                if(isset($request['as_j_1']) && !empty($request['as_j_1'])) {
                    $as_j_1 = $request['as_j_1'];
                    $query->where('as_j_1', $as_j_1);
                }

                if((isset($request['start-date']) && !empty($request['start-date']))  && (isset($request['end-date']) && !empty($request['end-date'])) ){
                    $start_date = $request['start-date'];
                    $end_date = $request['end-date'];
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                }
            })
                ->orderByDesc('tickets.id');
    }



    public function history($id)
    {
        $ticketLogs = TicketsLog::select(
            [ 'agent_traitant','motif_report','statut_finale', 'motif_ko','commentaire_report','as_j_1','statut_ticket','commentaire','created_at'
            ])
            ->where('ticket_id', '=', $id)
            ->orderBy('created_at','asc')
            ->get();

        return DataTables::of($ticketLogs)->toJson();

    }

    public function store(CreateTicketRequest $request)
    {
        $ticket = new Tickets();
        $ticket->agent_traitant      = auth()->user()->id;
        $ticket->region              = $request->get('region');
        $ticket->numero_intervention = $request->get('numero_intervention');
        $ticket->cdp                 = $request->get('cdp');
        $ticket->num_cdp             = $request->get('num_cdp');
        $ticket->type_intervention   = $request->get('type_intervention');
        $ticket->client              = $request->get('client');
        $ticket->cp                  = $request->get('cp');
        $ticket->ville               = $request->get('ville');
        $ticket->Sous_type_Inter     = $request->get('Sous_type_Inter');
        $ticket->date_reception      = $request->get('date_reception');
        $ticket->date_planification  = $request->get('date_planification');
        $ticket->report              = $request->get('report');
        $ticket->motif_report        = $request->get('motif_report');
        $ticket->commentaire_report  = $request->get('commentaire_report');
        $ticket->statut_finale       = $request->get('statut_finale');
        $ticket->nom_tech            = $request->get('nom_tech');
        $ticket->prenom_tech         = $request->get('prenom_tech');
        $ticket->num_tel             = $request->get('num_tel');
        $ticket->adresse_mail        = $request->get('adresse_mail');
        $ticket->motif_ko            = $request->get('motif_ko');
        $ticket->as_j_1              = $request->get('as_j_1');
        $ticket->statut_ticket       = $request->get('statut_ticket');
        $ticket->commentaire         = $request->get('commentaire');
        $ticket->save();

        $ticketLog = new TicketsLog();
        $ticketLog->agent_traitant      = auth()->user()->id;
        $ticketLog->ticket_id           = $ticket->id;
        $ticketLog->motif_report        = $request->get('motif_report');
        $ticketLog->commentaire_report  = $request->get('commentaire_report');
        $ticketLog->statut_finale       = $request->get('statut_finale');
        $ticketLog->motif_ko            = $request->get('motif_ko');
        $ticketLog->as_j_1              = $request->get('as_j_1');
        $ticketLog->statut_ticket       = $request->get('statut_ticket');
        $ticketLog->commentaire         = $request->get('commentaire');
        $ticketLog->save();
    }

    public function edit($id){
        return Tickets::find($id);
    }

    public function update(Request $request,$id){

        $motif_report = $request->get('motif_report');
        $motif_ko = $request->get('motif_ko');

        if($request->get('statut_finale') === 'ok'){
            $motif_report = null;
            $motif_ko = null;
        }else{
            $motif_report = $request->get('motif_report');;
            $motif_ko = $request->get('motif_ko');;
        }
        $ticket = Tickets::find($id);
        $ticket->agent_traitant = auth()->user()->id;
        $ticket->statut_finale       = $request->get('statut_finale');
        $ticket->motif_ko            = $motif_ko;
        $ticket->motif_report        = $motif_report;
        $ticket->as_j_1              = $request->get('as_j_1');
        $ticket->statut_ticket       = $request->get('statut_ticket');
        $ticket->commentaire_report  = $request->get('commentaire_report');
        $ticket->commentaire         = $request->get('commentaire');
        $ticket->update();

        $ticketLog = new TicketsLog();
        $ticketLog->agent_traitant      = auth()->user()->id;
        $ticketLog->ticket_id           = $id;
        $ticketLog->commentaire_report  = $request->get('commentaire_report');
        $ticketLog->statut_finale       = $request->get('statut_finale');
        $ticketLog->motif_report        = $motif_report;
        $ticketLog->motif_ko            = $motif_ko;
        $ticketLog->as_j_1              = $request->get('as_j_1');
        $ticketLog->statut_ticket       = $request->get('statut_ticket');
        $ticketLog->commentaire         = $request->get('commentaire');
        $ticketLog->save();

        return $ticket;
    }

}
