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
                                        <h3 class="nk-block-title page-title">Configuraciones de correo electrónico | <strong class="text-primary small">EMAIL</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Inicio</a></li>
                                                <li class="breadcrumb-item active">Edita la configuración del correo electrónico</li>
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
                                        <h4 class="nk-block-title">Ajustes del correo electrónico</h4>
                                        <div class="nk-block-des">
                                            <strong class="text-dark">Nota:</strong> Modifique los ajustes para el envio de correos desde el sistema.
                                        </div>
                                    </div>
                                </div>
                                <!-- include message block -->
                                <?php $this->load->view('admin/partials/_mesagges'); ?>
                                <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
                                            <!-- form start -->
                                            <?php echo form_open('email_controller/email_settings_post'); ?>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Biblioteca de correo</label>
                                                        <span class="form-note">Selecciona la biblioteca para correo electrónico</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-control-select">
                                                                <select class="form-control form-control-lg" id="mail_library" name="mail_library" onchange="window.location.href = '<?php echo base_url(); ?>admin/email-settings?library='+this.value;">
                                                                    <option value="swift" <?php echo ($library == "swift") ? "selected" : ""; ?>>Swift Mailer</option>
                                                                    <option value="php" <?php echo ($library == "php") ? "selected" : ""; ?>>PHP Mailer</option>
                                                                    <option value="codeigniter" <?php echo ($library == "codeigniter") ? "selected" : ""; ?>>CodeIgniter Mail</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Protocolo</label>
                                                        <span class="form-note">Selecciona el protocolo deseado</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-control-select">
                                                                <select class="form-control form-control-lg" id="mail_protocol" name="mail_protocol">
                                                                    <option value="smtp" <?php echo ($general_settings->mail_protocol == "smtp") ? "selected" : ""; ?>><?php echo 'smtp'; ?></option>
                                                                    <?php if ($library == "codeigniter") : ?>
                                                                        <option value="mail" <?php echo ($general_settings->mail_protocol == "mail") ? "selected" : ""; ?>><?php echo 'mail'; ?></option>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Titulo del correo</label>
                                                        <span class="form-note">Especifica un título para el mensaje</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" autocomplete="off" class="form-control form-control-lg" id="mail_title" name="mail_title" placeholder="Título" value="<?php echo html_escape($general_settings->mail_title); ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Servidor</label>
                                                        <span class="form-note">Especifica un servidor de correo electrónico</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" autocomplete="off" class="form-control form-control-lg" id="mail_host" name="mail_host" placeholder="Host" value="<?php echo html_escape($general_settings->mail_host); ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Puerto</label>
                                                        <span class="form-note">Especifica el puerto del servidor</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="number" autocomplete="off" class="form-control form-control-lg" id="mail_port" name="mail_port" placeholder="Port" value="<?php echo html_escape($general_settings->mail_port); ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Usuario</label>
                                                        <span class="form-note">Especifica usuario</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="email" autocomplete="off" class="form-control form-control-lg" id="mail_username" name="mail_username" placeholder="Username" value="<?php echo html_escape($general_settings->mail_username); ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Contraseña</label>
                                                        <span class="form-note">Especifica la contraseña</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="mail_password" tabindex="-1">
                                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                            </a>
                                                            <input type="password" autocomplete="off" class="form-control form-control-lg" id="mail_password" name="mail_password" placeholder="Contraseña" value="<?php echo html_escape($general_settings->mail_password); ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-gs">
                                                <div class="col-md-12 mt-3">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-lg btn-outline-primary">Guardar los cambios</button>
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