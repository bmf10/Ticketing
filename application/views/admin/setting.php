<div class="alert alert-danger" role="alert">
	Not recommended to change settings if you don't understand!
</div>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Twilio Setting</h3>
			</div>
			<div class="card-body">
				<form action="<?= base_url('admin/setting/twilio') ?>" method="POST">
					<div class="form-group row">
						<label class="col-3 col-form-label" for="twilio_auth_token">Auth Token</label>
						<div class="col-9">
							<input id="twilio_auth_token" value="<?= $twilio_auth_token->value ?>" name="twilio_auth_token" type="text" required="required" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="twilio_account_sid" class="col-3 col-form-label">Account SID</label>
						<div class="col-9">
							<input id="twilio_account_sid" value="<?= $twilio_account_sid->value ?>" name="twilio_account_sid" type="text" required="required" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="twilio_number" class="col-3 col-form-label">Phone Number</label>
						<div class="col-9">
							<input id="twilio_number" value="<?= $twilio_number->value ?>" name="twilio_number" type="text" required="required" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<div class="offset-3 col-9">
							<button name="submit" type="submit" class="btn btn-primary">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Bank Setting</h3>
			</div>
			<div class="card-body">
				<form action="<?= base_url('admin/setting/bank') ?>" method="POST">
					<input type="hidden" name="id" value="<?= $bank->id ?>">
					<div class="form-group row">
						<label class="col-3 col-form-label" for="name">Account Name</label>
						<div class="col-9">
							<input value="<?= $bank->name ?>" name="name" type="text" required="required" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="code" class="col-3 col-form-label">Code of Bank</label>
						<div class="col-9">
							<input id="twilio_account_sid" value="<?= $bank->code ?>" name="code" type="text" required="required" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="number" class="col-3 col-form-label">Account Number</label>
						<div class="col-9">
							<input value="<?= $bank->number ?>" name="number" type="text" required="required" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label for="provider" class="col-3 col-form-label">Bank Name</label>
						<div class="col-9">
							<input value="<?= $bank->provider ?>" name="provider" type="text" required="required" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<div class="offset-3 col-9">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Test SMS</h3>
			</div>
			<div class="card-body">
				<form action="<?= base_url('admin/setting/sms') ?>" method="POST">
					<div class="form-group">
						<label for="text">Phone number</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">+62</div>
							</div>
							<input autocomplete="hp" name="number_phone" type="number" required="required" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<button name="submit" type="submit" class="btn btn-warning">Send</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#setting_menu').addClass('active')
	})
</script>
