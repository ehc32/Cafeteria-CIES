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
                                        <h3 class="nk-block-title page-title">Usuarios | <strong class="text-primary small">Registrados</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/users">Usuarios</a></li>
                                                <li class="breadcrumb-item active">Lista de Usuarios registrados</li>
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
                                        <h4 class="nk-block-title">Lista de usuarios registrados</h4>
                                        <div class="nk-block-des">
                                            <strong class="text-dark">Nota:</strong> podrá editar, eliminar, activar, desactivar, etc. cada uno de los usuarios registrados.
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
                                                        <th>Avatar</th>
                                                        <th>Username</th>
                                                        <th>Nombre completo</th>
                                                        <th>Correo</th>
                                                        <th>Rol</th>
                                                        <th>Estado</th>
                                                        <th>Last seen</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($users)) : ?>
                                                        <?php foreach ($users as $user) : ?>
                                                            <tr>
                                                                <td> <?php echo $user->id ?> </td>
                                                                <td>
                                                                    <div class="user-avatar">
                                                                        <img src="<?php echo get_user_avatar($user) ?>" alt="user_avatar" style="width: 50px;">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?php echo $user->username  ===  $this->session->userdata("username") ?
                                                                        '<span class="badge badge-primary">' . $user->username . '</span>' :
                                                                        '<span class="badge badge-gray">' . $user->username . ' </span>';
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $user->fullname; ?></td>
                                                                <td><?php echo $user->email; ?></td>
                                                                <td>
                                                                    <?php echo $user->is_superuser  === "1" ?
                                                                        '<span class="badge badge-primary"> Administrador </span>' :
                                                                        '<span class="badge badge-light"> Usuario </span>';
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $user->status ? '<span class="badge badge-primary">Activo</span>' : '<span class="badge badge-danger">Desactivado</span>' ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $user->last_seen; ?><br>
                                                                    <span class="sub-text"><?php echo time_ago($user->last_seen); ?></span>
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <a href="#" class="btn btn-outline-primary" data-toggle="dropdown" aria-expanded="false"><span>Seleccione</span><em class="icon ni ni-chevron-down"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-auto mt-1">
                                                                            <ul class="link-list-plain">
                                                                                <li><a href="#" onclick="editUser(
                                                                                    '<?php echo $user->id; ?>', 
                                                                                    '<?php echo $user->fullname; ?>',
                                                                                    '<?php echo $user->username; ?>',
                                                                                    '<?php echo $user->email; ?>',
                                                                                    '<?php echo $user->is_superuser; ?>',
                                                                                )"><em class="icon ni ni-user-alt-fill text-blue"></em> Editar</a></li>

                                                                                <?php echo form_open_multipart("users_controller/user_options_post", ['id' => 'form_' . $user->id]); ?>

                                                                                <input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">

                                                                                <?php if ($user->status == "1") : ?>
                                                                                    <li>
                                                                                        <a href="#" onclick="document.getElementById('form_<?php echo $user->id ?>').submit();"
                                                                                            <?php echo ($user->id == "1") ? 'class="disabled text-danger"' : '' ?>>
                                                                                            <em class="icon ni ni-eye-fill text-warning"></em>Deshabilitar
                                                                                        </a>
                                                                                    </li>
                                                                                    <input type="hidden" name="option" value="ban">
                                                                                <?php else : ?>
                                                                                    <li>
                                                                                        <a href="#" onclick="document.getElementById('form_<?php echo $user->id ?>').submit();"
                                                                                            <?php echo ($user->id == "1") ? 'class="disabled"' : '' ?>>
                                                                                            <em class="icon ni ni-eye-fill text-warning"></em>Habilitar
                                                                                        </a>
                                                                                    </li>
                                                                                    <input type="hidden" name="option" value="remove_ban">
                                                                                <?php endif; ?>

                                                                                <li>
                                                                                    <a href="javascript:void(0)" class="disabled text-danger" onclick="delete_item(
                                                                                    '<?php echo base_url(); ?>admin/users/delete/<?php echo html_escape($user->id); ?>',
                                                                                    '<?php echo html_escape($user->id); ?>',
                                                                                    'Usuario eliminado correctamente!'
                                                                                );"><em class="icon ni ni-trash-empty-fill text-danger"></em>Eliminar</a>
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
                <h5 class="modal-title">Información del usuario</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">

                <?php echo form_open('users_controller/change_user_post'); ?> <!-- form -->

                <input type="hidden" name="user_id" id="user_id">

                <div class="form-group">
                    <label class="form-label">Nombre completo</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="fullname" name="fullname" placeholder="Nombre completo">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Usuario</label>
                    <div class="form-control-wrap">
                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="user" name="username" placeholder="Usuario (MQTT)" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <div class="form-control-wrap">
                        <input type="email" autocomplete="off" class="form-control form-control-lg" id="email" name="email" placeholder="Correo electrónico" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <div class="form-control-wrap">
                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password" tabindex="-1">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a>
                        <input type="password" autocomplete="off" class="form-control form-control-lg" id="password" name="password" placeholder="Contraseña">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Rol de usuario</label>
                    <ul class="custom-control-group g-3 align-center">
                        <li>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radioadmin" name="role" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="radioadmin">Administrador</label>
                            </div>
                        </li>
                        <li>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="radiouser" name="role" class="custom-control-input" value="0">
                                <label class="custom-control-label" for="radiouser">Usuario</label>
                            </div>
                        </li>
                    </ul>
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
    function editUser(id, fullname, username, email, rol) {
        const modalEdit = new bootstrap.Modal(modalForm, {}).show();
        document.getElementById('user_id').value = id;
        document.getElementById('fullname').value = fullname;
        document.getElementById('user').value = username;
        document.getElementById('email').value = email;
        if (rol === "1") {
            document.getElementById('radioadmin').checked = true;
        } else {
            document.getElementById('radiouser').checked = true;
        }
    }
</script>
<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>
</body>

</html>