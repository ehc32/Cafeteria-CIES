<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view("admin/includes/_header"); ?>

<div class="nk-app-root">
    <?php $this->load->view("admin/includes/_sidebar"); ?>
    <div class="nk-main">
        <div class="nk-wrap">
            <?php $this->load->view("admin/includes/_main-header"); ?>
            <div class="nk-content">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between g-3">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Detalle de Receta</h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/inicio">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/recetas">Recetas</a></li>
                                                <li class="breadcrumb-item active">Detalle</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <?php if (!empty($receta)) : ?>
                                        <a href="<?php echo base_url('admin/recetas/export_pdf/' . $receta->id); ?>" class="btn btn-outline-primary">
                                            <em class="icon ni ni-printer"></em>
                                            <span>Exportar PDF</span>
                                        </a>
                                        <?php endif; ?>
                                        <a href="<?php echo base_url(); ?>admin/recetas" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                            <em class="icon ni ni-arrow-left"></em>
                                            <span>Regresar</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <?php $this->load->view('admin/partials/_mesagges'); ?>

                            <?php if (!empty($receta)) : ?>
                            <div class="nk-block">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="border rounded p-3 h-100">
                                                    <h5 class="mb-2"><?php echo html_escape($receta->nombre); ?></h5>
                                                    <div class="text-soft small">Nº Receta</div>
                                                    <div class="fw-bold mb-2"><?php echo html_escape($receta->numero_receta); ?></div>
                                                    <div class="text-soft small">Descripción</div>
                                                    <div><?php echo nl2br(html_escape($receta->descripcion)); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="border rounded p-3 h-100">
                                                    <h6 class="mb-3">Resumen de Costos</h6>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-soft">Costo Ingredientes</span>
                                                        <span class="fw-bold">$<?php echo number_format((float)$receta->costo_total_ingredientes, 2); ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-soft">Margen Variación</span>
                                                        <span class="fw-bold"><?php echo number_format((float)$receta->margen_variacion, 2); ?>%</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-soft">Costo Total de la Preparación</span>
                                                        <span class="fw-bold">$<?php echo number_format((float)$receta->costo_total_preparacion, 2); ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-soft">Número de Porciones</span>
                                                        <span class="fw-bold"><?php echo (int)$receta->numero_porciones; ?></span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-soft">Costo por Porción</span>
                                                        <span class="fw-bold">$<?php echo number_format((float)$receta->costo_por_porcion, 2); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="nk-block mt-3">
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <h6 class="card-title mb-3">Ingredientes</h6>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th class="text-right">Cantidad</th>
                                                        <th>Unidad</th>
                                                        <th class="text-right">Valor Unitario</th>
                                                        <th class="text-right">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($receta->ingredientes)) : ?>
                                                        <?php foreach ($receta->ingredientes as $ing) : ?>
                                                            <tr>
                                                                <td><?php echo html_escape($ing->producto_nombre ?? 'Producto (sin inventario)'); ?></td>
                                                                <td class="text-right"><?php echo number_format((float)$ing->cantidad, 2); ?></td>
                                                                <td><?php echo html_escape($ing->unidad); ?></td>
                                                                <td class="text-right">$<?php echo number_format((float)$ing->valor_unitario, 2); ?></td>
                                                                <td class="text-right">$<?php echo number_format((float)$ing->valor_total, 2); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center text-soft">Sin ingredientes</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                                <div class="alert alert-warning">Receta no encontrada.</div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("admin/includes/_JavaScripts"); ?>
</body>
</html>


