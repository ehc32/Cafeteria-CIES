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
                                        <h3 class="nk-block-title page-title">Ventas | <strong class="text-primary small">Registro de venta</strong></h3>
                                        <div class="nk-block-des text-soft d-none d-md-inline-flex">
                                            <ul class="breadcrumb breadcrumb-pipe">
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/dashboard">Inicio</a></li>
                                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/ventas">Ventas</a></li>
                                                <li class="breadcrumb-item active">Registrar una nueva venta</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="<?php echo base_url(); ?>admin/clientes-add" class="btn btn-outline-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Nuevo Cliente</span></a>
                                        <a href="<?php echo base_url() ?>admin/inicio" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Regresar</span></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->

                            <div class="nk-block">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Registro de venta</h4>
                                    </div>
                                </div>
                                <!-- include message block -->
                                <?php $this->load->view('admin/partials/_mesagges'); ?>

                                <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
                                            <div class="nk-block">
                                                <?php echo form_open_multipart('ventas_register_controller/registerVenta'); ?>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Identificación del cliente</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="number" autocomplete="off" class="form-control form-control-lg" id="identificacion_cliente" name="identificacion_cliente" placeholder="Numero de identificación del cliente">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Nombre del cliente</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-lg" id="nombre_cliente" name="nombre_cliente" placeholder="Nombre del cliente" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Correo del Cliente</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control form-control-lg" id="correo_cliente" name="correo_cliente" placeholder="Correo electronico del cliente" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="vendedor_username" value="<?php echo $vendedor_username; ?>">
                                                </div>


                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalForm">Agregar un producto</button>

                                                <input type="hidden" id="productos_vendidos" name="productos_vendidos" value="">

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Valor Total</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="number" autocomplete="off" class="form-control form-control-lg" id="valor_total" name="valor_total" placeholder="Valor total del producto" required="" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Modo de pago</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <select class="form-select" data-placeholder="Seleccione el tipo de pago" id="pago" name="pago">
                                                                    <option value="">-</option>
                                                                    <option value="0">Efectivo</option>
                                                                    <option value="1">Transferencia</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const selectPago = document.getElementById('pago');
                                                        const numReferenciaInput = document.getElementById('num_referencia');
                                                        const numReferenciaLabel = document.getElementById('label_num_ref')
                                                        const cantidadPagoInput = document.getElementById('cantidad_pago')
                                                        const cantidadDevolverInput = document.getElementById('cantidad_devolver');
                                                        const cantidadPagoLabel = document.getElementById('cantidad_pago_label');
                                                        const cantidadDevolverLabel = document.getElementById('cantidad_devolver_label');

                                                        numReferenciaInput.hidden = true;
                                                        numReferenciaLabel.hidden = true;
                                                        cantidadPagoInput.hidden = true;
                                                        cantidadPagoLabel.hidden = true;
                                                        cantidadDevolverInput.hidden = true;
                                                        cantidadDevolverLabel.hidden = true;

                                                        $('#pago').on('change', function() {
                                                            const modoPago = $(this).val();
                                                            if (modoPago === '0') {
                                                                numReferenciaInput.hidden = true;
                                                                numReferenciaLabel.hidden = true;
                                                                cantidadPagoInput.hidden = false;
                                                                cantidadPagoLabel.hidden = false;
                                                                cantidadDevolverInput.hidden = false;
                                                                cantidadDevolverLabel.hidden = false;
                                                            } else if (modoPago === '1') {
                                                                numReferenciaInput.hidden = false;
                                                                numReferenciaLabel.hidden = false;
                                                                cantidadPagoInput.hidden = true;
                                                                cantidadPagoLabel.hidden = true;
                                                                cantidadDevolverInput.hidden = true;
                                                                cantidadDevolverLabel.hidden = true;
                                                            } else {
                                                                numReferenciaInput.hidden = true;
                                                                numReferenciaLabel.hidden = true;
                                                                cantidadPagoInput.hidden = true;
                                                                cantidadPagoLabel.hidden = true;
                                                                cantidadDevolverInput.hidden = true;
                                                                cantidadDevolverLabel.hidden = true;
                                                            }
                                                        });
                                                    });
                                                </script>

                                                <!-- Si es transferencia -->

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label" id="label_num_ref">Numero de referencia</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="number" autocomplete="off" class="form-control form-control-lg" id="num_referencia" name="num_referencia" placeholder="Ingresa el numero de referencia">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Si es efectivo -->

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label" id="cantidad_pago_label">Cantidad recibida del cliente</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="number" autocomplete="off" class="form-control form-control-lg" id="cantidad_pago" name="cantidad_pago" placeholder="Cantidad recibida del cliente">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 align-center">
                                                    <div class="col-lg-3 offset-0">
                                                        <div class="form-group">
                                                            <label class="form-label" id="cantidad_devolver_label">Cantidad a devolver al cliente</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 mb-3">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="number" autocomplete="off" class="form-control form-control-lg" id="cantidad_devolver" name="cantidad_devolver" placeholder="Cantidad a devolver al cliente" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <ul id="listaProductos"></ul>
                                                <div class="nk-block nk-block-lg">
                                                    <div class="invoice">
                                                        <div class="invoice-bills">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Producto vendido</th>
                                                                            <th>Valor Unitario</th>
                                                                            <th>Cantidad</th>
                                                                            <th>Descuento</th>
                                                                            <th class="w-0">Valor Total</th>
                                                                            <th>Acciones</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="productos-body">
                                                                    </tbody>
                                                                    <tfoot>
                                                                    </tfoot>
                                                                </table>

                                                            </div>
                                                            <div class="row gy-4">
                                                                <!--col-->
                                                                <div class="col-12 mt-3">
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-outline-primary justify-content-center" id="button">Registrar venta</button>
                                                                    </div>
                                                                </div>
                                                                <!--col-->
                                                            </div>
                                                        </div><!-- .invoice-bills -->
                                                    </div><!-- .invoice-wrap -->
                                                </div><!-- .invoice -->
                                            </div>
                                        </div><!-- .card-preview -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->


            </div><!-- .nk-block -->


        </div>
        <!-- wrap @e -->
    </div>
    <!-- main @e -->
