<section id="new_create_stado" class="modal modal-s">
  
  <div class="modal-header">
    <h1>Seleccione estados</h1>
  </div>
  
  <div class="modal-content">
    
    <section>
      <section class="row">
        <div class="large-12 medium-12 small-12 columns padding padd_v">
          <span style="background-color: #eee; display: block; padding: 10px;">
            Seleccione los estados que aplicaran para la gestión de los asesores sobre esta campana
          </span>
        </div>
      </section>
    </section>

    <section>
      <table class="stack" id="tableStates">
      </table>
    </section>

  </div>
   
  <section class="modal-footer formweb">
    <fieldset class="large-12 medium-12 small-12 columns padding">
      <label for="stateName" class="required"> Nuevo estado </label>
      <input class="form-control input-block-level" id="stateName">          
      <input id="stateCampaing" type="hidden">          
    </fieldset>
    <fieldset class="large-12 medium-12 small-12 columns padding text_center">
      <button onclick="saveNewState()" class="btnb waves-effect waves-light right">
        GUARDAR
      </button>
    </fieldset>
    
  </section>

</section>