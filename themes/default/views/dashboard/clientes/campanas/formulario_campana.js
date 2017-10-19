(function () {
  
  'use strict';

  // Son los datos a almacenar mientras se recibe la info del pago
  var datosASerializar = {emails : []};

  // Submit form
  var form = document.forms.namedItem("frmSubirCampana");
  form.addEventListener('submit', function(ev) {
    // Detenemos el evento del form
    ev.preventDefault();
    
    // Configuracion del ajax
    var oData = new FormData(form);
    var oReq = new XMLHttpRequest();
    var inputFile = document.getElementById('file');

    //Obtener los valores del formulario
    var serviceType, notificationType, serviceName;
    var campaignName = window.document.forms.frmSubirCampana['campaignName'].value;
    var file = inputFile.value;
    var terms = window.document.forms.frmSubirCampana['terms'].value;

    // Obtenemos el tipo de servicio
    ['servicio1', 'servicio2'].forEach(function(radio) {
      var input = document.getElementById(radio);
      if(input.checked){
        serviceType = input.value;
        serviceName = $(input).next('label').text();
      } 
    });

    // Obtenemos el tipo de notificacion
    ['notification1', 'notification2', 'notification3'].forEach(function(radio) {
      var input = document.getElementById(radio);
      if(input.checked) notificationType = input.value;
    });

    // Añadir la data al ajax
    oData.append("campaignName", campaignName);
    oData.append("file", inputFile.files[0]);
    oData.append("serviceType", serviceType);
    oData.append("notificationType", notificationType);
    oData.append("serviceName", serviceName);
    oData.append("terms", terms);

    // Realizamos la peticion
    oReq.open("POST", ev.target.action, true);

    // Capturamos la respuesta de la peticion
    oReq.onload = function(oEvent) {
      if(oEvent.currentTarget.response) {
        var response = oEvent.currentTarget.response;

        if(response.length > 200) {
            response = JSON.parse(response);
        }

        if(typeof response == 'object') {
          var resp = response;
          
          //Reemplazamos los valores por los que queremos mostrar
          var nuevoHtml = document.getElementById("hide").innerHTML;
          nuevoHtml = nuevoHtml.replace('%nombre%', resp.campana_name);
          nuevoHtml = nuevoHtml.replace('%num_deudores%', resp.cant_deudores);
          nuevoHtml = nuevoHtml.replace('%total_campana%', resp.total_campana);
          nuevoHtml =  nuevoHtml.replace('%correo 1%', resp.email_usuario);
          nuevoHtml = nuevoHtml.replace('%tipo de notificaciones%', resp.notificacion_description);
          nuevoHtml = nuevoHtml.replace('%costoServicio%', resp.valor_pagar);
          nuevoHtml = nuevoHtml.replace('%nombreServicio%', 'Servicio ' + resp.service_name);

          // Mostramos el modal
          datosASerializar = Object.assign(datosASerializar, resp);
          document.getElementById("show").innerHTML =  nuevoHtml;
          document.querySelector('a[href="#detalle_carga_campana"]').click();
        }else {
          window.toastr.error(response.replace('"', '').replace('"', ''));
        }
      }else {
        window.toastr.error('Lo sentimos ha ocurrido un error al procesar tu solicitud.\n Por favor intentalo de nuevo.');
      }
    }

    // Validamos y enviamos la peticion
    if(campaignName != '' && file != '') {
      oReq.send(oData);
    }else {
      if(! file != '') window.toastr.error('Por favor seleccione un archivo valido.');
      if(! campaignName != '') window.toastr.error('Por favor digite el nombre de la campaña.');
    }

  }, false);

  // Btn click pagar campaña
  window.pagarCampana = function() {
    var li = $('#show #listEmails').children('li');
    // Obtenemos los emails de notificacion
    datosASerializar.emails = [];
    if(typeof li == 'object') {
      for (var i = li.length - 1; i >= 0; i--) { 
        datosASerializar.emails.push(li[i].innerText);
        if(i == 0) enviarDatos(datosASerializar);
      }
    }
    // Alacenamos la info en el db para validar el pago
    function enviarDatos(datos) {
      var url = document.getElementById('serialize').attributes['endpoint'].value;
      $.post(url, datos, function(resp) {
        if(resp == 0) window.toastr.error('Lo sentimos ha ocurrido un error al procesar tu solicitud.');
        var r = confirm('Aceptar pago (Respuesta pasarela)');
        if(r) {
          apiService.get('dashboard/pagoOk/'+resp, null, true);
        }
        // else window.alert('falta la pasarela de pagos id = ' + resp + ' url = ' + url); 
      });
    }
  }

  // Eliminar correo de notificacion
  window.elimiarEmailNotificacion = function(element) {
    var resp = window.confirm('Eliminar dirección de correo electrónico?');
    if(resp) $(element).parent().remove();
  }

  // agregar email de notificacion
  window.anadirEmailNotificacion = function() {
    var email = prompt("Por favor digite el correo electronico");
    if(validateEmail(email)){
      var li = '<li>'+email+' <i class="fa fa-times" onclick="window.elimiarEmailNotificacion(this)"></i></li>';
      $('#show #listEmails').append(li);
    }else {
      window.toastr.error('Por favor ingresa una dirección de correo electrónico valida.');
    }
  }
  
  // Validar email
  function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }


})();