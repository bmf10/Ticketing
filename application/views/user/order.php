<section class="page-section portfolio my-5" id="auth">
	<div class="container">
		<div class="text-center">
			<h2 class="page-section-heading text-secondary mb-0 d-inline-block">Order Ticket</h2>
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
						<h4 class="text-dark">Order Here</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								<div style="border: 1px solid #343A40; border-radius: 15px; margin: 2px; padding:5px">
									<h5 class="text-dark text-center">Ticket List</h5>
									<br>
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Category</th>
												<th>Price</th>
												<th>Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($ticket as $list) : ?>
												<tr>
													<td><?= $list->name ?></td>
													<td>Rp <?= number_format($list->price) ?></td>
													<td><input type="number" min="0" data-price="<?= $list->price ?>" data-name="<?= $list->name ?>" data-id="<?= $list->id ?>" class="_amount" value="0" max="10" style="width: 40px;"></td>
												</tr>
											<?php endforeach ?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-md-4">
								<div style="border: 1px solid #343A40; border-radius: 15px; margin: 2px; padding:5px">
									<h5 class="text-dark text-center">Ticket Summary</h5>
									<br>
									<table class="table" id="table_sum">
										<thead>
											<tr>
												<th>Category</th>
												<th>Summary</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<hr>
									<p>Total</p>
									<p id="sum">Rp 0</p>
									<button id="submit" class="btn btn-primary btn-block mb-3">Buy Ticket</button>
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
		$('._amount').on('click change keyup', function() {
			let name = $(this).data('name')
			let price = $(this).data('price')
			let value = $(this).val()

			if (value == 0) {
				$('.' + name).remove()
			} else {
				if ($('.' + name) != null) {
					$('.' + name).remove()
				}
				let html = '<tr class="' + name + '"><td>' + name + '</td><td class="temp_sum" data-total="' + (price * value) + '">' + moneyFormater(price * value) + '</td></tr>'
				$('#table_sum tbody').append(html)
			}
			summary()
		})

		function summary() {
			let total = 0
			$('.temp_sum').each(function() {
				total = total + $(this).data('total')
			})
			$('#sum').html(moneyFormater(total))
		}

		$('#submit').click(() => {
			let value = {
				total: totalGetter(),
				data: {}
			}
			$('._amount').each(function(index) {
				if ($(this).val() != 0) {
					value.data[index] = {
						id: $(this).data('id'),
						value: $(this).val()
					}
				}
			})

			$.post({
				url: '<?= base_url('order/process') ?>',
				data: value,
				success: response => {
					let insert_id = response.data.insert_id
					window.location.href = "<?= base_url('order/payment/') ?>" + insert_id
				},
				error: error => {
					let errorData = error.responseJSON
					toastr.error(errorData.data.error)
				}
			})
		})

		totalGetter = () => {
			let total = $('#sum').html()
			let result = total.replace(/\.|\&|Rp|nbsp;/g, '')
			return result
		}

		moneyFormater = number => {
			let format = new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR',
			}).format(number).replace(/\D00(?=\D*$)/, '')
			return format
		}
	})
</script>
