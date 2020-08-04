<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return isB2bSfrGroup();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'agent_traitant' 		=> 'required',
            'region' 				=> 'required|max:20',
            'numero_intervention' 	=> 'required|max:20',
            'cdp' 					=> 'required|max:50',
            'num_cdp' 				=> 'required|max:20',
            'type_intervention' 	=> 'required|max:20',
            'client' 				=> 'required|max:50',
            'cp' 					=> 'required|max:5',
            'ville' 				=> 'required|max:50',
            'Sous_type_Inter' 		=> 'required|max:30',
            'date_reception' 		=> 'required',
            'date_planification' 	=> 'required',
            'motif_report' 			=> 'max:20',
            'statut_finale' 		=> 'required|max:20',
            'nom_tech' 				=> 'required|max:20',
            'prenom_tech' 			=> 'required|max:20',
            'num_tel' 				=> 'required|max:15',
            'adresse_mail' 			=> 'required|email|max:30',
            'as_j_1' 				=> 'required|max:5',
            'statut_ticket' 		=> 'required|max:20',
            'commentaire'			=> 'required',
        ];
    }
}
