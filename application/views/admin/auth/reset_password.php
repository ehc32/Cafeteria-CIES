<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php $this->load->view('admin/auth/includes/_header_auth.php') ?>

<body class="nk-body ui-rounder npc-default pg-auth">
    <style>
        .nk-body {
            background-image: url('<?php echo base_url(); ?>assets/images/fondo_login(5).jpg');
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

                        <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                            <div class="brand-logo pb-0 text-center logo-organizacion">
                                <a href="<?php echo base_url(); ?>" class="logo-link">
                                    <img class="logo-light logo-img logo-img-lg" src="<?php echo base_url(); ?>assets/images/logo-dark-small.png" srcset="<?php echo base_url(); ?>assets/images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img logo-img-lg" src="<?php echo base_url(); ?>assets/images/logo-dark-small.png" srcset="<?php echo base_url(); ?>assets/images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                                <p>Servicios <br>Tecnologicos</p>
                                <img src="<?php echo base_url() ?>assets/images/line.png" class="lineaLogoIcon">
                                <p>Tecnoparque <br>Nodo Neiva</p>
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
                                        font-size: 16px;
                                        font-family: Nunito, sans-serif;
                                        font-weight: bold !important;
                                        line-height: normal;
                                        color: black !important;
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
                                <div class="card card-bordered">
                                    <div class="card-inner card-inner-lg">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h5 class="nk-block-title">Nueva contraseña</h5>
                                                <div class="nk-block-des">
                                                    <p>En este formulario podrá establecer una nueva contraseña</p>
                                                </div>

                                            </div>
                                        </div>
                                        <style>
                                            .nk-block-title {
                                                color: white !important;
                                                font-size: 1.8rem;
                                                text-align: center;
                                            }

                                            .nk-block-des {
                                                color: white !important;
                                                text-align: left;
                                                font-size: 1rem;
                                                font-weight: bold;
                                                margin-top: 20px;
                                            }
                                        </style>
                                        <!-- include message block -->
                                        <?php $this->load->view('admin/partials/_mesagges'); ?>

                                        <?php echo form_open('auth_controller/reset_password_post', ['id' => 'form_validate']); ?>

                                        <?php if (!empty($user)) : ?>
                                            <input type="hidden" name="token" value="<?php echo $user->token; ?>">
                                        <?php endif; ?>

                                        <?php if (!empty($login)) : ?>
                                            <div class="form-group m-t-30">
                                                <a href="<?php echo base_url(); ?>login" class="btn btn-lg btn-outline-primary btn-block">Iniciar</a>
                                            </div>
                                        <?php else : ?>

                                            <div class="form-group">
                                                <label class="form-label" for="password">Nueva contraseña</label>
                                                <div class="form-control-wrap">
                                                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password" tabindex="-1">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input type="password" autocomplete="off" class="form-control form-control-lg" id="password" name="password" value="<?php echo old("password"); ?>" placeholder="Nueva contraseña" required="" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$" title="La contraseña debe tener minimo 8 caracteres y contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label" for="password_confirm">Confirmación</label>
                                                <div class="form-control-wrap">
                                                    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password_confirm" tabindex="-1">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input type="password" autocomplete="off" class="form-control form-control-lg" id="password_confirm" name="password_confirm" value="<?php echo old("password_confirm"); ?>" placeholder="Confirmación" required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary btn-block">Crea la nueva contraseña</button>
                                            </div>
                                            <style>
                                                .form-label {
                                                    color: white;
                                                    font-weight: bolder !important;
                                                    font-size: 0.9rem;
                                                }
                                            </style>
                                        <?php endif; ?>
                                        <?php echo form_close(); ?><!-- form end -->

                                        <div class="form-note-s2 text-center pt-4">
                                            <a href="<?php echo base_url() ?>"><strong>Retornar al Inicio</strong></a>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php $this->load->view('admin/auth/includes/_footer_auth.php') ?>