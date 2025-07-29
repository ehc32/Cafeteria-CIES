<?php

defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script src="<?php echo base_url(); ?>assets/admin/js/bundle.js?ver=2.9.0"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/scripts.js?ver=2.9.0"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/libs/datatable-btns.js?ver=2.9.0"></script>

<!-- MQTT -->
<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

<!-- Custom Scripts -->
<?php echo $this->general_settings->custom_javascript_codes; ?>

<script src="<?php echo base_url(); ?>assets/admin/scripts.js"></script>