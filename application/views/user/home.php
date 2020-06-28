<header class="masthead bg-primary text-white text-center">
	<div class="container d-flex align-items-center flex-column">
		<!-- Masthead Avatar Image--><img class="masthead-avatar mb-5" src="<?= base_url('assets/') ?>assets/img/3262045.svg" alt="">
		<!-- Masthead Heading-->
		<h1 class="masthead-heading mb-0">SIMPETUK</h1>
		<!-- Icon Divider-->
		<div class="divider-custom divider-light">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<!-- Masthead Subheading-->
		<p class="pre-wrap masthead-subheading font-weight-light mb-0">SISTEM PENJUALAN TIKET MASUK KOLAM RENANG</p>
	</div>
</header>
<section class="page-section portfolio" id="portfolio">
	<div class="container">
		<!-- Portfolio Section Heading-->
		<div class="text-center">
			<h2 class="page-section-heading text-secondary mb-0 d-inline-block">PRICE</h2>
		</div>
		<!-- Icon Divider-->
		<div class="divider-custom">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-8 text-center">
				<div class="card">
					<table class="table table-striped table-hover">
						<thead>
							<th class="text-center">Category</th>
							<th class="text-center">Price</th>
						</thead>
						<tbody>
							<?php foreach ($price as $price) : ?>
								<tr>
									<td class="text-center"><?= $price->name ?></td>
									<td class="text-center">Rp <?= number_format($price->price) ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
				<br>
				<a href="<?= base_url('order') ?>" class="btn btn-xl btn-primary">Order Now</a>
			</div>
		</div>
	</div>
</section>
<section class="page-section bg-primary text-white mb-0" id="about">
	<div class="container">
		<!-- About Section Heading-->
		<div class="text-center">
			<h2 class="page-section-heading d-inline-block text-white">ABOUT</h2>
		</div>
		<!-- Icon Divider-->
		<div class="divider-custom divider-light">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<!-- About Section Content-->
		<div class="row">
			<div class="col-lg-4 ml-auto">
				<p class="pre-wrap lead">Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional SASS stylesheets for easy customization.</p>
			</div>
			<div class="col-lg-4 mr-auto">
				<p class="pre-wrap lead">You can create your own custom avatar for the masthead, change the icon in the dividers, and add your email address to the contact form to make it fully functional!</p>
			</div>
		</div>
	</div>
</section>
<section class="page-section" id="contact">
	<div class="container">
		<!-- Contact Section Heading-->
		<div class="text-center">
			<h2 class="page-section-heading text-secondary d-inline-block mb-0">CONTACT</h2>
		</div>
		<!-- Icon Divider-->
		<div class="divider-custom">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<!-- Contact Section Content-->
		<div class="row justify-content-center">
			<div class="col-lg-4">
				<div class="d-flex flex-column align-items-center">
					<div class="icon-contact mb-3"><i class="fas fa-mobile-alt"></i></div>
					<div class="text-muted">Phone</div>
					<div class="lead font-weight-bold">(555) 555-5555</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="d-flex flex-column align-items-center">
					<div class="icon-contact mb-3"><i class="far fa-envelope"></i></div>
					<div class="text-muted">Email</div><a class="lead font-weight-bold" href="mailto:name@example.com">name@example.com</a>
				</div>
			</div>
		</div>
	</div>
</section>
<footer class="footer text-center">
	<div class="container">
		<div class="row">
			<!-- Footer Location-->
			<div class="col-lg-4 mb-5 mb-lg-0">
				<h4 class="mb-4">LOCATION</h4>
				<p class="pre-wrap lead mb-0">2215 John Daniel Drive
					Clark, MO 65243</p>
			</div>
			<!-- Footer Social Icons-->
			<div class="col-lg-4 mb-5 mb-lg-0">
				<h4 class="mb-4">AROUND THE WEB</h4><a class="btn btn-outline-light btn-social mx-1" href="https://www.facebook.com/StartBootstrap"><i class="fab fa-fw fa-facebook-f"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.twitter.com/sbootstrap"><i class="fab fa-fw fa-twitter"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.linkedin.com/in/startbootstrap"><i class="fab fa-fw fa-linkedin-in"></i></a><a class="btn btn-outline-light btn-social mx-1" href="https://www.dribble.com/startbootstrap"><i class="fab fa-fw fa-dribbble"></i></a>
			</div>
			<!-- Footer About Text-->
			<div class="col-lg-4">
				<h4 class="mb-4">ABOUT FREELANCER</h4>
				<p class="pre-wrap lead mb-0">Freelance is a free to use, MIT licensed Bootstrap theme created by Start Bootstrap</p>
			</div>
		</div>
	</div>
</footer>
