<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php $this->load->view('admin/auth/includes/_header_auth.php') ?>

<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content ">

                <div class="nk-app-root">
                    <!-- main @s -->
                    <div class="nk-main ">
                        <!-- wrap @s -->
                        <div class="nk-wrap nk-wrap-nosidebar">
                            <!-- content @s -->
                            <div class="nk-content ">
                                <div class="nk-block nk-block-middle wide-md mx-auto">
                                    <div class="nk-block-content nk-error-ld text-center">
                                        <img class="nk-error-gfx" src="<?php echo base_url(); ?>assets/images/gfx/error-404.svg" alt="error-404">
                                        <div class="wide-xs mx-auto">
                                            <h3 class="nk-error-title">¡Ups! ¿Por qué estás aquí?</h3>
                                            <p class="nk-error-text">Lamentamos mucho las molestias. Parece que está intentando acceder a una página que se ha eliminado o que nunca existió.</p>
                                            <a href="<?php echo base_url() ?>" class="btn btn-lg btn-outline-primary mt-2">Regresar al Inicio</a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $this->load->view('admin/auth/includes/_footer_auth.php') ?>