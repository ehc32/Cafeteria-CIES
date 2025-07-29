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
                                        <h3 class="nk-block-title page-title">Usuarios | <strong class="text-primary small">Registro</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/users">Usuarios</a></li>
                                                <li class="breadcrumb-item active">Registrar un nuevo Usuario</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="<?php echo base_url() ?>admin/dashboard" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Regresar</span></a>
                                        <a href="<?php echo base_url() ?>admin/dashboard" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Información del nuevo usuario</h4>
                                        <div class="nk-block-des">
                                            <strong class="text-dark">Nota:</strong> Agregue información común como el nombre, contraseña, etc.
                                        </div>
                                    </div>
                                </div>
                                <!-- include message block -->
                                <?php $this->load->view('admin/partials/_mesagges'); ?>

                                <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">

                                            <!-- form start -->
                                            <?php echo form_open_multipart('auth_controller/registerUser'); ?>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Nombre completo</label>
                                                        <span class="form-note">Nombre y Apellidos del nuevo usuario</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" autocomplete="off" class="form-control form-control-lg" id="fullname" name="fullname" placeholder="Nombre completo" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Usuario</label>
                                                        <span class="form-note">Nombre de usuario para la plataforma</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" autocomplete="off" class="form-control form-control-lg" id="username" name="username" placeholder="Usuario" required="">
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
                                                            <input type="email" autocomplete="off" class="form-control form-control-lg" id="email" name="email" placeholder="Correo electrónico" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Contraseña</label>
                                                        <span class="form-note">Contraseña para Login</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password" tabindex="-1">
                                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                            </a>
                                                            <input type="password" autocomplete="off" class="form-control form-control-lg" id="password" name="password" placeholder="Contraseña" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Rol de usuario</label>
                                                        <span class="form-note">Selecciona el rol del usuario</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="row gy-4">
                                                                <div class="col-md-3 col-sm-6">
                                                                    <div class="preview-block">
                                                                        <div class="custom-control custom-radio checked">
                                                                            <input type="radio" id="admin_role" name="role" class="custom-control-input" value="1">
                                                                            <label class="custom-control-label" for="admin_role">Administrador</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-sm-6">
                                                                    <div class="preview-block">
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio" id="user_role" name="role" checked="" class="custom-control-input" value="0">
                                                                            <label class="custom-control-label" for="user_role">Usuario</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-gs">
                                                <div class="col-md-12 mt-3">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-lg btn-outline-primary">Registra el usuario</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php echo form_close(); ?><!-- form end -->
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
<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>
</body>

</html>