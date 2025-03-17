<template>
<main class="main">
    <div class="container-fluid">
        <!-- <div class="card">
            <div class="card-header">
                
            </div>
            <div class="car-body">

                  <div class="row">
                    <div class="col-lg-3 col-6">
        
            <div class="small-box bg-danger">
              <div class="inner">

                   <p><b>CONTRATO:</b> {{arrayContrato[0].numero}}</p>
                <h4>{{arrayContrato[0].nombre}}</h4>

               
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
             
            </div>
          </div>
                      <div class="col-lg-3 col-6">
         
            <div class="small-box bg-success">
              <div class="inner">
                   <p><b>MONTO</b></p>
                <h4>{{formatPrice(arrayContrato[0].monto*1.16)}}</h4>

               
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
             
            </div>
          </div>
                      <div class="col-lg-3 col-6">
         
            <div class="small-box bg-info">
              <div class="inner">
                   <p><b>EJERCIDO</b></p>
                <h4>{{formatPrice((c1+c2+c3+c4+c5+c6+c7+c8+c9+c10+c11+c12)*1.16)}} </h4>

               
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
             
            </div>
          </div>
                <div class="col-lg-3 col-6">
        
            <div class="small-box bg-warning">
              <div class="inner">
                   <p> <b>REMANENTE</b></p>
                <h4>{{formatPrice((arrayContrato[0].monto-(c1+c2+c3+c4+c5+c6+c7+c8+c9+c10+c11+c12))*1.16)}}</h4>

               
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
             
            </div>
          </div>
                    </div>

                
                
                <div class="row">
                    <div class="col-md-6">
                       
  <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                          
                                            <th>PREVENTIVO: </th>
                                            <th>{{formatPrice((c11+c12)*1.16)}}</th>
                                            
                                        </tr>
                                      
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>MAYOR</td>
                                            <td>{{formatPrice(c12*1.16)}}</td>
                                        </tr>
                                        <tr>
                                            <td>MENOR</td>
                                            <td>{{formatPrice(c11*1.16)}}</td>
                                        </tr>
                                     
                                      
                                    </tbody>  
                                                           
                                </table>

                    </div>
                    <div class="col-md-6">
                        
 <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                          
                                            <th>CORRECTIVO:</th>
                                            <th>{{formatPrice((c1+c2+c3+c4+c5+c6+c7+c8+c9+c10)*1.16)}}</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>LINEA MOTOR A GASOLINA</td>
                                            <td>{{formatPrice(c1*1.16)}}</td>
                                        </tr>
                                         <tr>
                                            <td>LINEA FRENOS</td>
                                            <td>{{formatPrice(c2*1.16)}}</td>
                                        </tr>
                                         <tr>
                                            <td>LINEA EMBRAGUE</td>
                                            <td>{{formatPrice(c3)}}</td>
                                        </tr>
                                          <tr>
                                            <td>LINEA TRANSMISIÓN</td>
                                            <td>{{formatPrice(c4*1.16)}}</td>
                                        </tr>
                                         <tr>
                                            <td>LINEA SUSPENSIÓN</td>
                                            <td>{{formatPrice(c5*1.16)}}</td>
                                        </tr>
                                         <tr>
                                            <td>LINEA DIRECCION</td>
                                            <td>{{formatPrice(c6*1.16)}}</td>
                                        </tr>
                                         <tr>
                                            <td>LINEA ELECTRICO</td>
                                            <td>{{formatPrice(c7*1.16)}}</td>
                                        </tr>
                                         <tr>
                                            <td>ARRASTRES</td>
                                            <td>{{formatPrice(c8*1.16)}}</td>
                                        </tr>
                                         <tr>
                                            <td>LINEA DIFERENCIAL</td>
                                            <td>{{formatPrice(c9*1.16)}}</td>
                                        </tr>
                                         <tr>
                                            <td>LINE DE ESCAPES</td>
                                            <td>{{formatPrice(c10*1.16)}}</td>
                                        </tr>
                                     
                                      
                                    </tbody>  
                                                           
                                </table>

                    </div>
                </div>
            </div>
        </div> -->

        <center><font size="30"><b>BIENVENIDO A CFB</b></font></center>
        <center><img :src="'img/logo_cfb.png'"  width="400" ></center>


    </div>

</main>
</template>
<script>
    export default {
        data (){
            return {
                varIngreso:null,
                charIngreso:null,
                ingresos:[],
                varTotalIngreso:[],
                varMesIngreso:[], 
                arrayContrato:[{
                    nombre:'',
                    numero:'',
                    monto:0,
                }],
                c1:0,
                c2:0,
                c3:0,
                c4:0,
                c5:0,
                c6:0,
                c7:0,
                c8:0,
                c9:0,
                c10:0,
                c11:0,
                c12:0,
                varVenta:null,
                charVenta:null,
                ventas:[],
                varTotalVenta:[],
                varMesVenta:[],
            }
        },
        methods : {
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            getIngresos(){
                let me=this;
                var url= 'dashboard';
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    var respuesta= response.data;
                    me.arrayContrato = respuesta.contrato;
                    console.log(me.arrayContrato[0].nombre);
                    me.c1 = respuesta.totalmotor;
                    me.c2 = respuesta.totalenfriamiento;
                    me.c3 = respuesta.totalembrague;
                    me.c4 = respuesta.totaltrasmision;
                    me.c5 = respuesta.totalsuspencionydireccion;
                    me.c6 = respuesta.totalfrenosyruedas;
                    me.c7 = respuesta.totalelectrico;
                    me.c8 = respuesta.totalescape;
                    me.c9 = respuesta.totaltraslados;
                    me.c10 = respuesta.totalfuera;
                    me.c11 = respuesta.totalmayor;
                    me.c12 = respuesta.totalmenor;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getVentas(){
                let me=this;
                var url= 'dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ventas = respuesta.ventas;
                    //cargamos los datos del chart
                    me.loadVentas();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadIngresos(){
                let me=this;
                me.ingresos.map(function(x){
                    me.varMesIngreso.push(x.mes);
                    me.varTotalIngreso.push(x.total);
                });
                me.varIngreso=document.getElementById('ingresos').getContext('2d');

                me.charIngreso = new Chart(me.varIngreso, {
                    type: 'bar',
                    data: {
                        labels: me.varMesIngreso,
                        datasets: [{
                            label: 'Ingresos',
                            data: me.varTotalIngreso,
                            backgroundColor: '#ffc107',
                            borderColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },
            loadVentas(){
                let me=this;
                me.ventas.map(function(x){
                    me.varMesVenta.push(x.mes);
                    me.varTotalVenta.push(x.total);
                });
                me.varVenta=document.getElementById('ventas').getContext('2d');

                me.charVenta = new Chart(me.varVenta, {
                    type: 'bar',
                    data: {
                        labels: me.varMesVenta,
                        datasets: [{
                            label: 'Ventas',
                            data: me.varTotalVenta,
                            backgroundColor: '#007bff',
                            borderColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            }
        },
        mounted() {
            this.getIngresos();
            this.getVentas();
        }
    }
</script>