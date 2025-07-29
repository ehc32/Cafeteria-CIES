<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Cargar Vista del Header -->
<?php $this->load->view("admin/includes/_header.php"); ?>

<body class="nk-body ui-rounder npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- Cargar Vista del Sidebar -->
        <?php $this->load->view("admin/includes/_sidebar.php"); ?>
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php $this->load->view("admin/includes/_main-header.php"); ?>
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head">
                                    <div class="nk-block-between g-3">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Usuario | <strong class="text-primary small"><?php echo $this->session->userdata("fullname") ?></strong></h3>
                                            <div class="nk-block-des text-soft">
                                                <ul class="list-inline">
                                                    <li>Nombre de usuario: <span class="text-base"><?php echo $user->username ?></span></li>
                                                    <li>Ultima conexión: <span class="text-base"><?php echo $user->last_seen ?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <a href="<?php echo base_url() ?>admin/inicio" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Regresar</span></a>
                                            <a href="<?php echo base_url() ?>admin/inicio" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mensajes de error -->
                                <?php $this->load->view('admin/partials/_mesagges') ?>

                                <div class="nk-block nk-block-lg">
                                    <div class="card">
                                        <div class="card-aside-wrap">
                                            <div class="card-content">
                                                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab" href="#tabItemInfo"><em class="icon ni ni-user-circle-fill"></em><span>Información Personal</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#tabItemUpdate"><em class="icon ni ni-account-setting-fill"></em><span>Actualizar perfil</span></a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#tabItemSecurity"><em class="icon ni ni-lock-alt-fill"></em><span>Seguridad</span></a>
                                                    </li>
                                                </ul>
                                                <div class="card-inner">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tabItemInfo">
                                                            <div class="nk-block nk-block-between">
                                                                <div class="nk-block-head">
                                                                    <h6 class="title">Información personal</h6>
                                                                    <p>Información básica, como su nombre, correo, celular, que se usa en la Plataforma</p>
                                                                </div><!-- .nk-block-head -->
                                                            </div><!-- .nk-block-between  -->
                                                            <div class="nk-block">
                                                                <div class="profile-ud-list">
                                                                    <div class="profile-ud-item">
                                                                        <div class="profile-ud wider">
                                                                            <span class="profile-ud-label">Nombre de usuario:</span>
                                                                            <span class="profile-ud-value"><?php echo $user->username ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="profile-ud-item">
                                                                        <div class="profile-ud wider">
                                                                            <span class="profile-ud-label">Nombre completo:</span>
                                                                            <span class="profile-ud-value"><?php echo $user->fullname ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="profile-ud-item">
                                                                        <div class="profile-ud wider">
                                                                            <span class="profile-ud-label">Teléfono:</span>
                                                                            <span class="profile-ud-value"><?php echo $user->phone ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="profile-ud-item">
                                                                        <div class="profile-ud wider">
                                                                            <span class="profile-ud-label">Correo electrónico:</span>
                                                                            <span class="profile-ud-value"><?php echo $user->email ?></span>
                                                                        </div>
                                                                    </div>
                                                               
                                                                    <div class="profile-ud-item">
                                                                        <div class="profile-ud wider">
                                                                            <span class="profile-ud-label">Ultima conexión:</span>
                                                                            <span class="profile-ud-value"><?php echo time_ago($user->last_seen); ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="profile-ud-item">
                                                                        <div class="profile-ud wider">
                                                                            <span class="profile-ud-label">Estado:</span>
                                                                            <span class="profile-ud-value"><?php echo $user->status ? '<span class="lead-text text-success">Activo</span>' : '<span class="lead-text text-danger">Desactivado</span>' ?></span>
                                                                        </div>
                                                                    </div>

                                                                    <style>
                                                                        .profile-ud-value{
                                                                            text-align: left !important;
                                                                        }
                                                                    </style>
                                                                </div><!-- .profile-ud-list -->
                                                            </div><!-- .nk-block -->
                                                        </div><!-- tab pane -->


                                                        <div class="tab-pane" id="tabItemUpdate">
                                                            <div class="nk-block nk-block-between">
                                                                <div class="nk-block-head">
                                                                    <h6 class="title">Actualiza tú perfil</h6>
                                                                    <p>Edita los datos, como correo, teléfono, nombre, etc.</p>
                                                                </div><!-- .nk-block-head -->
                                                            </div><!-- .nk-block-between  -->

                                                            <div class="nk-block">

                                                                <div class="card-inner">

                                                                    <?php echo form_open_multipart("users_controller/update_profile_post", ['id' => 'form_profile']); ?>

                                                                    <div class="row g-3 align-center">
                                                                        <div class="col-lg-3 offset-0">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Nombre completo</label>
                                                                                <span class="form-note">Su nombre y apellidos</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-7 mb-3">
                                                                            <div class="form-group">
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" class="form-control form-control-lg" id="fullname" name="fullname" value="<?php echo  html_escape($user->fullname) ?>" placeholder="Nombre completo" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row g-3 align-center">
                                                                        <div class="col-lg-3 offset-0">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Nombre de usuario</label>
                                                                                <span class="form-note">Nombre de usuario en la aplicación</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-7 mb-3">
                                                                            <div class="form-group">
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" class="form-control form-control-lg" id="username" name="username" value="<?php echo  html_escape($user->username) ?>" placeholder="Username" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row g-3 align-center">
                                                                        <div class="col-lg-3 offset-0">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Teléfono</label>
                                                                                <span class="form-note">Teléfono de contacto</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-7 mb-3">
                                                                            <div class="form-group">
                                                                                <div class="form-control-wrap">
                                                                                    <input type="text" class="form-control form-control-lg" id="phone" name="phone" value="<?php echo  html_escape($user->phone) ?>" placeholder="Teléfono">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row g-3 align-center">
                                                                        <div class="col-lg-3 offset-0">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Correo electrónico</label>
                                                                                <span class="form-note">Correo electrónico de contacto (Login)</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-7 mb-3">
                                                                            <div class="form-group">
                                                                                <div class="form-control-wrap">
                                                                                    <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?php echo  html_escape($user->email) ?>" placeholder="Correo electrónico" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- profile image -->
                                                                    <div class="row g-3 align-center">
                                                                        <div class="col-lg-3 offset-0">
                                                                            <div class="form-group">
                                                                                <div class="preview-icon-box card card-bordered">
                                                                                    <div class="preview-icon-wrap">
                                                                                        <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo $user->username; ?>" class="rounded-top" style="max-width: 100px; padding: 5px;">
                                                                                    </div>
                                                                                </div><!-- .preview-icon-box -->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-2 offset-0">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Imágen de perfil actual</label>
                                                                                <span class="form-note">Imágen de perfil actual</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Nueva imágen</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input type="file" class="custom-file-input" id="img_profile" accept="image/*" name="file">
                                                                                    <label class="custom-file-label">Selecciona una imagen</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div><!-- end profile image -->

                                                                    <div class="row gy-4">
                                                                        <div class="col-12 mt-3">
                                                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                                                <li>
                                                                                    <button type="submit" class="btn btn-outline-primary">Guardar los cambios</button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                    <?php echo form_close(); ?>

                                                                </div><!-- .card -->

                                                            </div><!-- .nk-block -->
                                                        </div>
                                                        <!--tab pane-->

                                                        <!--tab pane-->
                                                        <div class="tab-pane" id="tabItemSecurity">
                                                            <div class="nk-block nk-block-between">
                                                                <div class="nk-block-head">
                                                                    <h6 class="title">Configuraciones de seguridad</h6>
                                                                    <p>Estas configuraciones lo ayudan a mantener su cuenta segura.</p>
                                                                </div><!-- .nk-block-head -->
                                                            </div><!-- .nk-block-between  -->
                                                            <div class="nk-block">
                                                                <div class="card card-bordered">
                                                                    <div class="card-inner-group">
                                                                        <div class="card-inner">
                                                                            <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                                                <div class="nk-block-text">
                                                                                    <h6>Cambiar la contraseña</h6>
                                                                                    <p>Establezca una contraseña única para proteger su cuenta.</p>
                                                                                </div>
                                                                                <div class="nk-block-actions flex-shrink-sm-0">
                                                                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                                                                                        <li class="order-md-last">
                                                                                            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalForm">Cambiar la contraseña</button>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div><!-- .card-inner -->
                                                                        <div class="card-inner">
                                                                            <div class="between-center flex-wrap g-3">
                                                                                <div class="nk-block-text">
                                                                                    <h6>Eliminar la cuenta</h6>
                                                                                    <p>Esta acción eliminará su usuario del sistema, junto a todos sus datos almacenados.</p>
                                                                                </div>
                                                                                <div class="nk-block-actions flex-shrink-sm-0">
                                                                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                                                                                        <li class="order-md-last">
                                                                                            <a href="javascript:void(0)" <?php echo ($user->id == "1") ? 'class="btn btn-outline-danger disabled"' : 'class="btn btn-outline-danger"' ?> onclick="delete_item(
                                                                                            'users_controller/delete_user_profile',
                                                                                            '<?php echo html_escape($user->id); ?>',
                                                                                            '¡Usuario eliminado correctamente!'
                                                                                        );">Eliminar la cuenta</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div><!-- .card-inner -->
                                                                        <div class="card-inner">
                                                                            <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                                                <div class="nk-block-text">
                                                                                    <h6>Cerrar la sesión</h6>
                                                                                    <p>Esta acción cerrará la sesión del sistema.</p>
                                                                                </div>
                                                                                <div class="nk-block-actions flex-shrink-sm-0">
                                                                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                                                                                        <li class="order-md-last">
                                                                                            <a href="<?php echo base_url(); ?>logout" class="btn btn-outline-primary">Salir del sistema</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div><!-- .card-inner -->
                                                                    </div><!-- .card-inner-group -->
                                                                </div><!-- .card -->
                                                            </div><!-- .nk-block -->
                                                        </div>
                                                        <!--tab pane-->

                                                        <!--tab pane-->
                                                    </div>
                                                    <!--tab content-->
                                                </div>
                                                <!--card inner-->
                                            </div><!-- .card-content -->

                                        </div><!-- .card-aside-wrap -->
                                    </div>
                                    <!--card-->
                                </div>
                                <!--nk block lg-->
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
    <div class="modal fade" id="modalForm">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambia tu contraseña</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart("users_controller/change_password_post", ['id' => 'form_password']); ?>
                    <?php if (!empty($user->password)) : ?>
                        <div class="form-group">
                            <label class="form-label" for="old_password">Contraseña anterior</label>
                            <div class="form-control-wrap">
                                <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="old_password" tabindex="-1">
                                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                </a>
                                <input type="password" autocomplete="off" class="form-control form-control-lg" value="<?php echo old("old_password"); ?>" id="old_password" name="old_password" placeholder="Contraseña" required>
                            </div>
                            <input type="hidden" value="1" name="is_pass_exist">
                        </div>
                    <?php else : ?>
                        <input type="hidden" value="0" name="is_pass_exist">
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="form-label" for="password">Nueva Contraseña</label>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password" tabindex="-1">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" autocomplete="off" class="form-control form-control-lg" value="<?php echo old("password"); ?>" id="password" name="password" placeholder="Nueva Contraseña" required pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}" title="La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirm">Confirmación</label>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password_confirm" tabindex="-1">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" autocomplete="off" class="form-control form-control-lg" value="<?php echo old("password_confirm"); ?>" id="password_confirm" name="password_confirm" placeholder="Confirmación" required>
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
    <?php $this->load->view("admin/includes/_JavaScripts.php"); ?>
</body>

</html>