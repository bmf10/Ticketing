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
											<option value="">Gender</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div>
									<div class="form-group">
										<label>Address</label>
										<textarea class="form-control" name="address" required placeholder="Enter address" rows="3"></textarea>
									</div>
									<div class="form-group" id="phone_group">
										<label>Phone</label>
										<input type="tel" id="phone" pattern="^[0]{1}[8]{1}[0-9]{9}$|^[0]{1}[8]{1}[0-9]{10}$|^[0]{1}[8]{1}[0-9]{11}$|^[0]{1}[8]{1}[0-9]{12}$" class="form-control" name="phone" required placeholder="Enter phone">
									</div>
									<div class="form-group" id="email_group">
										<label>Email address</label>
										<input type="email" class="form-control" id="email" name="email" required placeholder="Enter email">
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" name="password" required placeholder="Password">
									</div>
									<button type="submit" id="register_submit" class="btn btn-secondary my-2">Submit</button>
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
										<input type="password" minlength="6" name="password" class="form-control" placeholder="Password">
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

<div class="modal fade" id="verification" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Verification Phone</h5>
			</div>
			<div style="margin: 20px">
				<form id="verification_form" action="<?= base_url('auth/verification') ?>">
					<div class="form-group">
						<label>Your phone number</label>
						<input type="text" name="phone" id="phone_verification" readonly class="form-control">
					</div>
					<div class="form-group">
						<label>Code from sms</label>
						<input type="text" required name="code" class="form-control">
					</div>
					<button type="submit" class="btn btn-primary">Done</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
	$(document).ready(() => {
		$('#auth').addClass('active')

		$('#login').submit((e) => {
			e.preventDefault()
			let value = $('#login').serialize()
			let url = $('#login').attr('action')

			$.post({
				url: url,
				data: value,
				success: response => {
					toastr.success('Redirecting...')
					setTimeout(() => {
						window.location.href = "<?= $this->session->userdata('current_url') ? $this->session->userdata('current_url') : base_url('profile') ?>"
					}, 2000)
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

		$('#phone').focusin(() => {
			$('#phone').removeClass('is-invalid')
			$('#phone_invalid').remove()
		})

		$('#register').submit((e) => {
			e.preventDefault()

			let loading = "<div id='loading' class='spinner-border text-light spinner-border-sm' role='status'/>"
			$('#register_submit').empty()
			$('#register_submit').append(loading)
			$('#register_submit').attr('disabled', true)

			let value = $('#register').serialize()
			let url = $('#register').attr('action')

			$.post({
				url: url,
				data: value,
				success: response => {
					$('#loading').remove()
					$('#register_submit').append('Submit')
					$('#register_submit').attr('disabled', false)
					$('#register').trigger("reset")
					let responseData = response.data
					toastr.success('Register Successfull')
					$('#phone_verification').val(responseData.phone)
					$('#verification').modal('show')
				},
				error: error => {
					$('#loading').remove()
					$('#register_submit').append('Submit')
					$('#register_submit').attr('disabled', false)
					let errorData = error.responseJSON
					console.log(errorData)
					if (errorData.data && errorData.data.email) {
						let html = "<div id='phone_invalid' class='invalid-feedback'>Email Already Use</div>"
						$('#email').addClass('is-invalid')
						$('#email_group').append(html)
					}
					if (errorData.data && errorData.data.phone) {
						let html = "<div id='email_invalid' class='invalid-feedback'>Phone Already Use</div>"
						$('#phone').addClass('is-invalid')
						$('#phone_group').append(html)
					}
					if (errorData.data == '[HTTP 400] Unable to create record: The number  is unverified. Trial accounts cannot send messages to unverified numbers; verify  at twilio.com/user/account/phone-numbers/verified, or purchase a Twilio number to send messages to unverified numbers.') {
						toastr.success('Register Successfull')
						toastr.warning('Verification Undeliverable, please login and change your number with other number')
						$('#register').trigger("reset")
					}
				}
			})
		})

		$('#verification_form').submit((e) => {
			e.preventDefault()
			let value = $('#verification_form').serialize()
			let url = $('#verification_form').attr('action')

			$.post({
				url: url,
				data: value,
				success: response => {
					$('#verification_form').trigger("reset")
					toastr.success('Verification Success')
					$('#verification').modal('hide')
				},
				error: error => {
					let errorData = error.responseJSON
					toastr.error(errorData.data.error)
				}
			})
		})
	})
</script>
