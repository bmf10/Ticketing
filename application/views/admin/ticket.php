<div class="row">
	<div class="col-md-12">
		<button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modal">New Ticket</button>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Ticket</h3>
			</div>
			<div class="card-body">
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Price</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($ticket as $key => $ticket) : ?>
							<tr>
								<td><?= $key++ + 1 ?></td>
								<td><?= $ticket->name ?></td>
								<td>Rp <?= number_format($ticket->price) ?></td>
								<td>
									<a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this user?')" href="<?= base_url('admin/ticket/delete/' . $ticket->id) ?>">Delete</a>
									<button class="btn btn-info btn-sm edit" data-id="<?= $ticket->id ?>">Edit</button>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_title">New Ticket</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Name</label>
						<input id="name" name="name" placeholder="Ticket name" type="text" class="form-control" required="required">
					</div>
					<div class="form-group">
						<label for="price">Price</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">Rp</div>
							</div>
							<input id="price" name="price" placeholder="Ticket price" type="text" required="required" class="form-control">
						</div>
					</div>
				</div>
				<input type="hidden" name="id" id="edit_id" />
				<div class="modal-footer">
					<button type="submit" id="btn_submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(() => {
		$('#ticket_menu').addClass('active')
		$('#table').DataTable();

		if (window.outerWidth <= 1024) {
			$('#table').addClass('table-responsive')
		}

		Inputmask.extendAliases({
			'numeric': {
				"digits": 0,
				"digitsOptional": false,
				"decimalProtect": true,
				"groupSeparator": ",",
				"radixPoint": ".",
				"radixFocus": true,
				"autoGroup": true,
				"autoUnmask": true,
				"removeMaskOnSubmit": true
			}
		});
		$('#price').inputmask('numeric')

		$('#form').submit((e) => {
			e.preventDefault()
			$('#btn_submit').attr('disabled', true)
			let val = $('#form').serializeArray()
			if (!val[2].value) {
				$.post({
					url: '<?= base_url('admin/ticket/process') ?>',
					data: {
						name: val[0].value,
						price: val[1].value
					},
					success: response => {
						$('#modal').modal('hide')
						setTimeout(() => {
							location.reload()
						}, 2000)
						toastr.success(response.data)
						toastr.success('Reloading...')
					},
					error: error => {
						$('#btn_submit').attr('disabled', false)
						toastr.error('Something Wrong')
					}
				})
			} else {
				let id = val[2].value
				$.post({
					url: '<?= base_url('admin/ticket/process/') ?>' + id,
					data: {
						name: val[0].value,
						price: val[1].value
					},
					success: response => {
						$('#modal').modal('hide')
						setTimeout(() => {
							location.reload()
						}, 2000)
						toastr.success(response.data)
						toastr.success('Reloading...')
					},
					error: error => {
						$('#btn_submit').attr('disabled', false)
						toastr.error('Something Wrong')
					}
				})
			}
		})

		$('.edit').click(function() {
			let id = $(this).data('id')
			$.get({
				url: '<?= base_url('admin/ticket/single/') ?>' + id,
				success: response => {
					$('#modal_title').html('Edit Ticket')
					$('#name').val(response.data.name)
					$('#price').val(response.data.price)
					$('#edit_id').val(id)
					$('#modal').modal('show')
				},
				error: error => {
					toastr.error('Something Wrong')
				}
			})
		})

		$('#modal').on('hidden.bs.modal', function(e) {
			$('#modal_title').html('New Ticket')
			$('#form').trigger('reset')
		})
	})
</script>
