<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Cargar Vista de Header -->
<?php $this->load->view("admin/includes/_header"); ?>
<div class="nk-app-root">
    <!-- Cargar Vista de Sidebar -->
    <?php $this->load->view("admin/includes/_sidebar"); ?>
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php $this->load->view("admin/includes/_main-header"); ?>
            <!-- main header @e -->
            <!-- content @s -->
            <div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Clientes | <strong class="text-primary small">Registrados</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/inicio">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/clientes_add">Clientes</a></li>
                                                <li class="breadcrumb-item active">Lista de Clientes registrados</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="<?php echo base_url(); ?>admin/user-add" class="btn btn-icon btn-outline-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                                        <a href="<?php echo base_url(); ?>admin/user-add" class="btn btn-outline-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Nuevo</span></a>
                                    </div><!-- .nk-block-head-content -->
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">

                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Lista de Clientes registrados</h4>
                                        <div class="nk-block-des">
                                            <strong class="text-dark">Nota:</strong> podrá editar, eliminar, activar, desactivar, etc. cada uno de los Clientes registrados.
                                        </div>
                                    </div>
                                </div>

                                <!-- include message block -->
                                <?php $this->load->view('admin/partials/_mesagges'); ?>

                                <div class="nk-block nk-block-lg">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <!-- Tabla -->
                                            <table class="datatable-init-export nowrap table" data-export-title="Export">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Nombre</th>
                                                        <th>Identificación</th>
                                                        <th>Correo</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($clientes)) : ?>
                                                        <?php foreach ($clientes as $cliente) : ?>
                                                            <tr>
                                                                <td> <?php echo $cliente->id ?> </td>
                                                                <td>
                                                                    <?php echo $cliente->nombre; ?>
                                                                </td>
                                                                <td><?php echo $cliente->identificacion; ?></td>
                                                                <td><?php echo $cliente->correo; ?></td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-outline-primary" data-toggle="dropdown" aria-expanded="false"><span>Seleccione</span><em class="icon ni ni-chevron-down"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-auto mt-1">
                                                                            <ul class="link-list-plain">
                                                                                <li><a onclick="editClient(
                                                                                    '<?php echo $cliente->id; ?>', 
                                                                                    '<?php echo $cliente->nombre; ?>',
                                                                                    '<?php echo $cliente->identificacion; ?>',
                                                                                    '<?php echo $cliente->correo; ?>',
                                                                                )"><em class="icon ni ni-user-alt-fill text-blue"></em> Editar</a></li>

                                                                                <li>
                                                                                    <a href="javascript:void(0)" class="disabled text-danger" onclick="delete_item(
                                                                                    '<?php echo base_url(); ?>admin/clientes_add/delete/<?php echo html_escape($cliente->id); ?>',
                                                                                    '<?php echo html_escape($cliente->id); ?>',
                                                                                    'Cliente eliminado correctamente!'
                                                                                );"><em class="icon ni ni-trash-empty-fill text-danger"></em>Eliminar</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div><!-- .card-preview -->
                                </div>

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
<!-- Modal Form -->
<div class="modal fade" id="modalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Información del cliente</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">

                <?php echo form_open('clientes_controller/change_cliente_post'); ?> <!-- form -->

                <input type="hidden" name="cliente_id" id="cliente_id">

                <div class="form-group">
                    <label class="form-label">Nombre completo</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="nombre" name="nombre" placeholder="Nombre completo">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Identificación</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="identificacion" name="identificacion" placeholder="Identificación">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <div class="form-control-wrap">
                        <input type="email" autocomplete="off" class="form-control form-control-lg" id="correo" name="correo" placeholder="Correo electrónico" required>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-outline-primary">Guardar los cambios</button>
                </div>

                <?php echo form_close(); ?><!-- form end -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Form end -->


<script>
    function editClient(id, nombre, identificacion, correo) {
        const modalEdit = new bootstrap.Modal(document.getElementById('modalForm'), {});
        modalEdit.show();
        document.getElementById('cliente_id').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('identificacion').value = identificacion;
        document.getElementById('correo').value = correo;
    }
</script>
<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>
</body>

</html>