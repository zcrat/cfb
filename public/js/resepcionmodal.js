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

    $('#newcustomer').on('click',function(){
        $('#RecepcionVehicular').modal('hide');
        $('#usuarioStore').modal('show');
    });
    $('.closenewcustomer').on('click', function(){
        $('#usuarioStore').modal('hide');
        $('#RecepcionVehicular').modal('show');
    });
    $('#newcar').on('click',function(){
        $('#RecepcionVehicular').modal('hide');
        $('#newcarmodal').modal('show');
    });
    $('.closenewcar').on('click', function(){
        $('#newcarmodal').modal('hide');
        $('#RecepcionVehicular').modal('show');
    });

    $('#newcolorcar').on('click',function(){
        $('#newcarmodal').modal('hide');
        $('#newcolorcarmodal').modal('show');
    });
    $('.closenewcolorcar').on('click', function(){
        $('#newcolorcarmodal').modal('hide');
        $('#newcarmodal').modal('show');
    });
    $('#newmodelocar').on('click',function(){
        $('#newcarmodal').modal('hide');
        $('#newmodelocarmodal').modal('show');
    });
    $('.closemodelonewcar').on('click', function(){
        $('#newmodelocarmodal').modal('hide');
        $('#newcarmodal').modal('show');
    });
    $('#newmarcacar').on('click',function(){
        $('#newcarmodal').modal('hide');
        $('#newmarcacarmodal').modal('show');
    });
    $('.closemarcanewcar').on('click', function(){
        $('#newmarcacarmodal').modal('hide');
        $('#newcarmodal').modal('show');
    });
})