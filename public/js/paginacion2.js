
let Page2 = 1;

function ShowPagination2(elements,paginas,item) {
    if(item){
        itemsPerPage=item;
    }
    const totalPages = Math.ceil(elements / itemsPerPage);
    const mpagina = Math.floor(paginas / 2);
    let paginationHTML = '';

    Page2 = Math.max(1, Math.min(Page2, totalPages)); // Asegura que `Page2` esté en el rango [1, totalPages]

    if (totalPages > 1) {
        // Botón "anterior"
        paginationHTML += (Page2 > 1) ?
            `<button class="pagina" data-page="${Page2 - 1}"><i class="fa-solid fa-left-long"></i></button>` :
            `<button class="paginad" disabled><i class="fa-solid fa-left-long"></i></button>`;

        // Página 1 siempre visible
        paginationHTML += (Page2 === 1) ?
            `<button class="paginaactive" data-page="1">1</button>` :
            `<button class="pagina" data-page="1">1</button>`;

        // Páginas intermedias
        for (let i = 2; i < totalPages; i++) {
            // Si es impar, mantenemos el rango centrado con el mismo número de páginas a cada lado.
            if (paginas % 2 !== 0) {
                if ((Page2 <= mpagina + 1 && i-1 <= paginas) || 
                    (Page2 >= totalPages - mpagina && i >= totalPages - paginas) || 
                    (i >= Page2 - mpagina && i <= Page2 + mpagina)) {
                    paginationHTML += (Page2 === i) ?
                        `<button class="paginaactive" data-page="${i}">${i}</button>` :
                        `<button class="pagina" data-page="${i}">${i}</button>`;
                }
            } 
            // Si es par, el margen debe ajustarse para mostrar una página adicional a la izquierda
            else {
                if ((Page2 <= mpagina + 1 && i-1 <= paginas) || 
                    (Page2 >= totalPages - mpagina && i >= totalPages - paginas) || 
                    (i >= Page2 - mpagina && i < Page2 + mpagina)) {
                    paginationHTML += (Page2 === i) ?
                        `<button class="paginaactive" data-page="${i}">${i}</button>` :
                        `<button class="pagina" data-page="${i}">${i}</button>`;
                }
            }
        }
        

        // Última página siempre visible
        paginationHTML += (Page2 === totalPages) ?
            `<button class="paginaactive" data-page="${totalPages}">${totalPages}</button>` :
            `<button class="pagina" data-page="${totalPages}">${totalPages}</button>`;

        // Botón "siguiente"
        paginationHTML += (Page2 < totalPages) ?
            `<button class="pagina" data-page="${Page2 + 1}"><i class="fa-solid fa-right-long"></i></button>` :
            `<button class="paginad" disabled><i class="fa-solid fa-right-long"></i></button>`;
    }

    $('#pagination2').html(paginationHTML);
}

// Eventos de cambio de página y de elementos por página
$('#pagination2').on('click', '.pagina', function() {
    Page2 = parseInt($(this).data('page'));
    executeshowElements2();
});


