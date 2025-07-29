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
                                        <h3 class="nk-block-title page-title">Dispositivo genérico | SN: <strong class="text-primary small device"><?php echo $device == NULL ? "-" : $device->serialnumber; ?> </strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/devices-list">Dispositivos</a></li>
                                                <li class="breadcrumb-item active">Información del dispositivo</li>
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
                                <div class="row g-gs">
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title text-primary">NO. SERIE</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <span class="amount"><?php echo $device == NULL ? "-" : $device->serialnumber; ?></span>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title text-primary">NOMBRE</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <span class="amount"><?php echo $device == NULL ? "-" : $device->name; ?></span>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title text-primary">DIRECCIÓN</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <span class="amount"><?php echo $device == NULL ? "-" : $device->address; ?></span>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-xxl-3 col-sm-6">
                                        <div class="card">
                                            <div class="nk-ecwg nk-ecwg6">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title text-primary">REGISTRADO</h6>
                                                        </div>
                                                    </div>
                                                    <div class="data">
                                                        <div class="data-group">
                                                            <span class="amount"><?php echo $device == NULL ? "-" : $device->created ?></span>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .nk-ecwg -->
                                        </div><!-- .card -->
                                    </div><!-- .col arriba-->

                                    <div class="col-xxl-3 col-md-6">
                                        <div class="card">
                                            <div class="card-full overflow-hidden card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                    <span class="variable_name"><?php echo $device == NULL ? "-" : $device->variable1 . ' / ' . $device->unidad1; ?></span>
                                                        <style>
                                                            .variable_name {
                                                                max-width: 200px;
                                                                width: 100%;
                                                                padding: 6px;
                                                                margin: 10px 0px 40px;
                                                                font-size: 1.05rem;
                                                                border: none;
                                                                text-align: center;
                                                                font-family: Nunito, sans-serif;
                                                                font-weight: 700;
                                                                color: #0fac81;
                                                            }
                                                        </style>
                                                    </div>
                                                </div>
                                                <div class="card-inner text-center">
                                                    <div class="nk-knob text-center">
                                                    <input type="text" class="card-title border-0" style="font-size: 20px; color: black; font-weight: bold;" id="deviceDS18B20TempCG_<?php echo $device == NULL ? '' : $device->serialnumber ?>" value="<?php echo $device == NULL ? '' :  ' / ' . $device->unidad1 ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-md-6">
                                        <div class="card">
                                            <div class="card-full overflow-hidden card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                    <span class="variable_name"><?php echo $device == NULL ? "-" : $device->variable2 . ' / ' . $device->unidad2; ?></span>
                                                    </div>
                                                </div>
                                                <div class="card-inner text-center">
                                                    <div class="nk-knob text-center">
                                                        <input type="text" class="card-title border-0" style="font-size: 20px; color: black; font-weight: bold;" id="deviceDS18B20TempFG_<?php echo $device == NULL ? '' : $device->serialnumber ?>" value="<?php echo $device == NULL ? '' :  ' / ' . $device->unidad2 ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-md-6">
                                        <div class="card">
                                            <div class="card-full overflow-hidden card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                    <span class="variable_name"><?php echo $device == NULL ? "-" : $device->variable3 . ' / ' . $device->unidad3; ?></span>
                                                    </div>
                                                </div>
                                                <div class="card-inner text-center">
                                                    <div class="nk-knob text-center">
                                                        <input type="text" class="card-title border-0" style="font-size: 20px; color: black; font-weight: bold;" id="deviceCpuTempCG_<?php echo $device == NULL ? '' : $device->serialnumber ?>" value="<?php echo $device == NULL ? '' :  ' / ' . $device->unidad3 ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-md-6">
                                        <div class="card">
                                            <div class="card-full overflow-hidden card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                    <span class="variable_name"><?php echo $device == NULL ? "-" : $device->variable4 . ' / ' . $device->unidad4; ?></span>
                                                    </div>
                                                </div>
                                                <div class="card-inner text-center">
                                                    <div class="nk-knob text-center">
                                                        <input type="text" class="card-title border-0" style="font-size: 20px; color: black; font-weight: bold;" id="deviceRestartsG_<?php echo $device == NULL ? '' : $device->serialnumber ?>" value="<?php echo $device == NULL ? '' :  ' / ' . $device->unidad4 ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                 

                                    <!-- Información -->
                                    <div class="col-md-12 col-xxl-12 text-center">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Información del dispositivo</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner">
                                                <ul class="nk-top-products">
                                                    <li class="item">
                                                        <div class="thumb">
                                                            <em class="icon ni ni-circle-fill"></em>
                                                        </div>
                                                        <div class="info">
                                                            <div class="title"><span class="">Estado de la conexión:</span></div>
                                                        </div>
                                                        <div class="total">
                                                            <div class="amount"><span class="ml-auto">
                                                                    <?php if ($device != NULL) : ?>
                                                                        <?php echo $device->online ?
                                                                            '<span class="tb-odr-status">
                                                                            <span class="badge badge-dot badge-primary">Online</span>
                                                                        </span>'
                                                                            :
                                                                            '<span class="tb-odr-status">
                                                                            <span class="badge badge-dot badge-danger">Offline</span>
                                                                        </span>'
                                                                        ?>
                                                                    <?php else : ?>
                                                                        <span class="tb-odr-status">
                                                                            <span class="badge badge-dot badge-danger">Unknow</span>
                                                                        </span>
                                                                    <?php endif; ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="item">
                                                        <div class="thumb">
                                                            <em class="icon ni ni-clock"></em>
                                                        </div>
                                                        <div class="info">
                                                            <div class="title"><span class="">Ultima conexión:</span></div>
                                                        </div>
                                                        <div class="total">
                                                            <div class="amount"><?php echo $device == NULL ? '' : time_ago($device->lastseen); ?></div>
                                                        </div>
                                                    </li>
                                                  
                                                    <li class="item">
                                                        <div class="thumb">
                                                            <em class="icon ni ni-wifi"></em>
                                                        </div>
                                                        <div class="info">
                                                            <div class="title"><span class="">WiFi RSSI:</span> </div>
                                                        </div>
                                                        <div class="total">
                                                            <div class="amount"><span class="ml-auto" id="wifiRssiStatusG_<?php echo $device == NULL ? '' : $device->serialnumber ?>">-</span>dBm</div>
                                                        </div>
                                                    </li>
                                                    <li class="item">
                                                        <div class="thumb">
                                                            <em class="icon ni ni-signal"></em>
                                                        </div>
                                                        <div class="info">
                                                            <div class="title"><span class="">Señal del WiFi:</span> </div>
                                                        </div>
                                                        <div class="total">
                                                            <div class="amount"><span class="ml-auto" id="wifiQualityG_<?php echo $device == NULL ? '' : $device->serialnumber ?>">-</span>%</div>
                                                        </div>
                                                    </li>
                                                  
                                                    <li class="item">
                                                        <div class="thumb">
                                                            <em class="icon ni ni-clock"></em>
                                                        </div>
                                                        <div class="info">
                                                            <div class="title"><span class="">Tiempo de actividad:</span> </div>
                                                        </div>
                                                        <div class="total">
                                                            <div class="amount"><span class="ml-auto" id="deviceActiveTimeSecondsG_<?php echo $device == NULL ? '' : $device->serialnumber ?>">-</span></div>
                                                        </div>
                                                    </li>
                                                    <li class="item">
                                                        <div class="thumb">
                                                            <em class="icon ni ni-network"></em>
                                                        </div>
                                                        <div class="info">
                                                            <div class="title"><span class="">Dirección IPv4 local:</span> </div>
                                                        </div>
                                                        <div class="total">
                                                            <div class="amount"><span class="ml-auto" id="wifiIPv4G_<?php echo $device == NULL ? '' : $device->serialnumber ?>">-</span></div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col información -->

                                    <!-- Notificaciones -->
                                    <div class="col-md-12 col-xxl-12">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Historial de notificaciones</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner">
                                                <div class="timeline">
                                                    <h6 class="timeline-head"><?php echo date('M') ?>, <?php echo date('Y') ?></h6>
                                                    <ul class="timeline-list">
                                                        <?php if (!empty($device_log)) : ?>
                                                            <?php foreach ($device_log as $log) : ?>

                                                                <?php if ($log->type == "store") : ?>
                                                                    <li class="timeline-item">
                                                                        <div class="timeline-status bg-danger"></div>
                                                                        <div class="timeline-date"><?php echo $log->date ?> <em class="icon ni ni-alarm-alt"></em></div>
                                                                        <div class="timeline-data">
                                                                            <h6 class="timeline-title"><?php echo $log->userFullname ?></h6>
                                                                            <div class="timeline-des">
                                                                                <p><?php echo $log->description ?></p>
                                                                                <span class="time"><?php echo time_ago($log->date) ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                <?php elseif ($log->type == "status") : ?>
                                                                    <li class="timeline-item">
                                                                        <div class="timeline-status bg-info"></div>
                                                                        <div class="timeline-date"><?php echo $log->date ?> <em class="icon ni ni-alarm-alt"></em></div>
                                                                        <div class="timeline-data">
                                                                            <h6 class="timeline-title"><?php echo $log->userFullname ?></h6>
                                                                            <div class="timeline-des">
                                                                                <p><?php echo $log->description ?></p>
                                                                                <span class="time"><?php echo time_ago($log->date) ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                <?php elseif ($log->type == "disable") : ?>
                                                                    <li class="timeline-item">
                                                                        <div class="timeline-status bg-warning"></div>
                                                                        <div class="timeline-date"><?php echo $log->date ?> <em class="icon ni ni-alarm-alt"></em></div>
                                                                        <div class="timeline-data">
                                                                            <h6 class="timeline-title"><?php echo $log->userFullname ?></h6>
                                                                            <div class="timeline-des">
                                                                                <p><?php echo $log->description ?></p>
                                                                                <span class="time"><?php echo time_ago($log->date) ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                <?php elseif ($log->type == "enable") : ?>
                                                                    <li class="timeline-item">
                                                                        <div class="timeline-status bg-success"></div>
                                                                        <div class="timeline-date"><?php echo $log->date ?> <em class="icon ni ni-alarm-alt"></em></div>
                                                                        <div class="timeline-data">
                                                                            <h6 class="timeline-title"><?php echo $log->userFullname ?></h6>
                                                                            <div class="timeline-des">
                                                                                <p><?php echo $log->description ?></p>
                                                                                <span class="time"><?php echo time_ago($log->date) ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                <?php endif; ?>

                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->

                                    <!-- Tablas de datos -->
                                    <div class="col-md-12 col-xxl-12">
                                        <div class="nk-block nk-block-lg">
                                            <div class="nk-block-head">
                                                <div class="nk-block-head-content">
                                                    <h4 class="nk-block-title">Datos almacenados del dispositivo</h4>
                                                    <div class="nk-block-des">
                                                        <!-- include message block -->
                                                        <?php $this->load->view('admin/partials/_mesagges'); ?>
                                                        <!-- form start -->
                                                        <?php echo form_open_multipart(current_url()); ?>
                                                        <input type="hidden" name="form" value="1">
                                                        <div class="row mt-3">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="fechaInicio">Fecha de inicio</label>
                                                                    <div class="form-control-wrap focused">
                                                                        <div class="form-icon form-icon-left">
                                                                            <em class="icon ni ni-calendar"></em>
                                                                        </div>
                                                                        <input type="text" id="fechaInicio" name="fechaInicio" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?php echo old('fechaInicio') ?>">
                                                                    </div>
                                                                    <div class="form-note">Formato de fecha <code>yyyy-mm-dd</code></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="fechaFinal">Fecha de fin</label>
                                                                    <div class="form-control-wrap focused">
                                                                        <div class="form-icon form-icon-left">
                                                                            <em class="icon ni ni-calendar"></em>
                                                                        </div>
                                                                        <input type="text" id="fechaFinal" name="fechaFinal" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?php echo old('fechaFinal') ?>">
                                                                    </div>
                                                                    <div class="form-note">Formato de fecha <code>yyyy-mm-dd</code></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label class="form-label">Acciones</label>
                                                                    <li class="">
                                                                        <a href="<?php echo base_url(); ?>admin/devices/view/<?php echo get_serial64($device->serialnumber) ?>" class="btn btn-outline-secondary">Restablecer</a>
                                                                        <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                                                                    </li>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php echo form_close(); ?><!-- form end -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card card-preview">
                                                <div class="card-inner">
                                                    <table class="datatable-init-export nowrap table" data-export-title="Export">
                                                        <thead>
                                                            <tr>
                                                                <th>MQTT ID</th>
                                                                <th>Serial</th>
                                                                <th class="text-center"><?php echo $device == NULL ? "-" : $device->variable1; ?></th>
                                                                <th class="text-center"><?php echo $device == NULL ? "-" : $device->variable2; ?></th>
                                                                <th class="text-center"><?php echo $device == NULL ? "-" : $device->variable3; ?></th>
                                                                <th class="text-center"><?php echo $device == NULL ? "-" : $device->variable4; ?></th>
                                                                <th class="text-center">RSSI</th>
                                                                <th class="text-center">WIFI (%)</th>
                                                                <th class="text-center">Fecha y hora</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           

                                                            <?php if (!empty($device_data)) : ?>
                                                                <?php foreach ($device_data as $data) : ?>
                                                                    <tr>
                                                                        <td><?php echo $data->deviceMqttId ?></td>
                                                                        <td><?php echo $data->deviceSerial ?></td>
                                                                        <td class="text-center"><?php echo round($data->deviceCpuTempC, 2) ?></td><p><?php echo $device->unidad1; ?></p>
                                                                        <td class="text-center"><?php echo round($data->deviceDS18B20TempC, 2) ?><?php echo $device->unidad2; ?></td>
                                                                        <td class="text-center"><?php echo round($data->deviceDS18B20TempF, 2) ?><?php echo $device->unidad3; ?></td>
                                                                        <td class="text-center"><?php echo $data->deviceRestarts ?> <?php echo $device->unidad4; ?></td>
                                                                        <td class="text-center">
                                                                            <?php if ($data->wifiRssiStatus >= -76) : ?>
                                                                                <?php echo '<span class="badge badge-primary">' . $data->wifiRssiStatus . '</span>' ?>
                                                                            <?php elseif ($data->wifiRssiStatus <= -77 && $data->wifiRssiStatus > -89) : ?>
                                                                                <?php echo '<span class="badge badge-info">' . $data->wifiRssiStatus . '</span>' ?>
                                                                            <?php elseif ($data->wifiRssiStatus <= -90 && $data->wifiRssiStatus > -97) : ?>
                                                                                <?php echo '<span class="badge badge-warning">' . $data->wifiRssiStatus . '</span>' ?>
                                                                            <?php elseif ($data->wifiRssiStatus <= -98 && $data->wifiRssiStatus > -103) : ?>
                                                                                <?php echo '<span class="badge badge-danger">' . $data->wifiRssiStatus . '</span>' ?>
                                                                            <?php elseif ($data->wifiRssiStatus <= -113 && $data->wifiRssiStatus > -132) : ?>
                                                                                <?php echo '<span class="badge badge-secondary">' . $data->wifiRssiStatus . '</span>' ?>
                                                                            <?php else : ?>
                                                                                <?php echo '<span class="badge badge-dark">' . $data->wifiRssiStatus . '</span>' ?>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php echo $data->wifiQuality ?>
                                                                        </td>
                                                                        <td class="text-center"><?php echo $data->created ?></td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div><!-- .card-preview -->
                                        </div> <!-- nk-block -->
                                    </div><!-- .col -->

                                    <!-- Tablas de datos -->
                                    <div class="col-md-12 col-xxl-12">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Gráficas de parámetros almacenados en base de datos</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-inner">
                                                <div class="nk-block">
                                                    <div class="nk-block-head">
                                                        <div class="nk-block-head-content">
                                                            <h4 class="nk-block-title">Gráfica tipo Linea</h4>
                                                            <div class="nk-block-des">
                                                                <div class="row mt-3">
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="f_Inicio">Fecha de inicio</label>
                                                                            <div class="form-control-wrap focused">
                                                                                <div class="form-icon form-icon-left">
                                                                                    <em class="icon ni ni-calendar"></em>
                                                                                </div>
                                                                                <input type="text" id="f_Inicio" name="f_Inicio" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="">
                                                                            </div>
                                                                            <div class="form-note">Formato de fecha <code>yyyy-mm-dd</code></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="f_Final">Fecha de fin</label>
                                                                            <div class="form-control-wrap focused">
                                                                                <div class="form-icon form-icon-left">
                                                                                    <em class="icon ni ni-calendar"></em>
                                                                                </div>
                                                                                <input type="text" id="f_Final" name="f_Final" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="">
                                                                            </div>
                                                                            <div class="form-note">Formato de fecha <code>yyyy-mm-dd</code></div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Filtro</label>
                                                                            <div class="form-control-wrap">
                                                                                <select class="form-select" id="select_items" onchange="updateValue(this)">
                                                                                    <option value="4" ><?php echo $device == NULL ? "-" : $device->variable1; ?></option>
                                                                                    <option value="5" ><?php echo $device == NULL ? "-" : $device->variable2; ?></option>
                                                                                    <option value="3" selected><?php echo $device == NULL ? "-" : $device->variable3; ?></option>
                                                                                    <option value="6" ><?php echo $device == NULL ? "-" : $device->variable4; ?></option>
                                                                                    <option value="7">WiFi %</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card card-preview">
                                                        <div class="card-inner">
                                                            <div class="nk-ck">
                                                                <canvas class="line-chart" id="solidLineChart"></canvas>
                                                            </div>
                                                        </div>
                                                    </div><!-- .card-preview -->

                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col gráfica -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
            <input type="hidden" id="deviceId" value="<?php echo $device == NULL ? '' : $device->id ?>">
        </div>
        <!-- wrap @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>

