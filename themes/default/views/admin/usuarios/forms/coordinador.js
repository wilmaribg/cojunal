(function() {

    $(document).ready(function() {
        var msgError = 'Por favor completa todos los campos y/o perfil de usuario.';

        $('#AbtnSaveInfo').click(function(e) {
            e.preventDefault();
            if ($('#AAdvisers_name').val() != '' && $('#AAdvisers_idAuthAssignment').val() != '' && $('#AAdvisers_parentAdviser').val() != '') {
                window.document.forms.frmAsesores.submit();
            } else {
                window.toastr.error(msgError);
            }
        });

        $('#CbtnSaveInfo').click(function(e) {
            e.preventDefault();
            if ($('#CAdvisers_name').val() != '' && $('#CAdvisers_idAuthAssignment').val() != '') {
                window.document.forms.frmCoordinadores.submit();
            } else {
                window.toastr.error(msgError);
            }
        });

    });

    $('#AAJuridico').change(function(e) {
        var paramsC = { id: 'Coordinador jurídico' };
        window.apiService.post('Perfilselect', paramsC, function(resp) {
            $html = "";
            if (typeof resp == 'object') {
                resp.forEach(function(item, index) {
                    $html += "<option>" + item.name + "</option>";
                    console.log(item.name)
                });
            }

            $('#AAdvisers_parentAdviser').html($html);
        });
        console.log("juridico")

    });

    $('#AAPJuridico').change(function(e) {
        var paramsC = { id: 'Coordinador pre jurídico' };
        window.apiService.post('Perfilselect', paramsC, function(resp) {
            $html = "";
            if (typeof resp == 'object') {
                resp.forEach(function(item, index) {
                    $html += "<option>" + item.name + "</option>";
                    console.log(item.name)
                });
            }

            $('#AAdvisers_parentAdviser').html($html);
        });
        console.log("prejuridico")
    });


})();

function autoload() {
    var paramsC = { id: 'Coordinador jurídico' };
    window.apiService.post('Perfilselect', paramsC, function(resp) {
        $html = "";
        if (typeof resp == 'object') {
            resp.forEach(function(item, index) {
                $html += "<option>" + item.name + "</option>";
                console.log(item.name)
            });
        }

        $('#AAdvisers_parentAdviser').html($html);
    });
}

$(document).ready(function() {
    autoload();
});