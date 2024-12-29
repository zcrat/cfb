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
const modalrecepcion=$('#RecepcionVehicular');
const modalempresas=$('#Empresa_modal');
const modalclientes=$('#usuarioStore');
const modalvehiculo=$('#newcarmodal');
const modalcolor=$('#newcolorcarmodal');
const modalmarca=$('#newmarcacarmodal');
const modalmodelo=$('#newmodelocarmodal');

    function modalprincipal(hide,show){
        hide.modal('hide')
        show.modal('show')
    }
    //se abren desde una modal
    $('#newempresas').on('click',function(){modalprincipal(modalrecepcion,modalempresas)});
    $('.closenewempresa').on('click', function(){modalprincipal(modalempresas,modalrecepcion)});

    $('#newcustomer').on('click',function(){modalprincipal(modalrecepcion,modalclientes) });
    $('.closenewcustomer').on('click', function(){ modalprincipal(modalclientes,modalrecepcion) });

    $('#newcar').on('click',function(){modalprincipal(modalrecepcion,modalvehiculo)});
    $('.closenewcar').on('click', function(){modalprincipal(modalvehiculo,modalrecepcion) });

    $('#newcolorcar').on('click',function(){modalprincipal(modalvehiculo,modalcolor)});
    $('.closenewcolorcar').on('click', function(){modalprincipal(modalcolor,modalvehiculo)});

    $('#newmodelocar').on('click',function(){modalprincipal(modalvehiculo,modalmodelo)});
    $('.closemodelonewcar').on('click', function(){modalprincipal(modalmodelo,modalvehiculo)});
    
    //se abre de dos posibles modales
    $('.newmarcacar').on('click',function(){cerrarpadre(modalmarca);});
    $('.closemarcanewcar').on('click', function(){abrirpadre(modalmarca);});

    function cerrarpadre(segundomodal){
     modalVisible = $('.modal.show');
     modalprincipal( modalVisible,segundomodal)
    }
    function abrirpadre(segundomodal){
        modalprincipal(segundomodal,modalVisible)
    }


})