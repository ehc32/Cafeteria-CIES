<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="nk-footer nk-auth-footer-full">
    <div class="container wide-lg">
        <div class="row g-3">
            <div class="col-lg-6 order-lg-last">
                <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>">Términos y condiciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>">Política de privacidad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>">Ayuda</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="nk-block-content text-center text-lg-left">
                    <p class="text-soft">&copy; <?php echo Date('Y'); ?> <?php echo $this->settings->copyright; ?> <?php echo $this->general_settings->version; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- wrap @e -->
</div>
<!-- content @e -->
</div>
<!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<script src="<?php echo base_url(); ?>assets/admin/js/bundle.js?ver=2.9.0"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/scripts.js?ver=2.9.0"></script>

</body>


</html>