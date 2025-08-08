<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Cargar Vista de Header -->
<?php $this->load->view("admin/includes/_header"); ?>
<div class="nk-app-root">
    <!-- Cargar Vista de Sidebar -->
    <?php $this->load->view("admin/includes/_sidebar"); ?>
    <!-- main @s -->
    <div class="nk-main">
        <!-- wrap @s -->
        <div class="nk-wrap">
            <!-- main header @s -->
            <?php $this->load->view("admin/includes/_main-header"); ?>
            <!-- main header @e -->
            <!-- content @s -->
            <div class="nk-content">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Gestión de Recetas | <strong class="text-primary small">SENACoffe</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/inicio">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/recetas">Recetas</a></li>
                                                <li class="breadcrumb-item active">Administración de recetas</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <?php if ($this->session->userdata("is_superuser") === "1") : ?>
                                            <button type="button" class="btn btn-primary" onclick="addReceta()">
                                                <em class="icon ni ni-plus"></em> Nueva Receta
                                            </button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-outline-primary" onclick="recalcularCostos()">
                                            <em class="icon ni ni-reload"></em> Recalcular Costos
                                        </button>
                                        <a href="<?php echo base_url() ?>admin/inicio" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                            <em class="icon ni ni-arrow-left"></em><span>Regresar</span>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            
                            <?php $this->load->view('admin/partials/_mesagges'); ?>
                            
                            <!-- Filtros de búsqueda -->
                            <div class="nk-block">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Buscar Receta</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" id="searchReceta" class="form-control" placeholder="Nombre o número de receta...">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-label">Filtrar por Categoría</label>
                                                    <select id="filterCategoria" class="form-control">
                                                        <option value="">Todas las categorías</option>
                                                        <option value="Panaderia">Panadería</option>
                                                        <option value="Agroindustria">Agroindustria</option>
                                                        <option value="Otros">Otros</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button type="button" class="btn btn-primary btn-block" onclick="buscarRecetas()">
                                                        <em class="icon ni ni-search"></em> Buscar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de Recetas -->
                            <div class="nk-block">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <table class="datatable-init nowrap table" data-export-title="Recetas">
                                            <thead>
                                                <tr>
                                                    <th>Número</th>
                                                    <th>Nombre</th>
                                                    <th>Porciones</th>
                                                    <th>Costo Ingredientes</th>
                                                    <th>Margen %</th>
                                                    <th>Costo Total</th>
                                                    <th>Costo/Porción</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabla-recetas">
                                                <?php foreach($recetas as $receta): ?>
                                                <tr>
                                                    <td><?php echo $receta->numero_receta; ?></td>
                                                    <td><?php echo $receta->nombre; ?></td>
                                                    <td><?php echo $receta->numero_porciones; ?></td>
                                                    <td>$<?php echo number_format($receta->costo_total_ingredientes, 2); ?></td>
                                                    <td><?php echo $receta->margen_variacion; ?>%</td>
                                                    <td>$<?php echo number_format($receta->costo_total_preparacion, 2); ?></td>
                                                    <td>$<?php echo number_format($receta->costo_por_porcion, 2); ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                                                <em class="icon ni ni-more-h"></em>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li>
                                                                        <a href="javascript:void(0)" onclick="viewReceta(<?php echo $receta->id; ?>)">
                                                                            <em class="icon ni ni-eye"></em><span>Ver Detalle</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0)" onclick="editReceta(<?php echo $receta->id; ?>)">
                                                                            <em class="icon ni ni-edit"></em><span>Editar</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:void(0)" onclick="duplicarReceta(<?php echo $receta->id; ?>)">
                                                                            <em class="icon ni ni-copy"></em><span>Duplicar</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php if ($this->session->userdata("is_superuser") === "1") : ?>
                                                                    <li class="divider"></li>
                                                                    <li>
                                                                        <a href="javascript:void(0)" onclick="deleteReceta(<?php echo $receta->id; ?>)">
                                                                            <em class="icon ni ni-trash"></em><span>Eliminar</span>
                                                                        </a>
                                                                    </li>
                                                                    <?php endif; ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Form Receta -->
                            <div class="modal fade" id="modalRecetaForm" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalRecetaFormTitle">Nueva Receta</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open('admin/recetas/add', array('id' => 'recetaForm')); ?>
                                            <input type="hidden" name="receta_id" id="receta_id">
                                            
                                            <!-- Información básica -->
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nombre de la Receta *</label>
                                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Número de Receta *</label>
                                                        <input type="text" class="form-control" id="numero_receta" name="numero_receta" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Porciones *</label>
                                                        <input type="number" class="form-control" id="numero_porciones" name="numero_porciones" min="1" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label class="form-label">Descripción</label>
                                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="2"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Margen Variación %</label>
                                                        <input type="number" class="form-control" id="margen_variacion" name="margen_variacion" step="0.01" min="0" value="5">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sección de Ingredientes -->
                                            <div class="form-group">
                                                <label class="form-label d-flex justify-content-between">
                                                    <span>Ingredientes</span>
                                                    <button type="button" class="btn btn-sm btn-primary" onclick="addIngrediente()">
                                                        <em class="icon ni ni-plus"></em> Agregar Ingrediente
                                                    </button>
                                                </label>
                                                <div id="ingredientes-container">
                                                    <!-- Los ingredientes se agregarán dinámicamente aquí -->
                                                </div>
                                            </div>

                                            <!-- Resumen de costos -->
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <h6 class="card-title">Resumen de Costos</h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Costo Ingredientes</label>
                                                                <div class="form-control-plaintext">$<span id="costo_ingredientes">0.00</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Costo Total</label>
                                                                <div class="form-control-plaintext">$<span id="costo_total">0.00</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label">Costo por Porción</label>
                                                                <div class="form-control-plaintext">$<span id="costo_porcion">0.00</span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mt-3">
                                                <button type="submit" class="btn btn-primary" id="submit-button">Guardar Receta</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Form end -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
        </div>
        <!-- wrap @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->

