(function() {

	// Parametos para la consulta de coordinadorea
	var paramsC = { initFrom: 0, q: '', orderBy: 'ASC', field: 'name' };

	// Estos valores son la cabecera de la tabla
	var tableCoordinadorTableHead = [
		['Nombre de usuario', 'name'],
		['Número de asesores a cargo', 'num_asesores'],
		['Total de campañas asignadas', 'num_camapanas'],
		['Total asignado', ''],
		['Total recuperado', ''],
		['% de recuperación', ''],
		['Habilitar', 'active']
	];

	//Obtenemos los datos del backed y anexarlos a la tabla
	function getAllCordinatores() {
		window.apiService.post('getCoordinadores', paramsC, function(resp) {
			if(typeof resp == 'object') {
				var html = [];
				var content = '';
				resp.forEach(function(item, index) {
					var selected = 'selected="selected"';
					content = '<tr>';
						content += '<td>'+item.name+'</td>';
						content += '<td class="txt_center">'+item.num_asesores+'</td>';
						content += '<td class="txt_center">'+item.num_camapanas+'</td>';
						content += '<td>Falta</td>';
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
						$('#coordinadorTable').empty();
						$('#coordinadorTable').append(html.join(''));
					}
				});
			}
		});
	}

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

		paramsC.field = campo;
		paramsC.orderBy = orderType;
		paramsC.q = '';
		paramsC.initFrom = 0;
		getAllCordinatores();
	}

	

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
				$('#coordinadorTableHead').empty();
				$('#coordinadorTableHead').append(content);
			}
		});
	}
	setTableHead();

	// Esta funcion agrega los totales al encabezado de la table
	function addEncabezadosTotales(positions) { 
		document.querySelectorAll('#coordinadorTableHead tr th').forEach(function(th, index) {
			if(positions.indexOf(index) > -1) {
				$(th).append('<span>' + parseFloat(200000).format(0, 0, '.') + '</span>');
			}
		});
	}
	addEncabezadosTotales([3, 4, 5]);

	// Inicializacion del script
	$(document).ready(function() {
		getAllCordinatores();
	});

})();