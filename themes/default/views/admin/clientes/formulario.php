<style>
	.label { padding-top: 10px !important; }
</style>

<section class="panelBG m_b_20 lista_all_deudor">
	
	<section class="padding">
	
		<div class="panelBG wow m_b_20">
			
			<fieldset class="large-12 medium-12 small-12 columns padding">
				
				<div class="tab_base m_t_20">

					<?php $action = Yii::app()->baseUrl.'/admin/clientCreate'; ?>
					<!-- FORMULARIO COORDINADOR  -->			
					<form id="campaigns-form" name="campaigns-form" class="formweb" action="<?php echo $action ?>" method="POST">
						<fieldset class="large-12 medium-12 small-12 columns padding">
							<div class="large-3 medium-6 small-12 columns">
								<label class="label">NOMBRE</label>
							</div>				
							<div class="large-6 medium-6 small-12 columns">
								<input type="text" required="required" name="Campaigns[name]">
							</div>				
						</fieldset>

						<fieldset class="large-12 medium-12 small-12 columns padding">
							<div class="large-3 medium-6 small-12 columns">
								<label class="label">NIT</label>
							</div>				
							<div class="large-6 medium-6 small-12 columns">
								<input type="text" required="required" name="Campaigns[idNumber]">
							</div>				
						</fieldset>
						
						<fieldset class="large-12 medium-12 small-12 columns padding">
							<div class="large-3 medium-6 small-12 columns">
								<label class="label">CORREO</label>
							</div>				
							<div class="large-6 medium-6 small-12 columns">
								<input type="email" required="required" name="Campaigns[contactEmail]">
							</div>				
						</fieldset>
						
						<fieldset class="large-12 medium-12 small-12 columns padding">
							<div class="large-3 medium-6 small-12 columns">
								<label class="label">VALOR POR CARGA DE USUARIO SERVICIO 1</label>
							</div>				
							<div class="large-6 medium-6 small-12 columns">
								<input type="number" required="required" min="0" step="0.01" name="Campaigns[valueService1]">
							</div>				
						</fieldset>
						
						<fieldset class="large-12 medium-12 small-12 columns padding">
							<div class="large-3 medium-6 small-12 columns">
								<label class="label">VALOR POR CARGA DE USUARIO SERVICIO 2</label>
							</div>				
							<div class="large-6 medium-6 small-12 columns">
								<input type="number" required="required" min="0" step="0.01" name="Campaigns[valueService2]">
							</div>				
						</fieldset>
						
						<fieldset class="large-12 medium-12 small-12 columns padding">
							<div class="large-3 medium-6 small-12 columns">
								<label class="label">HONORARIOS POR CAMPAÑA</label>
							</div>				
							<div class="large-6 medium-6 small-12 columns">
								<input type="number" required="required" min="0" step="0.01" name="Campaigns[fees]">
							</div>				
						</fieldset>
						
						<fieldset class="large-12 medium-12 small-12 columns padding">
							<div class="large-3 medium-6 small-12 columns">
								<label class="label">INTERESES POR CAMPAÑA</label>
							</div>				
							<div class="large-6 medium-6 small-12 columns">
								<input type="number" required="required" min="0" step="0.01" name="Campaigns[interest]">
							</div>				
						</fieldset>

						<fieldset class="large-12 medium-12 small-12 columns padding">
							<div class="large-3 medium-6 small-12 columns">
								<label class="label">% DE COMISIÓN POR CAMPAÑA</label>
							</div>				
							<div class="large-6 medium-6 small-12 columns">
								<input type="number" required="required" min="0" step="0.01" name="Campaigns[percentageCommission]">
							</div>				
						</fieldset>
						
						<div class="txt_right block large-12 medium-12 small-12 columns padding">
							<div class="large-9 medium-9 small-12 columns">	
								<input type="hidden" value="58" name="Campaigns[idAdviser]">
								<input type="hidden" value="1" name="Campaigns[companyName]">
								<input type="hidden" value="1" name="Campaigns[idDistrict]">
								<input type="hidden" value="1" name="Campaigns[address]">
								<input type="hidden" value="1" name="Campaigns[contactName]">
								<input type="hidden" value="1" name="Campaigns[phone]">
								<input type="hidden" value="1" name="Campaigns[active]">
								<input type="hidden" value="1" name="Campaigns[comments]">
								<button id="btnSaveInfo" class="btnb waves-effect waves-light">GUARDAR</button>
							</div>
						</div>

					</form>

				</div>	

			</fieldset>

		</div>	

	</section>

</section>


<!-- Campaigns[name]
Campaigns[idNumber]
Campaigns[contactEmail]
Campaigns[percentageOfCommission]
Campaigns[interest]
Campaigns[fees]
Campaigns[valueService1]
Campaigns[valueService2]


Campaigns[idAdviser]
Campaigns[companyName]
Campaigns[idDistrict]
Campaigns[address]
Campaigns[contactName]
Campaigns[phone]
Campaigns[active]
Campaigns[comments] -->