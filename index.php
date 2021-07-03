<?php include_once 'vendor/autoload.php'; ?>

<!doctype html>
<html lang="en">
  <head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<title>PHP CRUD OOP with MySQL!</title>

	<style>
		body {
			font-size: 14px;
		}
	</style>
  </head>
  <body>
	<div class="container">
		<div class="row">
			<div class="col-s12">
				<div class="card mt-5">
					<div class="card-body">
						<h5 class="card-title text-center">PHP CRUD OOP with MySQL!</h5>
						<br>

						<button class="btn btn-primary" id="btn_add_employee" data-bs-toggle="modal" data-bs-target="#modal_employee">Add Employee</button>

						<table class="table table-responsive table-striped mt-3" id="tbl_employee">
							<thead>
								<tr>
									<th>Employee Number</th>
									<th>Fullname</th>
									<th>Email Address</th>
									<th>Mobile Number</th>
									<th>Created At</th>
									<th>Updated At</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal_employee" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="form_employee" method="POST" autocomplete="off">
					<div class="modal-header">
						<h5 class="modal-title">Add Employee</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" name="type" value="save">
						<input type="hidden" name="key" value="">
						<div class="mb-2">
							<label for="employee_number" class="form-label">Employee Number</label>
							<input type="text" class="form-control" name="employee_number" id="employee_number" placeholder="Employee Number">
						</div>
						<div class="mb-2">
							<label for="lname" class="form-label">Last Name</label>
							<input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" required>
						</div>
						<div class="mb-2">
							<label for="fname" class="form-label">First Name</label>
							<input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" required>
						</div>
						<div class="mb-2">
							<label for="mname" class="form-label">Middle Name</label>
							<input type="text" class="form-control" name="mname" id="mname" placeholder="Middle Name">
						</div>
						<div class="mb-2">
							<label for="email" class="form-label">Email Address</label>
							<input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
						</div>
						<div class="mb-2">
							<label for="mobile_number" class="form-label">Mobile Number</label>
							<input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="Mobile Number" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
		<div id="alert_toast" class="toast hide text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true" data-bs-animation="true">
			<div class="toast-header">
				<strong class="me-auto">Alert Message</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body"></div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<!-- Custom js -->
	<script type="text/javascript" src="/js/employee.js"></script>
  </body>
</html>