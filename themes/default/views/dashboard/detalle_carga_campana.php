<!-- ESTA SESSION CONTIENE EL MODAL CON LA INFORMACION PÁRA AGREGAR LAS CAMPAÑAS AL SISTEMA -->

<div id="detalle_carga_campana" class="modal modal-s">
  <!-- placeholder del contenido -->
  <div id="hide" style="display: none;">
  	<div class="modal-header">
      <h1>Comfirmación de la campaña</h1>
    </div>
    <div class="row padding">
  	<!-- Informacion deudores campaña -->
    	<br>
    	<p> La campaña %nombre% tiene un total de %num_deudores% deudores por un monto total de <br> $ %total_campana% </p>
    	<br>
  	<!-- Listado de correos de notificacion -->
    	<p> Usted recibira una notificación %tipo de notificaciones% a los siguientes correos: </p>
    	<ul id="listEmails" style="margin-left: 10px; margin-bottom: 5px;"> 
        <li>%correo 1% <i class="fa fa-times" onclick="window.elimiarEmailNotificacion(this)"></i></li>
      </ul>
      <!-- Botton agrgar email de notificacion -->
    	<a style="cursor: pointer;" onclick="window.anadirEmailNotificacion()">
        Agregar dirección de correo electróníco
      </a>
    </div>
    <br><br>
    <div class="modal-footer">    
    	<!-- Información de cobro por el servicio -->
    	<p> El servicio que se prestara es %nombreServicio% por un costo de <br> $ %costoServicio% </p>
    	<br>
      <!-- Boton aceptar y pagar servicio -->
      <p class="txt_right">
    	 <button class="btnb" onclick="window.pagarCampana()">Aceptar y pagar</button>
      </p>
    </div>
  </div>
  <!-- Muestra el contenido -->
  <div id="show"></div>
</div>