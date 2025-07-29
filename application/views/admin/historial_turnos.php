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
                                        <h3 class="nk-block-title page-title">Historial Turnos | <strong class="text-primary small">SENACoffe</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/inicio">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/ventas">ventas</a></li>
                                                <li class="breadcrumb-item active">Historico entrega de turnos</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">

                                        <a href="<?php echo base_url() ?>admin/inicio" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Regresar</span></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <!-- form start -->
                            <!-- include message block -->
                            <?php $this->load->view('admin/partials/_mesagges'); ?>

                            <?php echo form_open_multipart('entrega_controller/listar_historial_filtrado'); ?>
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
                            </div>
                            <?php echo form_close(); ?><!-- form end -->

                        </div>
                        <div class="nk-block nk-block-lg">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <!-- Tabla -->
                                    <table class="datatable-init-export nowrap table" data-export-title="Export">
                                        <thead>
                                            <tr>
                                                <th>Vendedor</th>
                                                <th>Total Ventas</th>
                                                <th>Pagos a proovedores</th>
                                                <th>Saldo final Caja</th>
                                                <th>Fecha entrega del turno</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($historico as $turno) : ?>
                                                <tr>
                                                    <td><?php echo $turno->username; ?></td>
                                                    <td>$<?php echo number_format($turno->total_ventas, 0, '.', ''); ?></td>
                                                    <td>$<?php echo number_format($turno->pagos, 0, '.', ''); ?></td>
                                                    <td>$<?php echo number_format($turno->saldo_final_caja, 0, '.', ''); ?></td>
                                                    <td><?php echo $turno->created; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
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

</html>