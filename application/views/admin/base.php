<?php
$user_login = $this->db->get_where('users', ['id' => $this->session->userdata('id')])->row();
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title>Simpetuk | <?= $title ?></title>

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?= base_url('assets/admin/') ?>plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('assets/admin/') ?>dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- jQuery -->
	<script src="<?= base_url('assets/admin/') ?>plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url('assets/admin/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('assets/admin/') ?>dist/js/adminlte.min.js"></script>
	<!-- Toastr -->
	<link rel="stylesheet" href="<?= base_url('assets/admin/') ?>plugins/toastr/toastr.min.css">
	<script src="<?= base_url('assets/admin/') ?>plugins/toastr/toastr.min.js"></script>
	<!-- DataTables -->
	<link rel="stylesheet" href="<?= base_url('assets/admin/') ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
	<script src="<?= base_url('assets/admin/') ?>plugins/datatables/jquery.dataTables.js"></script>
	<script src="<?= base_url('assets/admin/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
	<!-- Inputmask -->
	<script src="<?= base_url('assets/admin/') ?>plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
</head>

<script>
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
</script>

<body class="hold-transition sidebar-mini sidebar-collapse">
	<div class="wrapper">

		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Home</a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Contact</a>
				</li>
			</ul>
		</nav>

		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<a href="#" class="brand-link">
				<span class="brand-text font-weight-light">Simpetuk v1.0</span>
			</a>

			<div class="sidebar">
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="<?= base_url() ?>assets/assets/img/default.png" class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
						<a href="#" class="d-block"><?= $user_login->name ?></a>
					</div>
				</div>

				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<li class="nav-item">
							<a href="<?= base_url('admin') ?>" class="nav-link" id="dashboard_menu">
								<i class="nav-icon fas fa-home"></i>
								<p>
									Dashboard
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('admin/users') ?>" class="nav-link" id="users_menu">
								<i class="nav-icon fas fa-users"></i>
								<p>
									Users
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('admin/transaction') ?>" class="nav-link" id="transaction_menu">
								<i class="nav-icon fas fa-money-check"></i>
								<p>
									Transaction
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url('admin/ticket') ?>" class="nav-link" id="ticket_menu">
								<i class="nav-icon fas fa-ticket-alt"></i>
								<p>
									Ticket
								</p>
							</a>
						</li>
						<?php if ($this->session->userdata('role') == 3) : ?>
							<li class="nav-item">
								<a href="<?= base_url('admin/setting') ?>" class="nav-link" id="setting_menu">
									<i class="nav-icon fas fa-cog"></i>
									<p>
										Setting
									</p>
								</a>
							</li>
						<?php endif ?>
						<li class="nav-item">
							<a href="<?= base_url('admin/dashboard/logout') ?>" class="nav-link">
								<i class="nav-icon fas fa-sign-out-alt"></i>
								<p>
									Logout
								</p>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</aside>

		<div class="content-wrapper">
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><?= $title ?></h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?= base_url('admin/') ?>"><?= ucfirst($this->uri->segment(1)) ?></a></li>
								<?= $this->uri->segment(2) ? '<li class="breadcrumb-item active"><a href=' . base_url('admin/' . $this->uri->segment(2)) . '>' . ucfirst($this->uri->segment(2)) . '</a></li>' : '<li class="breadcrumb-item active"><a href=' . base_url('admin') . '>Dashboard</a></li>' ?>
								<?= $this->uri->segment(3) ? '<li class="breadcrumb-item active">' . ucfirst($this->uri->segment(3)) . '</li>' : '' ?>
								<?= $this->uri->segment(4) ? '<li class="breadcrumb-item active">' . ucfirst($this->uri->segment(4)) . '</li>' : '' ?>
								<?= $this->uri->segment(5) ? '<li class="breadcrumb-item active">' . ucfirst($this->uri->segment(5)) . '</li>' : '' ?>
							</ol>
						</div>
					</div>
				</div>
			</div>

			<div class="content">
				<div class="container-fluid">
					<?= $contents; ?>
				</div>
			</div>
		</div>

		<footer class="main-footer">
			<strong>Copyright &copy; 2020 <a href="<?= base_url() ?>">Simpetuk</a>.</strong> All rights reserved.
		</footer>
	</div>
</body>
<?= $this->session->flashdata('message') ?>

</html>
