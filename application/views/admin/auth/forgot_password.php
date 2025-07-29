<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Cargar Vista del Header -->
<?php $this->load->view("admin/auth/includes/_header_auth.php"); ?>

<body class="nk-body ui-rounder npc-default pg-auth">
    <style>
        .nk-body {
            background-image: url('<?php echo base_url(); ?>assets/images/fondo_login(5).jpeg');
            background-size: cover;
            background-position: center;
        }
    </style>>
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-0 text-center logo-organizacion">
                            <a href="<?php echo base_url(); ?>" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="<?php echo base_url(); ?>assets/images/logo-dark-small.png" srcset="<?php echo base_url(); ?>assets/images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="<?php echo base_url(); ?>assets/images/logo-dark-small.png" srcset="<?php echo base_url(); ?>assets/images/logo-dark2x.png 2x" alt="logo-dark">
                            </a>
                            <img src="<?php echo base_url() ?>assets/images/line.png" class="lineaLogoIcon">
                            <p>Servicios <br>Tecnologicos</p>
                          
                           
                            <style>
                                .logo-img-lg {
                                    max-width: 100px !important;
                                    width: 100px !important;
                                    max-height: 100px !important;
                                    position: relative;
                                    top: 2.5em !important;
                                }


                                @media (max-width: 500px) {
                                    .logo-img-lg {
                                        max-width: 70px !important;
                                        width: 60px !important;
                                        max-height: 70px !important;
                                        position: relative;
                                        top: -0.2em !important;
                                    }
                                }

                                .logo-organizacion {
                                    display: flex;
                                    flex-direction: row;
                                    align-items: center;
                                    justify-content: center;
                                }

                                .logo-organizacion p {
                                    font-size: 24px;
                                    font-family: Nunito, sans-serif;
                                    font-weight: bold !important;
                                    line-height: normal;
                                    color: white !important;
                                    font-weight: 900 !important;
                                }

                                .lineaLogoIcon {
                                    height: 1.8em;
                                    width: 2.5em;
                                    scale: 2.5;
                                    position: relative;
                                    top: -0.5em;

                                }
                            </style>
                        </div>
                        <div class="card card-bordered">
                            <style>
                                .card.card-bordered {
                                    background-color: transparent;
                                    border: 2px solid rgba(255, 255, 255, 0.5);
                                    backdrop-filter: blur(10px);
                                }
                            </style>
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Recuperar contraseña</h5>
                                        <style>
                                            .nk-block-title {
                                                color: white !important;
                                                font-size: 1.8rem;
                                                text-align: center;
                                            }
                                        </style>
                                        <div class="nk-block-des"><br>
                                            <p>Si olvidó su contraseña, se le enviará un correo electrónico con las instrucciones para restablecer su contraseña.</p>
                                        </div>
                                        <style>
                                            .nk-block-des {
                                                color: white !important;
                                                text-align: center;
                                                font-size: 0.9rem;
                                                font-weight: bold;
                                            }
                                        </style>
                                    </div>
                                </div>
                                <!-- Mensajes de error -->
                                <?php $this->load->view('admin/partials/_mesagges') ?>

                                <?php echo form_open('auth_controller/forgot_password_post'); ?>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="email">Correo electrónico</label>
                                    </div>
                                    <style>
                                        .form-label {
                                            color: white;
                                            font-weight: bolder !important;
                                            font-size: 0.9rem;
                                        }
                                    </style>
                                    <div class="form-control-wrap">
                                        <input autocomplete="off" type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Correo electrónico" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary btn-block">Enviar Link de recuperación</button>
                                </div>
                                <?php echo form_close(); ?>
                                <div class="form-note-s2 text-center pt-4">
                                    <a href="<?php echo base_url(); ?>"><strong>Regresar al login</strong></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $this->load->view('admin/auth/includes/_footer_auth.php') ?>