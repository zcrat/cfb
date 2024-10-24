<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" @click="$store.state.menuc=0">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-id-badge"></i>
                    Asignar Tecnico a Recepción
                </div>
                <!-- Listado de recepciones vehiculaes-->
                
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-12 col-md-6 offset-md-3">
                            <div class="text-center">
                                <div class="input-group">
                                    <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio)"
                                            class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarIngreso(1,buscar,criterio)"
                                            class="btn btn-primary"><i class="fa fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>Orden seguimiento</th>
                                <th>Folio</th>
                                <th>Empresa</th>
                                <th>Vehículo</th>
                                <th>Fecha recepción</th>
                                <th>Fecha compromiso</th>
                                <th>Asignar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="recepcion in listaRecepciones"  :key="recepcion.id">
                                <td v-text="recepcion.orden_seguimiento"></td>
                                <td v-text="recepcion.folio"></td>
                                <td v-text="recepcion.empresa.nombre"></td>
                                <td>{{recepcion.vehiculo.placas}} - {{recepcion.vehiculo.marca.nombre}} - {{recepcion.vehiculo.modelo.nombre}}</td>
                                <td v-text="recepcion.fecha"></td>
                                <td v-text="recepcion.fecha_compromiso"></td>
                                <td>
                                    <input type="search" class="form-control form-control-sm" 
                                        :name="'tecnico'+recepcion.id-1" 
                                        :id="'tecnico'+recepcion.id-1"
                                        v-model="tecnico[recepcion.id-1]"    
                                        list="listTecnicos"  
                                        @change="asignarTecnico(recepcion.id-1)"
                                    />
                                    <datalist id="listTecnicos">
                                        <option v-for="tecnico in tecnicos" :key="tecnico.id">
                                            {{tecnico.id}}-{{tecnico.nombre}}
                                        </option> 
                                    </datalist>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#"
                                    @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page"
                                :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)"
                                    v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#"
                                    @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            <!--Fin Listado-->
            </div>
        </div>
    </main>    
</template>

<script>
    export default {
        data(){
            return{
                listaRecepciones: [],
                tecnicos:{},
                buscar:'',
                tecnico:[],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },                
            };
        },   
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },

            //Calcula los elementos de la paginación
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            },

            calcularTotal: function () {
                var resultado = 0.0;
                for (var i = 0; i < this.arrayDetalle.length; i++) {
                    resultado = resultado + (this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad)
                }
                return resultado;
            }
        }, 
        methods: {
            getTecnico(){
                let me = this;
                axios
                    .get("tecnicos/get")
                    .then(function(response){
                        me.tecnicos = response.data;
                        console.log(me.tecnicos);
                    })
                    .catch(function(response){
                        console.log(response);
                    });
            },
            asignarTecnico(id){
                let me = this;
                var temp = me.tecnico[id].split('-');
                me.listaRecepciones[id].id_tecnico = temp[0];
                axios
                    .put('asignarTecnico/' + me.listaRecepciones[id].id ,{
                        recepcione: me.listaRecepciones[id]
                    })
                    .then(function(response){
                         if (response.data == 1) {
                            me.$toastr.success('Se asigno tecnico correctamente', 'Asignación');
                        }
                        console.log(response.data);
                    })
                    .catch(function(error){
                        me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                        console.log(error);
                    });

                console.log(me.listaRecepciones);
            },
            listarRecepciones() {
                let me = this;
                var i = 0;
                axios.get('recepcion/index').then(function (response) {
                    console.log(response.data);
                    me.listaRecepciones = response.data;
                    for(let value of me.listaRecepciones){
                        if (value.id_tecnico != null && value.id_tecnico != '') {
                            for (const item in me.tecnicos) {
                                if (value.id_tecnico == me.tecnicos[item].id) {
                                    me.tecnico[i] = me.tecnicos[item].id+'-'+me.tecnicos[item].nombre;
                                    i += 1;
                                }
                                console.log(me.tecnicos[item]);
                            }
                        }
                    }
                }).catch(function (response) {
                    console.log(response);
                })
            },
        },
        mounted() {
            this.getTecnico();
            this.listarRecepciones();
        },
    }
</script>