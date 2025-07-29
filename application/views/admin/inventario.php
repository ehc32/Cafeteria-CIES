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
                                        <h3 class="nk-block-title page-title">Inventario de productos | <strong class="text-primary small">SENACoffe</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/inicio">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/inventario">Inventario</a></li>
                                                <li class="breadcrumb-item active">Registro y administración de inventario</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <?php if ($this->session->userdata("is_superuser") === "1") : ?>
                                            <button type="button" class="btn btn-primary" onclick="addProduct()">Agregar Producto</button>
                                        <?php endif; ?>

                                        <a href="<?php echo base_url() ?>admin/inicio" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Regresar</span></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <?php $this->load->view('admin/partials/_mesagges'); ?>
                            <?php echo form_open_multipart(current_url()); ?>
                            <input type="hidden" name="form" value="1">
                            <div class="row mt-3">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label" for="fechaInicio">Fecha de inicio</label>
                                        <div class="form-control-wrap focused">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="fechaInicio" name="fechaInicio" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?php echo old('fechaInicio') ?>">
                                        </div>
                                        <div class="form-note">Formato de fecha <code>yyyy-mm-dd</code></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label" for="fechaFinal">Fecha de fin</label>
                                        <div class="form-control-wrap focused">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="fechaFinal" name="fechaFinal" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?php echo old('fechaFinal') ?>">
                                        </div>
                                        <div class="form-note">Formato de fecha <code>yyyy-mm-dd</code></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Acciones</label>
                                        <li class="">
                                            <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                                        </li>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Sede</label>
                                        <select name="sede" class="form-control" id="sede">
                                            <option value="">Seleccione una sede</option>
                                            <option value="CIES">CIES</option>
                                            <option value="Comercio">Comercio</option>
                                        </select><br>
                                    </div>
                                </div>
                            </div>


                            <div id="datos-inventario"></div>
                            <?php echo form_close(); ?>
                        </div>
                        <div id="datos-inventario"></div>
                        <!-- Modal Form -->
                        <div class="modal fade" id="modalProductForm" tabindex="-1" role="dialog" aria-labelledby="modalProductFormTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalProductFormTitle">Agregar/Editar Producto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form start -->
                                        <?php echo form_open_multipart('inventario_controller/registerProduct'); ?>

                                        <input type="hidden" name="product_id" id="product_id">

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-3 offset-0">
                                                <div class="form-group">
                                                    <label class="form-label">Nombre del producto</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="nombre" name="nombre" placeholder="Nombre del producto" required=""
                                                            <?php if ($this->session->userdata("is_superuser") !== "1") : ?>disabled<?php endif; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-3 offset-0">
                                                <div class="form-group">
                                                    <label class="form-label">Presentación</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select class="form-select" data-placeholder="Seleccione la presentación" id="presentacion" name="presentacion" required=""
                                                            <?php if ($this->session->userdata("is_superuser") !== "1") : ?>disabled<?php endif; ?>>
                                                            <option value="Unidad">Unidad</option>
                                                            <option value="Mililitros">Mililitros</option>
                                                            <option value="Rollo">Rollo</option>
                                                            <option value="Paquete">Paquete</option>
                                                            <option value="Sobre">Sobre</option>
                                                            <option value="Gramos">Gramos</option>
                                                            <option value="Libras">Libras</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-3 offset-0">
                                                <div class="form-group">
                                                    <label class="form-label">Cantidad</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="number" autocomplete="off" class="form-control form-control-lg" id="cantidad" name="cantidad" placeholder="Ingrese la cantidad" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 align-center">
                                            <div class="col-lg-3 offset-0">
                                                <div class="form-group">
                                                    <label class="form-label">Categoría</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 mb-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select class="form-select" data-placeholder="Seleccione la categoría" id="categoria" name="categoria" required=""
                                                            <?php if ($this->session->userdata("is_superuser") !== "1") : ?>disabled<?php endif; ?>>
                                                            <option value="Panaderia">Panadería</option>
                                                            <option value="Agroindustria">Agroindustria</option>
                                                            <option value="Materia prima">Materia prima</option>
                                                            <option value="Insumos desechables y aseo">Insumos desechables y aseo</option>
                                                            <option value="Otros">Otros</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="sede" id="hidden_sede">
                                        <div class="row g-gs">
                                            <div class="col-md-12 mt-3">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-lg btn-outline-primary" id="submit-button">Agregar producto</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Form end -->

                    </div>
                    <div class="nk-block nk-block-lg">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <!-- Tabla -->
                                <table class="datatable-init-export nowrap table" data-export-title="Export">
                                    <thead>
                                        <tr>

                                            <th>Nombre del producto</th>
                                            <th>Presentación</th>
                                            <th>Cantidad</th>
                                            <th>Categoría</th>
                                            <th>Fecha de reporte</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-productos">

                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div>
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
</body>
<script>
    // Inicializa el modal
    var modalProductForm = new bootstrap.Modal(document.getElementById('modalProductForm'));

    const sedeSelect = document.getElementById('sede');
    const hiddenSedeInput = document.getElementById('hidden_sede');
    sedeSelect.addEventListener('change', function() {
        hiddenSedeInput.value = this.value;
    });
    // Función para abrir el modal en modo de edición
    function editProduct(id, nombre, presentacion, cantidad, categoria, sede) {
        modalProductForm.show();
        document.getElementById('product_id').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('cantidad').value = cantidad;
        const sedeSelect = document.getElementById('sede');
        sedeSelect.value = sede;

        // Actualizar el campo oculto de sede
        const hiddenSedeInput = document.getElementById('sede');
        hiddenSedeInput.value = sede;

        const presentacionSelect = document.getElementById('presentacion');
        if (presentacionSelect.querySelector(`option[value="${presentacion}"]`)) {
            presentacionSelect.value = presentacion;
        } else {
            const newOption = new Option(presentacion, presentacion);
            presentacionSelect.add(newOption);
            presentacionSelect.value = presentacion;
        }
        const categoriaSelect = document.getElementById('categoria');
        if (categoriaSelect.querySelector(`option[value="${categoria}"]`)) {
            categoriaSelect.value = categoria;
        } else {
            const newOption = new Option(categoria, categoria);
            categoriaSelect.add(newOption);
            categoriaSelect.value = categoria;
        }

        document.getElementById('modalProductFormTitle').innerText = 'Editar Producto';
        document.getElementById('submit-button').innerText = 'Actualizar Producto';
    }

    // Función para abrir el modal en modo de agregar nuevo producto
    function addProduct() {
        modalProductForm.show();

        document.getElementById('product_id').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('presentacion').value = '';
        document.getElementById('cantidad').value = '';
        document.getElementById('categoria').value = '';

        document.getElementById('modalProductFormTitle').innerText = 'Agregar Nuevo Producto';
        document.getElementById('submit-button').innerText = 'Agregar producto';
    }




    $(document).ready(function() {
        $('#sede').change(function() {
            var sede = $(this).val();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('Inventario_controller/get_productos_by_sede'); ?>',
                data: {
                    sede: sede
                },
                dataType: 'json',
                success: function(data) {
                    var html = '';

                    $.each(data, function(index, item) {
                        html += `
                        <tr>
                            <td>` + item.nombre + `</td>
                            <td>` + item.presentacion + `</td>
                            <td>` + item.cantidad + `</td>
                            <td>` + item.categoria + `</td>
                            <td>` + item.created + `</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary" id="edit" onclick="editProduct(
                                    '` + item.id + `', 
                                    '` + item.nombre + `',
                                    '` + item.presentacion + `',
                                    '` + item.cantidad + `',
                                    '` + item.categoria + `',
                                    '` + item.sede + `' 

                                );">Editar</a>
                                
                                <?php if ($this->session->userdata("is_superuser") === "1") : ?>
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_item(
                                        '` + base_url + `admin/inventario/delete/` + item.id + `',
                                        '` + item.id + `',
                                        'Producto eliminado correctamente!',
                                        '` + item.sede + `'
                                    );">Eliminar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    `;
                    });

                    $('#tabla-productos').html(html);
                },
                error: function(xhr, status, error) {
                    console.log('Error AJAX:', error);
                }
            });
        });
    });
</script>


</html>