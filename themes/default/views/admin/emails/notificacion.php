<style>
	.help {
		height: 0px;
		overflow: hidden;
		-webkit-transition: all 0.2s; 
		transition: all 0.2s;
	}
	.help li {
		margin-bottom: 5px;
	}
	.cursor {
		cursor: pointer;
	}
</style>
<section class="panelBG m_b_20 lista_all_deudor padding">
	
	<!-- BOTON GUARDAR -->
	<div class="padding padd_v card_dash text_right">
		<small>
			Para crear el formulario debe tener en cuenta los campos disponibles, nombre y formato en el sistema. 
			<a class="cursor" onclick="showCampos()">Ver campos disponibles:</a>
			<ul class="help">
				<div class="clear"></div>
				<br>
				<li>Nit: &nbsp; <b>%nit% </b></li>
				<li>Nombre: &nbsp; <b>%nombre% </b></li>
				<li>Correo: &nbsp; <b>%correo% </b></li>
				<li>Contraseña: &nbsp; <b>%contrasena% </b></li>
				<li>Honorarios por campaña: &nbsp; <b>%honorariosXcampana% </b></li>
				<li>Intereses por campaña: &nbsp; <b>%interesesXcampana% </b></li>
				<li>Porcentaje de comisión por campaña: &nbsp; <b>%comisiónXcampana% </b></li>
				<li>Valor por carga de usuario servicio 1: &nbsp; <b>%valorXservicio1% </b></li>
				<li>Valor por carga de usuario servicio 2: &nbsp; <b>%valorXservicio2% </b></li>
				<li>Copie y pegue los valores incluidos los signos porcerntuales Ej. %nombre%</li>
			</ul>
		</small>
		<br>
		<button id="btnSaveInfo" class="btnb waves-effect waves-light" onclick="saveEmailPlaceholder('editor1')">
			GUARDAR
		</button>
		<div class="clear"></div>
	</div>
	
	<!-- EDITOR DE TEXTO -->
	<div class="padding padd_v card_dash">		
		<textarea name="editor1" id="editor1" rows="10" cols="80">
			<?php echo $emailsConfig[0]['regiaterClientNotification'] ?>
		</textarea>
	</div>

</section>


