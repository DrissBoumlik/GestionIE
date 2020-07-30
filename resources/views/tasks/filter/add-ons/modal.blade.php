<div class="modal" id="modal-choose-collaborater" tabindex="-1" role="dialog"
     aria-labelledby="modal-choose-collaborater" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
          <h3 class="block-title">Validation de l'affectation de tâche au collaborateur</h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
              <i class="fa fa-fw fa-times"></i>
            </button>
          </div>
        </div>
        <div class="block-content font-size-sm">
          <form id="form-choose-collaborater">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
              <!-- label for="collaborater">Choisir un collaborateur</label -->
              <select class="form-control w-100" id="collaborater" name="collaborater"
                      style="width: 100%">
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->firstname . ' ' . $agent->lastname }}</option>
                @endforeach
              </select>
            </div>
          </form>
        </div>
        <div class="block-content block-content-full text-right border-top">
          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-sm btn-primary" id="btn-choose"><i
              class="fa fa-check mr-1"></i>Valider
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal-unaffect" tabindex="-1" role="dialog" aria-labelledby="modal-unaffect" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="form-unaffect">
        <div class="block block-themed block-transparent mb-0">
          <div class="block-header bg-primary-dark">
            <h3 class="block-title">Désaffectation de la tâche</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content font-size-sm">
            <p>Voullez-vous vraiment désaffecter cette tâche ?</p>
          </div>
          <div class="block-content block-content-full text-right border-top">
            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-sm btn-primary" id="btn-unaffect"><i
                class="fa fa-check mr-1"></i>Désaffecter
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="modal-update" tabindex="-1" role="dialog" aria-labelledby="modal-update" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
          <h3 class="block-title">Modification de la tâche</h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
              <i class="fa fa-fw fa-times"></i>
            </button>
          </div>
        </div>
        <div class="block-content font-size-sm">
          <div class="block">
            <div class="block-content tab-content overflow-hidden">
              <div class="tab-pane fade show active" id="tab-update-statut" role="tabpanel">
                <form id="form-update-statut">
                  <input type="hidden" name="_method" value="PUT">
                  @foreach ($params as $key => $param)
                    <div class="form-group">
                      <label for="statut">{{ $param['title'] }}</label>
                      <select type="text" class="form-control" id="{{ $key }}" name="{{ $key }}"
                              style="width: 100%">
                          @if($key !== 'agent_traitant')
                          <option selected disabled>choissir un {{str_replace('_',' ',$key)}}</option>
                          @endif
                        @foreach ($param['values'] as $paramValue)
                                  @if($key !== 'statut_final')
                                        <option value="{{ $paramValue }}">{{ $paramValue }}</option>
                                  @else

                                          <option value="{{ $paramValue }}" selected="{{$paramValue === 'EN COURS'}}">{{ $paramValue }}</option>
                                  @endif
                        @endforeach
                      </select>
                    </div>
                  @endforeach
                  <div class="text-right">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                      Fermer
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" id="btn-update-statut">
                      <i class="fa fa-check mr-1"></i>Modifier
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Pop In Block Modal -->
<div class="modal fade modal-history" id="modal-history" tabindex="-1" role="dialog" aria-labelledby="modal-history" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
          <h3 class="block-title">Visualiser l'historique</h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
              <i class="fa fa-fw fa-times"></i>
            </button>
          </div>
        </div>
        <div class="block-content font-size-sm">
          <table id="historyPreview"
                 class="not-stats-table table table-bordered table-striped table-valign-middle capitalize w-100">
          </table>
        </div>
        <div class="block-content block-content-full text-right border-top">
          <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="fa fa-check mr-1"></i>Ok</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END Pop In Block Modal -->
