<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Transaction</h3>
			</div>
			<div class="card-body">
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>User</th>
							<th>Date</th>
							<th>Expired</th>
							<th>Total</th>
							<th>Unique Code</th>
							<th>Status</th>
							<th>Ticket</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($transaction as $key => $t) : ?>
							<tr>
								<td><?= $t->id ?></td>
								<td><?= $t->username ?></td>
								<td><?= datetime($t->date) ?></td>
								<td><?= datetime($t->expired) ?></td>
								<td><?= rupiah($t->total) ?></td>
								<td><?= $t->unique_code ?></td>
								<td><?= $t->status ?></td>
								<td><?= $t->amount ?> Tickets</td>
								<td><button class="btn btn-primary btn_detail" data-id="<?= $t->id ?>">Detail</button></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Transaction Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Mark As
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item mark" data-actually="Approved" href="#">Approve</a>
						<a class="dropdown-item mark" data-actually="Rejected" href="#">Reject</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 mt-2">
						<div style="border: 1px #DEE2E6 solid; border-radius: 10px; width: 100%; height: 100%;">
							<h5 class="text-center">Detail</h5>
							<table class="table">
								<tr>
									<td>Status</td>
									<td>:</td>
									<td id="status"></td>
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
					<div class="col-md-6 mt-2">
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
				<div class="row mt-3">
					<div class="col-md-6 offset-md-3">
						<div id="barcode_box" style="border: 1px #DEE2E6 solid; border-radius: 10px; width: 100%; height: 100%;">
							<h5 class="text-center">Tickets</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('assets/js/JsBarcode.all.min.js') ?>"></script>
<script>
	$(document).ready(() => {
		$('#transaction_menu').addClass('active')
		$('#table').DataTable();

		if (window.outerWidth <= 1024) {
			$('#table').addClass('table-responsive')
		}

		moneyFormater = number => {
			let format = new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR'
			}).format(number)
			return format
		}

		$('.btn_detail').click(function() {
			let id = $(this).data('id')

			$.get({
				url: "<?= base_url('admin/transaction/detail/') ?>" + id,
				success: response => {
					let data = response.data[0]
					$('#user').html(data.username)
					$('#status').html(data.status)
					$('#date').html(data.date)
					$('#expired').html(data.expired)
					$('#total').html(moneyFormater(data.total))
					$('#code').html(data.unique_code)
					$('#nop').html(data.name_of_payment ? data.name_of_payment : "Waiting")
					$('#bop').html(data.bank_of_payment ? data.bank_of_payment : "Waiting")
					$('#pop').html(data.name_of_payment ? "<a target='_blank' href='<?= base_url('upload/') ?>" + data.proof_of_payment + "'><img class='img-thumbnail' alt='proof of payment' src='<?= base_url('upload/') ?>" + data.proof_of_payment + "'/></a>" : "Waiting")
					$('.decision').attr('data-id', data.transid)
					$('#detail').modal('show')
					$('.mark').attr('data-id', data.transid)
					$('.mark').attr('data-status', data.status)

					if (data.status == 'Rejected') {
						$('#barcode_box').append('<div class="text-center barcode_status"><p>Rejected</p></div>')
					} else if (data.status == 'Payment') {
						$('#barcode_box').append('<div class="text-center barcode_status"><p>Please check your dashboard</p></div>')
					} else if (data.status == 'Approved') {
						let tickets = response.data
						for (let index = 0; index < tickets.length; index++) {
							$('#barcode_box').append('<div class="text-center barcode_status"><p>' + tickets[index].name + '</p><img id="barcode_' + index + '"></img><hr></div>')
							$('#barcode_' + index).JsBarcode(tickets[index].barcode_number)
						}
					} else {
						$('#barcode_box').append('<div class="text-center barcode_status"><p>Waiting</p></div>')
					}
				},
				error: error => {
					console.log(error)
				}
			})
		})

		$('#detail').on('hidden.bs.modal', function() {
			$('.barcode_status').remove()
		})

		$('.mark').click(function() {
			let btn = $(this).data('actually')
			let status = $(this).data('status')
			let id = $(this).data('id')

			if (status != btn) {
				if (btn == 'Approved') {
					window.location.href = "<?= base_url('admin/dashboard/executeTransaction/Approve/') ?>" + id
				} else if (btn == 'Rejected') {
					window.location.href = "<?= base_url('admin/dashboard/executeTransaction/Reject/') ?>" + id
				}
			} else {
				toastr.error("Status is correct")
			}
		})
	})
</script>
