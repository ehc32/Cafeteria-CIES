<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>

<input type="hidden" id="base_url" value="<?php echo base_url() ?>">

<input type="hidden" id="username" value="<?php echo $this->session->userdata("username") ?>">



<div class="nk-sidebar" data-content="sidebarMenu">
    <div class="nk-sidebar-bar">
        <div class="nk-apps-brand-left">
            <a href="#" class="logo-link">
                <img class="logo-light logo-img" src="<?php echo base_url(); ?>assets/images/logo-dark-small.png" srcset="<?php echo base_url(); ?>assets/images/logo-small2x.png 2x" alt="logo">
                <img class="logo-dark logo-img" src="<?php echo base_url(); ?>assets/images/logo-dark-small.png" srcset="<?php echo base_url(); ?>assets/images/logo-dark-small2x.png 2x" alt="logo-dark">

                <style>
                    .nk-apps-brand{
                        justify-content: left !important;
                    }
                    .logo-img{
                        max-width: 80px !important;
                        max-height: 80px !important;
                        margin-left: 0 !important;
                    }
                    .nk-apps-brand .logo-link{
                        justify-content: flex-start !important;

                    }
                </style>
            </a>
        </div>
        <div class="nk-sidebar-element">
            <div class="nk-sidebar-body">
                <div class="nk-sidebar-content" data-simplebar>
                    <div class="nk-sidebar-menu">
                        <!-- Menu -->
                        <ul class="nk-menu apps-menu">
                            <li class="nk-menu-item active ">
                                <a href="#" class="nk-menu-link nk-menu-switch" data-target="navDashboard" data-original-title="Dashboard" title="Dashboard">
                                    <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                                </a>
                            </li>

                            <li class="nk-menu-hr"></li>
                            <?php if ($this->session->userdata("is_superuser") === "1") : ?>
                                <li class="nk-menu-item">
                                    <a href="#" class="nk-menu-link nk-menu-switch" data-target="navComponents" data-original-title="Configuraciones" title="Configuraciones">
                                        <span class="nk-menu-icon"><em class="icon ni ni-setting-fill"></em></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-sidebar-main is-light">
        <div class="nk-sidebar-inner" data-simplebar>
            <div class="nk-menu-content" data-content="navDashboard">
                <h5 class="title">Cafetería CIES / Comercio</h5>
                <ul class="nk-menu">
                    <!-- Vista inicio -->
                    <li class="nk-menu-item active current-page">
                        <a href="<?php echo base_url() ?>admin/inicio" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard"></em></span>
                            <span class="nk-menu-text">Inicio</span>
                        </a>
                    </li>

                    <li class="nk-menu-item active current-page">
                        <a href="<?php echo base_url() ?>admin/inventario" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-coffee"></em></span>
                            <span class="nk-menu-text">Inventario de productos</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                    <!-- .nk-menu-item -->

                    
                    <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-money"></em></span>
                            <span class="nk-menu-text">Ventas</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="<?php echo base_url() ?>admin/ventas-add" class="nk-menu-link"><span class="nk-menu-text">Registrar Venta</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?php echo base_url() ?>admin/ventas" class="nk-menu-link"><span class="nk-menu-text">Reportes de ventas</span></a>
                            </li>
                        </ul>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item has-sub">
                    <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-user-add"></em></span>
                            <span class="nk-menu-text">Clientes</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="<?php echo base_url() ?>admin/clientes-add" class="nk-menu-link"><span class="nk-menu-text">Registrar Cliente</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="<?php echo base_url() ?>admin/clientes_list" class="nk-menu-link"><span class="nk-menu-text">Lista de clientes</span></a>
                            </li>
                        </ul>
                    </li><!-- .nk-menu-item -->


                    <li class="nk-menu-item active current-page">
                        <a href="<?php echo base_url() ?>admin/entrega_turno" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-coffee"></em></span>
                            <span class="nk-menu-text">Entrega de turno</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <?php if ($this->session->userdata("is_superuser") === "1") : ?>
                    <li class="nk-menu-item active current-page">
                        <a href="<?php echo base_url() ?>admin/historial_turnos" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-table-view"></em></span>
                            <span class="nk-menu-text">Histórico de turnos</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <?php endif; ?>

                    <li class="nk-menu-item has-sub">
                    <li class="nk-menu-item">
                        <a href="<?php echo base_url(); ?>admin/user-profile/<?php echo $this->session->userdata("id") ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-user-fill"></em></span>
                            <span class="nk-menu-text">Perfil</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item">
                        <a href="<?php echo base_url(); ?>admin/activity-logs" class="nk-menu-link" data-original-title="Ver logs" title="Ver logs">
                            <span class="nk-menu-icon"><em class="icon ni ni-notes-alt"></em></span>
                            <span class="nk-menu-text">Logs</span>
                        </a>
                    </li><!-- .nk-menu-item -->

                </ul><!-- .nk-menu -->
            </div>
            <?php if ($this->session->userdata("is_superuser") === "1") : ?>
                <div class="nk-menu-content" data-content="navComponents">
                    <h5 class="title">Configuraciones</h5>
                    <ul class="nk-menu">

                        <li class="nk-menu-item">
                            <a href="<?php echo base_url() . 'admin/settings' ?>" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-opt-dot"></em></span>
                                <span class="nk-menu-text">Generales</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                                <span class="nk-menu-text">Usuarios</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="<?php echo base_url() . 'admin/user-add' ?>" class="nk-menu-link"><span class="nk-menu-text">Agregar</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="<?php echo base_url() . 'admin/users' ?>" class="nk-menu-link"><span class="nk-menu-text">Lista de Usuarios</span></a>
                                </li>
                            </ul>
                        </li>

                        <li class="nk-menu-item">
                            <a href="<?php echo base_url() . 'admin/email-settings' ?>" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-mail-fill"></em></span>
                                <span class="nk-menu-text">Correo Electronico</span>
                            </a>
                        </li>
                    </ul><!-- .nk-menu -->
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>