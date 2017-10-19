(function() {

	'use strict';

	window.asignmentCoordinatorToCampaign = function(element, idCoordinator) {
		var idCampaign = $(element).val();
		
		if(idCampaign && idCoordinator) asignarCoordinador();
		else showError('Lo sentimos no fue posible procesar tu solicitud.');

		function asignarCoordinador() {
			var data = {idCampaign: idCampaign, idCoordinator: idCoordinator};
			var res = window.confirm('Continuar operación');
			if(res) {
				window.apiService.post('', data, function(response) {
					console.log(response);
				});
			}
		}

		function showError(msg) {
			window.alert(msg)
		}
	}

})();