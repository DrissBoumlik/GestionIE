<?php


namespace App\Repositories;


use App\Models\Tickets;
use App\Models\TicketsLog;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTicketRequest;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TicketsRepository
{
    public function show(Request $request,$status){
            $tickets = DB::table('tickets')
                ->select('tickets.id','lastname','region','numero_intervention','cdp','num_cdp','type_intervention', 'client', 'cp','Ville',
                    'Sous_type_Inter','date_reception','date_planification','report','motif_report','statut_finale',
                    'nom_tech','prenom_tech','num_tel','adresse_mail','motif_ko','as_j_1','statut_ticket','commentaire')
                ->join('users','tickets.agent_traitant','=','users.id')
                ->where('statut_ticket', '=', $status)
                ->get();

            return DataTables::of($tickets)->toJson();

    }

    public function history($id)
    {
        $ticketLogs = DB::table('tickets_logs')
            ->select('lastname','motif_report','statut_finale', 'motif_ko','commentaire_report','as_j_1','statut_ticket','commentaire','tickets_logs.created_at')
            ->join('users','tickets_logs.agent_traitant','=','users.id')
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

        $ticket = Tickets::find($id);
        $ticket->agent_traitant = auth()->user()->id;
        $ticket->statut_finale       = $request->get('statut_finale');
        $ticket->motif_ko            = $request->get('motif_ko');
        $ticket->motif_report        = $request->get('motif_report');
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
        $ticketLog->motif_report        = $request->get('motif_report');
        $ticketLog->motif_ko            = $request->get('motif_ko');
        $ticketLog->as_j_1              = $request->get('as_j_1');
        $ticketLog->statut_ticket       = $request->get('statut_ticket');
        $ticketLog->commentaire         = $request->get('commentaire');
        $ticketLog->save();

        return $ticket;
    }

}
