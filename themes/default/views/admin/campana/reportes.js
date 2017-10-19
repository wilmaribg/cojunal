(function() {

  'use strict';

  $(document).ready(function() {
    getClientes();

    // Esta funcion me descarga el reporte
    $("#selectReporteCampanas").change(function(e) {
      var idCliente = $(e.target).val();
      if(idCliente) {
        apiService.get('GenerarRepoteCampanasDelCliente/'+idCliente, null, true);
      }else {
        toastr.info('Lo sentimos en este momento no fue posible procesar tu solcitud, por favor intentalo de nuevo.');
      }
    });

  });

  // Esta funcion me hace el llamado a la api
  function getClientes() {
    apiService.post('GetClientesCampaigns', {}, function(resp) {
      var options = ['<option value="">Seleccione...</option>'];
      if(typeof resp == 'object' && resp.length > 0) {
        resp.forEach(function(data, index) {
          options.push(configuraOption(data));
          if(appendReady(index, resp)) {
            $('#selectReporteCampanas').empty();
            $('#selectReporteCampanas').append(options.join(''));
          }
        });
      }
    });
  }

  // Esta funcion me configura los options
  function configuraOption(data) {
    return '<option value="'+ data.idCampaign +'">'+ data.name +'</option>';
  }   

  // Devuelve si el index es igual al length
  function appendReady(index, datos) {
    return (index == (datos.length - 1));
  }

})();