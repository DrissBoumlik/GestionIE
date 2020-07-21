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