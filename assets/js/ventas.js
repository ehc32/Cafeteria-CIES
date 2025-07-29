/**
 * ===================================
 * JAVASCRIPT PARA EL MÓDULO DE VENTAS
 * ===================================
 * 
 * Este archivo contiene todas las funciones JavaScript
 * necesarias para el funcionamiento del módulo de ventas
 */

// ===================================
// VARIABLES GLOBALES
// ===================================
let ventasTable;

// ===================================
// FUNCIONES DE EDICIÓN DE VENTAS
// ===================================

/**
 * Abre el modal de edición de venta
 * @param {number} id - ID de la venta
 * @param {string} categoria - Categoría del producto
 * @param {string} producto_vendido - Nombre del producto
 * @param {number} valor_unitario - Valor unitario
 * @param {number} cantidad - Cantidad vendida
 * @param {number} descuento - Descuento aplicado
 */
function editVenta(id, categoria, producto_vendido, valor_unitario, cantidad, descuento) {
    // Mostrar modal
    const modalEdit = new bootstrap.Modal(document.getElementById('modalForm'), {});
    modalEdit.show();
    
    // Llenar campos del formulario
    document.getElementById('venta_id').value = id;
    document.getElementById('categoria').value = categoria;
    document.getElementById('producto_vendido').value = producto_vendido;
    document.getElementById('valor_unitario').value = valor_unitario;
    document.getElementById('cantidad').value = cantidad;
    document.getElementById('descuento').value = descuento;

    // Calcular valor total inicial
    calcularValorTotal();

    // Agregar eventos para cálculo automático
    setupCalculoAutomatico();
}

/**
 * Calcula el valor total de la venta
 */
function calcularValorTotal() {
    const cantidad = parseFloat($('#cantidad').val()) || 0;
    const descuento = parseFloat($('#descuento').val()) || 0;
    const valor_unitario = parseFloat($('#valor_unitario').val()) || 0;

    if (cantidad && valor_unitario) {
        const valor_total = (valor_unitario * cantidad) - descuento;
        $('#valor_total').val(valor_total);
    }
}

/**
 * Configura el cálculo automático del valor total
 */
function setupCalculoAutomatico() {
    // Remover eventos anteriores para evitar duplicados
    $('#cantidad, #descuento').off('change keyup');
    
    // Agregar eventos para cálculo automático
    $('#cantidad, #descuento').on('change keyup', function() {
        calcularValorTotal();
    });
}

// ===================================
// INICIALIZACIÓN DEL DATA TABLE
// ===================================

/**
 * Inicializa el DataTable de ventas
 */
function inicializarDataTable() {
    // Verificar si la tabla ya está inicializada
    if ($.fn.DataTable.isDataTable('#ventas-table')) {
        $('#ventas-table').DataTable().destroy();
    }

    // Configurar DataTable con Server-Side Processing
    ventasTable = $('#ventas-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": baseUrl + 'admin/ventas/get_ventas_ajax',
            "type": "POST",
            "data": function(d) {
                // Agregar filtros de fecha
                d.fecha_inicio = $('#fechaInicio').val();
                d.fecha_final = $('#fechaFinal').val();
            }
        },
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        "deferRender": true,
        "order": [[5, "desc"]], // Ordenar por fecha descendente
        "responsive": {
            "details": {
                "display": $.fn.dataTable.Responsive.display.modal({
                    "header": function(row) {
                        var data = row.data();
                        return 'Detalles de la venta: ' + data[0];
                    }
                }),
                "renderer": $.fn.dataTable.Responsive.renderer.tableAll()
            }
        },
        "autoWidth": true,
        "scrollX": false,
        "scrollCollapse": false,
        "dom": '<"row"<"col-sm-12 col-md-6"f><"col-sm-12 col-md-6"<"d-flex justify-content-end"<"d-flex align-items-center"l><"ms-3"B>>>>' +
               '<"row"<"col-sm-12"tr>>' +
               '<"row"<"col-sm-12 col-md-7"p><"col-sm-12 col-md-5"i>>',
        "buttons": [
            {
                extend: 'copy',
                text: '<em class="icon ni ni-copy"></em>',
                className: 'btn btn-outline-primary btn-sm'
            },
            {
                extend: 'excel',
                text: '<em class="icon ni ni-file-xls"></em>',
                className: 'btn btn-outline-success btn-sm'
            },
            {
                extend: 'csv',
                text: '<em class="icon ni ni-file-csv"></em>',
                className: 'btn btn-outline-info btn-sm'
            },
            {
                extend: 'pdf',
                text: '<em class="icon ni ni-file-pdf"></em>',
                className: 'btn btn-outline-danger btn-sm'
            }
        ],
        "language": {
            "search": "",
            "searchPlaceholder": "Buscar en ventas...",
            "lengthMenu": "<span class='d-none d-sm-inline-block'>Mostrar</span><div class='form-control-select'> _MENU_ </div>",
            "info": "_START_ -_END_ de _TOTAL_",
            "infoEmpty": "No se encontraron registros",
            "infoFiltered": "( Total _MAX_ )",
            "processing": "<em class='icon ni ni-loader'></em> Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último", 
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
}

// ===================================
// FUNCIONES DE VALIDACIÓN
// ===================================

/**
 * Valida las fechas del formulario de filtro
 * @param {Event} e - Evento del formulario
 * @returns {boolean} - True si las fechas son válidas
 */
function validarFechas(e) {
    const fechaInicio = $('#fechaInicio').val();
    const fechaFinal = $('#fechaFinal').val();
    
    if (fechaInicio && fechaFinal) {
        if (fechaInicio > fechaFinal) {
            e.preventDefault();
            mostrarAlerta('La fecha de inicio no puede ser mayor que la fecha final', 'error');
            return false;
        }
    }
    return true;
}

/**
 * Muestra una alerta personalizada
 * @param {string} mensaje - Mensaje a mostrar
 * @param {string} tipo - Tipo de alerta (success, error, warning, info)
 */
function mostrarAlerta(mensaje, tipo = 'info') {
    // Puedes usar tu librería de alertas preferida aquí
    alert(mensaje);
}

// ===================================
// INICIALIZACIÓN DE COMPONENTES
// ===================================

/**
 * Inicializa los date pickers
 */
function inicializarDatePickers() {
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        language: 'es'
    });
}

/**
 * Configura los eventos del formulario
 */
function configurarEventosFormulario() {
    // Validación de fechas en el formulario de filtro
    $('form').on('submit', function(e) {
        if (!validarFechas(e)) {
            return false;
        }
        
        // Recargar tabla cuando se apliquen filtros
        e.preventDefault();
        if (ventasTable) {
            ventasTable.ajax.reload();
        }
    });
}

// ===================================
// FUNCIÓN PRINCIPAL DE INICIALIZACIÓN
// ===================================

/**
 * Función principal que se ejecuta cuando el DOM está listo
 */
$(document).ready(function() {
    // Inicializar componentes
    inicializarDatePickers();
    configurarEventosFormulario();
    
    // Esperar un poco para asegurar que no hay conflictos con la inicialización del tema
    setTimeout(function() {
        inicializarDataTable();
    }, 100);
});

// ===================================
// EXPORTAR FUNCIONES (si es necesario)
// ===================================
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        editVenta,
        calcularValorTotal,
        inicializarDataTable,
        validarFechas,
        mostrarAlerta
    };
} 