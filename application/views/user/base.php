<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>SIMPETUK</title>
	<!-- Font Awesome icons (free version)-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
	<!-- Core theme CSS (includes Bootstrap)-->
	<link href="<?= base_url('assets/') ?>css/styles.css" rel="stylesheet">
	<!-- Fonts CSS-->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/heading.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/body.css">
	<!--JQUERY-->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<!--TOASTR-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body id="page-top">
	<nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
		<div class="container"><a class="navbar-brand js-scroll-trigger" href="#page-top">SIMPETUK</a>
			<button class="navbar-toggler navbar-toggler-right font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu <i class="fas fa-bars"></i></button>
			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<?php if ($this->uri->segment(1) == 'home' || !$this->uri->segment(1)) : ?>
						<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">PRICE</a>
						</li>
						<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">ABOUT</a>
						</li>
						<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">CONTACT</a>
						</li>
						<?php if ($this->session->userdata('is_logged')) : ?>
							<li class=" nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" id="auth" href="<?= base_url('/profile') ?>">PROFILE</a>
							</li>
							<li class=" nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" id="auth" href="<?= base_url('/profile/logout') ?>">LOGOUT</a>
							</li>
						<?php else : ?>
							<li class=" nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" id="auth" href="<?= base_url('/auth') ?>">LOGIN</a>
							</li>
						<?php endif ?>
					<?php else : ?>
						<li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="<?= base_url('/home') ?>">HOME</a>
						</li>
						<?php if ($this->session->userdata('is_logged')) : ?>
							<li class=" nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" id="profile_menu" href="<?= base_url('/profile') ?>">PROFILE</a>
							</li>
							<li class=" nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" id="auth" href="<?= base_url('/profile/logout') ?>">LOGOUT</a>
							</li>
						<?php else : ?>
							<li class=" nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" id="auth" href="<?= base_url('/auth') ?>">LOGIN</a>
							</li>
						<?php endif ?>
					<?php endif ?>
				</ul>
			</div>
		</div>
	</nav>
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
	<?= $contents; ?>
	<!-- Copyright Section-->
	<section class=" copyright py-4 text-center text-white">
		<div class="container"><small class="pre-wrap">Copyright © Your Website 2020</small></div>
	</section>
	<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
	<div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
	<!-- Bootstrap core JS-->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
	<!-- Third party plugin JS-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
	<!-- Core theme JS-->
	<script src="<?= base_url('assets/') ?>js/scripts.js"></script>
</body>
<?= $this->session->flashdata('message') ?>

</html>
