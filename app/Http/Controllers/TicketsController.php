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

    public function create(){
        return view('b2bsfr.new');
    }

    public function store(CreateTicketRequest $request)
    {
        $this->ticketsRepository->store($request);
        return redirect()->back()->with('message', 'le ticket a été ajouté avec succès');
    }

    public function ongoing(){
        return view('b2bsfr.ongoing');
    }

    public function valid(){
        return view('b2bsfr.valid');
    }

    public function closed(){
        return view('b2bsfr.closed');
    }

    public function getTickets(Request $request,$status){
        return $this->ticketsRepository->all($request,$status);
    }

}
