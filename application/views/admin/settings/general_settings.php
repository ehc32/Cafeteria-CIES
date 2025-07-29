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
                                        <h3 class="nk-block-title page-title">Configuraciones generales | <strong class="text-primary small">IoT SENA</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Inicio</a></li>
                                                <li class="breadcrumb-item active">Edita las configuraciones generales</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="<?php echo base_url() ?>admin/dashboard" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Regresar</span></a>
                                        <a href="<?php echo base_url() ?>admin/dashboard" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h4 class="nk-block-title">Ajustes generales de la aplicación</h4>
                                    <div class="nk-block-des">
                                        <strong class="text-dark">Nota:</strong> Modifique los ajustes generales del sistema.
                                    </div>
                                </div>
                            </div>
                            <!-- include message block -->
                            <?php $this->load->view('admin/partials/_mesagges'); ?>
                            <!-- form start -->
                            <?php echo form_open_multipart('settings_controller/settings_post'); ?>

                            <div class="nk-block nk-block-lg">
                                <div class="card card-preview">
                                    <div class="card-inner">

                                        <ul class="nav nav-tabs mt-n3">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#tabItemGeneral"><em class="icon ni ni-layout"></em><span>Aplicación</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tabItemAppearance"><em class="icon ni ni-color-palette"></em><span>Apariencia</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tabItemContact"><em class="icon ni ni-mail"></em><span>Contacto</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tabItemSocialNetworks"><em class="icon ni ni-facebook-circle"></em><span>Redes sociales</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tabItemCss"><em class="icon ni ni-css3-fill"></em><span>Códigos CSS personalizados</span></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tabItemJavaScript"><em class="icon ni ni-js"></em><span>Códigos JavaScript personalizados</span></a>
                                            </li>
                                        </ul>


                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tabItemGeneral">
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Zona Horaria</label>
                                                            <span class="form-note">Selecciona la zona horaria de la aplicación</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <div class="form-control-select">
                                                                    <select class="form-select" id="timezone" name="timezone" data-search="on">
                                                                        <?php $timezones = timezone_identifiers_list();
                                                                        if (!empty($timezones)) :
                                                                            foreach ($timezones as $timezone) : ?>
                                                                                <option value="<?php echo $timezone; ?>" <?php echo ($timezone == $this->general_settings->timezone) ? 'selected' : ''; ?>><?php echo $timezone; ?></option>
                                                                        <?php endforeach;
                                                                        endif; ?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Nombre de la aplicación</label>
                                                            <span class="form-note">Especifica un nombre para la aplicación</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="application_name" name="application_name" placeholder="Nombre de la aplicación" value="<?php echo html_escape($form_settings->application_name); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Descripción</label>
                                                            <span class="form-note">Agrega una descripción para la aplicación</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <textarea class="form-control no-resize" id="site_description" name="site_description"><?php echo html_escape($form_settings->site_description); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Palabras claves</label>
                                                            <span class="form-note">Agrega palabras clave para la aplicación</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <textarea class="form-control no-resize" id="keywords" name="keywords"><?php echo html_escape($form_settings->keywords); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Copyright</label>
                                                            <span class="form-note">Agrega un Copyright para la aplicación</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="copyright" name="copyright" placeholder="copyright" value="<?php echo html_escape($form_settings->copyright); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane" id="tabItemAppearance">
                                                <!-- Logo -->
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <div class="preview-icon-box card card-bordered">
                                                                <div class="preview-icon-wrap">
                                                                    <?php if (!empty($this->general_settings->logo_path)) : ?>
                                                                        <img class="rounded-top" src="<?php echo base_url() . html_escape($this->general_settings->logo_path); ?>" alt="" style="max-width: 100px; padding: 5px;">
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div><!-- .preview-icon-box -->
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Logo actual</label>
                                                            <span class="form-note">Imágen del logo actual</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Logo</label>
                                                            <div class="form-control-wrap">
                                                                <input type="file" class="custom-file-input" id="logo_path" accept="image/*" name="logo">
                                                                <label class="custom-file-label">Selecciona una imagen</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end Logo -->

                                                <!-- Fav icon -->
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <div class="preview-icon-box card card-bordered">
                                                                <div class="preview-icon-wrap">
                                                                    <?php if (!empty($this->general_settings->favicon_path)) : ?>
                                                                        <img class="rounded-top" src="<?php echo base_url() . html_escape($this->general_settings->favicon_path); ?>" alt="" style="max-width: 100px; padding: 5px;">
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div><!-- .preview-icon-box -->
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Fav Icon actual</label>
                                                            <span class="form-note">Imágen del Fav Icon actual</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Fav Icon</label>
                                                            <div class="form-control-wrap">
                                                                <input type="file" class="custom-file-input" id="favicon_path" accept="image/*" name="favicon">
                                                                <label class="custom-file-label">Selecciona una imagen</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- end Fav icon -->

                                                <!-- Claro / Oscuro -->
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Modo Claro/Oscuro</label>
                                                            <span class="form-note">Cambia de apariencia a Claro/Oscuro</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <div class="g">
                                                                    <div class="custom-control custom-control-lg custom-switch">
                                                                        <?php if ($this->general_settings->dark_mode) : ?>
                                                                            <input type="checkbox" class="custom-control-input" id="dark_mode" checked="" onchange="set_mode('0')">
                                                                            <label class="custom-control-label" for="dark_mode">Oscuro</label>
                                                                        <?php else : ?>
                                                                            <input type="checkbox" class="custom-control-input" id="dark_mode" onchange="set_mode('1')">
                                                                            <label class="custom-control-label" for="dark_mode">Claro</label>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- End Claro / Oscuro -->
                                            </div>



                                            <div class="tab-pane" id="tabItemContact">

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Dirección</label>
                                                            <span class="form-note">Dirección de contacto</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="contact_address" name="contact_address" placeholder="Dirección" value="<?php echo html_escape($form_settings->contact_address); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Correo electrónico</label>
                                                            <span class="form-note">Correo electrónico de contacto</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="Correo" value="<?php echo html_escape($form_settings->contact_email); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Teléfono</label>
                                                            <span class="form-note">Teléfono de contacto</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" placeholder="Teléfono" value="<?php echo html_escape($form_settings->contact_phone); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="tabItemSocialNetworks">
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Facebook</label>
                                                            <span class="form-note">Url de Facebook</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="facebook_url" name="facebook_url" placeholder="Facebook" value="<?php echo html_escape($form_settings->facebook_url); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Twitter</label>
                                                            <span class="form-note">Url de Twitter</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="twitter_url" name="twitter_url" placeholder="Twitter" value="<?php echo html_escape($form_settings->twitter_url); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">YouTube</label>
                                                            <span class="form-note">Url de YouTube</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="youtube_url" name="youtube_url" placeholder="Youtube" value="<?php echo html_escape($form_settings->youtube_url); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane" id="tabItemCss">
                                                <div class="row gy-4">
                                                    <div class="col-sm-12">
                                                        <label class="form-label">Códigos CSS personalizados <mark>(Estos códigos se agregarán al encabezado del sitio.)</mark></label>
                                                        <div class="form-control-wrap">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">CSS</span>
                                                                </div>
                                                                <textarea class="form-control" aria-label="CSS" id="custom_css_codes" name="custom_css_codes"><?php echo $this->general_settings->custom_css_codes; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            E.g. <?php echo html_escape("<style> body {background-color: #00a65a;} </style>"); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <div class="tab-pane" id="tabItemJavaScript">
                                                <div class="row gy-4">
                                                    <div class="col-sm-12">

                                                        <label class="form-label">Códigos JavaScript personalizados <mark>(Estos códigos se agregarán al pie de página del sitio.)</mark></label>
                                                        <div class="form-control-wrap">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">JavaScript</span>
                                                                </div>
                                                                <textarea class="form-control" aria-label="With textarea" id="custom_javascript_codes" name="custom_javascript_codes"><?php echo $this->general_settings->custom_javascript_codes; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            E.g. <?php echo html_escape("<script> alert('Hello!'); </script>"); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 offset-md-0 mt-4">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-outline-primary">Guardar los cambios</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div><!-- .card-preview -->
                            </div>

                            <?php echo form_close(); ?>
                            <!-- form close-->
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
<script>
    function set_mode(dark_mode){
        const base_url = document.getElementById('base_url').value;
        let data = {
            'dark_mode': dark_mode  /* 0 | 1 */
        }
        $.ajax({
            type: "POST",
            url: base_url + "settings_controller/set_mode_post",
            data: data,
            success: function(response) {
                location.reload(); // volver a cargar la pagina
            }
        });
    }
</script>
<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>
</body>

</html>