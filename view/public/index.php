<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Address Book</title>
		<script data-main="assets/js/bootstrap" src="assets/js/lib/require.js"></script>
		<link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />
		<link rel="stylesheet" href="assets/css/style.css" type="text/css" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<section id="contacts" class="col-md-3 col-sm-3">
					<ul></ul>
				</section>
				<section id="info" class="col-md-9 col-sm-9">
					<div class="head">
						<div class="view">
							<div class="photo">
								<img />
							</div>
							<div class="text">
								<div class="name">
									<span class="first"></span>
									<span class="last"></span>
								</div>
								<div class="company">
									<span></span>
								</div>
							</div>
						</div>
						<div class="edit">
							<div class="photo">
								<img />
							</div>
							<div class="text">
								<div class="name">
									<input type="text" name="first_name" placeholder="First" />
									<input type="text" name="last_name" placeholder="Last" />
								</div>
								<div class="company">
									<input type="text" name="company_name" placeholder="Company" />
								</div>
							</div>
						</div>
					</div>
					<div class="attributes">
						<div class="container"></div>
						<a class="add">Add Field</a>
					</div>
					<div class="controls">
						<a class="btn edit">Edit</a>
						<a class="btn delete">Delete</a>
					</div>
				</section>
			</div>
		</div>
	</body>
</html>