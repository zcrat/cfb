<!-- Modal -->
<div class="modal fade" id="facturarmodal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="recepcionservicioLabel" >
    <div class="modal-dialog zdmw-60pct modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Facturar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <!-- Datos del Vehículo -->
                <div class="vaniflex zditemscenter zdpd-r05">    
                                <label class="zdmgr-r02">Empresas:</label>
                                <select  id="empresasfactura" required>
                                        <option value="">Todas</option>
                                </select>
                </div>
                <div class="col-md-12">
                <input type="hidden" id="emisorrfc">
                <button data-id="1" id="original" class="elimarestilosboton emisor"><img src="/img/logo_cfb_button.png" alt="" class="ajustaraltura"></button>
                <button data-id="2" class="elimarestilosboton emisor"><img src="/img/logo_akumas_button.png" alt="" class="ajustaraltura"></button>
                <button data-id="3" class="elimarestilosboton emisor"><img src="/img/logo_kmg_button.jpeg" alt="" class="ajustaraltura"></button>
            </div>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class=" selectconlabel zdw-30pct zdmg-r02">
                        <label for="Economico">Tipo de Comprobante</label>
                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control">
                            <option selected value="I">I - Factura</option> 
                            <option value="E">E - Nota de credito</option> 
                            <option value="E">N - Nomina</option>
                        </select>
                    </div> 
                    <div class=" selectconlabel zdw-30pct zdmg-r02">
                        <label for="rsmodelo">Uso de CFDI</label>
                        <select name="uso_cfdi" id="uso_cfdi" class="form-control"><option value="G01">G01 - Adquisicion de mercancias</option>
                            <option value="G02">G02 - Devoluciones, descuentos o bonificaciones</option>
                            <option value="G03">G03 - Gastos en general</option>
                            <option value="I01">I01 - Construcciones</option>
                            <option value="I02">I02 - Mobilario y equipo de oficina por inversiones</option>
                            <option value="I03">I03 - Equipo de transporte</option>
                            <option value="I04">I04 - Equipo de computo y accesorios</option>
                            <option value="I05">I05 - Dados, troqueles, moldes, matrices y herramental</option>
                            <option value="I06">I06 - Comunicaciones telefonicas</option>
                            <option value="I07">I07 - Comunicaciones satelitales</option>
                            <option value="I08">I08 - Otra maquinaria y equipo</option>
                            <option value="D01">D01 - Honorarios medicos, dentales y gastos hospitalarios.</option>
                            <option value="D02">D02 - Gastos medicos por incapacidad o discapacidad</option>
                            <option value="D03">D03 - Gastos funerales.</option>
                            <option value="D04">D04 - Donativos.</option>
                            <option value="D05">D05 - Intereses reales efectivamente pagados por creditos hipotecarios (casa habitaci?n)</option>
                            <option value="D06">D06 - Aportaciones voluntarias al SAR.</option>
                            <option value="D07">D07 - Primas por seguros de gastos medicos.</option>
                            <option value="D08">D08 - Gastos de transportacion escolar obligatoria.</option>
                            <option value="D09">D09 - Depositos en cuentas para el ahorro, primas que tengan como base planes de pension</option>
                            <option value="D10">D10 - Pagos por servicios educativos (colegiaturas)</option>
                            <option value="P01">P01 - Por definir</option>
                        </select>
                    </div> 
                    <div class=" selectconlabel zdw-30pct zdmg-r02">
                        <label for="rsvin">Tipo de Impuesto Local</label>
                        <select name="tipo_impuesto_local" id="tipo_impuesto_local" class="form-control"><option value="1">Sin Impuesto Local</option>
                            <option value="2">Inspeccion, Vigilancia, Control</option>
                            <option value="3">Impuesto Cedular</option>
                            <option value="4">Impuesto Sobre Remuneraciones al Trabajo Personal No Subordinado (RTP)</option>
                            <option value="5">Impuesto Sobre Nomina</option>
                        </select>
                    </div> 
                    <div class=" selectconlabel zdw-30pct zdmg-r02">
                        <label for="rsplacas">Moneda</label>
                        <select name="moneda" id="moneda"class="form-control">
                            <option value="MXN">MXN - PESOS</option>
                            <option value="USD">USD - DOLARES</option>
                            <option value="EUR">EUR - EUROS</option>
                        </select>
                    </div> 
                    <div class=" selectconlabel zdw-30pct zdmg-r02">
                        <label for="rsAño">Forma de Pago</label>
                        <select name="fpago" id="fpago"class="form-control"><option value="01">01 - Efectivo</option>
                            <option value="02">02 - Cheque nominativo</option>
                            <option value="03">03 - Transferencia electronica de fondos</option>
                            <option value="04">04 - Tarjeta de credito</option>
                            <option value="05">05 - Monedero Electronico</option>
                            <option value="06">06 - Dinero electronico</option>
                            <option value="08">08 - Vales de despensa</option>
                            <option value="12">12 - Dacion en pago</option>
                            <option value="13">13 - Pago por subrogacion</option>
                            <option value="14">14 - Pago por consignacion</option>
                            <option value="15">15 - Condonacion</option>
                            <option value="17">17 - Compensacion</option>
                            <option value="23">23 - Novacion</option>
                            <option value="24">24 - Confusion</option>
                            <option value="25">25 - Remision de deuda</option>
                            <option value="26">26 - Prescripcion o caducidad</option>
                            <option value="27">27 - A satisfaccion del acredor</option>
                            <option value="28">28 - Tarjeta de debito</option>
                            <option value="29">29 - Tarjeta de servicios</option>
                            <option value="99">99 - Por definir.</option>
                        </select>
                    </div> 
                    <div class=" selectconlabel zdw-30pct zdmg-r02">
                        <label for="rsKilometraje">Metodo de Pago</label>
                        <select name="mpago" id="mpago" class="form-control">
                            <option value="PUE">PUE - Pago en una sola exhibicion</option> 
                            <option value="PPD">PPD - Pago en parcialidades o diferidos</option>
                        </select>
                    </div> 
                </div>

            <div>
                <table id="tablaconceptosfactura" class="table table-sm  table-striped">
                    <thead>
                        <tr>
                            <th>Articulo</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
                <div class="vaniflex zdjc-end">
                    <div class="vaniflex zdfd-column totalizacion"> 
                        <label class="" id="subtotalfactura" for="">Subtotal: $0</label>
                        <label class="" id="ivafactura" for="">Iva:      $0</label>
                        <label class="" id="totalfactura" for="">Total:    $0</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="timbrarfactura" >Timbrar</button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function(){
        $('#empresasfactura').select2({
            language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
            dropdownParent: $("#facturarmodal"),
            placeholder: 'Escribe para buscar...',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: '/select2/obtenerempresas',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        term: params.term,
                    };
                    return query;
                },
                delay: 500,
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nombre,
                                id: item.id
                            };
                        })
                    };
                },
        cache: true
            }
        });
