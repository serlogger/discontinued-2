<!DOCTYPE html>
<html lang="en">
<head>
	<style>

		* {
			--pxamount: 0;
		}

		.col-border {
			border: var(--pxamount) solid skyblue;
			outline:1px solid black;
		}

		.row-border {
			border: var(--pxamount) solid coral;
			outline:1px solid black;
		}

		.row > [class*='col-'] {
			overflow:hidden;
		}






		/* // Large devices (desktops, 992px and up) */
		@media screen and (min-width: 992px) {
			.column-1 {
				height:400px;
			}
			.column-desc {
				height:200px;
			}
		}

		@media screen and (max-width: 991.98px) {
			.column-1 {
				height:500px;
			}
			.column-desc {
				height:200px;
			}
		}

		@media screen and (max-width: 767px) {
			.column-1 {
				max-height:650px;
			}
			.column-desc {
				height:100px;
			}
		}

	</style>
	<title>Bootstrap Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="row">
	<div class="col-md-2 col-border">

	</div>
	<div class="col-md-8 col-border">
		<p style="color:grey;">Window height: <span id="height"></span></p>
		<p><b>Window width: <span id="width"></span></b></p>
		<div class="container">
			<div class="row row-border" style="">
					<div class="col-md-6 col-lg-4 col-border">
						<div class="row row-border" style="justify-content:space-betwwn;">
							<div class="col-md-12 column-1 d-flex justify-content-center">
								<img src="http://placekitten.com/g/2000/1000">
							</div>
							<div class="col-md-12 col-border">
								Images 1 2 3 4
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-8 col-border" style="justify-content: space-between;">
						<div class="row row-border">
							<div class="col-md-12 col-border">
								<h3>Title lorem</h3>
							</div>
						</div>
						<div class="row row-border" style="flex:1;">
							<div class="col-md-12 col-border column-desc">
								Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Description Lorem ipsum dolor sit amet, consectetur adipiscing elit,
								<!-- Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  -->
							</div>
						</div>
						<div class="row row-border" style="float:top;">
							<div class="col-md-12 col-border">
								<div class="row row-border">
									<div class="col-md-12 col-border">
										Categorization Industry → Category → Sub-category
									</div>
								</div>
								<div class="row row-border">
									<div class="col-lg-6 col-border">
										<p>Specs 1</p>
										<p>Specs 1</p>
										<p>Specs 1</p>
									</div>
									<div class="col-lg-6 col-border">
										<p>Specs 2</p>
										<p>Specs 2</p>
										<p>Specs 2</p>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div class="container test-container">
			<div class="row row-border" style="">
					<div class="col-md-6 col-lg-4 col-border">
						<div class="row row-border" style="justify-content:space-betwwn;">
							<div class="col-md-12 column-1 d-flex justify-content-center">
								<img src="http://placekitten.com/g/2000/1000">
							</div>
							<div class="col-md-12 col-border">
								Images 1 2 3 4
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-8 col-border" style="justify-content: space-between;">
						<div class="row row-border">
							<div class="col-md-12 col-border">
								<h3>Title lorem</h3>
							</div>
						</div>
						<div class="row row-border" style="flex:1;">
							<div class="col-md-12 col-border column-desc">
								Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Description Lorem ipsum dolor sit amet, consectetur adipiscing elit,
								<!-- Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  -->
							</div>
						</div>
						<div class="row row-border" style="float:top;">
							<div class="col-md-12 col-border">
								<div class="row row-border">
									<div class="col-md-12 col-border">
										Categorization Industry → Category → Sub-category
									</div>
								</div>
								<div class="row row-border">
									<div class="col-lg-6 col-border">
										<p>Specs 1</p>
										<p>Specs 1</p>
										<p>Specs 1</p>
									</div>
									<div class="col-lg-6 col-border">
										<p>Specs 2</p>
										<p>Specs 2</p>
										<p>Specs 2</p>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div class="container test-container">
			<div class="row row-border" style="">
					<div class="col-md-6 col-lg-4 col-border">
						<div class="row row-border" style="justify-content:space-betwwn;">
							<div class="col-md-12 column-1 d-flex justify-content-center">
								<img src="http://placekitten.com/g/2000/1000">
							</div>
							<div class="col-md-12 col-border">
								Images 1 2 3 4
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-8 col-border" style="justify-content: space-between;">
						<div class="row row-border">
							<div class="col-md-12 col-border">
								<h3>Title lorem</h3>
							</div>
						</div>
						<div class="row row-border" style="flex:1;">
							<div class="col-md-12 col-border column-desc">
								Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Description Lorem ipsum dolor sit amet, consectetur adipiscing elit,
								<!-- Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Description Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  -->
							</div>
						</div>
						<div class="row row-border" style="float:top;">
							<div class="col-md-12 col-border">
								<div class="row row-border">
									<div class="col-md-12 col-border">
										Categorization Industry → Category → Sub-category
									</div>
								</div>
								<div class="row row-border">
									<div class="col-lg-6 col-border">
										<p>Specs 1</p>
										<p>Specs 1</p>
										<p>Specs 1</p>
									</div>
									<div class="col-lg-6 col-border">
										<p>Specs 2</p>
										<p>Specs 2</p>
										<p>Specs 2</p>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
	<div class="col-md-2 col-border">

	</div>
</div>
<script>
	const heightOutput = document.querySelector('#height');
	const widthOutput = document.querySelector('#width');

	function reportWindowSize() {
	heightOutput.textContent = window.innerHeight;
	widthOutput.textContent = window.innerWidth;
	}

	window.onresize = reportWindowSize;
	reportWindowSize();
</script>
</body>
</html>
