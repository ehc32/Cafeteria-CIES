<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
<!-- Cargar Vista del Header -->
<?php $this->load->view('admin/auth/includes/_header_auth.php') ?>

<body class="nk-body ui-rounder npc-default pg-auth">
    <style>
        .nk-body {
            background-image: url('<?php echo base_url(); ?>assets/images/fondo_login(5).jpeg');
            background-size: cover;
            background-position: center;
        }
    </style>
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
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
                                        <h4 class="nk-block-title">Registro de usuario</h4>
                                        <style>
                                            .nk-block-title {
                                                color: white !important;
                                                font-size: 1.8rem;
                                                text-align: center;
                                            }
                                        </style>
                                        <div class="nk-block-des">

                                        </div>
                                    </div>
                                </div>
                                <!-- Mensajes de error -->
                                <?php $this->load->view('admin/partials/_mesagges') ?>
                                <!-- form start -->
                                <?php echo form_open_multipart('auth_controller/registerUser'); ?>

                                <div class="form-group">
                                    <label class="form-label" for="fullname">Nombre completo</label>
                                    <div class="form-control-wrap">
                                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="fullname" name="fullname" placeholder="Nombre completo" required="" value="<?php echo old('fullname'); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="username">Usuario</label>
                                    <div class="form-control-wrap">
                                        <input type="text" autocomplete="off" class="form-control form-control-lg" id="username" name="username" placeholder="Usuario" required="" value="<?php echo old('username'); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="email">Correo electrónico</label>
                                    <div class="form-control-wrap">
                                        <input type="email" autocomplete="off" class="form-control form-control-lg" id="email" name="email" placeholder="Correo electrónico" required="" value="<?php echo old('email'); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <div class="form-control-wrap">
                                        <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password" tabindex="-1">
                                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                        </a>
                                        <input type="password" autocomplete="off" class="form-control form-control-lg" id="password" name="password" placeholder="Contraseña" required="" value="<?php echo old('password'); ?>" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$" title="La contraseña debe tener minimo 8 caracteres y contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.">
                                    </div>

                                </div>

                                <style>
                                    .form-label {
                                        color: white;
                                        font-weight: bolder !important;
                                        font-size: 0.9rem;
                                    }
                                </style>

                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary btn-block">Registra una cuenta</button>
                                </div>

                                <?php echo form_close(); ?><!-- form end -->

                                <div class="form-note-s2 text-center pt-4"> ¿Ya tienes una cuenta? <a href="<?php echo base_url(); ?>inicio-sesion"><strong>Inicia la sesión</strong></a>
                                </div>
                                <style>
                                    .form-note-s2 {
                                        color: white !important;
                                        font-size: 1rem;
                                    }

                                    .form-note-s2.text-center.pt-4 a {
                                        color: white;
                                        font-weight: bolder;
                                        font-size: 1rem;
                                    }
                                </style>
                                <div class="text-center pt-4 pb-3">
                                    <h6 class="overline-title overline-title-sap"><span>O</span></h6>
                                </div>
                                <ul class="nav justify-space-be gx-3">
                                    <li class="nav-item"><a class="nav-link text-center mt-3" href="https://industriaempresayservicios.blogspot.com/p/servicios-tecnologicos.html" style="color: white; font-size:14px">Servicios <br>Tecnologicos</a></li>
                                    <a href="http://industriaempresayservicios.blogspot.com/" target="_blank">
                                        <a href="#" class="btn btn-lg" target="_blank">
                                            <i class="bi bi-facebook facebook-icon"></i>
                                        </a>
                                        <a href="#" class="btn btn-lg" target="_blank">
                                            <i class="bi bi-youtube youtube-icon"></i>
                                        </a>
                                        <a href="https://www.sena.edu.co/es-co/Paginas/default.aspx" target="_blank">
                                            <img class="logo_sena" src="<?php echo base_url(); ?>assets/images/logo.png"></a>
                                        <style>
                                            .nav-item {
                                                font-weight: bolder !important;
                                            }

                                            .logo_ost {
                                                max-width: 100px;
                                                height: 50px;
                                                margin-top: 20px;

                                            }

                                            .logo_sena {
                                                max-width: 160px;
                                                height: 90px;
                                                margin-top: -2px;
                                            }

                                            @media (max-width: 582px) {
                                                .logo_ost {
                                                    margin-top: 5px;
                                                }
                                            }
                                        </style>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <style>
                        .facebook-icon,
                        .youtube-icon,
                        .pagina-icon,
                        .whatsapp-icon {
                            color: white !important;
                            font-size: 2.5rem;
                        }

                        .gx-4 {
                            margin-left: 1.3rem !important;
                        }
                    </style>
                    <?php $this->load->view('admin/auth/includes/_footer_auth.php') ?>