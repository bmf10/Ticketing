<section class="page-section portfolio my-5" id="auth">
	<div class="container">
		<div class="text-center">
			<h2 class="page-section-heading text-secondary mb-0 d-inline-block">Your Profile</h2>
		</div>
		<div class="divider-custom">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<?php if ($profile->is_verified == 0) : ?>
			<div class="alert alert-danger" role="alert">
				Your account is not verified. <button class="btn btn-link" onclick="$('#verification').modal('show')">Verified now!</button>
			</div>
		<?php endif ?>
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<div class="card text-white bg-primary mb-3">
							<div class="card-header">Your Profile</div>
							<div class="card-body">
								<form id="edit" action="<?= base_url('profile/edit_profile') ?>">
									<div class="form-group">
										<label>Name</label>
										<input type="text" name="name" value="<?= $profile->name ?>" required class="form-control" placeholder="Enter name">
									</div>
									<div class="form-group">
										<label for="exampleFormControlSelect1">Gender</label>
										<select class="form-control" name="gender" required id="exampleFormControlSelect1">
											<option value="">Gender</option>
											<option <?= $profile->gender === 'Male' ? 'selected' : '' ?> value="Male">Male</option>
											<option <?= $profile->gender === 'Female' ? 'selected' : '' ?> value="Female">Female</option>
										</select>
									</div>
									<div class="form-group">
										<label>Address</label>
										<textarea class="form-control" name="address" required placeholder="Enter address" rows="3"><?= $profile->address ?></textarea>
									</div>
									<div class="form-group" id="phone_group">
										<label>Phone</label>
										<input type="tel" id="phone" value="<?= $profile->phone ?>" pattern="^\d{10}$|^\d{11}$|^\d{12}$|^\d{13}$" class="form-control" name="phone" required placeholder="Enter phone">
									</div>
									<div class="form-group" id="email_group">
										<label>Email address</label>
										<input type="email" class="form-control" readonly value="<?= $profile->email ?>" id="email" name="email" required placeholder="Enter email">
									</div>
									<button type="button" id="edit_btn" class="btn btn-secondary my-2 float-right">Edit</button>
									<button type="submit" style="display: none" id="submit_btn" class="btn btn-secondary my-2">Submit</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card text-black bg-white mb-3">
							<div class="card-header">Etc.</div>
							<div class="card-body">
								<nav>
									<div class="nav nav-tabs" id="nav-tab" role="tablist">
										<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Transaction</a>
										<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Password</a>
									</div>
								</nav>
								<div class="tab-content" id="nav-tabContent">
									<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
									<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
										<form class="my-4" id="password_form" action="<?= base_url('profile/change_password') ?>">
											<div class="form-group" id="old_password_group">
												<label>Current Password</label>
												<input type="password" name="old_password" id="old_password" class="form-control">
											</div>
											<div class="form-group">
												<label>New Password</label>
												<input type="password" minlength="6" name="new_password" id="new_password" class="form-control">
											</div>
											<div class="form-group" id="retype_group">
												<label>Re-type Password</label>
												<input type="password" minlength="6" name="retype_password" id="retype_password" class="form-control">
											</div>
											<button type="submit" class="btn btn-primary">Submit</button>
										</form>
									</div>
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
				<form id="verification_form" action="<?= base_url('profile/verification') ?>">
					<div class="form-group">
						<label>Your phone number</label>
						<input type="text" value="<?= $profile->phone ?>" name="phone" id="phone_verification" readonly class="form-control">
					</div>
					<div class="form-group">
						<label>Code from sms</label>
						<input type="text" required name="code" class="form-control">
					</div>
					<button type="submit" class="btn btn-primary">Done</button>
					<button type="button" id="resend" class="btn btn-secondary">Resend</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(() => {
		setInterval(() => {
			$('#profile_menu').addClass('active')
		}, 10);
		$('#edit :input').attr('disabled', true)
		$('#edit :button').attr('disabled', false)

		$('#edit_btn').click(() => {
			if ($('#edit_btn').html() == 'Edit') {
				$('#edit :input').attr('disabled', false)
				$('#submit_btn').css('display', 'block')
				$('#edit_btn').empty()
				$('#edit_btn').append('Cancel')
			} else {
				$('#edit :input').attr('disabled', true)
				$('#edit :button').attr('disabled', false)
				$('#submit_btn').css('display', 'none')
				$('#edit_btn').empty()
				$('#edit_btn').append('Edit')
			}
		})

		$('#phone').focusin(() => {
			$('#phone').removeClass('is-invalid')
			$('#phone_invalid').remove()
		})

		$('#edit').submit((e) => {
			e.preventDefault();
			let loading = "<div id='loading' class='spinner-border text-light spinner-border-sm' role='status'/>"
			$('#submit_btn').empty()
			$('#submit_btn').append(loading)
			$('#submit_btn').attr('disabled', true)
			$('#edit_btn').attr('disabled', true)


			let value = $('#edit').serialize()
			let url = $('#edit').attr('action')

			$.post({
				url: url,
				data: value,
				success: response => {
					$('#loading').remove()
					$('#submit_btn').append('Submit')
					$('#submit_btn').attr('disabled', false)
					$('#edit_btn').trigger('click')
					let responseData = response.data
					toastr.success('Data change successfull')
					console.log(response)
					if (responseData.phone) {
						$('#phone_verification').val(responseData.phone)
						$('#verification').modal('show')
					}
				},
				error: error => {
					$('#loading').remove()
					$('#submit_btn').append('Submit')
					$('#submit_btn').attr('disabled', false)
					$('#edit_btn').attr('disabled', false)
					let errorData = error.responseJSON
					if (errorData.data && errorData.data.phone) {
						let html = "<div id='phone_invalid' class='invalid-feedback'>Phone Already Use</div>"
						$('#phone').addClass('is-invalid')
						$('#phone_group').append(html)
					}
					if (errorData.data == '[HTTP 400] Unable to create record: The number  is unverified. Trial accounts cannot send messages to unverified numbers; verify  at twilio.com/user/account/phone-numbers/verified, or purchase a Twilio number to send messages to unverified numbers.') {
						toastr.success('Data change successfull')
						toastr.warning('Verification Undeliverable, please check your number phone')
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
					location.reload();
				},
				error: error => {
					let errorData = error.responseJSON
					toastr.error(errorData.data.error)
				}
			})
		})


		$('#resend').click(() => {
			$('#resend').attr('disabled', true)
			setTimeout(() => {
				$('#resend').attr('disabled', false)
			}, 1000 * 60)
			$.get({
				url: "<?= base_url('/profile/resendCode') ?>",
				success: response => {
					toastr.success('Success, Verification Delivered')
				},
				error: error => {
					toastr.warning('Verification Undeliverable, please check your number phone')
				}
			})
		})

		$('#password_form').submit((e) => {
			e.preventDefault();
			let new_password = $('#new_password').val();
			let retype_password = $('#retype_password').val();

			if (new_password !== retype_password) {
				let html = "<div id='retype_invalid' class='invalid-feedback'>Retype password doesn't match</div>"
				$('#retype_password').addClass('is-invalid')
				$('#retype_group').append(html)
			} else {
				$('#retype_password').removeClass('is-invalid')
				$('#retype_invalid').remove()

				let value = $('#password_form').serialize()
				let url = $('#password_form').attr('action')
				$.post({
					url: url,
					data: value,
					success: response => {
						toastr.success('Success, Your password has been changed')
						$('#password_form').trigger("reset")
					},
					error: error => {
						let errorData = error.responseJSON
						if (errorData.data && errorData.data.old_password) {
							let html = "<div id='old_password_invalid' class='invalid-feedback'>Current password is wrong</div>"
							$('#old_password').addClass('is-invalid')
							$('#old_password_group').append(html)
						}
					}
				})
			}
		})

		$('#old_password').focus(() => {
			$('#old_password').removeClass('is-invalid')
			$('#old_password_invalid').remove()
		})
	})
</script>
