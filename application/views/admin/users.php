<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Data Users</h3>
			</div>
			<div class="card-body">
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Gender</th>
							<th>Address</th>
							<th>Phone</th>
							<th>Email</th>
							<th>Role</th>
							<th>Verified</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users as $key => $user) : ?>
							<tr>
								<td><?= $key++ + 1 ?></td>
								<td><?= $user->name ?></td>
								<td><?= $user->gender ?></td>
								<td><?= $user->address ?></td>
								<td><?= $user->phone ?></td>
								<td><?= $user->email ?></td>
								<?php if ($user->role == 1) : ?>
									<td>Member</td>
								<?php elseif ($user->role == 2 || $user->role == 3) : ?>
									<td>Admin</td>
								<?php endif ?>
								<?php if ($user->is_verified == 1) : ?>
									<td class="text-success">Yes</td>
								<?php else : ?>
									<td class="text-danger">No</td>
								<?php endif ?>
								<td>
									<?php if ($user->role == 1) : ?>
										<a class="btn btn-danger btn-sm btn-block" onclick="return confirm('Are you sure to delete this user?')" href="<?= base_url('admin/users/delete/' . $user->id) ?>">Delete</a>
										<a class="btn btn-info btn-sm btn-block" href="<?= base_url('admin/users/edit/' . $user->id) ?>">Edit</a>
									<?php elseif ($user->role == 2) : ?>
										<a class="btn btn-danger btn-sm btn-block" onclick="return confirm('Are you sure to delete this user?')" href="<?= base_url('admin/users/delete/' . $user->id) ?>">Delete</a>
										<a class="btn btn-info btn-sm btn-block" href="<?= base_url('admin/users/edit/' . $user->id) ?>">Edit</a>
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(() => {
		$('#users_menu').addClass('active')
		$('#table').DataTable();

		if (window.outerWidth <= 1024) {
			$('#table').addClass('table-responsive')
		}
	})
</script>
