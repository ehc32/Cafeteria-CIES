<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if ($this->session->flashdata("error")) : ?>
    <div class="example-alert mb-3">
        <div class="alert alert-danger alert-dismissible alert-icon">
            <em class="icon ni ni-cross-circle"></em> <strong><?php echo $this->session->flashdata("error") ?></strong>
            <button class="close" data-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata("success")) : ?>
    <div class="example-alert mb-3">
        <div class="alert alert-primary alert-icon alert-dismissible">
            <em class="icon ni ni-alert-circle"></em> <strong><?php echo $this->session->flashdata("success") ?></strong>
            <button class="close" data-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata("warning")) : ?>
    <div class="example-alert mb-3">
        <div class="alert alert-warning alert-icon alert-dismissible">
            <em class="icon ni ni-alert-circle"></em> <strong><?php echo $this->session->flashdata("warning") ?></strong>
            <button class="close" data-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata("info")) : ?>
    <div class="example-alert mb-3">
        <div class="alert alert-info alert-dismissible alert-icon">
            <em class="icon ni ni-alert-circle"></em> <strong><?php echo $this->session->flashdata("info") ?></strong>
            <button class="close" data-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>