<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>

<script>
// Variables globales
var modalRecetaForm = new bootstrap.Modal(document.getElementById('modalRecetaForm'));
var ingredienteCount = 0;
var productosDisponibles = <?php echo json_encode($productos); ?>;
// Trabajaremos solo con productos del inventario para definir ingredientes

// Función para agregar nueva receta
function addReceta() {
    $('#recetaForm').attr('action', '<?php echo base_url(); ?>admin/recetas/add');
    $('#receta_id').val('');
    $('#recetaForm')[0].reset();
    $('#ingredientes-container').html('');
    $('#modalRecetaFormTitle').text('Nueva Receta');
    $('#submit-button').text('Guardar Receta');
    ingredienteCount = 0;
    addIngrediente(); // Agregar al menos un ingrediente
    modalRecetaForm.show();
}

// Función para editar receta
function editReceta(id) {
    $.ajax({
        url: '<?php echo base_url(); ?>admin/recetas/get_receta',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                var receta = response.data;
                $('#recetaForm').attr('action', '<?php echo base_url(); ?>admin/recetas/update/' + id);
                $('#receta_id').val(receta.id);
                $('#nombre').val(receta.nombre);
                $('#numero_receta').val(receta.numero_receta);
                $('#numero_porciones').val(receta.numero_porciones);
                $('#descripcion').val(receta.descripcion);
                $('#margen_variacion').val(receta.margen_variacion);
                
                // Cargar ingredientes
                $('#ingredientes-container').html('');
                ingredienteCount = 0;
                if (receta.ingredientes && receta.ingredientes.length > 0) {
                    receta.ingredientes.forEach(function(ing) {
                        addIngrediente(ing);
                    });
                } else {
                    addIngrediente();
                }
                
                $('#modalRecetaFormTitle').text('Editar Receta');
                $('#submit-button').text('Actualizar Receta');
                calcularCostos();
                modalRecetaForm.show();
            }
        }
    });
}

// Función para agregar ingrediente
function addIngrediente(data = null) {
    ingredienteCount++;
    var html = `
        <div class="ingrediente-row mb-2" id="ingrediente_${ingredienteCount}">
            <div class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label small mb-1">Producto (inventario)</label>
                    <select class="form-control producto-select" name="ingredientes[${ingredienteCount}][producto_id]" 
                            onchange="updateValorUnitario(${ingredienteCount})" id="producto_${ingredienteCount}">
                        <option value="">Seleccionar producto...</option>`;

    productosDisponibles.forEach(function(prod) {
        var selected = (data && data.producto_id == prod.id) ? 'selected' : '';
        html += `<option value="${prod.id}" data-valor="${prod.valor_unitario}" data-nombre="${prod.nombre}" ${selected}>
                    ${prod.nombre} (${prod.presentacion})
                 </option>`;
    });

    html += `
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="ingredientes[${ingredienteCount}][cantidad]" 
                           placeholder="Cantidad" step="0.01" min="0" value="${data ? data.cantidad : ''}"
                           onchange="calcularCostos()" id="cantidad_${ingredienteCount}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="ingredientes[${ingredienteCount}][unidad]" 
                           placeholder="Unidad" value="${data ? data.unidad : ''}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="subtotal_${ingredienteCount}" 
                           value="$0.00" readonly>
                </div>
                <input type="hidden" name="ingredientes[${ingredienteCount}][valor_unitario]" id="valor_unitario_${ingredienteCount}" value="${data && data.valor_unitario ? data.valor_unitario : ''}">
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeIngrediente(${ingredienteCount})">
                        <em class="icon ni ni-trash"></em>
                    </button>
                </div>
            </div>
        </div>`;
    
    $('#ingredientes-container').append(html);
    
    // Ajustar el valor unitario inicial
    updateValorUnitario(ingredienteCount, true);
}

