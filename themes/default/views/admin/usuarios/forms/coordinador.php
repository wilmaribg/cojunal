<section class="panelBG m_b_20 lista_all_deudor">
	
	<section class="padding">
	
		<div class="panelBG wow m_b_20">
			
			<fieldset class="large-12 medium-12 small-12 columns padding">
				
				<div class="tab_base m_t_20">
					
					<a href="javascript:void(0)" class="large-4 medium-6 small-6 columns padding active">
						<input name="group1" type="radio" id="test1" checked="checked">
						<label for="test1">Crear asesor</label>
					</a>

					<a href="javascript:void(0)" class="large-4 medium-6 small-6 columns padding">
						<input name="group1" type="radio" id="test2">
						<label for="test2">Crear coordinador</label>
					</a>
					
					<div class="clear"></div>	
					<hr>

					<!-- FORMULARIO ASESOR  -->
					<div class="tab_cont padd_v">
						<?php $endPonint =  Yii::app()->baseUrl . '/admin/CreateAsesor'; ?>
						<form id="advisers-form" name="frmAsesores" class="formweb" action="<?php echo($endPonint); ?>" method="POST">

							<fieldset class="large-4 medium-4 small-12 columns padding">
								<label>Nombre asesor</label>
								<input name="Advisers[name]" id="AAdvisers_name" type="text" maxlength="155">
							</fieldset>

							<fieldset class="large-4 medium-4 small-12 columns padding">
								<label>Correo asesor</label>
								<input name="Advisers[idAuthAssignment]" id="AAdvisers_idAuthAssignment" maxlength="55" type="email">
								<input name="Advisers[weeklyGoal]" id="AAdvisers_weeklyGoal" value="0" type="hidden">
								<input name="Advisers[monthlyGoal]" id="AAdvisers_monthlyGoal" value="0" type="hidden">
								<input name="Advisers[status_idStatus]" id="AAdvisers_status_idStatus" value="2" type="hidden">
							</fieldset>

							<fieldset class="large-4 medium-4 small-12 columns padding">
								<label>Coordinador asignado</label>
								<select name="Advisers[parentAdviser]" placeholder="Seleccione..." id="AAdvisers_parentAdviser">
									<option value="">Seleccione</option>
									<?php foreach ($coordinadores_select as $coordinador): ?>
										<option value="<?php echo $coordinador['idAdviser'] ?>">
											<?php echo $coordinador['name'] ?>
										</option>
									<?php endforeach ?>
								</select>
							</fieldset>

							<fieldset class="large-12 medium-12 small-12 columns padding">
								<p>
									<label for="CJuridico">Seleccione perfil usuario</label>
								</p>
							</fieldset>

							<fieldset class="large-3 medium-4 small-12 columns padding">
								<p>
									<input checked="checked" type="radio" value="AJuridico" name="Advisers[perfil]" id="AAJuridico">
									<label for="AAJuridico">Abogado Externo</label>
								</p>
							</fieldset>

							<fieldset class="large-2 medium-3 small-12 columns padding">
								<p>
									<input type="radio" value="APJuridico" name="Advisers[perfil]" id="AAPJuridico">
									<label for="AAPJuridico">Pre jurídico</label>
								</p>
							</fieldset>
							
							<div class="clear"></div>

							<div class="txt_right block padding">
								<button id="AbtnSaveInfo" class="btnb waves-effect waves-light">GUARDAR</button>
							</div>

						</form>


					</div>

					<!-- FORMULARIO COORDINADOR  -->
					<div class="tab_cont padd_v">

						<form id="advisers-form" name="frmCoordinadores" class="formweb" action="<?php echo($endPonint); ?>" method="POST">
							
							<fieldset class="large-6 medium-6 small-12 columns padding">
								<label>Nombre coordinador</label>
								<input name="Advisers[name]" id="CAdvisers_name" type="text" maxlength="155">
							</fieldset>

							<fieldset class="large-6 medium-6 small-12 columns padding">
								<label>Correo coordinador</label>
								<input name="Advisers[idAuthAssignment]" id="CAdvisers_idAuthAssignment" maxlength="55" type="email">
								<input name="Advisers[weeklyGoal]" id="Advisers_weeklyGoal" value="0" type="hidden">
								<input name="Advisers[monthlyGoal]" id="Advisers_monthlyGoal" value="0" type="hidden">
								<input name="Advisers[status_idStatus]" id="Advisers_status_idStatus" value="6" type="hidden">
							</fieldset>
					
							<fieldset class="large-12 medium-12 small-12 columns padding">
								<p>
									<label for="CJuridico">Seleccione perfil usuario</label>
								</p>
							</fieldset>

							<fieldset class="large-2 medium-3 small-12 columns padding">
								<p>
									<input checked="checked" type="radio" value="CJuridico" name="Advisers[perfil]" id="CJuridico">
									<label for="CJuridico">Jurídico</label>
								</p>
							</fieldset>

							<fieldset class="large-2 medium-3 small-12 columns padding">
								<p>
									<input type="radio" value="CPJuridico" name="Advisers[perfil]" id="CPJuridico">
									<label for="CPJuridico">Pre jurídico</label>
								</p>
							</fieldset>

							<div class="txt_right block padding">
								<button id="CbtnSaveInfo" class="btnb waves-effect waves-light">GUARDAR</button>
							</div>

						</form>
					</div>
			
				</div>	

			</fieldset>

		</div>	

	</section>

</section>


<script>
	<?php require 'coordinador.js' ?>
</script>