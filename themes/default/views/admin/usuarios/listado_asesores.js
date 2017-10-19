(function () {

  'use strict';

    // Parametos para la consulta de coordinadorea
  var paramsC = { initFrom: 0, q: '', orderBy: 'ASC', field: 'name' };
  var coordinadoresList;

  // Estos valores son la cabecera de la tabla
  var tableCoordinadorTableHead = [
    ['Nombre de usuario', 'name'],
    ['Coordinador asiganado', ''],
    ['Total de campañas asignadas', 'num_camapanas'],
    ['Saldo total asignado', ''],
    ['Saldo total recuperado', ''],
    ['Habilitar', 'active']
  ];

  //Obtenemos los datos del backed y anexarlos a la tabla
  function getAllAsesores(coordinadores) {
    coordinadoresList = coordinadores;
    window.apiService.post('getAsesores', paramsC, function(resp) {
      if(typeof resp == 'object') {
        var html = [];
        var content = '';
        resp.forEach(function(item, index) {
          // item.parentAdviser
          var selected = 'selected="selected"';
          content = '<tr>';
            content += '<td>'+item.name+'</td>';
            content += '<td class="txt_center formweb">';
              content += '<select  onchange="setCoordinador(this, '+item.idAdviser+')">';
                content += '<option value="">Seleccione...</option>';
                coordinadores.forEach(function(coordinador) {
                  content += '<option value="'+coordinador.idAdviser+'">';
                  if(item.parentAdviser == coordinador.idAdviser) {
                    content += '<option selected="selected" value="'+coordinador.idAdviser+'">';
                  }
                  content += coordinador.name;
                  content += '</option>';
                });
              content += ' </select>';
            content += '</td>';
            content += '<td class="txt_center">'+(item.num_camapanas ? item.num_camapanas : 0)+'</td>';
            content += '<td>Falta</td>';
            content += '<td>Falta</td>';
            content += '<td  class="formweb">';
              content += '<select onchange="enableOrDisableadviser(this, '+item.idAdviser+')">'; 
                if(item.active == 1){
                  content += '<option selected="selected" value="1">Activo</option>'; 
                  content += '<option value="0">Inactivo</option>'; 
                }else {
                  content += '<option value="1">Activo</option>'; 
                  content += '<option selected="selected" value="0">Inactivo</option>';
                }
              content += '</select>'; 
            content += '</td>';
          content += '</tr>';
          html.push(content); 
          if(index == resp.length -1) {
            $('#asesoresTable').empty();
            $('#asesoresTable').append(html.join(''));
          }
        });
      }
    });
  }

  // Ordenamos los datos de la tabla
  window.orderByAsesores = function (campo, orderType, index) {
    tableCoordinadorTableHead.forEach(function(item, i) {
      document.getElementById('AA'+i).style.display = 'none';
      document.getElementById('AB'+i).style.display = 'inline-block';
    });

    document.getElementById('AA'+index).style.display = (orderType == 'ASC') ? 'none' : 'inline-block';
    document.getElementById('AB'+index).style.display = (orderType != 'ASC') ? 'none' : 'inline-block';

    paramsC.field = campo;
    paramsC.orderBy = orderType;
    paramsC.q = '';
    paramsC.initFrom = 0;
    getAllAsesores(coordinadoresList);
  }

  

  // setea lo titulos y filtros de oreder de la cabecera de la tabla
  function setTableHead() {
    var content = '<tr>';
    tableCoordinadorTableHead.forEach(function(item, index) {
      content += '<th class="txt_center">';
        content += item[0] + '&nbsp'; 
        content += '<i id="AA'+index+'" onclick="window.orderByAsesores('+'\''+item[1]+'\''+', \'ASC\', '+index+')" class="cursor fa fa-chevron-circle-up fa-lg"></i>';
        content += '<i id="AB'+index+'" onclick="window.orderByAsesores('+'\''+item[1]+'\''+', \'DESC\', '+index+')" class="cursor fa fa-chevron-circle-down fa-lg"></i>';
      content += '</th>';
      if(index == tableCoordinadorTableHead.length -1) {
        content += '</tr>';
        $('#asesoresTableHead').empty();
        $('#asesoresTableHead').append(content);
      }
    });
  }
  setTableHead();

  // setCoordinador
  window.setCoordinador = function(idAdviser, parentAdviser) {
    var r = confirm("Continuar operación?");
    if(r) {
      var msgError = 'Lo sentimos no fue posible procesar tu solicitud';
      var id = $(idAdviser).val();
      if(!id || !idAdviser) {
        window.alert(msgError);
      }else {
        var data = {parentAdviser: id, idAdviser:parentAdviser};
        window.apiService.post('setParentAdviser', data, function(response) {
          if(response.mensaje == 1){
            window.toastr.success('Datos actualizados!');
          }else {
            window.toastr.info('Lo sentimos no fue posible procesar tu solicitud.');
          }
        });
      }
    }
  }

  // Inicializacion del script
  $(document).ready(function() {
    // Obtener lo coordinadores para llenar los selects
    window.apiService.post('getCoordinadores', {}, function(resp) {
      getAllAsesores(resp);
    });
  });

})();