// Función para remover ingrediente
function removeIngrediente(id) {
    $('#ingrediente_' + id).remove();
    calcularCostos();
}

// Función para actualizar valor unitario
function updateValorUnitario(id, fromData=false) {
    var valorUnitario = 0;
    if (fromData) {
        var preset = parseFloat($('#valor_unitario_' + id).val());
        if (!isNaN(preset) && preset > 0) {
            valorUnitario = preset;
        }
    }
    if (valorUnitario === 0) {
        var selected = $('#producto_' + id).find(':selected');
        valorUnitario = parseFloat(selected.data('valor')) || 0;
    }
    $('#valor_unitario_' + id).val(valorUnitario);
    calcularCostos();
}

// Sin integración con catálogo de ventas: todo se basa en inventario

// Función para calcular costos
function calcularCostos() {
    var costoTotal = 0;
    
    $('.ingrediente-row').each(function() {
        var id = $(this).attr('id').replace('ingrediente_', '');
        var cantidad = parseFloat($('#cantidad_' + id).val()) || 0;
        var valorUnitario = parseFloat($('#valor_unitario_' + id).val()) || 0;
        var subtotal = cantidad * valorUnitario;
        
        $('#subtotal_' + id).val('$' + subtotal.toFixed(2));
        costoTotal += subtotal;
    });
    
    var margen = parseFloat($('#margen_variacion').val()) || 0;
    // Cálculo requerido: costo total preparación = costo ingredientes + margen (5% por defecto)
    var costoConMargen = costoTotal + (costoTotal * (margen / 100));
    var porciones = parseFloat($('#numero_porciones').val()) || 1;
    var costoPorcion = costoConMargen / porciones;
    
    $('#costo_ingredientes').text(costoTotal.toFixed(2));
    $('#costo_total').text(costoConMargen.toFixed(2));
    $('#costo_porcion').text(costoPorcion.toFixed(2));
}

// Función para ver detalle de receta
function viewReceta(id) {
    window.location.href = '<?php echo base_url(); ?>admin/recetas/view/' + id;
}

// Función para duplicar receta
function duplicarReceta(id) {
    if (confirm('¿Está seguro de que desea duplicar esta receta?')) {
        window.location.href = '<?php echo base_url(); ?>admin/recetas/duplicar/' + id;
    }
}

// Función para eliminar receta
function deleteReceta(id) {
    if (confirm('¿Está seguro de que desea eliminar esta receta? Esta acción no se puede deshacer.')) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/recetas/delete',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            }
        });
    }
}

// Función para buscar recetas
function buscarRecetas() {
    var searchTerm = $('#searchReceta').val();
    
    if (searchTerm.length > 0) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/recetas/search',
            type: 'POST',
            data: { search_term: searchTerm },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    // Actualizar tabla con resultados
                    updateTablaRecetas(response.data);
                }
            }
        });
    } else {
        location.reload();
    }
}

// Función para actualizar tabla de recetas
function updateTablaRecetas(recetas) {
    var html = '';
    recetas.forEach(function(receta) {
        html += `
            <tr>
                <td>${receta.numero_receta}</td>
                <td>${receta.nombre}</td>
                <td>${receta.numero_porciones}</td>
                <td>$${parseFloat(receta.costo_total_ingredientes).toFixed(2)}</td>
                <td>${receta.margen_variacion}%</td>
                <td>$${parseFloat(receta.costo_total_preparacion).toFixed(2)}</td>
                <td>$${parseFloat(receta.costo_por_porcion).toFixed(2)}</td>
                <td>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                            <em class="icon ni ni-more-h"></em>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="link-list-opt no-bdr">
                                <li><a href="javascript:void(0)" onclick="viewReceta(${receta.id})">
                                    <em class="icon ni ni-eye"></em><span>Ver</span></a></li>
                                <li><a href="javascript:void(0)" onclick="editReceta(${receta.id})">
                                    <em class="icon ni ni-edit"></em><span>Editar</span></a></li>
                                <li><a href="javascript:void(0)" onclick="deleteReceta(${receta.id})">
                                    <em class="icon ni ni-trash"></em><span>Eliminar</span></a></li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>`;
    });
    $('#tabla-recetas').html(html);
}

// Función para recalcular costos de todas las recetas
function recalcularCostos() {
    if (confirm('¿Desea recalcular los costos de todas las recetas con los precios actuales del inventario?')) {
        window.location.href = '<?php echo base_url(); ?>admin/recetas/recalcular_costos';
    }
}

// Eventos
$(document).ready(function() {
    // Actualizar costos cuando cambian los valores
    $('#numero_porciones, #margen_variacion').on('input', function() {
        calcularCostos();
    });
    
    // Búsqueda en tiempo real
    $('#searchReceta').on('keyup', function(e) {
        if (e.keyCode === 13) {
            buscarRecetas();
        }
    });
});
</script>

</body>
</html>