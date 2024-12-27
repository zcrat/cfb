$(function(){
    let selects=$(".condiciones");
        selects.each(function() {
            $(this).append('<option value="">Seleccionar</option>');
            $(this).append('<option value="2">Sin daño visible</option>');
            $(this).append('<option value="3">Operacional</option>');
            $(this).append('<option value="4">Falta Objeto</option>');
            $(this).append('<option value="5">Dañada</option>');
            $(this).append('<option value="6">Reparacion necesaria</option>');
            $(this).append('<option value="7">No Aplica</option>');
        });

    $('#newempresas').on('click',function(){
        console.log('sdsds');
        $('#RecepcionVehicular').modal('hide');
        $('#Empresa_modal').modal('show');
    });
    $('.closenewempresa').on('click', function(){
        $('#Empresa_modal').modal('hide');
        $('#RecepcionVehicular').modal('show');
    });
    
})