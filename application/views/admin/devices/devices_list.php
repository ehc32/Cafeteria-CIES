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
                                        <h3 class="nk-block-title page-title">Dispositivos | <strong class="text-primary small">Registrados</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/devices-list">Dispositivos</a></li>
                                                <li class="breadcrumb-item active">Dispositivos Registrados</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="<?php echo base_url(); ?>admin/devices-add" class="btn btn-icon btn-outline-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                                        <a href="<?php echo base_url(); ?>admin/devices-add" class="btn btn-outline-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Nuevo</span></a>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div>

                            <div class="nk-block">

                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Lista de dispositivos</h4>
                                        <div class="nk-block-des">
                                            <strong class="text-dark">Nota:</strong> Editar, eliminar, activar, desactivar, etc. cada uno de los dispositivos de la lista.
                                        </div>
                                    </div>
                                </div>
                                <!-- include message block -->
                                <?php $this->load->view('admin/partials/_mesagges'); ?>
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <table class="datatable-init-export nowrap table" data-export-title="Export" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Actividad</th>
                                                    <th>UserId</th>
                                                    <th>Nombre</th>
                                                    <th>Serial</th>
                                                    <th>Tipo</th>
                                                    <th>Almacenar</th>
                                                    <th>Ultima conexión</th>
                                                    <th>Registro</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($devices)) : ?>
                                                    <?php foreach ($devices as $device) : ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $device->online ?
                                                                    '<span class="tb-odr-status">
                                                                            <span class="badge badge-dot badge-primary">Online</span>
                                                                        </span>'
                                                                    :
                                                                    '<span class="tb-odr-status">
                                                                            <span class="badge badge-dot badge-danger">Offline</span>
                                                                        </span>'
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $device->userid  ===  $this->session->userdata("username") ?
                                                                    '<span class="badge badge-primary">' . $device->userid . '</span>' :
                                                                    '<span class="badge badge-secondary">' . $device->userid . ' </span>';
                                                                ?>
                                                            </td>
                                                            <td><?php echo $device->name; ?></td>
                                                            <td>
                                                                <a data-original-title="<?php echo $device->name ?>" title="<?php echo $device->name ?>" href="<?php echo base_url() . 'admin/devices/view/' . get_serial64($device->serialnumber); ?>">
                                                                    <span class="text-primary"><?php echo $device->serialnumber ?></span>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <?php echo $device->type === "0" ? '<span class="badge badge-primary">Genérico</span>' : '<span class="badge badge-gray">Otro</span>' ?>
                                                            </td>
                                                            <td>
                                                                <div class="g">
                                                                    <div class="custom-control custom-switch <?php echo $device->store === "1" ? 'checked' : '' ?>">
                                                                        <input type="checkbox" class="custom-control-input" <?php echo $device->store === "1" ? 'checked=""' : '' ?> id="Switch<?php echo $device->id ?>" onchange="store('devices_controller/deviceEditStoreData','<?php echo $device->id ?>');">
                                                                        <label class="custom-control-label" for="Switch<?php echo $device->id ?>" id="SwitchLabel<?php echo $device->id ?>">
                                                                            <?php echo $device->store === "1" ? 'SI' : 'NO' ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php echo $device->lastseen; ?>
                                                                <span class="sub-text"><?php echo time_ago($device->lastseen); ?></span>
                                                            </td>
                                                            <td>
                                                                <?php echo $device->created; ?>
                                                                <span class="sub-text"><?php echo time_ago($device->created); ?></span>
                                                            </td>
                                                            <td><?php echo $device->status ? '<span class="badge badge-primary">Activo</span>' : '<span class="badge badge-danger">Desactivado</span>' ?></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a href="javascript:void(0)" class="btn btn-primary" data-toggle="dropdown" aria-expanded="false"><span>Seleccione</span><em class="icon ni ni-chevron-down"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-auto mt-1">
                                                                        <ul class="link-list-plain">
                                                                            <!-- Editar -->
                                                                            <li>
                                                                                <a href="javascript:void(0)" onclick="editDevice(
                                                                                        '<?php echo $device->id; ?>', 
                                                                                        '<?php echo $device->serialnumber; ?>',
                                                                                        '<?php echo $device->name; ?>',
                                                                                        '<?php echo $device->address; ?>',
                                                                                        '<?php echo $device->variable1; ?>',
                                                                                        '<?php echo $device->variable2; ?>',
                                                                                        '<?php echo $device->variable3; ?>',
                                                                                        '<?php echo $device->variable4; ?>',
                                                                                        '<?php echo $device->unidad1; ?>',
                                                                                        '<?php echo $device->unidad2; ?>',
                                                                                        '<?php echo $device->unidad3; ?>',
                                                                                        '<?php echo $device->unidad4; ?>'                                               
                                                                                    )">
                                                                                    <em class="icon ni ni-cpu text-blue"></em>Editar
                                                                                </a>
                                                                            </li>
                                                                            <?php echo form_open_multipart("devices_controller/deviceEditStatus", ['id' => 'form_' . $device->id]); ?>
                                                                            <!-- Habilitar|Deshabilitar -->
                                                                            <input type="hidden" name="id" value="<?php echo html_escape($device->id); ?>">
                                                                            <?php if ($device->status == "1") : ?>
                                                                                <li><a href="javascript:void(0)" onclick="document.getElementById('form_<?php echo $device->id; ?>').submit();"><em class="icon ni ni-eye-off-fill text-warning"></em>Deshabilitar</a></li>
                                                                                <input type="hidden" name="value" value="0">
                                                                            <?php else : ?>
                                                                                <li><a href="javascript:void(0)" onclick="document.getElementById('form_<?php echo $device->id; ?>').submit();"><em class="icon ni ni-eye-fill text-warning"></em>Habilitar</a></li>
                                                                                <input type="hidden" name="value" value="1">
                                                                            <?php endif; ?>
                                                                            <!-- Eliminar -->
                                                                            <li>
                                                                                <a href="javascript:void(0)" onclick="delete_item(
                                                                                            'devices_controller/deviceDelete',
                                                                                            '<?php echo html_escape($device->id); ?>',
                                                                                            '¡Dispositivo eliminado correctamente!',
                                                                                    );">
                                                                                    <em class="icon ni ni-trash-empty-fill text-danger"></em>Eliminar
                                                                                </a>
                                                                            </li>
                                                                            <?php echo form_close(); ?>
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
                            </div> <!-- nk-block -->
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

