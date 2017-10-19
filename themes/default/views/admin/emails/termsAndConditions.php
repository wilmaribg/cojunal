<section class="panelBG m_b_20 lista_all_deudor padding">
	
	<!-- BOTON GUARDAR -->
	<div class="padding padd_v card_dash text_right">
		<button id="btnSaveInfo" class="btnb waves-effect waves-light" onclick="saveEmailPlaceholder('editor2')">
			GUARDAR
		</button>
		<div class="clear"></div>
	</div>
	
	<!-- EDITOR DE TEXTO -->
	<div class="padding padd_v card_dash">		
		<textarea name="editor2" id="editor2" rows="10" cols="80">
			<?php echo $emailsConfig[0]['termsConditions'] ?>
		</textarea>
	</div>

</section>
