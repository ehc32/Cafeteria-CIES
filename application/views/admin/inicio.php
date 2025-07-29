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
                                <div class="nk-block-between">
                            
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->

                            <!-- bloque de inicio -->
                            <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h2>Bienvenido a SENACoffe</h2>
                                            <h3> Sistemas de estaciones de café del SENA</h3>
                                            
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <div class="col-xxl-6 col-lg-4 col-sm-6">
                                            <div class="card card-bordered product-card">
                                                <div class="product-thumb">
                                                    <a href="<?php echo base_url() ?>admin/inventario">
                                                        <img class="card-img-top" src="<?php echo base_url() ?>assets/images/fondo_card.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="card-inner text-center">
                                                <ul class="product-tags">                                 
                                                    <li><a href="<?php echo base_url() ?>admin/inventario" class="btn btn-primary"><span style="color: white;">Acceder</span></a></li>
                                                </ul>    
                                                    <h3 class="product-title">Módulo Inventario de Productos</h3>
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                        <div class="col-xxl-6 col-lg-4 col-sm-6">
                                            <div class="card card-bordered product-card">
                                                <div class="product-thumb">
                                                    <a href="<?php echo base_url() ?>admin/ventas-add">
                                                        <img class="card-img-top" src="<?php echo base_url() ?>assets/images/fondo_card(1).jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="card-inner text-center">
                                                    <ul class="product-tags">
                                                    <li><a href="<?php echo base_url() ?>admin/ventas-add" class="btn btn-primary"><span style="color: white;">Acceder</span></a></li>
                                                    </ul>
                                                    <h3 class="product-title">Módulo de Ventas</h3>
                                                    
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                    </div><!-- .nk-block -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->

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