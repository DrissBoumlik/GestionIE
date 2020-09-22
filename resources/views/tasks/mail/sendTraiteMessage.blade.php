@component('mail::message')
    Bonjour,<br>
    @if($task->numero_de_labonne_reference_client)
        veuillez trouver ci-dessous les données du ticket {{$task->numero_de_labonne_reference_client}},<br>
        <ul>
            <li>Ville : {{$task->station_de_modulation_Ville}}</li>
            <li>Région : {{$task->zone_region}}</li>
            <li>sit : {{$task->stit}}</li>
            <li>commune : {{$task->commune}}</li>
            <li>code_postal : {{$task->code_postal}}</li>
            <li>numéro de l'appel: {{$task->numero_de_lappel_reference_sfr}}</li>
            <li>Type : {{$task->libcap_typologie_inter}}</li>
            <li>date de rendez-vous: {{$task->date_de_rendez_vous}}</li>
            <li>agent traitant: {{$task->agent_traitant}}</li>
            <li>statut du report : {{$task->statut_du_report}}</li>
            <li>statut final: {{$task->statut_final}}</li>
        </ul>
    @else
        veuillez trouver ci-dessous les données du ticket {{$task->as}},<br>
        <ul>
            <li>ville : {{$task->ville}}</li>
            <li>region : {{$task->region}}></li>
            <li>prestataire : {{$task->prestataire}}</li>
            <li>code_postal : {{$task->code_postal}}</li>
            <li>numéro de l'appel: {{$task->numero_abo}}</li>
            <li>Type :{{$task->type}}</li>
            <li>agent traitant: {{$task->agent_traitant}}</li>
            <li>cause_du_report: {{$task->cause_du_report}}</li>
            <li>statut du report : {{$task->statut_du_report}}</li>
            <li>statut final: {{$task->statut_final}}</li>
        </ul>
    @endif
    Cordialement,<br>
    {{ auth()->user()->firstname }}
@endcomponent
