<style>
	.label { padding-top: 10px !important; }
	.txt-center { text-align: center; }
</style>

<div id="app-remisiones">
	
	<section class="panelBG m_b_20 lista_all_deudor">
		
		<!-- SELECCIOPN CLIENTE PARA REMISION -->
		<div class="padding">
				
				<br><br>

				<div class="large-4 medium-4 small-12 columns padding">
					<div class="label">Seleccione el cliente que desee remisionar</div>
				</div>

				<!-- onchange="window.showCampaignList(this)" -->
				<div class="large-6 medium-6 small-12 columns padding">
					<fieldset class="formweb">
						<select v-on:change="Clientesvalue" >
							<option value="">Selecccione...</option>
							<?php foreach ($clientesNames as $name): ?>
								<option value="<?php echo$name['idCampaign'] ?>"><?php echo$name['name'] ?></option>
							<?php endforeach ?>
						</select>
					</fieldset>
				</div>

		</div>

		<div class="padding">
		<br><br>

				<div class="large-4 medium-4 small-12 columns padding">
					<div class="label">Digite el numero de orden de servicio</div>
				</div>

			<div class="row" >
				<div class="large-6 medium-6 small-12 columns padding">
					<fieldset class="formweb" >
					<input type="text" v-on:keyup="busqueda" v-model="buscar" class="form-control" placeholder=" Buscar orden de serivicio" >
					</fieldset>
				</div>
			</div>
		</div>
		
		<br><br><br>

		<!-- TEXTO EXPLICATIVO -->
		<div class="padding">
				
				<div class="large-12 medium-12 small-12 columns padding">
					Acontinuación se muestran las ordenes de servicio.
				</div>

		</div>
		
		<br><br><br>

		<!-- TABLA PARA LA SELECCION -->
		<table class="bordered highlight responsive-table">
			<thead>
				<tr>
					<th class="txt_center"># Orden</th>
					<th class="txt_center">Nombre de la campaña</th>
					<th class="txt_center">Fecha</th>
					<th class="txt_center">Hora</th>					
					<th class="txt_center">Descarga</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="cliente in clientes">
					<td>{{ cliente.id }}</td>
					<td>{{ cliente.name }}</td>
					<td class="txt-center">{{ cliente.fecha }}</td>
					<td class="txt-center">{{ cliente.hora }}</td>					
					<td class="txt-center">
						<a :href="'http://cojunal.com/plataforma/beta/admin/DescargarPdfRemision/'+cliente.id" target="_blank">Descarga</a>
					</td>
				</tr>
			</tbody>
		</table>

	</section>
	

</div>

<script>
	<?php include realpath('./').'/themes/default/views/admin/clientes/remisiones.js' ?>
</script>