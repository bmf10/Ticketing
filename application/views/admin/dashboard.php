<div class="row">
	<div class="col-md-12">
		<?php if ($this->session->userdata('role') == 3) : ?>
			<a href="<?= base_url('admin/dashboard/admin') ?>" class="btn btn-primary my-2">New Admin</a>
		<?php endif ?>
		<a href="<?= base_url('admin/dashboard/profile') ?>" class="btn btn-primary my-2">Edit Profile</a>
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
						<h4 class="text-center">Last Transaction</h4>
						<table class="table table-striped table-hover">
							<thead>
								<th>ID</th>
								<th>User</th>
								<th>Date</th>
								<th>Status</th>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>User 1</td>
									<td>10/10/1910</td>
									<td>Waiting for payment</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(() => {
		$('#dashboard_menu').addClass('active')
	})
</script>
