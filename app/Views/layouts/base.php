<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?=link_tag('vendor/fontawesome-free/css/all.min.css')?>

		<!-- Page level plugin CSS-->
		<?=link_tag('vendor/datatables/dataTables.bootstrap4.css')?>

		<?=link_tag('css/sb-admin.css')?>
		<title><?=$title?></title>
	</head>
	<body id="page-top">
		<div id="wrapper">
			<?=$this->include('layouts/navbar')?>
			<div id="content-wrapper">
				<?=$this->renderSection('content')?>


				<footer class="sticky-footer">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Copyright © Brandon Hernandez 2020</span>
						</div>
					</div>
				</footer>
			</div>



		</div>



		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>
		<?=$this->renderSection('footer')?>

		<!-- Bootstrap core JavaScript-->
		<?=script_tag('vendor/jquery/jquery.min.js')?>
		<?=script_tag('vendor/bootstrap/js/bootstrap.bundle.min.js')?>

		<!-- Core plugin JavaScript-->
		<!-- <?=script_tag('vendor/jquery-easing/jquery.easing.min.js')?> -->

		<!-- Page level plugin JavaScript-->
		<?=script_tag('vendor/chart.js/Chart.min.js')?>
		<?=script_tag('vendor/datatables/jquery.dataTables.js')?>
		<?=script_tag('vendor/datatables/dataTables.bootstrap4.js')?>

		<?=script_tag('js/sb-admin.js')?>

		<?=script_tag('js/indicadores.js')?>

		<?=script_tag('vendor/momentjs/moment-with-locales.js')?>

		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />

		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-range/4.0.2/moment-range.js" integrity="sha512-XKgbGNDruQ4Mgxt7026+YZFOqHY6RsLRrnUJ5SVcbWMibG46pPAC97TJBlgs83N/fqPTR0M89SWYOku6fQPgyw==" crossorigin="anonymous"></script>

		<script>
			window['moment-range'].extendMoment(moment);
		</script>

		<?=$this->renderSection('scripts')?>



	</body>
</html>
