(function() {

    'use strict';

    var query = {};
    var coordinadoresParaJurudicos;

    // Esta funcion devuelve el select con el coordinador
    function configurarSelectCoordinador(idDeudor, idCoordinador, idCampaign) {
      var select = [
        '<select name="coordinador" style="display:block" onchange="asignmentCoordinatorParaJuridico(this,'+idDeudor+','+idCampaign+')">',
        '<option value="-1">Seleccione</option>'
      ];

      coordinadoresParaJurudicos.forEach(function(coordinador) {
        var option = '';
        if(idCoordinador == coordinador.idAdviser) {
          option = '<option selected="selected" value="'+coordinador.idAdviser+'">'+coordinador.name+'</option>';
        }else {
          option = '<option value="'+coordinador.idAdviser+'">'+coordinador.name+'</option>';
        } 
          select.push(option);
      });
      select.push('</select>');
      return select.join('');
    } 

    // Devuelve si el index es igual al length
    function appendReadyParaJuridico(index, datos) {
      return (index == (datos.length - 1));
    }

    // Estos valores son la cabecera de la tabla
    var tableparajuridicosTableHead = [
        ['Campaña', 'campanaName'],
        ['Nombre del cliente', 'legalName'],
        ['Correo', 'email'],
        ['Saldo total asignado', 'capitalValue'],
        ['Coordinador Asignado', '']
    ];

    function setTableHead() {
        var content = '<tr>';
        tableparajuridicosTableHead.forEach(function(item, index) {
            content += '<th class="txt_center">';
            content += item[0] + '&nbsp';
            content += '<i id="AJ' + index + '" onclick="window.orderByparajuridicos(' + '\'' + item[1] + '\'' + ', \'ASC\', ' + index + ')" class="cursor fa fa-chevron-circle-up fa-lg"></i>';
            content += '<i id="BJ' + index + '" onclick="window.orderByparajuridicos(' + '\'' + item[1] + '\'' + ', \'DESC\', ' + index + ')" class="cursor fa fa-chevron-circle-down fa-lg"></i>';
            content += '</th>';
            if (index == tableparajuridicosTableHead.length - 1) {
                content += '</tr>';
                $('#parajuridicosTableHead').empty();
                $('#parajuridicosTableHead').append(content);
            }
        });
    }
    setTableHead();

    // Ordenamos los datos de la tabla
    window.orderByparajuridicos = function(campo, orderType, index) {
        tableparajuridicosTableHead.forEach(function(item, i) {
            document.getElementById('AJ' + i).style.display = 'none';
            document.getElementById('BJ' + i).style.display = 'inline-block';
        });

        if (orderType == 'ASC') {
            document.getElementById('AJ' + index).style.display = 'none';
            document.getElementById('BJ' + index).style.display = 'inline-block';
        } else {
            document.getElementById('AJ' + index).style.display = 'inline-block';
            document.getElementById('BJ' + index).style.display = 'none';
        }

        query.field = campo;
        query.orderBy = orderType;
        query.q = '';
        query.initFrom = 0;
        getCoordonadoresParaJuridico();
    }

    // Esta funcion asigna el coordinador a la campaña
    window.asignmentCoordinatorToParajuridico = function(element, idCoordinator) {
        console.log(element)
        function showError(msg) {
            window.alert(msg)
        }
    }

    // Esta funcion me devuelve los clientes que van para juridico
    function getCoordonadoresParaJuridico() {
      apiService.post('GetCoordinadoresJuridicos', {}, function(resp) {
        coordinadoresParaJurudicos = resp;
        // Obtenemos las campañas y las mostramos
        var endPoint = window.baseUrl+"/admin/GetDeuduresJuridicos";
        apiService.post(endPoint, query, function(resp) {
          var tbody = '';
          resp.forEach(function(datos, index) {
            tbody += configurarTdJuridico(datos);
            if(appendReadyParaJuridico(index, resp)) {
              $("#parajuridicosTableBody").empty();
              $("#parajuridicosTableBody").append(tbody);
            }
          });
        });
      });
    }

    // Esta funcion devuelve los datos para una fila para el listado de campañas
    function configurarTdJuridico(datos) {
      var td = [
        '<td>' + datos.campanaName + '</td>',
        '<td>' + datos.legalName + '</td>',
        '<td>' + datos.email + '</td>',
        '<td>' + parseFloat(datos.capitalValue).format(0, 0, '.')  + '</td>',
        '<td class="formweb">'  
          + configurarSelectCoordinador(datos.id, datos.idCoordinador, datos.idCampaign) 
        + '</td>'
      ].join('');
      return '<tr>' + td + '</tr>';
    }

    window.asignmentCoordinatorParaJuridico = function(element, idDeudor, idCampaign) {
        var idCoordinador = $(element).val();
        console.log(idCoordinador, idDeudor);

        if (idCoordinador && idDeudor && idCampaign) asignarCoordinador();
        else showError('Lo sentimos no fue posible procesar tu solicitud.');

        function asignarCoordinador() {
            var data = { idCoordinador: idCoordinador, idDeudor: idDeudor, idCampaign: idCampaign };
            var res = window.confirm('Continuar operación');
            if (res) {
                window.apiService.post('SetClienteParaJuridico', data, function(response) {
                    if (response == 1) {
                      $(element).parent('td').parent('tr').remove();
                      window.toastr.success('Coordinador asignado!.');
                    }else {
                      window.toastr.error('Lo sentimos no fue posible procesar tu solicitud.');
                    } 
                });
            }
        }

        function showError(msg) {
            window.alert(msg)
        }
    }

    // Cargamos los datos
    $(document).ready(function() {
      getCoordonadoresParaJuridico();
    });

})();