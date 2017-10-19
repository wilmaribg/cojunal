$(document).ready(function() {

	window.showCampos = function () {
		var element = document.getElementsByClassName('help')[0]
		var height = element.style.height;
		element.style.height = (height == '0px' || height == '') ? '200px' : '0px';
	}

  CKEDITOR.editorConfig = function( config ) {
  	config.language = 'es';
  	config.uiColor = '#F7B42C';
  	config.height = 300;
  	config.toolbarCanCollapse = true;
  };

  window.saveEmailPlaceholder = function(textarea) {
  	var content = CKEDITOR.instances[textarea].getData(); 
  	var endPoint = (textarea == 'editor2') ?  'updateTermsConditions' : 'UpdateRegiaterClientNotification';
  	window.apiService.post(endPoint, {text:content}, function(resp) {
  		if(resp == 1) window.toastr.success('Datos actializados!');
  		else window.toastr.error('Lo sentimos ha ocurrido un error al procesar tu solicitud.');
  	});
  }

  CKEDITOR.replace( 'editor1' );
  CKEDITOR.replace( 'editor2' );

});
