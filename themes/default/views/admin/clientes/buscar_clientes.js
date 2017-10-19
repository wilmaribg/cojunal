(function() {

    'use strict';
    var app = new Vue({
        el: '#app-busca_clientes',

        data: {
            buscar: []
        },
        methods: {
            busqueda: function() {

                // var _this = this;
                if (this['buscar'].length > 3) {
                    console.log(this['buscar'])
                    window.apiService.post('GetSearchClientes', { busqueda: this['buscar'] }, function(response) {

                        console.log(JSON.stringify(response));
                        console.log(response);

                    })
                }


            }

        }
    });

})();