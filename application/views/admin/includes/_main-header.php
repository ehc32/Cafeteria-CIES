<?php

defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="nk-header nk-header-fixed nk-header-fluid is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="html/index.html" class="logo-link">
          
                </a>
            </div><!-- .nk-header-brand -->

            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    </li><!-- .dropdown -->
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <em class="icon ni ni-user-alt"></em>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                            <div class="dropdown-inner user-card-wrap bg-lighter">
                                <div class="user-card">
                                    <style>
                                        .user-card{
                                            width: 300px;
                                        }
                                    </style>
                                    <?php
                                    $re = '/\b(\w)[^\s]*\s*/m';
                                    $str = $this->session->userdata("fullname");
                                    $subst = '$1';
                                    $result = preg_replace($re, $subst, $str);
                                    $photo = $this->session->userdata('photo');
                                    $photo_url = base_url() . 'uploads/profile/avatar_default.jpg';
                                    if (!empty($photo) && file_exists(FCPATH . $photo)) {
                                        $photo_url = base_url() . $photo;
                                    } elseif (!empty($photo)) {
                                        $photo_url = $photo;
                                    }
                                    ?>
                                    <div class="user-avatar">
                                        <img class="avatar_perfil" src="<?php echo $photo_url; ?>">
                                    </div>
                                    <style>
                                        .avatar_perfil{
                                            height: 80px !important;
                                            width: 80px !important;
                                            margin-right: 5px !important;
                                            object-fit: cover !important;
                                            max-width: 100px;
                                        }
                                    </style>
                                    <div class="user-info">
                                        <style>
                                            .user-info{
                                                padding-left: 3em;
                                            }
                                        </style>
                                        <span class="lead-text"><?php echo $this->session->userdata("fullname") ?></span>
                                        <span class="sub-text"><?php echo $this->session->userdata("email") ?></span>
                                        <span class="badge badge-secondary"><?php echo $this->session->userdata("is_superuser") === "1" ? "Administrador" : "Usuario" ?></span>
                                    </div>
                                </div>
                                <style>
                                    .lead-text {
                                        font-size: 16px !important;
                                    }

                                    .sub-text {
                                        font-size: 14px !important;
                                    }
                                </style>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="<?php echo base_url(); ?>admin/user-profile/<?php echo $this->session->userdata("id") ?>"><em class="icon ni ni-user-alt"></em><span>Perfil</span></a></li>
                                </ul>
                            </div>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="<?php echo base_url() ?>logout"><em class="icon ni ni-signout"></em><span>Salir</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>