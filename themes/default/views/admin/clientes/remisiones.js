(function() {

    'use strict';
    var app = new Vue({
        el: '#app-remisiones',
        data: {
            clientes: [],
            buscar: []
        },
        methods: {
            Clientesvalue: function(e) {
                var _this = this;
                window.apiService.post('GetCampanasForRemisiones', { idCliente: e.target.value }, function(response) {
                    _this['clientes'] = response[0];

                });
            },
            busqueda: function() {
                var _this = this;
                //console.log(this['buscar'])
                // var _this = this;

                window.apiService.post('GetSearchOrdenes', { busqueda: this['buscar'] }, function(response) {
                    // console.log(response);
                    _this['clientes'] = response[0];
                })



            },
            descargar: function(item) {
                var _this = this;
            }
        }
    });

})();