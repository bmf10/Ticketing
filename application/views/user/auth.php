<section class="page-section portfolio my-5" id="auth">
	<div class="container">
		<div class="text-center">
			<h2 class="page-section-heading text-secondary mb-0 d-inline-block">Login & Register</h2>
		</div>
		<div class="divider-custom">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<div class="card text-white bg-primary mb-3">
							<div class="card-header">Register</div>
							<div class="card-body">
								<form id="register" action="<?= base_url('auth/register') ?>">
									<div class="form-group">
										<label>Name</label>
										<input type="text" name="name" required class="form-control" placeholder="Enter name">
									</div>
									<div class="form-group">
										<label for="exampleFormControlSelect1">Gender</label>
										<select class="form-control" name="gender" required id="exampleFormControlSelect1">
											<option>Gender</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div>
									<div class="form-group">
										<label>Address</label>
										<textarea class="form-control" name="address" required placeholder="Enter address" rows="3"></textarea>
									</div>
									<div class="form-group">
										<label>Phone</label>
										<input type="tel" pattern="^\d{10}$|^\d{11}$|^\d{12}$|^\d{13}$" class="form-control" name="phone" required placeholder="Enter phone">
									</div>
									<div class="form-group" id="email_group">
										<label>Email address</label>
										<input type="email" class="form-control" id="email" name="email" required placeholder="Enter email">
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" name="password" required placeholder="Password">
									</div>
									<button type="submit" class="btn btn-secondary my-2">Submit</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card text-white bg-secondary mb-3">
							<div class="card-header">Login</div>
							<div class="card-body">
								<form id="login" action="<?= base_url('auth/login') ?>">
									<div class="form-group">
										<label>Email address</label>
										<input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
										<small id="emailHelp" class="form-text">We'll never share your email with anyone else.</small>
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name="password" class="form-control" placeholder="Password">
									</div>
									<button type="submit" class="btn btn-primary my-2">Submit</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
	$(document).ready(() => {
		$('#auth').addClass('active')

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

		$('#login').submit((e) => {
			e.preventDefault()
			let value = $('#login').serialize()
			let url = $('#login').attr('action')

			$.post({
				url: url,
				data: value,
				success: response => {
					let responseData = response.responseJSON
					toastr.success('Redirecting...')
				},
				error: error => {
					let errorData = error.responseJSON
					toastr.error(errorData.data.error)
				}
			})
		})

		$('#email').focusin(() => {
			$('#email').removeClass('is-invalid')
			$('#email_invalid').remove()
		})

		$('#register').submit((e) => {
			e.preventDefault()
			let value = $('#register').serialize()
			let url = $('#register').attr('action')

			$.post({
				url: url,
				data: value,
				success: response => {
					let responseData = response.responseJSON
					toastr.success('Check Your Email')
				},
				error: error => {
					let errorData = error.responseJSON
					if (errorData.data && errorData.data.email) {
						let html = "<div id='email_invalid' class='invalid-feedback'>Email Already Used</div>"
						$('#email').addClass('is-invalid')
						$('#email_group').append(html)
					} else {
						toastr.error(errorData.data.error)
					}
				}
			})
		})
	})
</script>
