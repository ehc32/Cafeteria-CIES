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
                                        <h3 class="nk-block-title page-title">Configuraciones del Bróker MQTT | <strong class="text-primary small">EMQX</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Inicio</a></li>
                                                <li class="breadcrumb-item active">Edita la configuración del Bróker MQTT</li>
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
                                        <h4 class="nk-block-title">Ajustes del Bróker MQTT</h4>
                                        <div class="nk-block-des">
                                            <strong class="text-dark">Nota:</strong> Modifique los ajustes para la conexión al bróker mqtt desde el sistema.
                                        </div>
                                    </div>
                                </div>

                                <!-- include message block -->
                                <?php $this->load->view('admin/partials/_mesagges'); ?>

                                <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
                                            <!-- form start -->
                                            <?php echo form_open('settings_controller/mqtt_settings_post'); ?>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Protocolo WebSockets</label>
                                                        <span class="form-note">Selecciona el protocolo para la conexión WebSockets</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="form-control-select">
                                                                <select class="form-control form-control-lg" id="mqtt_protocol" name="mqtt_protocol">
                                                                    <option value="ws" <?php echo ($general_settings->mqtt_protocol == "ws") ? "selected" : ""; ?>><?php echo 'ws'; ?></option>
                                                                    <option value="wss" <?php echo ($general_settings->mqtt_protocol == "wss") ? "selected" : ""; ?>><?php echo 'wss'; ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Servidor</label>
                                                        <span class="form-note">Servidor MQTT</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" autocomplete="off" class="form-control form-control-lg" id="mqtt_host" name="mqtt_host" placeholder="Servidor" value="<?php echo html_escape($general_settings->mqtt_host); ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Puerto</label>
                                                        <span class="form-note">Puerto WebSockets</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="number" autocomplete="off" class="form-control form-control-lg" id="mqtt_port" name="mqtt_port" placeholder="Puerto" value="<?php echo html_escape($general_settings->mqtt_port); ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">EMQX AppID</label>
                                                        <span class="form-note">AppID del Broker - API EMQX</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="emqx_AppID" tabindex="-1">
                                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                            </a>
                                                            <input type="password" autocomplete="off" class="form-control form-control-lg" id="emqx_AppID" name="emqx_AppID" placeholder="EMQX AppID" value="<?php echo html_escape($general_settings->emqx_AppID); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">EMQX AppSecret</label>
                                                        <span class="form-note">AppSecret del Broker - API EMQX</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="emqx_AppSecret" tabindex="-1">
                                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                            </a>
                                                            <input type="password" autocomplete="off" class="form-control form-control-lg" id="emqx_AppSecret" name="emqx_AppSecret" placeholder="EMQX AppSecret" value="<?php echo html_escape($general_settings->emqx_AppSecret); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">ApiWebToken</label>
                                                        <span class="form-note">ApiWebToken - API del sistema</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="emqx_ApiWebToken" tabindex="-1">
                                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                            </a>
                                                            <input type="password" autocomplete="off" class="form-control form-control-lg" id="emqx_ApiWebToken" name="emqx_ApiWebToken" placeholder="ApiWebToken" value="<?php echo html_escape($general_settings->emqx_ApiWebToken); ?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">EMQX AppPort</label>
                                                        <span class="form-note">Puerto de la API EMQX</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="number" autocomplete="off" class="form-control form-control-lg" id="emqx_AppPort" name="emqx_AppPort" placeholder="AppPort" value="<?php echo html_escape($general_settings->emqx_AppPort); ?>" required="">
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