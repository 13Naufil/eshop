<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        var site_url = '<?=site_url();?>';
        var base_url = '<?=base_url();?>';
        var assets_url = '<?=base_url('assets');?>/';
        var theme_assets_url = '<?=template_url('assets');?>';
    </script>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo get_option('admin_title'); ?></title>

    <link href="<?php echo  base_url('assets/admin/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo  base_url('assets/admin/css/theme.min.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo  base_url('assets/admin/css/styles.min.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo  base_url('assets/admin/css/icons.min.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo  base_url('assets/admin/css/validationEngine.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo  base_url('assets/admin/css/custom-styles.css');?>" rel="stylesheet" type="text/css">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/jquery.min.js');?>"></script>
    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js">-->
    <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>-->
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/jquery-ui.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/charts/sparkline.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/uniform.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/select2.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/inputmask.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/autosize.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/inputlimit.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/listbox.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/multiselect.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/validate.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/tags.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/switch.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/uploader/plupload.full.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/forms/uploader/plupload.queue.min.js');?>"></script>
    <!--<script type="text/javascript" src="<?php /*echo  base_url('assets/admin/js/plugins/forms/wysihtml5/wysihtml5.min.js');*/?>"></script>
    <script type="text/javascript" src="<?php /*echo  base_url('assets/admin/js/plugins/forms/wysihtml5/toolbar.js');*/?>"></script>-->
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/interface/daterangepicker.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/interface/fancybox.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/interface/moment.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/interface/jgrowl.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/interface/datatables.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/interface/colorpicker.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/interface/fullcalendar.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/interface/timepicker.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/plugins/interface/collapsible.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/bootstrap.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/application.js');?>"></script>


    <!-- ----------------------------------Libraries------------------------------------- -->

    <!-- validation -->
    <script type="text/javascript" src="<?= base_url('assets/admin/js/plugins/forms/jquery.validation.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/admin/js/plugins/forms/jquery.validationEngine-en.js'); ?>"></script>

    <!-- tiny_mce -->
    <script type="text/javascript" src="<?= base_url('assets/tiny_mce/tiny_mce.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/tiny_mce/tiny_mce_setting.js'); ?>"></script>

    <!-- jstree -->
    <link href="<?php echo  base_url('assets/admin/css/jstree.css');?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/jstree.min.js');?>"></script>

    <!-- jquery.nestable -->
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/jquery.nestable.js');?>"></script>

    <!-- bootbox -->
    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/jquery.bootbox.min.js');?>"></script>

    <!-- datetimepicker -->
    <link href="<?= base_url('assets/admin/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?= base_url('assets/admin/js/moment.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/admin/js/bootstrap-datetimepicker.min.js'); ?>"></script>

    <!-- Print -->
    <script type="text/javascript" src="<?= base_url('assets/admin/js/jquery.printElement.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/admin/js/html2canvas.min.js'); ?>"></script>

    <script type="text/javascript" src="<?= base_url('assets/admin/js/numeral.min.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo  base_url('assets/admin/js/custom-app.js');?>"></script>
</head>
