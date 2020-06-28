<div class="row">
	<div class="col-md-12">
		<?php if ($this->session->userdata('role') == 3) : ?>
			<a href="<?= base_url('admin/dashboard/admin') ?>" class="btn btn-primary my-2">New Admin</a>
		<?php endif ?>
		<a href="<?= base_url('admin/dashboard/profile') ?>" class="btn btn-primary my-2">Edit Profile</a>
		<button class="btn btn-primary" onclick="$('#ticket_checker').modal('show')">Ticket Checker</button>
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<h4 class="text-center">Your Profile</h4>
						<div class="text-center">
							<img src="<?= base_url() ?>assets/assets/img/default.png" class="img-thumbnail" /><br><br>
							<p style="margin-bottom: -3px; font-weight: bold">Name</p>
							<p style="margin-bottom: 5px;"><?= $user->name ?></p>
							<p style="margin-bottom: -3px; font-weight: bold">Gender</p>
							<p style="margin-bottom: 5px;"><?= $user->gender ?></p>
							<p style="margin-bottom: -3px; font-weight: bold">Address</p>
							<p style="margin-bottom: 5px;"><?= $user->address ?></p>
							<p style="margin-bottom: -3px; font-weight: bold">Phone</p>
							<p style="margin-bottom: 5px;"><?= $user->phone ?></p>
							<p style="margin-bottom: -3px; font-weight: bold">Email</p>
							<p style="margin-bottom: 5px;"><?= $user->email ?></p>
						</div>
					</div>
					<div class="col-md-1">
						<div style="width: 1px; height: 100%; background-color: grey"></div>
					</div>
					<div class="col-md-7">
						<h4 class="text-center text-danger">Must be processed immediately</h4>
						<table class="table table-striped table-hover">
							<thead>
								<th>ID</th>
								<th>User</th>
								<th>Expired</th>
								<th>Status</th>
								<th>Action</th>
							</thead>
							<tbody>
								<?php foreach ($transaction as $t) : ?>
									<tr>
										<td><?= $t->id ?></td>
										<td><?= $t->name ?></td>
										<td><?= datetime($t->expired) ?></td>
										<td><?= $t->status ?></td>
										<td><button class="btn btn-primary detail" data-id="<?= $t->id ?>">Detail</button></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" id="modal" role="dialog" aria-labelledby="modal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Transaction Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div style="border: 1px #DEE2E6 solid; border-radius: 10px; width: 100%; height: 100%;">
							<h5 class="text-center">Detail</h5>
							<table class="table">
								<tr>
									<td>User</td>
									<td>:</td>
									<td id="user"></td>
								</tr>
								<tr>
									<td>Date</td>
									<td>:</td>
									<td id="date"></td>
								</tr>
								<tr>
									<td>Expired</td>
									<td>:</td>
									<td id="expired"></td>
								</tr>
								<tr>
									<td>Total</td>
									<td>:</td>
									<td id="total"></td>
								</tr>
								<tr>
									<td>Unique Code</td>
									<td>:</td>
									<td id="code"></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-md-6">
						<div style="border: 1px #DEE2E6 solid; border-radius: 10px; width: 100%; height: 100%;">
							<h5 class="text-center">Payment</h5>
							<table class="table">
								<tr>
									<td>Name of payment</td>
									<td>:</td>
									<td id="nop"></td>
								</tr>
								<tr>
									<td>Bank of payment</td>
									<td>:</td>
									<td id="bop"></td>
								</tr>
								<tr>
									<td>Proof of payment</td>
									<td>:</td>
									<td id="pop"></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success decision" data-decision="Approve" data-id="">Approve</button>
				<button class="btn btn-danger decision" data-decision="Reject" data-id="">Reject</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" id="ticket_checker" role="dialog" aria-labelledby="modal" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Ticket Checker</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="ticket_form">
					<div class="form-group">
						<label for="barcode_number">Barcode</label>
						<input name="barcode_number" placeholder="Barcode number" type="text" required="required" class="form-control">
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(() => {
		$('#dashboard_menu').addClass('active')

		$('.decision').click(function() {
			let decision = $(this).data('decision')
			let id = $(this).data('id')
			window.location.href = "<?= base_url('admin/dashboard/executeTransaction/') ?>" + decision + '/' + id
		})

		moneyFormater = number => {
			let format = new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR'
			}).format(number)
			return format
		}

		$('.detail').click(function() {
			let id = $(this).data('id')
			$.get({
				url: "<?= base_url('admin/dashboard/transaction/') ?>" + id,
				success: response => {
					let data = response.data[0]
					$('#user').html(data.username)
					$('#date').html(data.date)
					$('#expired').html(data.expired)
					$('#total').html(moneyFormater(data.total))
					$('#code').html(data.unique_code)
					$('#nop').html(data.name_of_payment ? data.name_of_payment : "Waiting")
					$('#bop').html(data.bank_of_payment ? data.bank_of_payment : "Waiting")
					$('#pop').html(data.name_of_payment ? "<a target='_blank' href='<?= base_url('upload/') ?>" + data.proof_of_payment + "'><img class='img-thumbnail' alt='proof of payment' src='<?= base_url('upload/') ?>" + data.proof_of_payment + "'/></a>" : "Waiting")
					$('.decision').attr('data-id', data.transid)
					$('#modal').modal('show')
				},
				error: error => {
					console.log(error)
				}
			})
		})

		$('#ticket_form').submit(function(e) {
			e.preventDefault()
			let value = $(this).serialize()
			$.post({
				url: "<?= base_url('admin/dashboard/ticket_checker') ?>",
				data: value,
				success: response => {
					toastr.success(response.data.success)
					$(this).trigger("reset")
				},
				error: error => {
					let errorData = error.responseJSON
					toastr.error(errorData.data.error)
					$(this).trigger("reset")
				}
			})
		})
	})
</script>