<script>
    // Ejecutar un POST para la data
    const getDataGraph = async ({
        id = "",
        url = "",
        column = "",
        fechainicio = "",
        fechafin = "",
    }) => {
        let data = {
            id: id,
            column: column,
            fechainicio: fechainicio,
            fechafin: fechafin,
        };

        // la base url de la petición
        // const base_url = document.getElementById("base_url").value;
        try {
            const get = base_url + url;
            const response = await fetch(get, {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            });
            const json = await response.json();
            return await json;
        } catch (error) {
            console.log(error);
        }
    }

    const selects = [{
            name: 'Relay01',
            value: 'deviceRelay1Status',
            unit: 'status',
            color: '#940533'
        },
        {
            name: 'Relay02',
            value: 'deviceRelay2Status',
            unit: 'status',
            color: '#c0012a'
        },
        {
            name: 'Dimmer',
            value: 'deviceDimmer',
            unit: '%',
            color: '#ff8e65'
        },
        {
            name: 'Temp CPU °C',
            value: 'deviceCpuTempC',
            unit: '°C',
            color: '#58ce74'
        },
        {
            name: 'Temp DS18B20 °C',
            value: 'deviceDS18B20TempC',
            unit: '',
            color: '#31827c'
        },
        {
            name: 'Temp DS18B20 °F',
            value: 'deviceDS18B20TempF',
            unit: '',
            color: '#95c68f'
        },
        {
            name: 'WiFi RSSI',
            value: 'wifiRssiStatus',
            unit: 'dBm',
            color: '#ff8800'
        },
        {
            name: 'WiFi %',
            value: 'wifiQuality',
            unit: '%',
            color: '#ffb300'
        },
    ]

    let fechas = [];
    let datas = [];

    // cuando se cargue el DOM
    document.addEventListener("DOMContentLoaded", () => {
        (async () => {
            const data = {
                id: document.getElementById("deviceId").value,
                url: 'devices_controller/get_data_for_graph',
                column: "deviceDS18B20TempC",
                fechainicio: "",
                fechafin: "",
            }
            /* console.log(data);
            return; */
            const resp = await getDataGraph(data);
            //console.log(resp);
            // limppiamos un array de la data
            fechas.length = 0;
            datas.length = 0;
            const nuevoArreglo = resp.map(valor => {
                //console.log(valor.created);
                fechas.push(valor.created);
                datas.push(valor.datos);
            });
            //console.log(fechas);
            let solidLineChart = {
                labels: fechas,
                dataUnit: '°C',
                lineTension: .4,
                legend: false,
                datasets: [{
                    label: "Flujo de Agua",
                    color: "#31827c",
                    background: 'transparent',
                    data: datas
                }]
            };
            lineChart('.line-chart', solidLineChart);
        })()
    });

    async function updateValue(e) {
        //console.log(e);
        const data = {
            id: document.getElementById("deviceId").value,
            url: 'devices_controller/get_data_for_graph',
            column: selects[e.value].value,
            fechainicio: document.getElementById('f_Inicio').value,
            fechafin: document.getElementById('f_Final').value,
        }
        const resp = await getDataGraph(data);
        fechas.length = 0;
        datas.length = 0;
        const nuevoArreglo = resp.map(valor => {
            fechas.push(valor.created);
            datas.push(valor.datos);
        });
        let solidLineChart = {
            labels: fechas,
            dataUnit: selects[e.value].unit,
            lineTension: .4,
            legend: false,
            datasets: [{
                label: selects[e.value].name,
                color: selects[e.value].color,
                background: 'transparent',
                data: datas
            }]
        };
        // llamada al gráfico
        lineChart('.line-chart', solidLineChart);
    }


    function lineChart(selector, set_data) {
        var $selector = selector ? $(selector) : $('.line-chart');
        $selector.each(function() {
            var $self = $(this),
                _self_id = $self.attr('id'),
                _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

            var selectCanvas = document.getElementById(_self_id).getContext("2d");
            var chart_data = [];

            for (var i = 0; i < _get_data.datasets.length; i++) {
                chart_data.push({
                    label: _get_data.datasets[i].label,
                    tension: _get_data.lineTension,
                    backgroundColor: _get_data.datasets[i].background,
                    borderWidth: 2,
                    borderColor: _get_data.datasets[i].color,
                    pointBorderColor: _get_data.datasets[i].color,
                    pointBackgroundColor: '#fff',
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: _get_data.datasets[i].color,
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                    pointHitRadius: 4,
                    data: _get_data.datasets[i].data
                });
            }

            var chart = new Chart(selectCanvas, {
                type: 'line',
                data: {
                    labels: _get_data.labels,
                    datasets: chart_data
                },
                options: {
                    legend: {
                        display: _get_data.legend ? _get_data.legend : false,
                        rtl: NioApp.State.isRTL,
                        labels: {
                            boxWidth: 12,
                            padding: 20,
                            fontColor: '#6783b8'
                        }
                    },
                    maintainAspectRatio: false,
                    tooltips: {
                        enabled: true,
                        rtl: NioApp.State.isRTL,
                        callbacks: {
                            title: function title(tooltipItem, data) {
                                return data['labels'][tooltipItem[0]['index']];
                            },
                            label: function label(tooltipItem, data) {
                                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                            }
                        },
                        backgroundColor: '#eff6ff',
                        titleFontSize: 13,
                        titleFontColor: '#6783b8',
                        titleMarginBottom: 6,
                        bodyFontColor: '#9eaecf',
                        bodyFontSize: 12,
                        bodySpacing: 4,
                        yPadding: 10,
                        xPadding: 10,
                        footerMarginTop: 0,
                        displayColors: false
                    },
                    scales: {
                        yAxes: [{
                            display: true,
                            position: NioApp.State.isRTL ? "right" : "left",
                            ticks: {
                                beginAtZero: false,
                                fontSize: 12,
                                fontColor: '#9eaecf',
                                padding: 10
                            },
                            gridLines: {
                                color: NioApp.hexRGB("#526484", .2),
                                tickMarkLength: 0,
                                zeroLineColor: NioApp.hexRGB("#526484", .2)
                            }
                        }],
                        xAxes: [{
                            display: true,
                            ticks: {
                                fontSize: 12,
                                fontColor: '#9eaecf',
                                source: 'auto',
                                padding: 5,
                                reverse: NioApp.State.isRTL
                            },
                            gridLines: {
                                color: "transparent",
                                tickMarkLength: 10,
                                zeroLineColor: NioApp.hexRGB("#526484", .2),
                                offsetGridLines: true
                            }
                        }]
                    }
                }
            });
        });
    } // init line chart

    //lineChart();
</script>

</body>

</html>