<!-- Modal Form -->
<div class="modal fade" id="modalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza el dispositivo</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart("devices_controller/change_device_post", ['id' => 'form_device']); ?>
                <input type="hidden" name="device_id" id="device_id">
                <div class="form-group">
                    <label class="form-label">Número de serie</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="serialnumber" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="name">Nombre</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="name" name="name" placeholder="Nombre" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="address">Dirección</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="address" name="address" placeholder="Dirección" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="variable1">Variable 1</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="variable1" name="variable1" placeholder="Variable 1" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="unidad1">Unidad 1</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="unidad1" name="unidad1" placeholder="Unidad 1" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="variable2">Variable 2</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="variable2" name="variable2" placeholder="Variable 2" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="unidad2">Unidad 2</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="unidad2" name="unidad2" placeholder="Unidad 2">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="variable3">Variable 3</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="variable3" name="variable3" placeholder="Variable 3" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="unidad3">Unidad 3</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="unidad3" name="unidad3" placeholder="Unidad 3">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="variable4">Variable 4</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="variable4" name="variable4" placeholder="Variable 4" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="unidad4">Unidad 4</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="unidad4" name="unidad4" placeholder="Unidad 4" >
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

<script>
    function editDevice(id, serialnumber, name, address, variable1,  variable2, variable3, variable4, unidad1, unidad2, unidad3, unidad4) {
        const ModalEdit = new bootstrap.Modal(modalForm, {}).show();
        document.getElementById('device_id').value = id;
        document.getElementById('serialnumber').value = serialnumber;
        document.getElementById('name').value = name;
        document.getElementById('address').value = address;
        document.getElementById('variable1').value = variable1;
        document.getElementById('variable2').value = variable2;
        document.getElementById('variable3').value = variable3;
        document.getElementById('variable4').value = variable4;
        document.getElementById('unidad1').value = unidad1;
        document.getElementById('unidad2').value = unidad2;
        document.getElementById('unidad3').value = unidad3;
        document.getElementById('unidad4').value = unidad4;
    }
</script>
<!-- app-root @e -->
<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>
</body>

</html>