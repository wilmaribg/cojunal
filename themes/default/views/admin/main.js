(function () {

	'use strict';

	// Esta funcion realiza 
	window.apiService = {
		post: function(endPoint, data, callback) {
			$.ajax({type: "POST", url: endPoint, data: data, success: callback, dataType: 'json'});
		},
		get: function(endPoint, callback, newWindow) {
			if(!newWindow) $.ajax({type: "GET", url: endPoint, success: callback});
			else window.open(endPoint, '_blank');
		} 
	}

	/**
	 * [enableOrDisableadviser description]
	 * @param  {[type]} input     [description]
	 * @param  {[type]} idAdviser [description]
	 * @return {[type]}           [description]
	 */
	window.enableOrDisableadviser = function(input, idAdviser) {
		var r = confirm("Continuar operación?");
    	if(r) {
			var msgError = 'Lo sentimos no fue posible procesar tu solicitud';
			if(!input || !idAdviser) {
				window.alert(msgError);
			}else {
				var active = $(input).val();
				var data = {idAdviser: idAdviser, active: active};
				window.apiService.post('enableDisableAdvisers', data, function(response) {
					if(response.mensaje == 1){
						window.toastr.success('Datos actualizados!');
					}else {
						window.toastr.info('Lo sentimos no fue posible procesar tu solicitud.');
					}
				});
			}
    	}
	}

})();