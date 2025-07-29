<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Cargar Vista de Header -->
<?php $this->load->view("admin/includes/_header"); ?>
<div class="nk-app-root">
    <!-- Cargar Vista de Sidebar -->
    <?php $this->load->view("admin/includes/_sidebar"); ?>
    <!-- main @s -->
    <div class="nk-main">
        <!-- wrap @s -->
        <div class="nk-wrap">
            <!-- main header @s -->
            <?php $this->load->view("admin/includes/_main-header"); ?>
            <!-- main header @e -->

            <!-- content @s -->
            <div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title">Modulo/ <strong class="text-primary small">Entrega de turno</strong></h3>
                                    <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                        <ul class="breadcrumb breadcrumb-pipe">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/inicio">Inicio</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/entrega_turno">Entrega de turno</a></li>
                                            <li class="breadcrumb-item active">Formulario para entrega de turno diario</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- include message block -->
                            <?php $this->load->view('admin/partials/_mesagges'); ?>

                            <div class="nk-block nk-block-lg">
                                <div class="card">
                                    <div class="card-aside-wrap">
                                        <div class="card-content">
                                            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#tabItem1"><em class="icon ni ni-user-circle-fill"></em><span>Entrega de turno </span></a>
                                                </li>
                                            </ul>
                                            <div class="card-inner">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tabItem1">
                                                        <div class="nk-block nk-block-between">
                                                            <div class="nk-block-head">
                                                                <h6 class="title">Información de ventas realizadas el día de hoy.</h6>
                                                                <p></p>
                                                            </div><!-- .nk-block-head -->
                                                        </div><!-- .nk-block-between  -->
                                                        <div class="nk-block">
                                                            <div class="card">
                                                                <div class="nk-tb-list nk-tb-ulist is-compact">
                                                                    <div class="card-inner">
                                                                        <!-- Tabla -->
                                                                        <table class="datatable-init-export nowrap table" data-export-title="Export">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Producto Vendido</th>
                                                                                    <th>Valor Unitario</th>
                                                                                    <th>Cantidad</th>
                                                                                    <th>Valor Total</th>
                                                                                    <th>Descuento</th>
                                                                                    <th>Fecha de venta</th>
                                                                                    <th>Vendedor</th>


                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($ventas as $venta) : ?>
                                                                                    <?php
                                                                                    $productos_vendidos = json_decode($venta->productos_vendidos, true);
                                                                                    if (!empty($productos_vendidos)) {
                                                                                        foreach ($productos_vendidos as $producto) {
                                                                                    ?>
                                                                                            <tr>
                                                                                                <td class="ocultar-venta"><?php echo $venta->id; ?></td>
                                                                                                <td><?php echo $producto['producto']; ?></td>
                                                                                                <td>$<?php echo $producto['valor_unitario']; ?></td>
                                                                                                <td><?php echo $producto['cantidad']; ?></td>
                                                                                                <td>$<?php echo $producto['subtotal']; ?></td>
                                                                                                <td>$<?php echo number_format($venta->descuento, 0); ?></td>
                                                                                                <td><?php echo $venta->created; ?></td>
                                                                                                <td><?php echo $venta->vendedor_username; ?></td>
                                                                                                <style>
                                                                                                    .ocultar-venta {
                                                                                                        display: none;
                                                                                                    }
                                                                                                </style>
                                                                                            </tr>
                                                                                    <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                    <!-- Modal -->
                                                                                    <div class="modal fade" id="modal-<?php echo $venta->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                        <div class="modal-dialog" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title" id="exampleModalLabel">Productos vendidos</h5>
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <ul>
                                                                                                        <?php foreach ($productos_vendidos as $producto) : ?>
                                                                                                            <li>
                                                                                                                Producto: <?php echo $producto['producto']; ?><br>
                                                                                                                Valor Unitario:<?php echo $producto['valor_unitario']; ?><br>
                                                                                                                Cantidad: <?php echo $producto['cantidad']; ?><br>
                                                                                                                Subtotal: <?php echo $producto['subtotal']; ?><br>
                                                                                                            </li>
                                                                                                        <?php endforeach; ?>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div><!-- .nk-tb-list -->
                                                            </div><!-- .card -->
                                                        </div><!-- .nk-block -->
                                                    </div><!-- tab pane -->
                                                    <!--tab pane-->
                                                </div>
                                                <!--tab content-->
                                            </div>
                                            <!--card inner-->
                                        </div><!-- .card-content -->
                                        <div class="card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                                            <div class="card-inner-group" data-simplebar>
                                                <div class="card-inner">
                                                    <div class="user-card user-card-s8">
                                                        <div class="user-avatar"><br>
                                                            <?php $photo = $this->session->userdata('photo');
                                                            $photo_url = base_url() . 'uploads/profile/avatar_default.jpg';
                                                            if (!empty($photo) && file_exists(FCPATH . $photo)) {
                                                                $photo_url = base_url() . $photo;
                                                            } elseif (!empty($photo)) {
                                                                $photo_url = $photo;
                                                            }
                                                            ?>
                                                            <img class="avatar_perfil" src="<?php echo $photo_url; ?>">
                                                        </div>
                                                        <div class="user-info">

                                                            <h5><?php echo $str = $this->session->userdata("fullname"); ?></h5>

                                                            <span class="sub-text"><?php echo $this->session->userdata("email") ?></span>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->

                                                <div class="card-inner">
                                                    <div class="row text-center">
                                                        <div class="col-4">
                                                            <div class="profile-stats">
                                                                <span class="amount">$<?php echo $total_ventas; ?></span>
                                                                <span class="sub-text">Total ventas del dia</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="profile-stats">
                                                                <span id="amount-pagos" class="amount">$0</span>
                                                                <span class="sub-text">Pagos a proovedores</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="profile-stats">
                                                                <span id="saldo-final-caja" class="amount">$<?php echo $total_ventas; ?></span>
                                                                <span class="sub-text">Saldo Final Caja</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner">
                                                    <h6 class="overline-title-alt mb-2">Pagos a proovedores</h6>
                                                    <div class="row g-3">
                                                        <div class="row g-3 align-center">
                                                            <div class="col-lg-3 offset-0">
                                                                <div class="form-group">
                                                                    <label class="form-label">Pago a proveedores</label>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7 mb-3">
                                                                <div class="form-group">
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" autocomplete="off" class="form-control form-control-lg" id="pagos" name="pagos" placeholder="Valor pagos" required="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-lg btn-outline-primary  btnRegistrarPago">Registrar pago</button>
                                                            <span class="mr-4"></span>
                                                            <form id="formulario-entrega-turno">
                                                                <input type="hidden" name="total_ventas" id="total-ventas">
                                                                <input type="hidden" name="pagos" id="pagos">
                                                                <input type="hidden" name="saldo_final_caja" id="saldo-final-caja">
                                                                <button type="submit" class="btn btn-lg btn-outline-primary mr-1" id="entregar-turno">Entregar Turno</button>
                                                            </form>


                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->

                                            </div><!-- .card-inner -->
                                        </div><!-- .card-aside -->
                                    </div><!-- .card-aside-wrap -->
                                </div>
                                <!--card-->
                            </div>
                            <!--nk block lg-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputPagos = document.getElementById("pagos");
        const btnRegistrarPago = document.querySelector("button[type='submit']");
        const spanAmount = document.getElementById("amount-pagos");
        const saldoFinalCaja = document.getElementById("saldo-final-caja");

        btnRegistrarPago.addEventListener("click", function(event) {
            event.preventDefault();
            const valorPagos = parseFloat(inputPagos.value);
            const valorTotal = parseFloat(document.querySelector(".amount").textContent.replace('$', ''));
            spanAmount.textContent = `$${valorPagos}`;
            const saldoFinal = calcularSaldoFinal(valorTotal, valorPagos);
            saldoFinalCaja.textContent = saldoFinal;

            // Obtener valores de los inputs después de que se hayan asignado
            var pagos = $('#pagos').val();
            var saldo_final_caja = $('#saldo-final-caja').val();
            var total_ventas = valorTotal;

            // Guardar datos en el localStorage
            localStorage.setItem('pagos', pagos);
            localStorage.setItem('saldo_final_caja', saldo_final_caja);
            localStorage.setItem('total_ventas', total_ventas);
        });

        document.getElementById('formulario-entrega-turno').addEventListener('submit', function(event) {
            event.preventDefault();
            var pagos = localStorage.getItem('pagos');
            var saldo_final_caja = localStorage.getItem('saldo_final_caja');
            var total_ventas = localStorage.getItem('total_ventas');

            // Enviar datos a la base de datos
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>entrega/entregar_turno',
                data: {
                    total_ventas: total_ventas,
                    pagos: pagos,
                    saldo_final_caja: saldo_final_caja
                },
                success: function(data) {
                    console.log(data);
                }
            });
        });

        function calcularSaldoFinal(valorTotal, valorPagos) {
            const saldoFinal = valorTotal - valorPagos;
            return `$${saldoFinal}`;
        }
    });
</script>
<!-- app-root @e -->
<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>
</body>

</html>