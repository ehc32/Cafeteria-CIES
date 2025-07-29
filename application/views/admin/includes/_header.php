<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="es" class="js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Page Title  -->
    <title><?php echo xss_clean($title); ?> | <?php echo xss_clean($application_name); ?></title>
    <meta name="description" content="<?php echo xss_clean($description); ?>">
    <meta name="keywords" content="<?php echo xss_clean($keywords); ?>" />
    <meta name="author" content="IoTHost.org" />
    <meta name="robots" content="all" />
    <meta name="revisit-after" content="1 Days" />
    <meta property="og:locale" content="<?php echo "es_CO" ?>" />
    <meta property="og:site_name" content="<?php echo $application_name ?>" />
    <meta property="og:type" content=website />
    <meta property="og:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($application_name); ?>" />
    <meta property="og:description" content="<?php echo xss_clean($description); ?>" />
    <meta property="og:url" content="<?php echo base_url(); ?>" />
    <meta name="twitter:site" content="<?php echo $application_name; ?>" />
    <meta name="twitter:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($application_name); ?>" />
    <meta name="twitter:description" content="<?php echo xss_clean($description); ?>" />
    <link rel="canonical" href="<?php echo base_url(); ?>" />

    <!-- Fav Icon  -->
    <?php if (empty($this->general_settings->favicon_path)) : ?>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <?php else : ?>
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url() . html_escape($this->general_settings->favicon_path); ?>" />
    <?php endif; ?>
  
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/dashlite.css?ver=2.9.0">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/theme.css?ver=2.9.0">

    <?php if (!empty($this->general_settings->custom_css_codes)) : ?>
        <!-- Custom StyleSheets  -->
        <?php echo $this->general_settings->custom_css_codes; ?>
    <?php endif; ?>

    <?php if (!empty($this->general_settings->google_analytics)) : ?>
        <!-- Google analytics  -->
        <?php echo $this->general_settings->google_analytics; ?>
    <?php endif; ?>
    
</head>

<body class="nk-body ui-rounder npc-default has-sidebar <?php echo $this->general_settings->dark_mode ? "dark-mode" : "" ?>">