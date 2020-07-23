<?php


namespace App\Repositories;


use App\Models\Tickets;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTicketRequest;
use Yajra\DataTables\DataTables;

class TicketsRepository
{
    public function all(Request $request)
    {
        $tickets = Tickets::select(
            ['id', 'agent_traitant','region','numero_intervention','cdp','num_cdp','type_intervention', 'client', 'cp','Ville',
                'Sous_type_Inter','date_reception','date_planification','report','motif_report','statut_finale',
                'nom_tech','prenom_tech','num_tel','adresse_mail','motif_ko','as_j_1','statut_ticket','commentaire'
            ])->get();

        return DataTables::of($tickets)->toJson();

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

    }

}
