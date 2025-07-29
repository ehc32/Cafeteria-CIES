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
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Eventos registrados</h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>">INICIO</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url() . 'admin/activity-logs?type=login' ?>">Login (<?php echo !empty($login_count) ? $login_count : 0 ?>)</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url() . 'admin/activity-logs?type=delete' ?>">Eliminados (<?php echo !empty($delete_count) ? $delete_count : 0 ?>)</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url() . 'admin/activity-logs?type=disable' ?>">Deshabilitados (<?php echo !empty($disable_count) ? $disable_count : 0 ?>)</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url() . 'admin/activity-logs?type=enable' ?>">Habilitados (<?php echo !empty($enable_count) ? $enable_count : 0 ?>)</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url() . 'admin/activity-logs?type=status' ?>">Estados (<?php echo !empty($status_count) ? $status_count : 0 ?>)</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url() . 'admin/activity-logs?type=store' ?>">Almacenamiento (<?php echo !empty($store_count) ? $store_count : 0 ?>)</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <a href="<?php echo base_url() ?>" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Regresar</span></a>
                                        <a href="<?php echo base_url() ?>" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                    </div>
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <!-- include message block -->
                            <?php $this->load->view('admin/partials/_mesagges'); ?>

                            <div class="nk-block">
                                <div class="card card-bordered card-stretch">
                                    <div class="card-inner-group">

                                        <div class="card-inner position-relative card-tools-toggle">
                                            <div class="card-title-group">
                                                <div class="card-tools">
                                                    <div class="form-inline flex-nowrap gx-3">
                                                        <div class="form-wrap w-200px">
                                                            <select class="form-select form-select-sm" data-search="off" data-placeholder="Bulk Action" id="type">
                                                                <option value="all" <?php echo ($type == "all") ? "selected" : ""; ?>>Todos</option>
                                                                <option value="login" <?php echo ($type == "login") ? "selected" : ""; ?>>Login</option>
                                                                <option value="delete" <?php echo ($type == "delete") ? "selected" : ""; ?>>Eliminados</option>
                                                                <option value="disable" <?php echo ($type == "disable") ? "selected" : ""; ?>>Deshabilitados</option>
                                                                <option value="enable" <?php echo ($type == "enable") ? "selected" : ""; ?>>Habilitados</option>
                                                                <option value="status" <?php echo ($type == "status") ? "selected" : ""; ?>>Estados</option>
                                                                <option value="store" <?php echo ($type == "store") ? "selected" : ""; ?>>Almacenamiento</option>
                                                            </select>
                                                        </div>
                                                        <div class="btn-wrap">
                                                            <span class="d-none d-md-block"><button class="btn btn-outline-light" onclick="search();">Filtra por tipo</button></span>
                                                            <span class="d-md-none"><button class="btn btn-outline-light btn-icon" onclick="search();"><em class="icon ni ni-arrow-right"></em></button></span>
                                                        </div>

                                                        <?php if (is_admin() /* $this->session->userdata("is_superuser") === "1" */) : ?>
                                                            <div class="btn-wrap">
                                                                <span class="d-none d-md-block"><button class="btn btn-outline-danger" onclick="delete_item(
                                                                'admin_controller/clear_activity_log_post',
                                                                'activity_log', /* Nombre de la tabla posición del ID*/
                                                                '¡Registros de eventos limpiados!'
                                                            );">Limpia todos los eventos</button></span>
                                                                <span class="d-md-none"><button class="btn btn-outline-light btn-icon text-danger" onclick="delete_item(
                                                                'admin_controller/clear_activity_log_post',
                                                                'activity_log', /* Nombre de la tabla posición del ID*/
                                                                '¡Registros de eventos limpiados!'
                                                            );"><em class="icon ni ni-trash"></em></button></span>
                                                            </div>
                                                        <?php endif; ?>

                                                    </div><!-- .form-inline -->
                                                </div><!-- .card-tools -->
                                            </div><!-- .card-title-group -->
                                        </div><!-- .card-inner -->

                                        <div class="card-inner p-0">
                                            <div class="nk-tb-list nk-tb-ulist">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col"><span></span></div>
                                                    <div class="nk-tb-col tb-col-mb"><span>Descripción</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span>Fecha/Hora</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>Tipo</span></div>
                                                    <div class="nk-tb-col nk-tb-col-tools">&nbsp;</div>
                                                </div><!-- .nk-tb-item -->
                                                <?php if (!empty($activity_logs)) : ?>
                                                    <?php foreach ($activity_logs as $log) : ?>
                                                        <div class="nk-tb-item">
                                                            <!-- ID -->
                                                            <div class="nk-tb-col tb-col-mb">
                                                                <span class="tb-lead-sub"><?php echo $log->id ?></span>
                                                            </div>

                                                            <!-- Descripción -->
                                                            <div class="nk-tb-col">
                                                                <div class="user-card">
                                                                    <div class="user-info">
                                                                        <span class="tb-lead-sub"><?php echo $log->description ?> [<?php echo $log->userFullname ?>]</span>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="nk-tb-col tb-col-lg">
                                                                <span class="tb-date"><?php echo $log->date ?></span>
                                                            </div>

                                                            <div class="nk-tb-col tb-col-md">
                                                                <?php if ($log->type == "login") : ?>
                                                                    <span class="tb-status text-primary"><?php echo $log->type ?></span>
                                                                    <span data-toggle="tooltip" title="[ <?php echo time_ago($log->date); ?> ]" data-placement="top"><em class="icon ni ni-info"></em></span>
                                                                <?php elseif ($log->type == "disable") : ?>
                                                                    <span class="tb-status text-warning"><?php echo $log->type ?></span>
                                                                    <span data-toggle="tooltip" title="[ <?php echo time_ago($log->date); ?> ]" data-placement="top"><em class="icon ni ni-info"></em></span>
                                                                <?php elseif ($log->type == "enable") : ?>
                                                                    <span class="tb-status text-success"><?php echo $log->type ?></span>
                                                                    <span data-toggle="tooltip" title="[ <?php echo time_ago($log->date); ?> ]" data-placement="top"><em class="icon ni ni-info"></em></span>
                                                                <?php elseif ($log->type == "status") : ?>
                                                                    <span class="tb-status text-info"><?php echo $log->type ?></span>
                                                                    <span data-toggle="tooltip" title="[ <?php echo time_ago($log->date); ?> ]" data-placement="top"><em class="icon ni ni-info"></em></span>
                                                                <?php elseif ($log->type == "delete") : ?>
                                                                    <span class="tb-status text-danger"><?php echo $log->type ?></span>
                                                                    <span data-toggle="tooltip" title="[ <?php echo time_ago($log->date); ?> ]" data-placement="top"><em class="icon ni ni-info"></em></span>
                                                                <?php elseif ($log->type == "store") : ?>
                                                                    <span class="tb-status text-indigo"><?php echo $log->type ?></span>
                                                                    <span data-toggle="tooltip" title="[ <?php echo time_ago($log->date); ?> ]" data-placement="top"><em class="icon ni ni-info"></em></span>
                                                                <?php else : ?>
                                                                    <span class="badge badge-dot badge-gray">unknown</span>
                                                                    <span data-toggle="tooltip" title="¡Evento desconocido!" data-placement="top"><em class="icon ni ni-info"></em></span>
                                                                <?php endif; ?>
                                                            </div>

                                                            <div class="nk-tb-col nk-tb-col-tools">
                                                                <ul class="nk-tb-actions gx-1">
                                                                    <li>
                                                                        <div class="drodown">
                                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <ul class="link-list-opt no-bdr">
                                                                                    <li><a href="<?php echo base_url() . 'admin_controller/delete_log_post/' . $log->id ?>"><em class="icon ni ni-trash text-danger"></em><span>Eliminar</span></a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        </div><!-- .nk-tb-item -->
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div><!-- .card-inner TABLA-->

                                        <div class="card-inner">
                                            <div class="nk-block-between-md g-3">
                                                <div class="g">
                                                    <ul class="pagination justify-content-center justify-content-md-start">
                                                        <?php if(!empty($links)) echo $links ?>
                                                    </ul><!-- .pagination -->
                                                </div>
                                            </div><!-- .nk-block-between -->
                                        </div><!-- .card-inner -->

                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
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

<script>
    "use strict";
    //const base_url = document.getElementById('base_url').value;

    //const base_url = document.getElementById('base_url').value;

    // capturamos todos los li con clase .page-item
    let paginacion = document.querySelectorAll('.page-item');
    // recorrer todos los li
    paginacion.forEach(element =>{
        // si el elemento tiene un enlace <a></a>
        if(element.lastChild.nodeName === 'A'){
            // le ponemos la clase .page-link
            element.lastChild.classList.add('page-link');
        }else{
           //  Si no tiene un <a></a>  
           let a = document.createElement("a");
           // poner el valor
           a.innerHTML = element.innerHTML;
           // agregamos la clase .page-link
           a.classList.add('page-link');
           // caoturamos el elemento padre
           const container = document.querySelector(".page-item.active");
           // limpiamos su innerHTML y le ponemos el elemento creado en su hijo
           container.innerHTML = '';
           container.appendChild(a);
        }
    });

    // buscar
    const search=()=>{
        const type = document.getElementById('type').value;
        window.location.href = base_url + 'admin/activity-logs?type='+type;
    }


</script>



</body>

</html>