$('.emisor').on('click',function(){
    $('.rfcactive').removeClass('rfcactive');
    $(this).addClass('rfcactive');
    const id_presupuestos=$(this).attr('data-id');
    $('#emisorrfc').val(id_presupuestos)
})

$('#timbrarfactura').on('click', function (){
    let factura={};
    let data=[];
    let emisor_id= $('#emisorrfc').val();
    const id_presupuestos=$(this).attr('data-id');
    factura.empresa_id=$('#empresasfactura').val();
    factura.tipo_comprobante=$('#tipo_comprobante').val();
    factura.uso_cfdi=$('#uso_cfdi').val();
    factura.moneda=$('#moneda').val();
    factura.fpago=$('#fpago').val();
    factura.mpago=$('#mpago').val();
    const contrato = @json($mod);
    $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.conceptospresupuesto') }}',
            data:{
                id: id_presupuestos,
                contrato:contrato,
            },
            success: function(response) {
                listaconceptos=response.conceptos;
                factura.contrato=response.contrato;
                console.log(listaconceptos);
                $.each(listaconceptos, function(index, element) {
                    data[index] = {};
                    data[index].idarticulo=element.pCFEConcepto_id;
                    data[index].cantidad=element.cantidad;
                    data[index].precio=element.precio_v;
                });
                Swal.fire({
                title: '¿Estás seguro?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Facturar',
                cancelButtonText: 'No, Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                    $.ajax({
                    url: "{{route('2025.cfe.facturar.unica')}}",
                    type: "post",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        data:data,
                        factura:factura,
                        emisor_id:emisor_id,
                        presupuesto:id_presupuestos,
                    },
                    success: function(response) {
                        var respuesta = response.id;
                        const mensaje=response.success;
                        Swal.fire({ html: `${mensaje}`, icon: 'success',showConfirmButton: false,timer: 2000,});
                        $.ajax({
                        url: "{{route('2025.cfe.cambiar.estatus.presupuesto')}}",
                        type: "post",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id:id_presupuestos,
                            estatus:5,
                        },
                        success: function(response) {
                            executeSearchdata()
                        },
                        error: function(xhr, status, error) {
                            if(xhr.status===499){
                                Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                                executeSearchdata();
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                        }
                    });
                    },
                    error: function(xhr, status, error) {
                        if(xhr.status===499){
                            let errorMessage = 'Verifique Los Datos';
                            Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                        }else{
                            let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                            Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                        }
                    }
                })
        }
    });
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        }); 
});
})
</script>
@endpush