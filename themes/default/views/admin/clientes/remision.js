(function() {

    'use strict';

    Vue.component('graficos-component', {
        template: '#graficos_component',
        created: function() {
            var _this = this;
            apiService.post('GetCampaingsGrafico', { id: this.id }, function(resp) {
                _this['campana'] = resp[0];
                var recaudado = _this['campana']['monto_recuperado'];
                var service = (_this['campana']['serviceType'] == 'SERVICIO 1') ?
                    _this['campana']['valueService1'] :
                    _this['campana']['valueService2'];

                var costo = parseFloat(_this['campana']['num_clientes']) * parseFloat(service);
                var fee = (recaudado * _this['campana']['fee']);
                var interests = (recaudado * _this['campana']['interests']);
                var comisions = (recaudado * _this['campana']['comisions']);

                var costo_campana = recaudado - (fee + interests + comisions);
                console.log(fee, interests, comisions);

                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        // labels: ["Costo campaña", "Total recaudado"],
                        datasets: [{
                            data: [costo_campana, recaudado],
                            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                            borderColor: ['rgba(255,99,132,1)', 'rgba(54, 162, 235, 1)'],
                            borderWidth: 1
                        }],
                        options: {
                            scales: {
                                xAxes: [{
                                    display: false
                                }]
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                titleFontSize: 200
                            }
                        }
                    }
                });

                _this['costo'] = costo;
                _this['recaudado'] = recaudado;
                _this['costo_campana'] = costo_campana;

                console.log(costo, _this['campana']['num_clientes'], service);
                console.log(resp);
            });
        },
        data: function() {
            return {
                costo: 0,
                recaudado: 0,
                costo_campana: 0,
                campana: {}
            }
        },
        props: ['id']
    });

    var app = new Vue({
        el: '#app-remision1',
        data: {
            showG: false,
            idCampaign: 0,
            campanas: []

        },
        methods: {
            showGF: function(id) {
                this.showG = true;
                this.idCampaign = id;
            },
            getData: function(e) {
                var _this = this;
                window.apiService.post('GetCampanasForRemision', { idCampaign: e.target.value }, function(response) {
                    if (response[0].length > 0) _this['campanas'] = response[0];
                    else {
                        _this['campanas'] = [];
                        toastr.info('No hay campañas para mostrar.');
                    }
                    console.log(response[0]);
                });
            },

            remisionar: function(item) {
                var _this = this;
                var r = confirm('Seguro de remisionar esta cuenta?');
                var data = {
                    monto: item.saldoCampana,
                    recaudo: item.recaudado,
                    comision: item.comisions,
                    idCliente: item.IdCampaign,
                    intereses: item.interests,
                    honorarios: item.fee,
                    idPayments: item.idPayments,
                    idWalletByCampaign: item.idWalletByCampaign
                };
                if (r) {
                    window.apiService.post('GuardarRemisiones', data, function(response) {
                        console.log(response);
                        if (response[0] > 0) {
                            console.log(response[0]);
                            window.open('http://cojunal.com/plataforma/beta/admin/DescargarPdfRemision/' + response[0], '_newtab');
                            updateList();
                        } else {
                            updateList();
                        }

                        function updateList() {
                            _this.getData({ target: { value: item.IdCampaign } });
                        }
                    });
                }
                // console.log(item, _this.getData({target: {value: 72}}));
            }
        }
    });

})();