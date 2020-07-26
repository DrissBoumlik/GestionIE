 <section class="mb-3 text-center text-lg-left dark-grey-text">
    @foreach($tickets as $ticket)
        <!--Grid row-->
        <div class="row mb-3">
            <div class="col-md-12 mb-4 mb-md-0">

                <h3 class="font-weight-bold">Numéro d'intervention : {{$ticket->numero_intervention}}</h3>
                <ul class="list-group mb-2">
                    <li class="list-group-item">Type Intervention : {{$ticket->type_intervention}}</li>
                    <li class="list-group-item">Sous-type intervention : {{$ticket->Sous_type_Inter}}</li>
                    <li class="list-group-item">Statut Ticket : {{$ticket->statut_ticket}}</li></li>
                </ul>
                @if($ticket->statut_ticket !== 'Clôturé')
                <a class="btn btn-warning btn-md mr-2" href="{{ route('b2bSfr.tickets.edit',['id' => $ticket->id ]) }}" role="button"><i class="fas fa-pen mr-2"></i>Modifier le ticket</a>
                @endif
                <a class="btn btn-warning btn-md mr-2" href="{{ route('b2bSfr.tickets.showTicketHistoryPage',['id' => $ticket->id ]) }}" role="button"><i class="fas fa-eye mr-2"></i>visualiser l'historique</a>
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->
        @endforeach
 </section>
 <nav aria-label="Page navigation">
     {!! $tickets->render() !!}
 </nav>
