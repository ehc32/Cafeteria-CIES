<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view("admin/includes/_header"); ?>

<meta name="viewport" content="width=58mm, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<style>
    @media print {
        @page {
            size: 58mm auto;
            margin: 0;
        }
        body {
            width: 58mm;
            margin: 0;
            padding: 0;
            font-size: 11px;
            font-family: Arial, sans-serif;
            text-align: center;
            color: #000;
            font-weight: bold;
            -webkit-print-color-adjust: exact;
        }
        .invoice-wrap {
            width: 58mm;
            max-width: 58mm;
            padding: 0;
            box-sizing: border-box;
        }
        .invoice-brand img {
            max-width: 90px;
            margin-bottom: 1px;
        }
        .invoice-desc {
            margin-bottom: 5px;
            color: #000;
            font-weight: bold;
        }
        .invoice-desc ul {
            padding: 0;
            margin: 0;
            list-style-type: none;
        }
        .invoice-desc li {
            margin-bottom: 2px;
            color: #000;
            font-weight: bold;
        }
        .invoice-items {
            margin-top: 5px;
        }
        .invoice-items div {
            margin-bottom: 3px;
            color: #000;
            font-weight: bold;
        }
        .invoice-total {
            margin-top: 5px;
            font-size: 12px;
            font-weight: bold;
            color: #000;
        }
        html, body {
            overflow: hidden;
        }
    }
</style>

<body onload="printPromot()">
    <div class="invoice-wrap">
        <div class="invoice-brand text-center">
            <img src="<?php echo base_url(); ?>assets/images/logo-dark-small.png" alt="logo">
        </div>

        <div class="invoice-desc">
            <h3 class="title" style="color: #000; font-weight: bold;">VENTA</h3>
            <ul>
                <li><strong>ID:</strong> <?php echo $detalle_venta->id; ?></li>
                <li><strong>Fecha:</strong> <?php echo $detalle_venta->created; ?></li>
            </ul>
        </div>

        <div class="invoice-items">
            <?php
            $productos_vendidos = json_decode($detalle_venta->productos_vendidos, true);
            foreach ($productos_vendidos as $producto) {
            ?>
                <div>
                    <?php echo substr($producto['producto'], 0, 20); ?> 
                    (x<?php echo $producto['cantidad']; ?>) - 
                    <?php echo number_format($producto['subtotal'], 0, ',', '.'); ?>
                </div>
            <?php } ?>
        </div>

        <div class="invoice-total">
            <div>Descuento: <?php echo number_format($detalle_venta->descuento, 0, ',', '.'); ?></div>
            <div>Total: <?php echo number_format($detalle_venta->valor_total, 0, ',', '.'); ?></div>
        </div>
    </div>

    <script>
        function printPromot() {
            window.print();
        }
    </script>

<?php $this->load->view("admin/includes/_JavaScripts"); ?>
</body>
</html>

