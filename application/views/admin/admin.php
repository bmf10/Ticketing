<?php
$name = $admin ? $admin->name : set_value('name');
$gender = $admin ? $admin->gender : set_value('gender');
$address = $admin ? $admin->address : set_value('address');
$phone = $admin ? $admin->phone : set_value('phone');
$email = $admin ? $admin->email : set_value('email');
?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<form action="<?= current_url() ?>" method="POST">
					<div class="form-group">
						<label for="name">Name</label>
						<input id="name" name="name" value="<?= $name ?>" placeholder="Fullname" type="text" required="required" class="form-control">
					</div>
					<div class="form-group">
						<label for="gender">Gender</label>
						<div>
							<select id="gender" name="gender" class="custom-select" required="required">
								<option value="">Select</option>
								<option <?= $gender == "Male" ? 'Selected' : '' ?> value="Male">Male</option>
								<option <?= $gender == "Female" ? 'Selected' : '' ?> value="Female">Female</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="address">Address</label>
						<textarea id="address" placeholder="Full address" name="address" cols="40" rows="3" class="form-control" required="required"><?= $address ?></textarea>
					</div>
					<div class="form-group">
						<label for=" phone">Phone</label>
						<input id="phone" value="<?= $phone ?>" name="phone" placeholder="Number Phone" type="tel" pattern="^\d{10}$|^\d{11}$|^\d{12}$|^\d{13}$" class="form-control <?= form_error('phone') ? 'is-invalid' : '' ?>"" required=" required">
						<?php if (form_error('phone')) : ?>
							<div class="invalid-feedback">
								Phone number is already used
							</div>
						<?php endif ?>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input id="email" value="<?= $email ?>" name="email" placeholder="Email" type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" required="required">
						<?php if (form_error('email')) : ?>
							<div class="invalid-feedback">
								Email number is already used
							</div>
						<?php endif ?>
					</div>
					<?php if (!$admin) : ?>
						<div class="form-group">
							<label for="password">Password</label>
							<input id="password" minlength="6" name="password" placeholder="Password" type="password" class="form-control" required="required">
						</div>
					<?php endif ?>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(() => {
		$('#dashboard_menu').addClass('active')
	})
</script>
