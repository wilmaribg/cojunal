(function() {

  'use strict';

  // Nuevo
  $(document).ready(function() {


    // Datos a enviar al server ej. ordenar o filtrar o paginar
    var query = {buscar: '', initPagina:  0 };
    var coordinadores = [];

    // Estos valores son la cabecera de la tabla
    var tableCoordinadorTableHead = [
      ['Campañas', ''],
      ['Cliente', ''],
      ['Saldo total', ''],
      ['Número deudores', ''],
      ['Asesor', ''],
      ['Tipo de servicio', ''],
    ];

    // setea lo titulos y filtros de oreder de la cabecera de la tabla
    function setTableHead() {
      var content = '<tr>';
      tableCoordinadorTableHead.forEach(function(item, index) {
        content += '<th>';
        content += item[0] + '&nbsp'; 
        content += '<i id="A'+index+'" onclick="window.orderByCoordinadores('+'\''+item[1]+'\''+', \'ASC\', '+index+')" class="cursor fa fa-chevron-circle-up fa-lg"></i>';
        content += '<i id="B'+index+'" onclick="window.orderByCoordinadores('+'\''+item[1]+'\''+', \'DESC\', '+index+')" class="cursor fa fa-chevron-circle-down fa-lg"></i>';
        content += '</th>';
        if(index == tableCoordinadorTableHead.length -1) {
          content += '</tr>';
          $('#campanasTableHead').empty();
          $('#campanasTableHead').append(content);
        }
      });
    }
    setTableHead();

    // Ordenamos los datos de la tabla
    window.orderByCoordinadores = function (campo, orderType, index) {
      tableCoordinadorTableHead.forEach(function(item, i) {
        document.getElementById('A'+i).style.display = 'none';
        document.getElementById('B'+i).style.display = 'inline-block';
      });

      if(orderType == 'ASC') {  
        document.getElementById('A'+index).style.display = 'none';
        document.getElementById('B'+index).style.display = 'inline-block';
      }else {
        document.getElementById('A'+index).style.display = 'inline-block';
        document.getElementById('B'+index).style.display = 'none';
      } 

      query.field = campo;
      query.orderBy = orderType;
      query.q = '';
      query.initFrom = 0;
      getCampaings();
    }

    // Obtenemos los coordinadores
    function getCampaings() {
      apiService.post('dashboard/GetCampanasPorCliente_cpj', {}, function(resp) {
        console.log(resp);
        var tbody = [];
        resp.forEach(function(datos, index) {
          tbody += configurarTd(datos);
          if(appendReady(index, resp)) {
            $("#campanasTableBody").empty();
            $("#campanasTableBody").append(tbody);
          }
        });
      });
    }
    getCampaings();

    // Devuelve si el index es igual al length
    function appendReady(index, datos) {
      return (index == (datos.length - 1));
    }


    // Esta funcion devuelve los datos para una fila para el listado de campañas
    function configurarTd(datos) {
      var td = [
        '<td>' + datos.campaignName + '</td>',
        '<td>' + datos.name + '</td>',
        '<td>' + (datos.saldoTotal || 0) + '</td>',
        '<td>' + (datos.numDeudores || 0) + '</td>',
        '<td>' + 'falta' + '</td>',
        '<td>' + datos.serviceType + '</td>'
      ].join('');
      return '<tr onclick="window.showFilterDeudor1209(this, '+datos.idCampaign+')">' + td + '</tr>';
    }

    // Esta funcion configura el select para los asesores
    function configurarSelectCoordinador(idCampaing, idCoordinador) {
      var select = [
        '<select name="coordinador" style="display:block" onchange="asignmentCoordinatorToCampaign(this,'+idCampaing+')">',
        '<option value="-1">Seleccione</option>'
      ];

      asesores.forEach(function(asesor) {
        var option = '';
        if(idasesor == asesor.idAdviser) {
          option = '<option selected="selected" value="'+asesor.idAdviser+'">'+asesor.name+'</option>';
        }else {
          option = '<option value="'+asesor.idAdviser+'">'+asesor.name+'</option>';
        } 
          select.push(option);
      });

      select.push('</select>');
      return select.join('');
       
    }

    // Esta funcion me muestra el filtro de dudores para ese cliente 
    window.showFilterDeudor1209 = function(element, idCliente) {
      var active = $(element).attr('data-active');
      var filters = [
        '<tr>',
          '<td colspan="6">',
            configureTableCampanas(0),
          '</td>',
        '</tr>'
      ];
      
      if(active == 'true') {
        $(element).attr('data-active', 'false');
        $(element).next().remove();
      }else {
        $(element).attr('data-active', 'true');
        $(element).after(filters.join(''));
      }

      console.log(element);
      console.log(idCliente);
    }
  });

  function cofigureFilters(idCampana)
  {

  }

  function configureTableCampanas(id) {
    var table = [
      '<table>',
        '<thead>',
          '<tr>',
            '<th>Campaña</th>',
            '<th>Saldo total asignado</th>',
            '<th>Saldo total recuperado</th>',
            '<th>% Recuperación</th>',
            '<th>Acciones</th>',
          '</tr>',
        '</thead>',
        '<tbody>',
          '<tr>',
            '<td>Campaña</td>',
            '<td>Saldo total asignado</td>',
            '<td>Saldo total recuperado</td>',
            '<td>% Recuperación</td>',
            '<td>Filtrar</td>',
          '</tr>',
        '</tbody>',
      '</table>',
    ];

    return table.join('');
  }

})();