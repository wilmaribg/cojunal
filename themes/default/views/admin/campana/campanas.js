(function() {

  'use strict';

  // Nuevo
  $(document).ready(function() {


    // Datos a enviar al server ej. ordenar o filtrar o paginar
    var query = {buscar: '', initPagina:  0 };
    var coordinadores = [];

    // Estos valores son la cabecera de la tabla
    var tableCoordinadorTableHead = [
      ['Campaña', 'campaignName'],
      ['Cliente', 'nameCliente'],
      ['Fecha', 'createAt'],
      ['Tipo servicio', 'serviceType'],
      ['Saldo capital asignado', 'saldoAsignado'],
      // ['Saldo total recuperado', ''],
      ['Intereses', ''],
      ['Honorarios dedudor', ''],
      ['% de recuperación', ''],
      ['Comisión cojunal', ''],
      ['Coordinador', 'idCoordinador'],
      ['Asignar', '']
    ];

    // setea lo titulos y filtros de oreder de la cabecera de la tabla
    function setTableHead() {
      var content = '<tr>';
      tableCoordinadorTableHead.forEach(function(item, index) {
        content += '<th class="txt_center">';
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
      getCoordonadores();
    }

    // Esta funcion obtien las campanas
    var getCampaings = new Promise(function (resolve, reject) {
    });

    // Obtenemos los coordinadores
    function getCoordonadores() {
      apiService.post('GetCoordinadoresJuridicos', {}, function(resp) {
        coordinadores = resp;
        // Obtenemos las campañas y las mostramos
        var endPoint = window.baseUrl+"/admin/ObtenerCampanasParaAdmin";
        apiService.post(endPoint, query, function(resp) {
          var tbody = '';
          resp.forEach(function(datos, index) {
            tbody += configurarTd(datos);
            if(appendReady(index, resp)) {
              $("#adminListadoCampanas").empty();
              $("#adminListadoCampanas").append(tbody);
            }
          });
        });
      });
    }

    getCoordonadores();

    // Devuelve si el index es igual al length
    function appendReady(index, datos) {
      return (index == (datos.length - 1));
    }


    // Esta funcion devuelve los datos para una fila para el listado de campañas
    function configurarTd(datos) {
      var td = [
        '<td>' + datos.campaignName + '</td>',
        '<td>' + datos.nameCliente + '</td>',
        '<td>' + datos.createAt + '</td>',
        '<td>' + datos.serviceType + '</td>',
        '<td>' + parseFloat(datos.saldoAsignado || 0).format(0, 0, ',') + '</td>',
        '<td class="financialData" onclick="window.editFinalData('
          +datos.intereses+', '+datos.idWalletByCampaign+', \'interests\', this)">' 
          + parseFloat(datos.intereses).format(0, 0, '.')  
        + '</td>',
        '<td class="txt-center financialData" onclick="window.editFinalData('
          +datos.honorarios+', '+datos.idWalletByCampaign+', \'fee\', this)">' 
          + parseFloat(datos.honorarios).format(0, 0, '.') 
        + '</td>',
        '<td>' + 'falta' + '</td>',
        '<td class="financialData" onclick="window.editFinalData('
          +datos.comision+', '+datos.idWalletByCampaign+', \'comisions\', this)">' 
          + parseFloat(datos.comision).format(2) + ' %'  
        + '</td>',
        '<td class="formweb">'  
          + configurarSelectCoordinador(datos.idWalletByCampaign, datos.idCoordinador, datos.cantEstados) 
        + '</td>',
        '<td class="txt_center">' + configureStado(datos.idWalletByCampaign) + '</td>'
      ].join('');
      return '<tr>' + td + '</tr>';
    }

    // Esta funcion me edita el dato financiero pasado como parametro
    window.editFinalData = function(value, idCampeign, field, element) {
      // var r = confirm('Continuar operación?');
      if(true) {
        var newValue  = prompt('Por favor ingresa el  nuevo valor', value);
        var reg = /^-?\d*\.?\d*$/;
        if(newValue && reg.test(newValue)) {
          var data  = {campo:field, valor: newValue, idCampaign: idCampeign};
          apiService.post('UpdateDatoFinaciero', data, function(resp) {
            if(resp == 1) {
              $(element).text(newValue);
              toastr.success('Dato actualizado!');
            }
          });
        }else {
          console.log(newValue, value);
          if(! reg.test(newValue)) {
           toastr.error('Por favor ingresa un valor valido.');
          }
        }
      }
    }

    // Esta funcion devuelve el select con el coordinador
    function configurarSelectCoordinador(idCampaing, idCoordinador, cantEstados) {
      var text = '<small>Debes asignar por los menos 2 estados.</small>';
      var select = [
        '<select name="coordinador" style="display:block" onchange="asignmentCoordinatorToCampaign(this,'+idCampaing+')">',
        '<option value="-1">Seleccione</option>'
      ];

      coordinadores.forEach(function(coordinador) {
        var option = '';
        if(idCoordinador == coordinador.idAdviser) {
          option = '<option selected="selected" value="'+coordinador.idAdviser+'">'+coordinador.name+'</option>';
        }else {
          option = '<option value="'+coordinador.idAdviser+'">'+coordinador.name+'</option>';
        } 
          select.push(option);
      });

      select.push('</select>');
      // (cantEstados >= 2) ? text : 
      return select.join('');
       
    } 
    
    // Esta funcion devuelve el enlace para agregar estados a la campaña
    function configureStado(idCampaign) {
      return '<a href="#new_create_stado" class="modal_clic" onclick="setIdCampaing(this, '+idCampaign+')">Asignar</a>';
    }

    // Esta funcion asigna el coordinador a la campaña
    window.asignmentCoordinatorToCampaign = function(element, idCoordinator) {
      var idCampaign = $(element).val();

      if(idCampaign && idCoordinator) asignarCoordinador();
      else showError('Lo sentimos no fue posible procesar tu solicitud.');

      function asignarCoordinador() {
        var data = {idCoordinator: idCampaign, idCampaign: idCoordinator};
        var res = window.confirm('Continuar operación');
        if(res) {
          var endPoint = baseUrl + '/admin/AsignarCoordinador';
          window.apiService.post(endPoint, data, function(response) {
            if(response == 1) window.toastr.success('Coordinador asignado!.');
            else window.toastr.error('Lo sentimos no fue posible procesar tu solicitud.');
          });
        }
      }

      function showError(msg) {
        window.alert(msg)
      }
    }

    

  });


  /*=============================================================== 
  
    No tener en cuenta

  ===============================================================*/ 
  window.setEditIdCampaing = function(show, index, idCampaing) {
    if(show) {
      $('.item').css('display', 'none');
      $('.item.item-input-'+index).css('display', 'block');
    }else {
      $('.item.input').css('display', 'none');
      $('.item.text').css('display', 'block');
      var inputs = $('.item.input.item-input-'+index);
      var descripcion = $(inputs[0]).val();
      var idStatus = $(inputs[1]).val();
      var data = {descripcion: descripcion, idStatus: idStatus};
      
      apiService.post('edtEstadoCampana', data, function(resp) {
        if(resp == 1) window.listarStatus(idCampaing);
        else showError('Lo sentimos no fue posible procesar tu solicitud.');
      });
    }
  }

  /**
   * [setIdCampaing description]
   * @param {[type]} idCampaign [description]
   */
  window.setIdCampaing = function(element, idCampaign) {
    window.listarStatus(idCampaign);
    document.getElementById('stateCampaing').value = idCampaign;
    $(element).leanModal();
  }

  /**
   * [ListarStatus description]
   * @param {[type]} idCampaign [description]
   */
  window.listarStatus = function(idCampaign) {
    var data = {idCampaing: idCampaign};

    apiService.post('getEstadosPorCampana', data, function(resp) {
      window.a = {
        asignar: function (idStatus, idCampaign) {
          apiService.post('AddEstadoACampana', {idStatus: idStatus, idCampaign: idCampaign}, function(resp) {
            window.listarStatus(idCampaign);
          })
        },
        remover: function (idStatus, idCampaign) {
          apiService.post('DeleteEstadoACampana', {idStatus: idStatus, idCampaign: idCampaign}, function(resp) {
            window.listarStatus(idCampaign);
          })
        }
      }

      function getCheck(value, idCampaign, idStatus) {
        if(value) {
          return '<i class="fa fa-check-square-o" onclick="window.a.remover('+idStatus+', '+idCampaign+')"></i>';
        }else {
          return '<i class="fa fa-square-o" onclick="window.a.asignar('+idStatus+', '+idCampaign+')"></i>';
        }
      }

      function printTable() {
        var tbody = [];
        $('#tableStates').empty();
        resp.forEach(function(item, index) {
          var tr = '<tr>'+ 
            '<td>'
              +'<span class="item text item-text-'+index+'">'+item.description+'</span>'
              +'<input id="upDescripcion" class="item input item-input-'+index+'" type="text" value="'+item.description+'">'
              +'<input id="upID" class="item input item-input-'+index+'" type="hidden" value="'+item.idStatus+'">'
            +'</td>'
            +'<td>'+ getCheck(item.asignado, idCampaign, item.idStatus) +'</td>'
            +' <td class="text_center">'
              +'<a class="item text item-text-'+index+'" onclick="setEditIdCampaing(true, '+index+', 0)">Editar</a>'
              +'<a class="waves-effect waves-light right item input item-input-'+index+'" onclick="setEditIdCampaing(false, '+index+', '+item.idCampaign+')">Guardar</a>'
            +'</td> '
          +'</tr>';
          tbody.push(tr);
          if(index == (resp.length - 1)) {
            $('#tableStates').append(tbody.join(''));
          }
        });
      }
      printTable();

    });
  }

  /**
   * [saveNewState description]
   * @return {[type]} [description]
   */
  window.saveNewState = function() {
    var idCampaign = document.getElementById('stateCampaing').value;
    var name = document.getElementById('stateName').value;
    if(name) {
      var data = {idCampaing: idCampaign, description: name};
      window.apiService.post('CreateEstado', data, function(resp) {
        if(resp == 1) {
          window.listarStatus(idCampaign);
          document.getElementById('stateName').value = '';
        }else {
          showError('Lo sentimos no fue posible procesar tu solicitud.');
        } 
      });
    }else {
      toastr.info('Debes ingresar un nombre de estado.');
    }
  }

  /**
   * [asignmentCoordinatorToCampaign description]
   * @param  {[type]} element       [description]
   * @param  {[type]} idCoordinator [description]
   * @return {[type]}               [description]
   */
  window.asignmentCoordinatorToCampaign = function(element, idCoordinator) {
    var idCampaign = $(element).val();
    
    if(idCampaign && idCoordinator) asignarCoordinador();
    else showError('Lo sentimos no fue posible procesar tu solicitud.');

    function asignarCoordinador() {
      var data = {idCampaign: idCampaign, idCoordinator: idCoordinator};
      var res = window.confirm('Continuar operación');
      if(res) {
        window.apiService.post('addCoordinatorToCampaign', data, function(response) {
          // console.log(response);
        });
      }
    }

    /**
     * [showError description]
     * @param  {[type]} msg [description]
     * @return {[type]}     [description]
     */
    function showError(msg) {
      window.alert(msg)
    }
  }

})();