</div>



<!-- Modal Form -->
<div class="modal fade" id="modalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar producto a venta</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="row g-3 align-center">
                        <div class="col-lg-3 offset-0">
                            <div class="form-group">
                                <label class="form-label">Categoria</label>
                            </div>
                        </div>
                        <div class="col-lg-7 mb-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <select class="form-select" data-placeholder="Seleccione la categoría" id="categoria" name="categoria">
                                        <option>Selecciona una categoria</option>
                                        <?php foreach ($categorias as $categoria) { ?>
                                            <option value="<?php echo $categoria->categoria; ?>"><?php echo $categoria->categoria; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-center">
                        <div class="col-lg-3 offset-0">
                            <div class="form-group">
                                <label class="form-label">Producto vendido</label>
                            </div>
                        </div>
                        <div class="col-lg-7 mb-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <select class="form-select" data-placeholder="Seleccione el producto vendido" id="producto_vendido" name="producto_vendido">
                                        <option>Selecciona un producto</option>
                                        <?php foreach ($productos as $producto) { ?>
                                            <option>Selecciona un producto</option>
                                            <option value="<?php echo $producto->producto; ?>"><?php echo $producto->producto; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center">
                        <div class="col-lg-3 offset-0">
                            <div class="form-group">
                                <label class="form-label">Valor unitario</label>
                            </div>
                        </div>
                        <div class="col-lg-7 mb-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" autocomplete="off" class="form-control form-control-lg" id="valor_unitario" name="valor_unitario" placeholder="Valor unitario del producto" readonly>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row g-3 align-center">
                        <div class="col-lg-3 offset-0">
                            <div class="form-group">
                                <label class="form-label">Cantidad</label>
                            </div>
                        </div>
                        <div class="col-lg-7 mb-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" autocomplete="off" class="form-control form-control-lg" id="cantidad" name="cantidad" placeholder="Ingrese la cantidad">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 align-center">
                        <div class="col-lg-3 offset-0">
                            <div class="form-group">
                                <label class="form-label">Descuento</label>
                            </div>
                        </div>
                        <div class="col-lg-7 mb-3">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" autocomplete="off" class="form-control form-control-lg" id="descuento" name="descuento" placeholder="Ingrese el valor del descuento">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-lg btn-primary" id="agregarProducto">Agregar Producto a lista</button><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<?php $this->load->view("admin/includes/_JavaScripts"); ?>


</div>

</body>

</html>


<script>
    $(document).ready(function() {
        $('#identificacion_cliente').on('change', function() {
            console.log('Evento change disparado');
            var identificacion = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>clientes_controller/buscar_cliente',
                data: {
                    identificacion: identificacion
                },
                success: function(response) {
                    console.log(response);
                    var partes = response.split('}');
                    var data1 = JSON.parse(partes[0] + '}');
                    var data2 = JSON.parse(partes[1].trim() + '}');
                    var data = Object.assign({}, data1, data2);
                    if (data.nombre_cliente) {
                        $('#nombre_cliente').val(data.nombre_cliente);
                        $('#correo_cliente').val(data.correo_electronico);
                    } else {
                        $('#nombre_cliente').val('');
                    }
                }
            });
        });

        // Manejador para la selección de categoría y carga de productos
        $('#categoria').change(function() {
            var categoria = $(this).val();
            console.log('Categoría seleccionada: ' + categoria);

            $.ajax({
                url: '<?php echo base_url('/admin/ventas-add/get_productos_por_categoria'); ?>',
                type: 'GET',
                data: {
                    categoria: categoria
                },
                success: function(response) {
                    console.log(response);
                    var productos = JSON.parse(response);
                    console.log(productos);
                    var productoVendidoSelect = $('#producto_vendido');
                    productoVendidoSelect.empty();

                    if (productos && productos.length > 0) {
                        $.each(productos, function(index, producto) {
                            productoVendidoSelect.append('<option value="' + producto.producto_vendido + '">' + producto.producto_vendido + '</option>');
                        });
                    } else {
                        productoVendidoSelect.append('<option value="">No hay productos en esta categoría.</option>');
                    }

                    // Agregar evento change al selector de productos
                    productoVendidoSelect.change(function() {
                        var producto_seleccionado = $(this).val();
                        var valor_unitario = 0;
                        $.each(productos, function(index, producto) {
                            if (producto.producto_vendido === producto_seleccionado) {
                                valor_unitario = producto.valor_unitario;
                            }
                        });
                        $('#valor_unitario').val(valor_unitario);
                    });
                }
            });
        });

        // Función para agregar producto al localStorage
        $('#agregarProducto').click(function() {
            var categoria = $('#categoria').val();
            var productoVendido = $('#producto_vendido').val();
            var valorUnitario = $('#valor_unitario').val();
            var cantidad = $('#cantidad').val();
            var descuento = $('#descuento').val();

            if (!categoria || !productoVendido || !valorUnitario || !cantidad || !descuento) {
                alert('Por favor, complete todos los campos.');
                return;
            }

            var producto = {
                categoria: categoria,
                producto_vendido: productoVendido,
                valor_unitario: valorUnitario,
                cantidad: cantidad,
                descuento: descuento
            };

            var productos = JSON.parse(localStorage.getItem('productos')) || [];
            productos.push(producto);
            localStorage.setItem('productos', JSON.stringify(productos));

            actualizarListaProductos();
            $('#modalForm').modal('hide');
        });

        // Función para actualizar la lista de productos en la vista
        function actualizarListaProductos() {
            let productos = JSON.parse(localStorage.getItem('productos')) || [];
            let tbody = document.getElementById('productos-body');
            tbody.innerHTML = '';

            let subtotal = 0;

            productos.forEach((prod) => {
                let valorUnitario = parseFloat(prod.valor_unitario) || 0;
                let cantidad = parseInt(prod.cantidad, 10) || 0;
                let descuentoProducto = parseFloat(prod.descuento) || 0;

                let valorTotal = valorUnitario * cantidad;

                if (descuentoProducto > valorTotal) {
                    descuentoProducto = valorTotal;
                }

                valorTotal -= descuentoProducto;

                subtotal += valorTotal;

                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${prod.producto_vendido || 'Producto no disponible'}</td>
                    <td>$${valorUnitario.toFixed(0)}</td>
                    <td>
                    <button class="btn btn-secondary btn-sm disminuir-cantidad" data-producto="${prod.producto_vendido}">-</button>
                    <input type="number" class="cantidad-producto" data-producto="${prod.producto_vendido}" value="${cantidad}" readonly style="text-align: center;">
                    <button class="btn btn-secondary btn-sm aumentar-cantidad" data-producto="${prod.producto_vendido}">+</button>
                    </td>
                    <td>$${descuentoProducto.toFixed(0)}</td>
                    <td class="">$${valorTotal.toFixed(0)}</td>
                    <td colspan="5">
                    <button class="btn btn-danger btn-sm eliminar-producto" data-producto="${prod.producto_vendido}">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            let totalConDescuento = subtotal;

            let tfoot = document.querySelector('table tfoot');
            tfoot.innerHTML = `
                <tr>
                    <td colspan="5">Valor Total</td>
                    <td>$${totalConDescuento.toFixed(0)}</td>
                </tr>
            `;

            // Actualizar el campo de valor total en el formulario
            $('#valor_total').val(totalConDescuento.toFixed(0));

            $('#productos_vendidos').val(JSON.stringify(productos));
        }

        // Actualizar la lista de productos al cargar la página
        actualizarListaProductos();

        // Manejador de eventos para eliminar productos
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('eliminar-producto')) {
                let producto = event.target.getAttribute('data-producto');
                let productos = JSON.parse(localStorage.getItem('productos')) || [];

                productos = productos.filter(p => p.producto_vendido !== producto);
                localStorage.setItem('productos', JSON.stringify(productos));

                actualizarListaProductos();
            }
        });

        // Manejador de eventos para aumentar la cantidad
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('aumentar-cantidad')) {
                let producto = event.target.getAttribute('data-producto');
                let cantidadInput = document.querySelector(`input[data-producto='${producto}']`);
                let nuevaCantidad = parseInt(cantidadInput.value, 10) + 1;

                actualizarCantidadProducto(producto, nuevaCantidad);
            }
        });

        // Manejador de eventos para disminuir la cantidad
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('disminuir-cantidad')) {
                let producto = event.target.getAttribute('data-producto');
                let cantidadInput = document.querySelector(`input[data-producto='${producto}']`);
                let nuevaCantidad = Math.max(parseInt(cantidadInput.value, 10) - 1, 1);

                actualizarCantidadProducto(producto, nuevaCantidad);
            }
        });

        // Función para actualizar la cantidad en localStorage y refrescar la tabla
        function actualizarCantidadProducto(producto, nuevaCantidad) {
            let productos = JSON.parse(localStorage.getItem('productos')) || [];

            // Buscar el producto en el array y actualizar la cantidad
            productos = productos.map(p => {
                if (p.producto_vendido === producto) {
                    p.cantidad = nuevaCantidad;
                }
                return p;
            });

            // Guardar los productos actualizados en localStorage
            localStorage.setItem('productos', JSON.stringify(productos));

            // Actualizar la tabla de productos
            actualizarListaProductos();
        }

        // Cálculo de valores totales
        $('#cantidad, #descuento').change(function() {
            // Obtener los valores de la cantidad, descuento y valor unitario
            var cantidad = parseInt($('#cantidad').val()) || 0;
            var descuento = parseFloat($('#descuento').val()) || 0;
            var valor_unitario = parseFloat($('#valor_unitario').val()) || 0;

            // Calcular el subtotal (valor_unitario * cantidad)
            var subtotal = valor_unitario * cantidad;

            // Calcular el valor total restando el descuento del subtotal
            var valor_total = subtotal - descuento;

            // Asegurarse de que el valor total no sea negativo
            valor_total = Math.max(valor_total, 0);

            // Actualizar el campo de valor_total en la vista
            $('#valor_total').val(valor_total.toFixed(0));
            // Actualizar la tabla de productos
            actualizarListaProductos();
        });

        // Cálculo del valor a devolver
        $('#cantidad_pago, #valor_total').change(function() {
            var valor_total = parseFloat($('#valor_total').val()) || 0;
            var cantidad_pago = parseFloat($('#cantidad_pago').val()) || 0;

            // Calcular la cantidad a devolver
            var cantidad_devolver = cantidad_pago - valor_total;

            // Asegurarse de que la cantidad a devolver no sea negativa
            cantidad_devolver = Math.max(cantidad_devolver, 0);

            // Actualizar el campo de cantidad_devolver en la vista
            $('#cantidad_devolver').val(cantidad_devolver.toFixed(0));
        });
    });

    $(document).ready(function() {
        localStorage.clear();
    });

    $('#submitForm').click(function() {
        var productos = JSON.parse(localStorage.getItem('productos')) || [];

        if (productos.length === 0) {
            alert('No hay productos en la lista.');
            return;
        }
        console.log('Productos:', productos);
        // Actualizar el campo oculto con el JSON de productos
        $('#productos_vendidos').val(JSON.stringify(productos));

        console.log('Valor del campo oculto:', $('#productos_vendidos').val());

        // Obtener los valores de los campos del formulario
        var descuento = $('#descuento').val().toFixed(0);
        var nombreCliente = $('#nombre_cliente').val();
        var identificacionCliente = $('#identificacion_cliente').val();
        var correoCliente = $('#correo_cliente').val();
        var valorTotal = $('#valor_total').val();
        var num_referencia = $('#num_referencia').val();

        // Enviar datos mediante AJAX
        $.ajax({
            url: '<?php echo base_url('/admin/registrar'); ?>',
            type: 'POST',
            data: {
                productos: JSON.stringify(productos),
                descuento: descuento,
                nombre_cliente: nombreCliente,
                identificacion_cliente: identificacionCliente,
                correo_cliente: correoCliente,
                valor_total: valorTotal,
                num_referencia: num_referencia
            },
            success: function(response) {
                var res = JSON.parse(response);
                console.log(data)
                if (res.success) {
                    alert('Venta registrada exitosamente');
                    localStorage.clear();
                    location.reload();
                    setTimeout(function() {
                        $('formulario').trigger('reset');
                        document.getElementById('tbody').innerHTML = '';
                    }, 100);
                } else {
                    alert('Error al registrar la venta');
                }
            }
        });
    });
</script>