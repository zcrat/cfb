$('.empresas-Select2').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
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
$('#empresasrecepcion').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#RecepcionVehicular"),
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

$('#vehiculo').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#RecepcionVehicular"),
    placeholder: 'Escribe para buscar...',
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: '/select2/obtenervehiculos',
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

$('#clientesrecepcion').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#RecepcionVehicular"),
    placeholder: 'Escribe para buscar...',
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: '/select2/obtenerclientes',
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

$('#marcanewmodelo').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#newmodelocarmodal"),
    placeholder: 'Escribe para buscar...',
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: '/select2/obtenermarcasvehiculos',
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
$('#marcanewvehiculo').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#newcarmodal"),
    placeholder: 'Escribe para buscar...',
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: '/select2/obtenermarcasvehiculos',
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


$('#modelonewvehiculo').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#newcarmodal"),
    placeholder: 'Escribe para buscar...',
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: '/select2/obtenermodelosvehiculo',
        dataType: 'json',
        data: function(params) {
            var query = {
                term: params.term,
                marcaid:$('#marcanewvehiculo').val(),
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

$('#colornewvehiculo').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#newcarmodal"),
    placeholder: 'Escribe para buscar...',
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: '/select2/obtenercoloresvehiculo',
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
$('#tiponewvehiculo').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#newcarmodal"),
    placeholder: 'Escribe para buscar...',
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: '/select2/obtenertipovehiculo',
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
$('#rsUbicacion2').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#recepcionservicio"),
    placeholder: 'Escribe para buscar...',
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: '/select2/obtenerubicaciones',
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
$('#rsCorrectivos').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#recepcionservicio"),
    placeholder: 'Escribe para buscar...',
    allowClear: true,
    minimumInputLength: 0,
    ajax: {
        url: '/select2/obtenertipovehiculo',
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
$('#marcanewvehiculo').on('change',function(){
    $('#modelonewvehiculo').val(null).empty().trigger('change');
})
$('#Conceptos_Select2').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#nuevosconceptos"),
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
$('#Tiposconceptos_Select2').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#nuevosconceptos"),
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
$('#Categoriaconceptos_Select2').select2({
    language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
    dropdownParent: $("#nuevosconceptos"),
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