(function (self) {
	document.addEventListener("DOMContentLoaded", function(event) {
	  	self.setIdCampaingModalClienteGraficos = function(id) {
		    console.log(id);

		    apiService.post('GetCampaingsGrafico', {id: id}, function(resp) {
		    	console.log(resp[0]);
		    	var d = resp[0];
			    $('#g-total-recuperado').html(d.name + ' <br> ' + parseFloat(d.cant_deuda).format(0, 0, '.'));

			    var ctx1 = document.getElementById("g-total-recuperado");
			    var myChart1 = new Chart(ctx1, {
			    	type: 'pie',
			    	data: {
			    		labels: ["Total campañas", "Total recuperado"],
			    		datasets: [{
			    			label: 'Recuperado',
			    			data: [d.cant_deuda, d.cant_recuperada]
			    		}]
			    	}
			    });

			    // var ctx = document.getElementById("g-campanas");
			    // var myChart = new Chart(ctx, {
			    // 	type: 'bar',
			    // 	data: {
			    // 		labels: ["Total campañas", "Total recuperado", "Número de deudores"],
			    // 		datasets: [{
			    // 			label: '# of Votes',
			    // 			data: [d.cant_campanas, d.cant_recuperada, d.cant_deudores]
			    // 		}]
			    // 	}
			    // });

		    })
		};
	});

})(window);