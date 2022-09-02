<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<meta content="<?=base_url() ?>" name="base_url">

	<title><?= isset($title) ? $title : 'SYSTEM'; ?></title>
	<link href="https://majoo.id/favicon.png" rel='shortcut icon'>

	<!-- General CSS Files -->
	<link rel="stylesheet" href="<?= base_url('assets/modules/fontawesome/css/all.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/modules/bootstrap/css/bootstrap.min.css') ?>">

	<!-- Lib  -->
	<link rel="stylesheet" href="<?= base_url('assets/dropify/dist/css/dropify.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/external/css/buttons.dataTables.min.css') ?>">

	<!-- Template CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/custom.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/css/global.css') ?>">
	
    <link rel="stylesheet" href="<?= base_url('assets/external/datatables/dataTables.bootstrap4.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/summernote/summernote-bs4.css') ?>">

    <!-- CDN -->
	<link rel="stylesheet" href="<?= base_url('assets/modules/select2/dist/css/select2.min.css') ?>">

	<!--Theme-->
	<script src="<?= base_url('assets/external/js/jquery.3.4.1.min.js') ?>"></script>
	<script src="<?= base_url('assets/external/js/tooltip.js') ?>"></script>
	<script src="<?= base_url('assets/external/js/popper.js') ?>"></script>

	<!--Datatables-->
	<script src="<?= base_url('assets/external/datatables/dataTables.1.10.18.js') ?>"></script>
	<script src="<?= base_url('assets/external/datatables/dataTables.bootstrap4.min.js') ?>"></script>
	<script src="<?= base_url('assets/external/datatables/dataTables.responsive.min.js') ?>"></script>

	<script>
		const base_url = $('meta[name=base_url]').attr('content')
	</script>
</head>
<body>

	<?php if ($auth->check): ?>
		<?php $this->load->view('template/admin/navbar'); ?>
		<?php $this->load->view('template/admin/sidebar'); ?>
	<?php endif ?>
	
