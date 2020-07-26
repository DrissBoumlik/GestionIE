<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Repositories\TicketsRepository;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    private $ticketsRepository;

    public function __construct(TicketsRepository $ticketsRepository)
    {
        $this->ticketsRepository = $ticketsRepository;
    }

    public function index(Request $request,$status){

        $tickets = $this->ticketsRepository->index($request,$status);
        if($request->ajax()) {

            return view('b2bsfr.ajax.index', compact('tickets'));
        }
        return view('b2bsfr.index',compact('tickets','status'));
    }

    public function create(){
        return view('b2bsfr.new');
    }

    public function store(CreateTicketRequest $request)
    {
        $this->ticketsRepository->store($request);
        return redirect()->back()->with('message', 'le ticket a été ajouté avec succès');
    }

    public function edit($id){
        $ticket = $this->ticketsRepository->edit($id);
        return view('b2bsfr.edit',compact('ticket'));
    }

    public function updateTicket(Request $request,$id){
        $this->ticketsRepository->update($request,$id);
        return redirect()->back()->with('message', 'le ticket a été modifié avec succès');
    }

    public function showTicketHistoryPage($id){
        return view('b2bsfr.history',compact('id'));
    }

    public function getTicketHistory($id){
        return $this->ticketsRepository->history($id);
    }

}
