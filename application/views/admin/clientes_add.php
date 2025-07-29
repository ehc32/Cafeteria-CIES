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
                                        <h3 class="nk-block-title page-title">Clientes | <strong class="text-primary small">Registro</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/users">Clientes</a></li>
                                                <li class="breadcrumb-item active">Registrar un nuevo cliente</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="<?php echo base_url() ?>admin/inicio" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Regresar</span></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Información del cliente</h4>
                                        <div class="nk-block-des">
                                            <strong class="text-dark">Nota:</strong> Agregue información común del nuevo cliente.
                                        </div>
                                    </div>
                                </div>
                                <!-- include message block -->
                                <?php $this->load->view('admin/partials/_mesagges'); ?>

                                <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">

                                            <!-- Formulario de registro de cliente -->
                                            <?php echo form_open_multipart('clientes_controller/registrar_cliente'); ?>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Nombre completo</label>
                                                        <span class="form-note">Nombre y Apellidos del cliente</span>
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
                                                        <label class="form-label">Identificación</label>
                                                        <span class="form-note">Número de identificación del cliente</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 mb-3">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" autocomplete="off" class="form-control form-control-lg" id="identificacion" name="identificacion" placeholder="Identificación" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 align-center">
                                                <div class="col-lg-3 offset-0">
                                                    <div class="form-group">
                                                        <label class="form-label">Correo electrónico</label>
                                                        <span class="form-note">Correo electrónico de contacto del cliente</span>
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

                                            <button type="submit" class="btn btn-lg btn-outline-primary">Registrar cliente</button>

                                            <?php echo form_close(); ?>
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