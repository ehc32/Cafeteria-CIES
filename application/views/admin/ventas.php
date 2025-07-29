<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Cargar Vista de Header -->
<?php $this->load->view("admin/includes/_header"); ?>

<!-- CSS específico para ventas -->
<link rel="stylesheet" href="<?php echo base_url('assets/Css/ventas.css'); ?>">

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
                                        <h3 class="nk-block-title page-title">Modulo de ventas | <strong class="text-primary small">SENACoffe</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/inicio">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/ventas">ventas</a></li>
                                                <li class="breadcrumb-item active">Registro y administración ventas</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="<?php echo base_url() ?>admin/inicio" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Regresar</span></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            
                            <!-- include message block -->
                            <?php $this->load->view('admin/partials/_mesagges'); ?>

                            <!-- Formulario de filtros -->
                            <?php echo form_open_multipart('ventas_register_controller/listar_ventas_filtradas', ['class' => 'ventas-filters']); ?>
                            <input type="hidden" name="form" value="1">
                            <div class="row mt-3">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label" for="fechaInicio">Fecha de inicio</label>
                                        <div class="form-control-wrap focused">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                            <input type="text" id="fechaInicio" name="fechaInicio" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?php echo isset($fecha_inicio) ? $fecha_inicio : ''; ?>">
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
                                            <input type="text" id="fechaFinal" name="fechaFinal" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?php echo isset($fecha_final) ? $fecha_final : ''; ?>">
                                        </div>
                                        <div class="form-note">Formato de fecha <code>yyyy-mm-dd</code></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Acciones</label>
                                        <li class="">
                                            <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                                            <a href="<?php echo base_url('admin/ventas'); ?>" class="btn btn-outline-secondary">Limpiar</a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>

                        </div>

                        <!-- Tabla de ventas -->
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <table id="ventas-table" class="nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr>
                                                <th>Producto Vendido</th>
                                                <th>Valor Unitario</th>
                                                <th>Cantidad</th>
                                                <th>Valor Total</th>
                                                <th>Descuento</th>
                                                <th>Fecha de venta</th>
                                                <th>Vendedor</th>
                                                <th>Num. Referencia</th>
                                                <th>Imprimir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Los datos se cargarán dinámicamente via AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de edición -->
<div class="modal fade modal-ventas" id="modalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Información de venta registrada</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <?php echo form_open('ventas_register_controller/change_venta_post'); ?>
                <input type="hidden" name="venta_id" id="venta_id">

                <div class="form-group">
                    <label class="form-label">Categoria</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="categoria" name="categoria" placeholder="Categoria del producto vendido" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Producto Vendido</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="producto_vendido" name="producto_vendido" placeholder="Producto vendido" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Valor Unitario</label>
                    <div class="form-control-wrap">
                        <input type="number" autocomplete="off" class="form-control form-control-lg" id="valor_unitario" name="valor_unitario" placeholder="Valor unitario del producto" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Cantidad</label>
                    <div class="form-control-wrap">
                        <input type="number" autocomplete="off" class="form-control form-control-lg" id="cantidad" name="cantidad" placeholder="Cantidad" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Descuento</label>
                    <div class="form-control-wrap">
                        <input type="number" autocomplete="off" class="form-control form-control-lg" id="descuento" name="descuento" placeholder="Descuento (Si aplica)" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Valor Total</label>
                    <div class="form-control-wrap">
                        <input type="number" autocomplete="off" class="form-control form-control-lg" id="valor_total" name="valor_total" placeholder="Valor total" required readonly>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-outline-primary">Guardar los cambios</button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>

<!-- JavaScript específico para ventas -->
<script>
    // Variable global para la URL base
    const baseUrl = '<?php echo base_url(); ?>';
</script>
<script src="<?php echo base_url('assets/js/ventas.js'); ?>"></script>

</html>