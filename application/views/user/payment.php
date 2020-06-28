<section class="page-section portfolio my-5" id="auth">
	<div class="container">
		<div class="text-center">
			<h2 class="page-section-heading text-secondary mb-0 d-inline-block">Payment</h2>
		</div>
		<div class="divider-custom">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card bg-default mb-3">
					<div class="card-header">
						<div class="row">
							<div class="col-md-6">
								<h4 class="text-dark">Payment Details</h4>
							</div>
							<div class="col-md-6">
								<button data-id="<?= $transaction->id ?>" id="cancel" class="btn btn-danger float-right">Cancel</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div style="border: 1px solid #343A40; border-radius: 15px; margin: 2px; padding:5px">
									<h5 class="text-dark text-center">Bill</h5>
									<table class="table">
										<tr>
											<td>Payment Id</td>
											<td>:</td>
											<td><?= $transaction->id ?></td>
										</tr>
										<tr>
											<td>Date</td>
											<td>:</td>
											<td><?= datetime($transaction->date) ?></td>
										</tr>
										<tr>
											<td>Expired</td>
											<td>:</td>
											<td><?= datetime($transaction->expired) ?></td>
										</tr>
										<tr>
											<td>Unique Code</td>
											<td>:</td>
											<td><?= $transaction->unique_code ?></td>
										</tr>
										<tr>
											<td>Total</td>
											<td>:</td>
											<td><?= rupiah($transaction->total) ?></td>
										</tr>
									</table>
								</div>
								<div style="border: 1px solid #343A40; border-radius: 15px; margin: 2px; margin-top: 15px; padding:5px">
									<h5 class="text-dark text-center">Account name</h5>
									<table class="table">
										<tr>
											<td>Account Name</td>
											<td>:</td>
											<td><?= $bank->name ?></td>
										</tr>
										<tr>
											<td>Bank</td>
											<td>:</td>
											<td><?= $bank->provider ?></td>
										</tr>
										<tr>
											<td>Code</td>
											<td>:</td>
											<td><?= $bank->code ?></td>
										</tr>
										<tr>
											<td>Account number</td>
											<td>:</td>
											<td><?= $bank->number ?></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="col-md-6">
								<div style="border: 1px solid #343A40; border-radius: 15px; margin: 2px; padding:5px">
									<h5 class="text-dark text-center">Form</h5>
									<form action="<?= base_url('order/payments') ?>" method="POST" enctype="multipart/form-data">
										<input type="hidden" name="id" value="<?= $transaction->id ?>">
										<div class="form-group">
											<label>Name of Account Bank</label>
											<input required type="text" name="name_of_payment" class="form-control">
										</div>
										<div class="form-group">
											<label>Bank Name</label>
											<input required type="text" name="bank_of_payment" class="form-control">
										</div>
										<div class="form-group">
											<label>Proof of Payment</label>
											<input type="file" accept="image/*" size="10" name="proof_of_payment" class="form-control">
										</div>
										<input type="submit" class="btn btn-primary mb-2 ml-1">
									</form>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-md-12">
									<br>
									<p class="mx-3"><strong>NB: Please pay according to the total price shown to the last digit</strong></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>
<script>
	$(document).ready(function() {
		$('#cancel').click(function() {
			confirm('Are you sure to cancel this transaction?')
			let id = $(this).data('id')
			window.location.href = "<?= base_url('order/cancel/') ?>" + id
		})
	})
</script>
